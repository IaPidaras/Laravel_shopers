<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Загружаем заказы с их элементами и статусом
        $orders = Order::where('id_user', $user->id)
                       ->with(['orderItems.product', 'status'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('profile', compact('user', 'orders'));
    }

    public function cancelOrder($id_order)
    {
        $order = Order::where('id_user', auth()->id())->findOrFail($id_order);

        // id_status === 1 — это статус "Новый"
        if ($order->id_status === 1) {
            $order->delete();
            return redirect()->back()->with('success', 'Заказ успешно удален.');
        }

        return redirect()->back()->with('error', 'Нельзя удалить этот заказ.');
    }
}
