@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <div class="text-center mb-5 p-5 bg-white rounded shadow-sm border">
            <div class="mb-3">
                <img src="{{ asset('public/images/logo.png') }}" alt="Copy Star Логотип" class="img-fluid" style="max-height: 100px;">
            </div>
            <h1 class="fw-bold text-dark mb-2">Copy Star</h1>
            <h3 class="fst-italic text-primary fw-normal">«Безупречный отпечаток вашего успеха»</h3>
            <p class="text-muted mt-3 max-w-600 mx-auto">Мы поставляем передовое копировальное оборудование для офисов и типографий. Надёжность, высокая скорость печати и экономия вашего бюджета — наши главные стандарты.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3 class="text-center mb-4 fw-bold text-secondary">Что нового</h3>

                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <!-- Автоматическая генерация индикаторов (точек) -->
                    <div class="carousel-indicators">
                        @foreach($carouselProducts as $index => $item)
                            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner" style="height: 450px;">
                        @foreach($carouselProducts as $item)
                            <!-- $loop->first автоматически сделает 'active' только самый первый слайд -->
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }} h-100">
                                @if($item->img)
                                    <img src="{{ asset('public/images/' . $item->img) }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="{{ $item->name }}">
                                @else
                                    <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center text-white">Нет фото</div>
                                @endif

                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3 mb-3">
                                    <h5 class="fw-bold">{{ $item->name }}</h5>
                                    <p class="mb-2">Модель: {{ $item->model }} | Цена: {{ number_format($item->cost, 0, '.', ' ') }} ₽</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Предыдущий</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Следующий</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
