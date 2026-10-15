<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    // Открытие админки (и для просмотра, и для редактирования)
    public function index(Request $request)
    {
        // Проверяем: авторизован ли пользователь вообще И равна ли его роль 2
        if (\Auth::check() && \Auth::user()->id_role == 2) {

            $items = Product::all();
            $editItem = null;

            // Если в ссылке передан ?edit=ID, находим этот товар для верхней формы
            if ($request->has('edit')) {
                $editItem = Product::find($request->edit);
            }

            // Передаем и список, и редактируемый товар (если он есть) в ОДИН файл
            return view('admin', compact('items', 'editItem'));

        } else {
            // Если пользователь не админ или не авторизован — выкидываем на главную
            return redirect('/');
        }
    }

    // Сохранение нового товара
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string', 'cost' => 'required|integer|min:0', 'country' => 'required|string',
            'year' => 'required|integer', 'model' => 'required|string', 'img' => 'required|string',
            'id_category' => 'required|integer', 'count' => 'required|integer|min:0',
        ]);

        Product::create($request->all());
        return redirect()->route('admin')->with('status', 'Новый товар успешно добавлен в базу данных!');
    }

    // Обработка обновления товара
    public function update(Request $request, $id_product)
    {
        $request->validate([
            'name' => 'required|string', 'cost' => 'required|integer|min:0', 'country' => 'required|string',
            'year' => 'required|integer', 'model' => 'required|string', 'img' => 'required|string',
            'id_category' => 'required|integer', 'count' => 'required|integer|min:0',
        ]);

        $item = Product::findOrFail($id_product);
        $item->update($request->all());

        // После обновления сбрасываем GET-параметр и возвращаем чистую админку
        return redirect()->route('admin')->with('status', 'Данные товара успешно обновлены!');
    }

    // Удаление товара
    public function destroy($id_product)
    {
        $item = Product::findOrFail($id_product);
        $item->delete();
        return redirect()->route('admin')->with('status', 'Товар удален из каталога.');
    }
}
