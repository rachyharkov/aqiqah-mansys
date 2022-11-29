<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\UsersBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    private $viewPath;

    /**
     * Construct function
     */
    public function __construct()
    {
        $this->viewPath = 'users_management.branch';
    }

    /**
     * for list branch ui
     */
    public function index() {
        $branch = Branch::all();
        $data = [
            'branches' => $branch
        ];

        return view($this->viewPath . '.index')
            ->with($data);
    }

    /**
     * @param page
     * @param limit
     * @var JsonResponse
     */
    public function json($page, $limit) {
        $branch = Branch::select('id', 'name')
            ->skip($page)
            ->limit($limit)
            ->get();

        $data = [
            'branches' => $branch
        ];
        $view = view($this->viewPath . '.table-list')
            ->with($data)->render();

        return response()->json([
            'message' => 'Data retrieve',
            'data' => [
                'view' => $view
            ]
        ]);
    }

    /**
     * @var JsonResponse
     */
    public function list() {
        $branch = Branch::all();

        return response()->json([
            'message' => 'Data retrieve',
            'data' => $branch
        ]);
    }

    /**
     * @param name
     * @var JsonResponse
     */
    public function update(Request $request) {
        // validation
        $validate = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            $error = array_values($errors);
            $err = [];
            for ($a = 0; $a < count($error); $a++) {
                $err[] = implode(',', $error[$a]);
            }
            return response()->json([
                'message' => $err,
                'status' => 422
            ]);
        }
        $currentData = Branch::where('id', $request->id)->first();
        if ($currentData->name != $request->name) {
            $name = strtolower($request->name);
            $check = Branch::whereRaw("LOWER(name) = '$name'")
                ->first();
            if ($check) {
                return response()->json([
                    'message' => 'Nama sudah ada di dalam database',
                    'status' => 422
                ]);
            }
        }
        
        // update
        $payload = [
            'name' => $request->name
        ];
        try {
            Branch::where('id', $request->id)
                ->update($payload);

            return response()->json([
                'message' => 'Update success',
                'status' => 200,
                'data' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 422
            ]);
        }
    }

    public function store(Request $request) {
        /// validation
        $validate = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            $error = array_values($errors);
            $err = [];
            for ($a = 0; $a < count($error); $a++) {
                $err[] = implode(',', $error[$a]);
            }
            return response()->json([
                'message' => $err,
                'status' => 422
            ]);
        }
        $check = Branch::whereRaw("LOWER(name) = '$request->name'")
            ->first();
        if ($check) {
            return response()->json([
                'message' => 'Nama sudah ada di dalam database',
                'status' => 422
            ]);
        }

        // store
        $payload = [
            'name' => $request->name
        ];
        try {
            Branch::insert($payload);

            return response()->json([
                'message' => 'Save success',
                'status' => 200,
                'data' => [] 
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 422
            ]);
        }
    }

    /**
     * @param id
     * @var JsonResponse
     */
    public function edit($id) {
        $branch = Branch::findOrFail($id);

        return response()->json([
            'message' => 'Data retrieve',
            'data' => $branch
        ]);
    }

    /**
     * @param id
     * @var JsonResponse
     */
    public function detail($id) {
        $branch = Branch::with(['pBranch', 'orders'])
            ->where('id', $id)
            ->first();
        $data = [
            'branch' => $branch
        ];
        $view = view($this->viewPath . '.detail')
            ->with($data)
            ->render();
        return response()->json([
            'message' => 'Data retrieve',
            'status' => 200,
            'data' => [
                'view' => $view
            ]
        ]);
    }

    /**
     * @param id
     * @var JsonResponse
     */
    public function delete(Request $request) {
        $id = $request->id;
        // check relation to user
        $relation = UsersBranch::select('id')
            ->where('branch_id', $id)
            ->get();

        $isDelete = true;
        if (count($relation) > 0) {
            $isDelete = false;
        }

        try {
            $delete = 0;
            if ($isDelete) {
                $delete = Branch::where('id', $id)
                    ->delete();
            }
    
            return response()->json([
                'message' => !$isDelete ? 'Hapus gagal, cabang ini masih mempunyai relasi dengan user' : 'Success',
                'status' => !$isDelete ? 422 : 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => []
            ]);
        }
    }
}
