@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="mb-4">
            <a href="{{ route('catalog') }}" class="btn btn-info btn-sm">
                ← Назад в каталог
            </a>
        </div>
        <div class="row g-5">
            <!-- Блок вывода динамического изображения -->
            <div class="col-md-6">
                <div class=" rounded p-3 bg-white d-flex align-items-center justify-content-center" style="min-height: 400px;">
                    @if($product->img)
                        <!-- Берем картинку конкретного принтера из базы данных -->
                        <img src="{{ asset('public/images/' . $product->img) }}" class="img-fluid" alt="{{ $product->name }}" style="max-height: 400px; object-fit: contain;">
                    @else
                        <!-- Заглушка, если картинки нет -->
                        <div style="color: #aaa; font-size: 18px;">Фотография отсутствует</div>
                    @endif
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-2">
                        @if($product->count > 0)
                            <span class="badge bg-success text-white">В наличии ({{ $product->count }} шт.)</span>
                        @else
                            <span class="badge bg-danger text-white">Нет в наличии</span>
                        @endif
                    </div>
                    <!-- Выводим динамическое название товара -->
                    <h1 class="fw-bold text-dark mb-3">{{ $product->name }}</h1>
                    <div class="mb-4">
                        <!-- Выводим динамическую цену -->
                        <span class="fs-2 fw-bold text-success">{{ number_format($product->cost, 0, '.', ' ') }} ₽</span>
                    </div>
                    <hr class="my-4">
                    <h5 class="fw-bold text-secondary mb-3">Характеристики товара</h5>
                    <div class="bg-light p-3  ">
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Модель:</div>
                            <!-- Динамическая модель -->
                            <div class="col-6 fw-semibold text-dark">{{ $product->model }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Год выпуска:</div>
                            <!-- Динамический год -->
                            <div class="col-6 fw-semibold text-dark">{{ $product->year ?? 'Не указан' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-muted">Страна-производитель:</div>
                            <!-- Динамическая страна -->
                            <div class="col-6 fw-semibold text-dark">{{ $product->country ?? 'Не указана' }}</div>
                        </div>
                    </div>
                </div>
                <!-- ЖИВАЯ КНОПКА ДОБАВЛЕНИЯ В КОРЗИНУ -->
                <div class="mt-4">
                    <form action="{{ route('cart.add', $product->id_product) }}" method="POST">
                        @csrf
                        <!-- Тип кнопки изменен на submit, чтобы форма отправлялась -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold" {{ $product->count <= 0 ? 'disabled' : '' }}>
                            {{ $product->count > 0 ? 'Добавить в корзину' : 'Товара нет в наличии' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
