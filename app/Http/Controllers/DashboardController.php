<?php

namespace App\Http\Controllers;

use App\Models\Order\Order;
use App\Models\UsersBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Source orders
        // 1: IG
        // 2: Facebook
        // 3: Google
        // 4: Others
        /** @var \App\User */
        $user = Auth::user();
        $userBranch = UsersBranch::query()
            ->where('users_id', $user->id)
            ->first();
        $formatIdrNumber = function ($number) {
            return number_format($number, 0, ',', '.');
        };
        $countOrders = function () use ($formatIdrNumber, $userBranch) {
            return $formatIdrNumber(
                Order::query()
                    ->when(!is_null($userBranch), function ($query) use ($userBranch) {
                        $query->where('branch_id', $userBranch->branch_id);
                    })
                    ->count()
            );
        };
        $countOrdersBySourceOrderId = function ($sourceOrderId) use ($formatIdrNumber, $userBranch) {
            return $formatIdrNumber(
                Order::query()
                    ->when(!is_null($userBranch), function ($query) use ($userBranch) {
                        $query->where('branch_id', $userBranch->branch_id);
                    })
                    ->where('source_order_id', $sourceOrderId)
                    ->count()
            );
        };

        return view('dashboard', [
            'totalOrders' => $countOrders(),
            'totalInstagramOrders' => $countOrdersBySourceOrderId(1),
            'totalFacebookOrders' => $countOrdersBySourceOrderId(2),
            'totalGoogleOrders' => $countOrdersBySourceOrderId(3),
            'totalOthersOrders' => $countOrdersBySourceOrderId(4),
        ]);
    }
}
