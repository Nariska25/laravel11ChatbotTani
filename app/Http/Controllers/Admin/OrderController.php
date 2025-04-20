<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $belumbayarOrders = Order::where('order_status', 'Belum Bayar')->get();
        $telahdibayarOrders = Order::where('order_status', 'Telah Dibayar')->get();
        $sedangdikemasOrders = Order::where('order_status', 'Sedang Dikemas')->get();
        $dikirimOrders = Order::where('order_status', 'Dikirim')->get();
        $selesaiOrders = Order::where('order_status', 'Selesai')->get();
        $dibatalkanOrders = Order::where('order_status', 'Dibatalkan')->get();

        return view('admin.order.index', compact(
            'belumbayarOrders',
            'telahdibayarOrders',
            'sedangdikemasOrders',
            'dikirimOrders',
            'selesaiOrders',
            'dibatalkanOrders'
        ));
    }

    public function updateStatus(Request $request, $orderId)
{
    $order = Order::findOrFail($orderId);

    $validStatuses = ['Belum Bayar', 'Telah Dibayar', 'Sedang Dikemas', 'Dikirim', 'Selesai', 'Dibatalkan'];
    if (!in_array($request->status, $validStatuses)) {
        return back()->with('error', 'Invalid status.');
    }

    $order->order_status = $request->status;
    $order->save();

    return redirect()->route('admin.order.index')->with('success', 'Order status updated.');
}
}
