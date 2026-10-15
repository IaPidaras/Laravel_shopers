@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Левая колонка: Информация о пользователе -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border bg-white">
                <div class="card-header bg-primary text-white fw-bold">
                    Мой профиль
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">{{ $user->name }} {{ $user->surname }}</h5>
                    <p class="mb-2"><strong>Логин:</strong> {{ $user->login }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="mb-0"><strong>Дата регистрации:</strong> 
                        {{ $user->created_at ? $user->created_at->format('d.m.Y в H:i') : 'Не указана' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Правая колонка: История заказов по ТЗ -->
        <div class="col-md-8">
            <h3 class="mb-4 fw-bold">История моих заказов</h3>

            <!-- Сообщения об успешном удалении или ошибках -->
            @if(session('success'))
                <div class="alert alert-success py-2 small">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
            @endif

            @if($orders->isEmpty())
                <div class="text-center py-5 bg-white border rounded shadow-sm">
                    <h4 class="text-muted mb-3">Вы еще не сделали ни одного заказа</h4>
                    <a href="{{ route('catalog') }}" class="btn btn-outline-primary btn-sm">Перейти в каталог</a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($orders as $order)
                        <div class="card mb-3 shadow-sm border bg-white">
                            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                <div>
                                    <span class="fw-bold text-secondary">Заказ №{{ $order->id_order }}</span>
                                    <span class="text-muted small ms-2">от {{ $order->created_at ? $order->created_at->format('d.m.Y в H:i') : 'Не указано' }}</span>
                                </div>
                                <div>
                                    <!-- Отображение статуса на основе id_status из твоего дампа БД -->
                                    @if($order->id_status === 1)
                                        <span class="badge bg-warning text-dark px-3 py-2">Новый</span>
                                    @elseif($order->id_status === 2)
                                        <span class="badge bg-success px-3 py-2">Подтвержденный</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">Отмененный</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="card-body py-2">
                                <!-- Список товаров в заказе из таблицы order_items -->
                                <table class="table table-sm table-borderless align-middle mb-0">
                                    <thead>
                                        <tr class="text-muted small border-bottom">
                                            <th>Товар</th>
                                            <th class="text-center">Количество</th>
                                            <th class="text-end">Цена</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($order->orderItems)
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>
                                                        <span class="fw-bold">{{ $item->product->name ?? 'Товар удален' }}</span>
                                                        @if(isset($item->product->model))
                                                            <div class="text-muted small">Модель: {{ $item->product->model }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $item->count }} шт.</td>
                                                    <td class="text-end fw-bold">{{ number_format($item->price, 0, '.', ' ') }} ₽</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Нижняя панель карточки: Расчет итога и Кнопка отмены -->
                            <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2 border-top-0">
                                <div>
                                    @php
                                        // Считаем общую сумму по элементам orderItems
                                        $orderTotal = $order->orderItems ? $order->orderItems->sum(function($item) { return $item->price * $item->count; }) : 0;
                                    @endphp
                                    <span class="text-muted small">Сумма заказа:</span>
                                    <span class="fw-bold text-success ms-1">{{ number_format($orderTotal, 0, '.', ' ') }} ₽</span>
                                </div>

                                {{-- По ТЗ кнопку удаления выводим только для статуса "Новый" (то есть id_status == 1) --}}
                                @if($order->id_status === 1)
                                    <form action="{{ route('order.cancel', $order->id_order) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите отменить и удалить этот заказ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1">
                                            Удалить заказ
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
    