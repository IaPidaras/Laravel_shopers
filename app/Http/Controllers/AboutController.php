<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Импортируем модель товаров

class AboutController extends Controller
{
    public function index()
    {
        // Вытаскиваем последние 5 товаров из базы данных для карусели
        $carouselProducts = Product::orderBy('id_product', 'desc')->take(5)->get();

        // Возвращаем ваш шаблон about.blade.php и передаем туда товары
        return view('about', compact('carouselProducts'));
    }
}
