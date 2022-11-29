<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Branch;
use App\Models\Role;
use App\Models\UsersBranch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    private $viewPath;

    public function __construct()
    {
        $this->viewPath = 'users_management.users';
    }

    public function index() {
        $users = User::withTrashed()
            ->with(['roles', 'branches'])
            ->paginate(request('per_page', 10));

        return view($this->viewPath . '.index', [
            'users' => $users,
        ]);
    }

    /**
     * @param page
     * @param limit
     * @var JsonResponse
     */
    public function json($page, $limit) {
        $user = User::withTrashed()
            ->select('id', 'name', 'username', 'email', 'roles_id', 'deleted_at')
            ->skip($page)
            ->limit($limit)
            ->get();

        $data = [
            'users' => $user
        ];
        $view = view($this->viewPath . '.table-list')
            ->with($data)->render();

        return response()->json([
            'message' => 'Data retrieve',
            'data' => [
                'view' => $view
            ],
            'user' => $data
        ]);
    }

    /**
     * Get branch and role list
     */
    public function generalData() {
        $role = Role::all();
        $branch = Branch::all();

        $data = [
            'role' => $role,
            'branch' => $branch
        ];
        return response()->json([
            'message' => 'Data Retrieve',
            'data' => $data
        ]);
    }

    /**
     * @param name
     * @var JsonResponse
     */
    public function update(Request $request) {
        $id = $request->id;
        // validation
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'role' => 'required',
            'email' => 'required'
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
        $currentUser = User::withTrashed()
                ->with('branches')
                ->findOrFail($id);

        if ($currentUser->username != $request->username) {
            $check = User::whereRaw("LOWER(username) = '$request->username'")
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
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'roles_id' => $request->role,
            'created_at' => Carbon::now()
        ];
        if ($request->has('password') || $request->password != '') {
            $payload['password'] = Hash::make($request->password);
        }

        try {
            DB::beginTransaction();

            UsersBranch::where('users_id', $currentUser->id)->delete();

            if ($request->filled('branch')) {
                UsersBranch::insert([
                    'users_id' => $currentUser->id,
                    'branch_id' => $request->branch,
                    'created_at' => Carbon::now()
                ]);
            }

            // update user table
            User::where('id', $id)
                ->update($payload);
            DB::commit();
            return response()->json([
                'message' => 'Update success',
                'status' => 200,
                'data' => []
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 422
            ]);
        }
    }

    public function store(Request $request) {
        /// validation
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'role' => 'required',
            'email' => 'required'
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
        $check = User::whereRaw("LOWER(username) = '$request->username'")
            ->first();
        if ($check) {
            return response()->json([
                'message' => 'Nama sudah ada di dalam database',
                'status' => 422
            ]);
        }

        // store
        $payload = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'roles_id' => $request->role,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now()
        ];
        try {
            DB::beginTransaction();

            $userId = User::insertGetId($payload);

            if ($request->filled('branch')) {
                UsersBranch::insert([
                    'users_id' => $userId,
                    'branch_id' => $request->branch,
                    'created_at'    => Carbon::now(),
                ]);

            }

            DB::commit();
            return response()->json([
                'message' => 'Save success',
                'status' => 200,
                'data' => []
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
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
        $user = User::withTrashed()
            ->with('branches')->findOrFail($id);
        $role = Role::all();
        $branch = Branch::all();

        return response()->json([
            'message' => 'Data retrieve',
            'data' => [
                'user' => $user,
                'branch' => $branch,
                'role' => $role
            ]
        ]);
    }

    /**
     * @param id
     * @var JsonResponse
     */
    public function detail($id) {
        $user = User::withTrashed()
            ->with(['branches.branch'])
            ->where('id', $id)
            ->first();
        $data = [
            'user' => $user
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
        $delete = User::where('id', $id)->delete();

        return response()->json([
            'message' => 'Delete success',
            'data' => []
        ]);
    }

    /**
     * Init user
     */
    public function init() {
        $user = Auth::user();
        $userBranch = User::with('branches')
            ->where('id', $user->id)
            ->first();

        return response()->json([
            'message' => 'Data retrieve',
            'data' => $userBranch
        ]);
    }
}
