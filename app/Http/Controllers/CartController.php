<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; 
use App\Models\Product; 
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CartController extends Controller
{
    // 1. ПРОСМОТР КОРЗИНЫ
    public function index()
    {
        $cartItems = Cart::where('id_user', auth()->id())->with('product')->get();

        $totalSum = 0;
        foreach ($cartItems as $item) {
            $totalSum += $item->product->cost * $item->count;
        }

        return view('cart', compact('cartItems', 'totalSum'));
    }

    // 2. ДОБАВЛЕНИЕ ТОВАРА В КОРЗИНУ
    public function add($id_product)
    {
        $product = Product::findOrFail($id_product);
        $userId = auth()->id();

        $cartItem = Cart::where('id_user', $userId)
                        ->where('id_product', $id_product)
                        ->first();

        if ($cartItem) {
            if ($cartItem->count < $product->count) {
                $cartItem->increment('count');
            } else {
                return redirect()->back()->with('error', 'Нельзя добавить больше, чем есть на складе!');
            }
        } else {
            if ($product->count > 0) {
                Cart::create([
                    'id_user' => $userId,
                    'id_product' => $id_product,
                    'count' => 1
                ]);
            } else {
                return redirect()->back()->with('error', 'К сожалению, этого товара нет в наличии.');
            }
        }

        return redirect()->route('cart')->with('success', 'Товар успешно добавлен в корзину!');
    }

    // 3. ИЗМЕНЕНИЕ КОЛИЧЕСТВА КНОПКАМИ ПЛЮС И МИНУС
    public function update(Request $request, $id_cart)
    {
        $cartItem = Cart::findOrFail($id_cart);

        if ($request->action == 'minus') {
            if ($cartItem->count > 1) {
                $cartItem->decrement('count');
            } else {
                $cartItem->delete();
                return redirect()->back()->with('success', 'Товар удален из корзины');
            }
        } 
        elseif ($request->action == 'plus') {
            if ($cartItem->count < $cartItem->product->count) {
                $cartItem->increment('count');
            } else {
                return redirect()->back()->with('error', 'Больше товара нет на складе!');
            }
        }

        return redirect()->back()->with('success', 'Количество обновлено');
    }

    // 4. УДАЛЕНИЕ ИЗ КОРЗИНЫ
    public function remove($id_cart)
    {
        $cartItem = Cart::findOrFail($id_cart);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Товар удален из корзины');
    }

    // 5. ОФОРМЛЕНИЕ ЗАКАЗА (БЕЗ JS)
    public function checkout(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ], [
            'password.required' => 'Введите пароль для подтверждения заказа.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'password' => 'Неверный пароль. Оформление заказа невозможно.'
            ])->withInput();
        }

        $cartItems = Cart::where('id_user', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Ваша корзина пуста.');
        }

        foreach ($cartItems as $item) {
            if ($item->count > $item->product->count) {
                return redirect()->back()->with('error', "Товара '{$item->product->name}' недостаточно на складе.");
            }
        }

        // Создаем заказ (id_status = 1 означаем "Новый")
        $order = Order::create([
            'id_user' => $user->id,
            'id_status' => 1, 
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'id_order' => $order->id_order,
                'id_product' => $item->id_product,
                'count' => $item->count,
                'price' => $item->product->cost,
            ]);

            $item->product->decrement('count', $item->count);
            $item->delete();
        }

        return redirect()->route('profile')->with('success', 'Заказ успешно сформирован!');
    }
}
