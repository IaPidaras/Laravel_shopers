@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-1">Ассортимент принтеров</h1>
    <h3> фильтр</h3>
    <form method="Get" action="{{ route('catalog') }}">
        <label for="id_category" class="form-label">Фильтр по категориям</label>
        <select class="form-select mb-3" id="id_category" name="id_category">
            <option value="" {{ request('id_category') === null || request('id_category') === '' ? 'selected' : '' }}>Все категории</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id_category }}" {{ request('id_category') === $category->id_category ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <label class="form-label">Сортировка по:</label>

        <div class="form-check">
            <input class="form-check-input" value="year" type="radio" id="sort1" name="sort" {{ request('sort') == 'year' ? 'checked' : '' }}>
            <label class="form-check-label" for="sort1">
                Год производства
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" value="name" type="radio" id="sort2" name="sort" {{ request('sort') == 'name' ? 'checked' : '' }}>
            <label class="form-check-label" for="sort2">
                Название
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" value="cost" type="radio" id="sort3" name="sort" {{ request('sort') == 'cost' ? 'checked' : '' }}>
            <label class="form-check-label" for="sort3">
                Цена
            </label>
        </div>

        <button type="submit" class="btn btn-primary mb-3">Применить</button>
    </form>
    <div class="row">
        @foreach($products as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; background: #fff;">

                <!-- Блок вывода изображения -->
                <div class="text-center mb-2" style="height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-color: #f8f9fa; border-radius: 4px;">
                    @if($item->img)
                    <!-- Ищем картинку в папке public/images/ -->
                    <img src="{{ asset('public/images/' . $item->img) }}" alt="{{ $item->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    @else
                    <!-- Заглушка, если картинки нет -->
                    <div style="color: #aaa; font-size: 14px;">Нет фото</div>
                    @endif
                </div>

                <!-- Данные товара -->
                <h3 class="h5 fw-bold">{{ $item->name }}</h3>
                <p class="mb-1"><b>Модель:</b> {{ $item->model }}</p>
                <p class="mb-1"><b>Цена:</b> {{ $item->cost }} руб.</p>
                <p class="mb-3"><b>В наличии:</b> {{ $item->count }} шт.</p>

                <!-- Кнопка для перехода на страницу товара -->
                <a href="{{ route('product.show', $item->id_product) }}" class="btn btn-secondary mt-auto">Посмотреть товар</a>

            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection