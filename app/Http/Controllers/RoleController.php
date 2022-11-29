<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    private $viewPath;

    /**
     * Construct function
     */
    public function __construct()
    {
        $this->viewPath = 'users_management.role';
    }

    /**
     * for list branch ui
     */
    public function index() {
        $role = Role::all();
        $data = [
            'roles' => $role
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
        $role = Role::select('id', 'nama')
            ->skip($page)
            ->limit($limit)
            ->get();

        $data = [
            'roles' => $role
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
        $currentData = Role::where('id', $request->id)->first();
        if ($currentData->nama != $request->name) {
            $name = strtolower($request->name);
            $check = Role::whereRaw("LOWER(nama) = '$name'")
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
            'nama' => $request->name
        ];
        try {
            Role::where('id', $request->id)
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
        $check = Role::whereRaw("LOWER(nama) = '$request->name'")
            ->first();
        if ($check) {
            return response()->json([
                'message' => 'Nama sudah ada di dalam database',
                'status' => 422
            ]);
        }

        // store
        $payload = [
            'nama' => $request->name
        ];
        try {
            Role::insert($payload);

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
        $role = Role::findOrFail($id);

        return response()->json([
            'message' => 'Data retrieve',
            'data' => $role
        ]);
    }

    /**
     * @param id
     * @var JsonResponse
     */
    public function detail($id) {
        $role = Role::with(['userRole'])
            ->where('id', $id)
            ->first();
        $data = [
            'role' => $role
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
        $relation = User::select('id')
            ->where('roles_id', $id)
            ->get();

        $isDelete = true;
        if (count($relation) > 0) {
            $isDelete = false;
        }

        try {
            $delete = 0;
            if ($isDelete) {
                $delete = Role::where('id', $id)
                    ->delete();
            }
    
            return response()->json([
                'message' => !$isDelete ? 'Hapus gagal, role ini masih mempunyai relasi dengan user' : 'Success',
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
