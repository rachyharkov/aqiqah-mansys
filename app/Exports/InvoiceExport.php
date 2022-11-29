<?php

namespace App\Exports;

use App\Models\Orders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceExport implements FromView,ShouldAutoSize
{
    private $start;
    private $end;
    private $branch;
    private $title;

    public function __construct($payload)
    {
        $this->start = $payload['start'];
        $this->end = $payload['end'];
        $this->branch = $payload['branch'] ?? null;
        $this->title = $payload['title'];
    }

    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
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
                'createdBy',
                'branch'
            ])
            ->where('send_date', '>=', $this->start)
            ->where('send_date', '<=', $this->end);

        if ($this->branch) {
            $orders = $orders->where('branch_id', $this->branch);
        }

        $orders = $orders->get();

        $orderPackage = [];
        foreach($orders as $or) {
            $breakdown = $this->getAllMenu($or->orderPackage);
            $orderPackage[] = [
                'allMenu' => implode(',', $breakdown['allMenus']),
                'rices' => implode(',', $breakdown['rices']),
                'isArabic' => implode(',', $breakdown['isArabic']),
                'menu1' => implode(',', $breakdown['menu1']),
                'menu2' => implode(',', $breakdown['menu2']),
                'menu3' => implode(',', $breakdown['menu3']),
                'menu4' => implode(',', $breakdown['menu4']),
                'menu5' => implode(',', $breakdown['menu5']),
            ];
        }
        $data = [
            'orders' => $orders,
            'orderPackage' => $orderPackage,
            'title' => $this->title
        ];
        return view('order.export.invoice')->with($data);
    }

    public function getAllMenu($orderPackage) {
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
}
