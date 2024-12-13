<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;

class ManageOrderController extends Controller
{
    public function PendingOrder()
    {
        $allData = Order::where('status', 'pending')->orderBy('id', 'desc')->get();
        return view('admin.backend.order.pending_order', compact('allData'));
    }
    public function ConfirmOrder()
    {
        $allData = Order::where('status', 'confirm')->orderBy('id', 'desc')->get();
        return view('admin.backend.order.confirm_order', compact('allData'));
    }
    public function ProccesingOrder()
    {
        $allData = Order::where('status', 'processing')->orderBy('id', 'desc')->get();
        return view('admin.backend.order.processing_order', compact('allData'));
    }
    public function DeliverdOrder()
    {
        $allData = Order::where('status', 'deliverd')->orderBy('id', 'desc')->get();
        return view('admin.backend.order.deliverd_order', compact('allData'));
    }

    public function AdminOrderDetails($id)
    {
        $order = Order::with('user')->where('id', $id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $id)->orderBy('id', 'desc')->get();
        $totalPrice = 0;
        foreach ($orderItem as $item) {
            $totalPrice += $item->price * $item->qty;
        }
        return view('admin.backend.order.order_detail', compact('order', 'orderItem', 'totalPrice'));
    } //End Method

    public function PendingToConfirm($id)
    {
        Order::find($id)->update(['status' => 'confirm']);
        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('confirm.order')->with($notification);
    }
    //End Method
    public function ConfirmToProcessing($id)
    {
        Order::find($id)->update(['status' => 'processing']);
        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('processing.order')->with($notification);
    }
    //End Method
    public function ProcessingToDiliverd($id)
    {
        Order::find($id)->update(['status' => 'deliverd']);
        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('deliverd.order')->with($notification);
    }
    //End Method
}
