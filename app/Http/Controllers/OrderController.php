<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Http\Requests\OrderRequest;
use App\Models\Branch;
use App\Models\ChickenMenu;
use App\Models\Customers;
use App\Models\District;
use App\Models\EggMenu;
use App\Models\MeatMenu;
use App\Models\OffalMenu;
use App\Models\OrderPackage;
use App\Models\Orders;
use App\Models\Package;
use App\Models\PackageChicken;
use App\Models\PackageEgg;
use App\Models\PackageMeat;
use App\Models\PackageOffal;
use App\Models\PackageRice;
use App\Models\PackageVegetable;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\RiceMenu;
use App\Models\Shipping;
use App\Models\TypeOrder;
use App\Models\UsersBranch;
use App\Models\VegetableMenu;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userBranch = UsersBranch::with('branch')->where('users_id', $user->id)->first();
        $branch = Branch::all();
        $data['user'] = $userBranch;
        $data['branches'] = $branch;
        $data['orders'] = Orders::query()
            ->with(['orderPackage.package', 'shipping'])
            ->select([
                'orders.*',
                'customers.name as customer_name',
                'customers.phone_1 as customer_phone_1',
            ])
            ->join('customers', 'orders.customer_id', 'customers.id')
            ->when(request()->filled('search'), function ($query) {
                $query->where('customers.name', 'LIKE', '%' . request('search') . '%');
            })
            ->when(request()->filled('branch_id'), function ($query) {
                $query->where('branch_id', request('branch_id'));
            })
            ->when(request()->filled('send_date'), function ($query) {
                $query->whereDate('send_date', request('send_date'));
            })
            ->latest()
            ->paginate(request('per_page', 10));
        return view('order.index')->with($data);
    }

    public function json()
    {
        $params = FacadesRoute::current()->parameters();
        $page = $params['page'];
        $limit = $params['limit'];
        $user = Auth::user();
        $userBranch = UsersBranch::where('users_id', $user->id)->with('branch')->first();
        if ($userBranch == null) {
            $where = 'id > 0';
        } else {
            $where = 'branch_id = ' . $userBranch->branch_id;
        }
        $order = Orders::with(['orderPackage.package', 'shipping'])
            ->whereRaw($where)
            // ->skip($page)
            // ->take($limit)
            ->latest()
            ->get();
        $view = view('order.partials.table-list', ['data' => $order])->render();
        return response()->json([
            'message' => 'Data retrieve',
            'data' => [
                'view' => $view,
                'data' => $order,
                'user' => $userBranch
            ]
        ]);
    }

    public function dataByBranch(Request $request)
    {
        $branch = $request->branch;
        $order = Orders::with(['orderPackage.package', 'shipping'])
            ->whereRaw('branch_id = ' . $branch)
            ->get();
        $view = view('order.partials.table-list', ['data' => $order])->render();
        return response()->json([
            'message' => 'Data retrieve',
            'data' => [
                'view' => $view
            ]
        ]);
    }

    public function invoice($id)
    {
        $orders = Orders::with([
            'orderPackage.package', 'customer.village',
            'orderPackage.offal.offal',
            'orderPackage.meat.meat',
            'orderPackage.chicken.chicken',
            'orderPackage.vegie.vegie',
            'orderPackage.rice.rice',
            'orderPackage.egg.egg',
            'customer.district', 'payment'
        ])
            ->findOrFail($id);
        $orderPackage = $this->getAllMenu($orders->orderPackage);
        $fileName = $orders->id . '_' . $orders->customer->name;
        $data = [
            'fileName' => $fileName,
            'data' => $orders,
            'allMenu' => $orderPackage['allMenus'],
            'rices' => $orderPackage['rices'],
            'isArabic' => $orderPackage['isArabic']
        ];
        $view = view('order.print-invoice')->with($data)
            ->render();
        $pdf = PDF::loadHTML($view)->setPaper('a4', 'landscape');
        return $pdf->stream($fileName . '.pdf');
    }

    public function kitchenInvoice($id)
    {
        $orders = Orders::with([
            'orderPackage.package', 'customer.village',
            'orderPackage.offal.offal',
            'orderPackage.meat.meat',
            'orderPackage.chicken.chicken',
            'orderPackage.vegie.vegie',
            'orderPackage.rice.rice',
            'orderPackage.egg.egg',
            'customer.district', 'payment',
            'createdBy'
        ])
            ->findOrFail($id)->makeVisible(['created_at']);
        $orderPackage = $this->getAllMenu($orders->orderPackage);
        $data = [
            'data' => $orderPackage,
            'orders' => $orders
        ];
        $view = view('order.testing')->with($data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('a4', 'landscape');

        return $pdf->download('laporan.pdf');
        // return view('order.testing')->with($data);
    }

    public function helpers(Request $request)
    {
        $id = $request->id;
        $orders = Orders::with([
            'orderPackage.package', 'customer.village',
            'orderPackage.offal.offal',
            'orderPackage.meat.meat',
            'orderPackage.chicken.chicken',
            'orderPackage.vegie.vegie',
            'orderPackage.rice.rice',
            'orderPackage.egg.egg',
            'customer.district', 'payment',
            'createdBy'
        ])
            ->findOrFail($id)->makeVisible(['created_at']);
        $orderPackage = $this->getAllMenu($orders->orderPackage);
        return response()->json([
            'data' => $orders,
            'all' => $orderPackage
        ]);
    }

    public function exportInvoice(Request $request)
    {
        // 1 ITU WEEK
        // 2 ITU MONTH
        // 3 ITU CUSTOM
        $timeline = $request->timeline;
        // validation
        if ($timeline == '' || $timeline == null) {
            return Redirect::back()
                ->withErrors('Pilih salah satu timeline')
                ->withInput();
        }
        if ($timeline == 3) {
            if ($request->start_date == '' || $request->end_date == '') {
                return Redirect::back()
                    ->withErrors('Pastikan tanggal mulai dan tanggal akhir sudah terisi')
                    ->withInput();
            }
            $date1 = strtotime($request->start_date);
            $date2 = strtotime($request->end_date);

            $diff = $date2 - $date1;
            if ($diff < 0) {
                return Redirect::back()
                    ->withErrors('Tanggal akhir harus lebih dari tanggal mulai')
                    ->withInput();
            }
        }


        $branch = $request->branch;


        if ($timeline == 1) {
            $start = date('Y-m-d', strtotime('-7days'));
            $end = date('Y-m-d');
            $title = 'Report Weekly ' . date('d F Y', strtotime($start)) . ' - ' . date('d F Y', strtotime($end));
        } else if ($timeline == 2) {
            $start = date('Y-m-01');
            $end = date('Y-m-t');
            $title = 'Report Monthly ' . date('d F Y', strtotime($start)) . ' - ' . date('d F Y', strtotime($end));
        } else {
            $start = $request->start_date;
            $end = $request->end_date;
            $title = 'Report Custom ' . date('d F Y', strtotime($start)) . ' - ' . date('d F Y', strtotime($end));
        }

        $param = [
            'start' => $start . ' 00:00:00',
            'end' => $end . ' 23:59:59',
            'title' => $title
        ];

        if (!$request->user()->canSeeAllBranches()) {
            $param['branch'] = $branch;
        }

        return Excel::download(new InvoiceExport($param), $title . '.xlsx');
    }

    public function create()
    {
        // get branch from user
        $user = Auth::user();
        $userBranch = UsersBranch::where('users_id', $user->id)->with('branch')->first();
        $allBranch = Branch::all();
        $data['branch'] = $userBranch;
        $data['allBranch'] = $allBranch;
        $data['payment'] = Payment::all();
        $data['typeOrder'] = TypeOrder::all();
        $data['package'] = Package::all();
        $data['shippings'] = Shipping::all();
        $data['districts'] = District::all();
        return view('order.create-backup')->with($data);
    }

    public function validateQuota($param)
    {
        $branchId = $param['branch_id'];
        $qty = $param['qty'];
        $time = $param['send_time'];
        $dates = $param['send_date'];
        $splitTime = explode(':', $time);
        $start = $dates . " $splitTime[0]:00";
        $end = $dates . " $splitTime[0]:59";
        $where = "send_date >= '$start' AND send_date <= '$end' and branch_id = $branchId";
        $data = Orders::select('id', 'qty')
            ->whereRaw($where)->get();
        $return = [];
        if (count($data) == 0) {
            $return['status'] = true;
            $return['quota'] = 300;
        } else {
            $sum = [];
            foreach ($data as $d) {
                $sum[] = $d->qty;
            }
            $quota = 300 - array_sum($sum);
            $check = $quota - $qty;
            if ($check < 0) {
                $return['status'] = false;
                $return['quota'] = $quota;
            } else {
                $return['status'] = true;
                $return['quota'] = $quota;
            }
        }

        return $return;
    }

    public function checkQuota(Request $request)
    {
        $branchId = $request->branch;
        $time = $request->times;
        $splitTime = explode(':', $time);
        $plus = $splitTime[0] + 1 . ':00';
        $start = $request->dates . " $splitTime[0]:00";
        $end = $request->dates . " $splitTime[0]:59";
        $where = "send_date >= '$start' AND send_date <= '$end' and branch_id = $branchId";
        $data = Orders::select('id', 'qty')
            ->whereRaw($where)->get();

        if (count($data) == 0) {
            $quota = 300;
        } else {
            $sum = [];
            foreach ($data as $d) {
                $sum[] = $d->qty;
            }
            $quota = 300 - array_sum($sum);
        }

        return response()->json([
            'message' => 'Data retrieve',
            'data' => $quota,
            'request' => $request->all(),
            'condition' => [
                'start' => $start,
                'end' => $end,
                'where' => $where
            ]
        ]);
    }

    public function getDetailPackage(Request $request)
    {
        $id = $request->packageId;
        $index = $request->index;
        $meat = MeatMenu::where('is_custom', false)->get();
        $offal = OffalMenu::where('is_custom', false)->get();
        $egg = EggMenu::where('is_custom', false)->get();
        $chicken = ChickenMenu::where('is_custom', false)->get();
        $rice = RiceMenu::all();
        $vegie = VegetableMenu::where('is_custom', false)->get();

        $order = "";
        if ($request->isEdit == 'edit') {
            $order = Orders::where('id', $request->orderId)
                ->with([
                    'orderPackage.package',
                    'orderPackage.meat.meat',
                    'orderPackage.offal.offal',
                    'orderPackage.chicken.chicken',
                    'orderPackage.vegie.vegie',
                    'orderPackage.rice.rice',
                    'orderPackage.egg.egg',
                ])->first();
        }
        // return response()->json([
        //     'req' => $request->isEdit,
        //     'order' => $order
        // ]);


        $view = "";
        if ($id == 1) {
            $view = view('order.partials.package1', [
                'meats' => $meat,
                'offals' => $offal,
                'rices' => $rice,
                'index' => $index,
                'order' => $order
            ])->render();
        } else if ($id == 2) {
            $view = view('order.partials.package2', [
                'meats' => $meat,
                'offals' => $offal,
                'rices' => $rice,
                'index' => $index,
                'order' => $order
            ])->render();
        } else if ($id == 3) {
            $view = view('order.partials.package3', [
                'meats' => $meat,
                'offals' => $offal,
                'eggs' => $egg,
                'rices' => $rice,
                'vegies' => $vegie,
                'index' => $index,
                'order' => $order
            ])->render();
        } else if ($id == 4) {
            $view = view('order.partials.package4', [
                'meats' => $meat,
                'offals' => $offal,
                'chickens' => $chicken,
                'rices' => $rice,
                'vegies' => $vegie,
                'index' => $index,
                'order' => $order
            ])->render();
        } else if ($id == 5) {
            $view = view('order.partials.package5', [
                'meats' => $meat,
                'offals' => $offal,
                'rices' => $rice,
                'index' => $index,
                'order' => $order
            ])->render();
        } else if ($id == 6) {
            $view = view('order.partials.package6', [
                'meats' => $meat,
                'vegies' => $vegie,
                'rices' => $rice,
                'index' => $index,
                'order' => $order
            ])->render();
        } else if ($id == 7) {
            $view = view('order.partials.package7', [
                'meats' => $meat,
                'chickens' => $chicken,
                'rices' => $rice,
                'index' => $index,
                'order' => $order
            ])->render();
        } else {
            $view = view('order.partials.package8', [
                'meats' => $meat,
                'offals' => $offal,
                'eggs' => $egg,
                'vegies' => $vegie,
                'rices' => $rice,
                'index' => $index,
                'order' => $order
            ])->render();
        }

        return response()->json([
            'status' => $view != "" ? 200 : 401,
            'message' => 'Data retrieve',
            'data' => [
                'view' => $view,
                'order' => $order,
                'index' => $index
            ]
        ]);
    }

    function showCardPackage(Request $request)
    {
        $index = $request->id;
        $view = view('order.partials.card-package', [
            'id' => $index,
            'package' => Package::all()
        ])->render();

        return response()->json([
            'message' => "Data retrieve",
            'data' => [
                'view' => $view
            ]
        ]);
    }

    public function edit($id)
    {
        // get branch from user
        $user = Auth::user();
        $branch = UsersBranch::where('branch_id', $user->id)->with('branch')->first();
        $orders = Orders::where('id', $id)->with(['orderPackage.package', 'customer', 'branch'])->first();
        $orders = Orders::with([
            'orderPackage.package', 'customer.village',
            'branch',
            'orderPackage.offal.offal',
            'orderPackage.meat.meat',
            'orderPackage.chicken.chicken',
            'orderPackage.vegie.vegie',
            'orderPackage.rice.rice',
            'orderPackage.egg.egg',
            'customer.district', 'payment'
        ])
            ->findOrFail($id);
        $villages = Village::where('district_id', $orders->customer->district_id)->get();
        $data['branch'] = $branch;
        $data['allBranch'] = Branch::all();
        $data['payment'] = Payment::all();
        $data['typeOrder'] = TypeOrder::all();
        $data['package'] = Package::all();
        $data['shippings'] = Shipping::all();
        $data['order'] = $orders;
        $data['id'] = $id;
        $data['districts'] = District::all();
        $data['villages'] = $villages;
        return view('order.show')->with($data);
    }

    public function show($id)
    {
        $orders = Orders::with([
            'orderPackage.package', 'customer.village',
            'orderPackage.offal.offal',
            'orderPackage.meat.meat',
            'orderPackage.chicken.chicken',
            'orderPackage.vegie.vegie',
            'orderPackage.rice.rice',
            'orderPackage.egg.egg',
            'customer.district', 'payment'
        ])
            ->findOrFail($id);
        return view('order.detail', [
            'data' => $orders,
        ]);
    }

    public function getAllMenu($orderPackage)
    {
        $allMenus = [];
        $rices = [];
        $isArabic = [];
        $menu1 = [];
        $menu2 = [];
        $menu3 = [];
        $menu4 = [];
        $menu5 = [];
        for ($a = 0; $a < count($orderPackage); $a++) {
            if ($orderPackage[$a]['meat'] != null) {
                $allMenus[] = 'Daging ' . $orderPackage[$a]['meat']['meat']['name'];
                $menu1[] = 'Daging ' . $orderPackage[$a]['meat']['meat']['name'];
            }
            if ($orderPackage[$a]['offal'] != null) {
                $allMenus[] = 'Jeroan ' . $orderPackage[$a]['offal']['offal']['name'];
                $menu2[] = 'Jeroan ' . $orderPackage[$a]['offal']['offal']['name'];
            }
            if ($orderPackage[$a]['chicken'] != null) {
                $allMenus[] = 'Ayam ' . $orderPackage[$a]['chicken']['chicken']['name'];
                $menu3[] = 'Ayam ' . $orderPackage[$a]['chicken']['chicken']['name'];
            }
            if ($orderPackage[$a]['egg'] != null) {
                $allMenus[] = 'Telur ' . $orderPackage[$a]['egg']['egg']['name'];
                $menu4[] = 'Telur ' . $orderPackage[$a]['egg']['egg']['name'];
            }
            if ($orderPackage[$a]['vegie'] != null) {
                $allMenus[] = 'Menu Pilihan 2 ' . $orderPackage[$a]['vegie']['vegie']['name'];
                $menu5[] = 'Menu Pilihan 2 ' . $orderPackage[$a]['vegie']['vegie']['name'];
            }
            if ($orderPackage[$a]['rice'] != null) {
                $allMenus[] = 'Beras ' . $orderPackage[$a]['rice']['rice']['name'];
                $rices[] = $orderPackage[$a]['rice']['rice']['name'];
                if ($orderPackage[$a]['rice']['rice']['is_arabic_rice']) {
                    $isArabic[] =  $orderPackage[$a]['rice']['rice']['name'];
                }
            }
        }

        return [
            'allMenus' => $allMenus,
            'rices' => $rices,
            'isArabic' => $isArabic,
            'menu1' => $menu1,
            'menu2' => $menu2,
            'menu3' => $menu3,
            'menu4' => $menu4,
            'menu5' => $menu5
        ];
    }

    public function store(Request $request)
    {
        // return response()->json([
        //     'data' => $request->all()
        // ]);
        $dataCustomer = [
            'name' => $request->name,
            'name_of_aqiqah' => $request->name_of_aqiqah,
            'gender_of_aqiqah' => $request->gender_of_aqiqah,
            'birth_of_date' => $request->birth_of_date,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'address' => $request->address,
            'district_id' => $request->district,
            'village_id' => $request->village,
            'postalcode' => $request->postalcode,
            'phone_1' => $request->phone_1,
            'phone_2' => $request->number_2,
            'created_at' => Carbon::now()
        ];
        $dataOrder = [
            'market_temperature' => $request->market_temperature,
            'payment_id' => $request->payment,
            'branch_id' => $request->branchId,
            'send_date' => $request->send_date . ' ' . $request->send_time,
            'send_time' => $request->send_time,
            'consumsion_time' => $request->consumsion_time,
            'branch_group_id' => $request->branch_group,
            'number_of_goats' => $request->number_of_goats,
            'gender_of_goats' => $request->gender_of_goats,
            'type_order_id' => $request->type_order,
            'maklon' => $request->maklon ?? 0,
            'qty' => $request->qty_order ?? 0,
            'shipping_id' => $request->shipping,
            'source_order_id' => $request->source_order,
            'total' => $request->total ?? 0,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now()
        ];

        // validation input field
        if (
            $request->name == "" || $request->phone_1 == '' ||
            $request->source_order == '' || $request->market_temperature == ''
        ) {
            return response()->json([
                'message' => 'Pastikan semua field data leads terisi',
                'data' => []
            ]);
        }

        // validate quota
        if ($request->qty_order != '') {
            $validate = $this->validateQuota([
                'branch_id' => $request->branchId,
                'send_date' => $request->send_date,
                'send_time' => $request->send_time,
                'qty' => $request->qty_order
            ]);
            if (!$validate['status']) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Jumlah order tidak boleh melebihi ' . $validate['quota']
                ]);
            }
        }

        // validation image
        // if (!$request->has('proof_of_payment') && !$request->has('kk') && !$request->has('ktp')) {
        //     return response()->json([
        //         'message' => 'Gambar harus di upload',
        //         'status' => 400
        //     ]);
        // }

        // validation package
        // $reqPackage = $request->package;
        // $validatePackage = $this->validatePackage($reqPackage);
        // if (!$validatePackage) {
        //     return response()->json([
        //         'message' => 'Pastikan detail menu tiap paket telah terisi',
        //         'status' => 400
        //     ]);
        // }

        // append new value to dataOrder
        $dataOrder['notes'] = $request->notes;
        $dataOrder['additional_price'] = $request->additional_price ?? 0;
        $dataOrder['discount_price'] = $request->discount_price ?? 0;

        DB::beginTransaction();
        try {
            $customer = Customers::insertGetId($dataCustomer);
            $dataOrder['customer_id'] = $customer;

            // save images
            if ($request->has('proof_of_payment')) {
                $ext = $request->file('proof_of_payment')->getClientOriginalExtension();
                $name = 'customer_pay_branch_' . $request->branchId . '.' . $ext;
                $path = $this->storeFile("customers", $request->file('proof_of_payment'), $name);
                $dataOrder['proof_of_payment_img'] = 'uploaded_files/customers/' . $name;
            }
            if ($request->has('kk')) {
                $ext = $request->file('kk')->getClientOriginalExtension();
                $name = 'customer_kk_branch_' . $request->branchId . '.' . $ext;
                $path = $this->storeFile("customers", $request->file('kk'), $name);
                $dataOrder['kk_img'] = 'uploaded_files/customers/' . $name;
            }
            if ($request->has('ktp')) {
                $ext = $request->file('ktp')->getClientOriginalExtension();
                $name = 'customer_ktp_branch_' . $request->branchId . '.' . $ext;
                $path = $this->storeFile("customers", $request->file('ktp'), $name);
                $dataOrder['ktp_img'] = 'uploaded_files/customers/' . $name;
            }
            $order = Orders::insertGetId($dataOrder);
            // insert many to many relation
            if ($request->has('package')) {
                for ($a = 0; $a < count($request->package); $a++) {
                    // insert to order package table
                    $orderPackge = OrderPackage::insertGetId([
                        'package_id' => $request->package[$a]['package_id'],
                        'order_id' => $order,
                        'created_at' => Carbon::now()
                    ]);

                    // insert to relation
                    if (isset($request->package[$a]['meat_menu'])) {
                        $packageMeatItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'meat_menu_id' => $request->package[$a]['meat_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['meat_menu'] == 'free_text') {
                            // insert new type free text in meat menu table
                            if ($request->package[$a]['meat_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeMeat = MeatMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['meat_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeMeat != '' || $checkFreeMeat != null) {
                                    $freeMeatId = $checkFreeMeat->id;
                                } else {
                                    $freeMeatId = MeatMenu::insertGetId([
                                        'name' => $request->package[$a]['meat_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageMeatItem['meat_menu_id'] = $freeMeatId;
                            }
                        }
                        PackageMeat::insert($packageMeatItem);
                    }
                    if (isset($request->package[$a]['offal_menu'])) {
                        $packageOffalItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'offal_menu_id' => $request->package[$a]['offal_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['offal_menu'] == 'free_text') {
                            // insert new type free text in offal menu table
                            if ($request->package[$a]['offal_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeOffal = OffalMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['offal_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeOffal != '' || $checkFreeOffal != null) {
                                    $freeOffalId = $checkFreeOffal->id;
                                } else {
                                    $freeOffalId = OffalMenu::insertGetId([
                                        'name' => $request->package[$a]['offal_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageOffalItem['offal_menu_id'] = $freeOffalId;
                            }
                        }
                        PackageOffal::insert($packageOffalItem);
                    }
                    if (isset($request->package[$a]['rice_menu'])) {
                        PackageRice::insert([
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'rice_menu_id' => $request->package[$a]['rice_menu'],
                            'created_at' => Carbon::now()
                        ]);
                    }
                    if (isset($request->package[$a]['vegetable_menu'])) {
                        $packageVegetableItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'vegetable_menu_id' => $request->package[$a]['vegetable_menu'],
                            'created_at' => Carbon::now()
                        ];

                        if ($request->package[$a]['vegetable_menu'] == 'free_text') {
                            // insert new type free text in Egg menu table
                            if ($request->package[$a]['vegetable_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeVegetable = VegetableMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['vegetable_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeVegetable != '' || $checkFreeVegetable != null) {
                                    $freeEggId = $checkFreeVegetable->id;
                                } else {
                                    $freeEggId = VegetableMenu::insertGetId([
                                        'name' => $request->package[$a]['vegetable_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageVegetableItem['vegetable_menu_id'] = $freeEggId;
                            }
                        }
                        PackageVegetable::insert($packageVegetableItem);
                    }
                    if (isset($request->package[$a]['egg_menu'])) {
                        $packageEggItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'egg_menu_id' => $request->package[$a]['egg_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['egg_menu'] == 'free_text') {
                            // insert new type free text in Egg menu table
                            if ($request->package[$a]['egg_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeEgg = EggMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['egg_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeEgg != '' || $checkFreeEgg != null) {
                                    $freeEggId = $checkFreeEgg->id;
                                } else {
                                    $freeEggId = EggMenu::insertGetId([
                                        'name' => $request->package[$a]['egg_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageEggItem['egg_menu_id'] = $freeEggId;
                            }
                        }
                        PackageEgg::insert($packageEggItem);
                    }
                    if (isset($request->package[$a]['chicken_menu'])) {
                        $packageChickenItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'chicken_menu_id' => $request->package[$a]['chicken_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['chicken_menu'] == 'free_text') {
                            // insert new type free text in Egg menu table
                            if ($request->package[$a]['chicken_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeEgg = ChickenMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['chicken_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeEgg != '' || $checkFreeEgg != null) {
                                    $freeEggId = $checkFreeEgg->id;
                                } else {
                                    $freeEggId = ChickenMenu::insertGetId([
                                        'name' => $request->package[$a]['chicken_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageChickenItem['chicken_menu_id'] = $freeEggId;
                            }
                        }
                        PackageChicken::insert($packageChickenItem);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Success',
                'status' => 200,
                'data' => []
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 422,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $dataCustomer = [
            'name' => $request->name,
            'name_of_aqiqah' => $request->name_of_aqiqah,
            'gender_of_aqiqah' => $request->gender_of_aqiqah,
            'birth_of_date' => $request->birth_of_date,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'address' => $request->address,
            'district_id' => $request->district,
            'village_id' => $request->village,
            'postalcode' => $request->postalcode,
            'phone_1' => $request->phone_1,
            'phone_2' => $request->number_2,
            'created_at' => Carbon::now()
        ];
        $dataOrder = [
            'market_temperature' => $request->market_temperature,
            'payment_id' => $request->payment,
            'branch_id' => $request->branchId,
            'send_date' => $request->send_date . ' ' . $request->send_time,
            'send_time' => $request->send_time,
            'consumsion_time' => $request->consumsion_time,
            'branch_group_id' => $request->branch_group,
            'number_of_goats' => $request->number_of_goats,
            'gender_of_goats' => $request->gender_of_goats,
            'type_order_id' => $request->type_order,
            'maklon' => $request->maklon ?? 0,
            'qty' => $request->qty_order ?? 0,
            'shipping_id' => $request->shipping,
            'source_order_id' => $request->source_order,
            'total' => $request->total,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now()
        ];

        // validation input field
        if (
            $request->name == "" || $request->phone_1 == '' ||
            $request->source_order == '' || $request->market_temperature == ''
        ) {
            return response()->json([
                'message' => 'Pastikan semua field data leads terisi',
                'data' => []
            ]);
        }

        // validate quota
        if ($request->qty_order != '' || $request->qty_order == 0) {
            $validate = $this->validateQuota([
                'branch_id' => $request->branchId,
                'send_date' => $request->send_date,
                'send_time' => $request->send_time,
                'qty' => $request->qty_order
            ]);
            if (!$validate['status']) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Jumlah order tidak boleh melebihi ' . $validate['quota']
                ]);
            }
        }

        // validation image
        // if ($request->static_file_id == 0) {
        //     if (!$request->has('proof_of_payment') && !$request->has('kk') && !$request->has('ktp')) {
        //         return response()->json([
        //             'message' => 'Gambar harus di upload',
        //             'status' => 400
        //         ]);
        //     }
        // }

        // validation package
        // $reqPackage = $request->package;
        // $validatePackage = $this->validatePackage($reqPackage);
        // if (!$validatePackage) {
        //     return response()->json([
        //         'message' => 'Pastikan detail menu tiap paket telah terisi',
        //         'status' => 400
        //     ]);
        // }

        // append new value to dataOrder
        $dataOrder['notes'] = $request->notes;
        $dataOrder['additional_price'] = $request->additional_price ?? 0;
        $dataOrder['discount_price'] = $request->discount_price ?? 0;

        $currentData = Orders::with(['customer', 'orderPackage.package'])->findOrFail($id);

        // return response()->json([
        //     'currnt' => $currentData,
        //     'order' => $dataOrder,
        //     'customer' => $dataCustomer,
        //     'package' => $request->package,
        //     'file' => $request->file('proof_of_payment')
        // ]);

        DB::beginTransaction();
        try {
            $customer = Customers::where('id', $currentData->customer->id)
                ->update($dataCustomer);
            $dataOrder['customer_id'] = $currentData->customer->id;

            // save images
            if ($request->has('proof_of_payment')) {
                $ext = $request->file('proof_of_payment')->getClientOriginalExtension();
                $name = 'customer_pay_branch_' . $request->branchId . '.' . $ext;
                $path = $this->storeFile("customers", $request->file('proof_of_payment'), $name);
                $dataOrder['proof_of_payment_img'] = 'uploaded_files/customers/' . $name;
            }
            if ($request->has('kk')) {
                $ext = $request->file('kk')->getClientOriginalExtension();
                $name = 'customer_kk_branch_' . $request->branchId . '.' . $ext;
                $path = $this->storeFile("customers", $request->file('kk'), $name);
                $dataOrder['kk_img'] = 'uploaded_files/customers/' . $name;
            }
            if ($request->has('ktp')) {
                $ext = $request->file('ktp')->getClientOriginalExtension();
                $name = 'customer_ktp_branch_' . $request->branchId . '.' . $ext;
                $path = $this->storeFile("customers", $request->file('ktp'), $name);
                $dataOrder['ktp_img'] = 'uploaded_files/customers/' . $name;
            }
            $order = Orders::where('id', $id)
                ->update($dataOrder);

            // delete current reletion
            if ($request->has('package')) {
                for ($x = 0; $x < count($currentData->orderPackage); $x++) {
                    // delete current realtion
                    PackageMeat::where('order_id', $currentData->orderPackage[$x]['id'])
                        ->delete();
                    // delete current realtion
                    PackageOffal::where('order_id', $currentData->orderPackage[$x]['id'])
                        ->delete();
                    // delete current realtion
                    PackageRice::where('order_id', $currentData->orderPackage[$x]['id'])
                        ->delete();
                    // delete current realtion
                    PackageVegetable::where('order_id', $currentData->orderPackage[$x]['id'])
                        ->delete();
                    // delete current realtion
                    PackageEgg::where('order_id', $currentData->orderPackage[$x]['id'])
                        ->delete();
                    // delete current realtion
                    PackageChicken::where('order_id', $currentData->orderPackage[$x]['id'])
                        ->delete();

                    // delete current orderPackage
                    OrderPackage::where('id', $currentData->orderPackage[$x]['id'])
                        ->delete();
                }

                // insert many to many relation
                for ($a = 0; $a < count($request->package); $a++) {
                    // insert to order package table
                    $orderPackge = OrderPackage::insertGetId([
                        'package_id' => $request->package[$a]['package_id'],
                        'order_id' => $id,
                        'created_at' => Carbon::now()
                    ]);

                    // insert to relation
                    if (isset($request->package[$a]['meat_menu'])) {
                        $packageMeatItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'meat_menu_id' => $request->package[$a]['meat_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['meat_menu'] == 'free_text') {
                            // insert new type free text in meat menu table
                            if ($request->package[$a]['meat_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeMeat = MeatMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['meat_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeMeat != '' || $checkFreeMeat != null) {
                                    $freeMeatId = $checkFreeMeat->id;
                                } else {
                                    $freeMeatId = MeatMenu::insertGetId([
                                        'name' => $request->package[$a]['meat_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageMeatItem['meat_menu_id'] = $freeMeatId;
                            }
                        }
                        PackageMeat::insert($packageMeatItem);
                    }
                    if (isset($request->package[$a]['offal_menu'])) {
                        $packageOffalItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'offal_menu_id' => $request->package[$a]['offal_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['offal_menu'] == 'free_text') {
                            // insert new type free text in offal menu table
                            if ($request->package[$a]['offal_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeOffal = OffalMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['offal_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeOffal != '' || $checkFreeOffal != null) {
                                    $freeOffalId = $checkFreeOffal->id;
                                } else {
                                    $freeOffalId = OffalMenu::insertGetId([
                                        'name' => $request->package[$a]['offal_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageOffalItem['offal_menu_id'] = $freeOffalId;
                            }
                        }
                        PackageOffal::insert($packageOffalItem);
                    }
                    if (isset($request->package[$a]['rice_menu'])) {
                        PackageRice::insert([
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'rice_menu_id' => $request->package[$a]['rice_menu'],
                            'created_at' => Carbon::now()
                        ]);
                    }
                    if (isset($request->package[$a]['vegetable_menu'])) {
                        $packageVegetableItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'vegetable_menu_id' => $request->package[$a]['vegetable_menu'],
                            'created_at' => Carbon::now()
                        ];

                        if ($request->package[$a]['vegetable_menu'] == 'free_text') {
                            // insert new type free text in Egg menu table
                            if ($request->package[$a]['vegetable_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeVegetable = VegetableMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['vegetable_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeVegetable != '' || $checkFreeVegetable != null) {
                                    $freeEggId = $checkFreeVegetable->id;
                                } else {
                                    $freeEggId = VegetableMenu::insertGetId([
                                        'name' => $request->package[$a]['vegetable_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageVegetableItem['vegetable_menu_id'] = $freeEggId;
                            }
                        }
                        PackageVegetable::insert($packageVegetableItem);
                    }
                    if (isset($request->package[$a]['egg_menu'])) {
                        $packageEggItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'egg_menu_id' => $request->package[$a]['egg_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['egg_menu'] == 'free_text') {
                            // insert new type free text in Egg menu table
                            if ($request->package[$a]['egg_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeEgg = EggMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['egg_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeEgg != '' || $checkFreeEgg != null) {
                                    $freeEggId = $checkFreeEgg->id;
                                } else {
                                    $freeEggId = EggMenu::insertGetId([
                                        'name' => $request->package[$a]['egg_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageEggItem['egg_menu_id'] = $freeEggId;
                            }
                        }
                        PackageEgg::insert($packageEggItem);
                    }
                    if (isset($request->package[$a]['chicken_menu'])) {
                        $packageChickenItem = [
                            'order_id' => $orderPackge,
                            'package_id' => $request->package[$a]['package_id'],
                            'chicken_menu_id' => $request->package[$a]['chicken_menu'],
                            'created_at' => Carbon::now()
                        ];
                        if ($request->package[$a]['chicken_menu'] == 'free_text') {
                            // insert new type free text in Egg menu table
                            if ($request->package[$a]['chicken_menu_custom'] != '') {
                                // check if new name is already saved in database
                                $checkFreeEgg = ChickenMenu::whereRaw("LOWER(name) = '" . strtolower($request->package[$a]['chicken_menu_custom']) . "'")
                                    ->first();
                                if ($checkFreeEgg != '' || $checkFreeEgg != null) {
                                    $freeEggId = $checkFreeEgg->id;
                                } else {
                                    $freeEggId = ChickenMenu::insertGetId([
                                        'name' => $request->package[$a]['chicken_menu_custom'],
                                        'is_custom' => true,
                                        'created_at' => Carbon::now()
                                    ]);
                                }
                                $packageChickenItem['chicken_menu_id'] = $freeEggId;
                            }
                        }
                        PackageChicken::insert($packageChickenItem);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Success',
                'status' => 200,
                'data' => []
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 422,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function showFileUploader(Request $request)
    {
        $id = $request->id;
        $order = "";
        $isEdit = false;
        if ($request->has('isEdit')) {
            $order = Orders::where('id', $request->orderId)->first();
            $isEdit = true;
        }
        $view = "";
        if ($id == 1) {
            $view = view('order.partials.file-cash', ['order' => $order, 'isEdit' => $isEdit])->render();
        } else {
            $view = view('order.partials.file-credit', ['order' => $order, 'isEdit' => $isEdit])->render();
        }
        return response()->json([
            'message' => 'Data retrieve',
            'data' => [
                'view' => $view
            ]
        ]);
    }

    public function getVillages(Request $request)
    {
        $id = $request->id;
        $villages = Village::where('district_id', $id)->get();

        return response()->json([
            'message' => 'Data retrieve',
            'data' => $villages
        ]);
    }

    public function validatePackage($reqPackage)
    {
        $isValid = true;
        for ($cc = 0; $cc < count($reqPackage); $cc++) {
            switch ($reqPackage[$cc]['package_id']) {
                case '1':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['offal_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                case '2':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['offal_menu']) ||
                        !isset($reqPackage[$cc]['rice_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                case '3':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['offal_menu']) ||
                        !isset($reqPackage[$cc]['rice_menu']) ||
                        !isset($reqPackage[$cc]['egg_menu']) ||
                        !isset($reqPackage[$cc]['vegetable_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                case '4':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['offal_menu']) ||
                        !isset($reqPackage[$cc]['rice_menu']) ||
                        !isset($reqPackage[$cc]['chicken_menu']) ||
                        !isset($reqPackage[$cc]['vegetable_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                case '5':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['offal_menu']) ||
                        !isset($reqPackage[$cc]['rice_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                case '6':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['vegetable_menu']) ||
                        !isset($reqPackage[$cc]['rice_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                case '7':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['chicken_menu']) ||
                        !isset($reqPackage[$cc]['rice_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                case '8':
                    if (
                        !isset($reqPackage[$cc]['meat_menu']) ||
                        !isset($reqPackage[$cc]['offal_menu']) ||
                        !isset($reqPackage[$cc]['rice_menu']) ||
                        !isset($reqPackage[$cc]['egg_menu']) ||
                        !isset($reqPackage[$cc]['vegetable_menu'])
                    ) {
                        $isValid = false;
                    }
                    break;

                default:
                    $isValid = true;
                    break;
            }
        }

        return $isValid;
    }
}
