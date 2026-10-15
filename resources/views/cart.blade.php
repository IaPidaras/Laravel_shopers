@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Корзина покупок</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Проверяем, есть ли записи в корзине через метод count() --}}
    @if($cartItems->isEmpty())
        <div class="text-center py-5 bg-white border rounded">
            <h3 class="text-muted mb-3">Ваша корзина пуста</h3>
            <a href="{{ route('catalog') }}" class="btn btn-primary">Перейти в каталог</a>
        </div>
    @else
        <div class="row">
            <!-- Левая часть: Простая таблица с товарами -->
            <div class="col-md-8">
                <table class="table align-middle bg-white border">
                    <thead class="table-light">
                        <tr>
                            <th>Фото</th>
                            <th>Товар</th>
                            <th class="text-center">Количество</th>
                            <th>Цена</th>
                            <th>Удалить</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <!-- Картинка товара -->
                                <td style="width: 100px;">
                                    <img src="{{ asset('public/images/' . $item->product->img) }}" class="img-fluid rounded" style="max-height: 60px;">
                                </td>
                                <!-- Название товара -->
                                <td>
                                    <strong>{{ $item->product->name }}</strong>
                                    <div class="text-muted small">Модель: {{ $item->product->model }}</div>
                                </td>
                                <!-- Управление количеством (кнопки плюс и минус) -->
                                <td style="width: 130px;">
                                    <form action="{{ route('cart.update', $item->id_cart) }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary" type="submit" name="action" value="minus">-</button>
                                            <input type="text" class="form-control text-center" value="{{ $item->count }}" readonly>
                                            <button class="btn btn-outline-secondary" type="submit" name="action" value="plus">+</button>
                                        </div>
                                    </form>
                                </td>
                                <!-- Стоимость (цена * количество) -->
                                <td>
                                    <span class="fw-bold">{{ number_format($item->product->cost * $item->count, 0, '.', ' ') }} ₽</span>
                                </td>
                                <!-- Кнопка удаления из корзины -->
                                <td>
                                    <form action="{{ route('cart.remove', $item->id_cart) }}" method="POST" onsubmit="return confirm('Удалить товар?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <a href="{{ route('catalog') }}" class="text-decoration-none">&larr; Вернуться в каталог</a>
                </div>
            </div>

            <!-- Правая часть: Итог и форма подтверждения заказа паролем -->
            <div class="col-md-4">
                <div class="card p-4 bg-white border">
                    <h4 class="mb-4">Итог заказа</h4>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Итого к оплате:</span>
                        {{-- Выводим сумму, которую посчитали в контроллере --}}
                        <span class="fs-4 fw-bold text-success">{{ number_format($totalSum, 0, '.', ' ') }} ₽</span>
                    </div>

                    <hr>

                    <!-- Вывод общих ошибок (например, если товара не хватило на складе) -->
                    @if(session('error'))
                        <div class="alert alert-danger small py-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Форма оформления заказа -->
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label small text-muted">Введите ваш текущий пароль для подтверждения:</label>
                            <input type="password" name="password" id="confirmPassword" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль от аккаунта" required>
                            
                            <!-- Вывод ошибки неверного пароля от Laravel Blade -->
                            @error('password')
                                <div class="invalid-feedback d-block fw-bold mt-2 small">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">
                            Сформировать заказ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
