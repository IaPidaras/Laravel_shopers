@extends('layouts.app')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Панель администратора (Управление товарами)</h1>

    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <strong>Ошибки при заполнении формы:</strong>
        <ul class="mb-0 ps-3 mt-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4 align-items-start">

        {{-- ФОРМА СОЗДАНИЯ / РЕДАКТИРОВАНИЯ --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header {{ isset($editItem) ? 'bg-warning text-dark' : 'bg-primary text-white' }} fw-bold">
                    @if(isset($editItem))
                    Редактировать товар #{{ $editItem->id_product }}
                    @else
                    Добавить новый товар
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ isset($editItem) ? route('admin.update', $editItem->id_product) : route('admin.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($editItem))
                        @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold mb-1">Наименование</label>
                                <input type="text" name="name" class="form-control" required
                                    value="{{ old('name', $editItem->name ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold mb-1">Модель</label>
                                <input type="text" name="model" class="form-control" required
                                    value="{{ old('model', $editItem->model ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold mb-1">Цена (руб.)</label>
                                <input type="number" name="cost" class="form-control" required
                                    value="{{ old('cost', $editItem->cost ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold mb-1">Кол-во на складе</label>
                                <input type="number" name="count" class="form-control" required
                                    value="{{ old('count', $editItem->count ?? '0') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold mb-1">Категория</label>
                                <select name="id_category" class="form-select" required>
                                    @php $cat = old('id_category', $editItem->id_category ?? 0); @endphp
                                    <option value="1" {{ $cat == 1 ? 'selected' : '' }}>Лазерные принтеры</option>
                                    <option value="2" {{ $cat == 2 ? 'selected' : '' }}>Струйные принтеры</option>
                                    <option value="3" {{ $cat == 3 ? 'selected' : '' }}>Термопринтеры</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold mb-1">Страна-производитель</label>
                                <input type="text" name="country" class="form-control" required
                                    value="{{ old('country', $editItem->country ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold mb-1">Год выпуска</label>
                                <input type="number" name="year" class="form-control" required
                                    value="{{ old('year', $editItem->year ?? date('Y')) }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="img" class="form-label fw-bold mb-1">Фото товара</label>
                                <input class="form-control" type="file" id="img" name="img"
                                    accept="image/*"
                                    {{ isset($editItem) ? '' : 'required' }}>

                                @if(isset($editItem) && $editItem->img)
                                @php $currentImg = basename($editItem->img); @endphp
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <img src="{{ asset('public/images/' . $currentImg) }}"
                                        alt="Текущее фото"
                                        style="max-height: 80px; border-radius: 4px; border: 1px solid #dee2e6;"
                                        onerror="this.style.display='none'">
                                    <small class="text-muted">
                                        Текущее фото: <code>{{ $currentImg }}</code><br>
                                        Оставьте поле пустым, чтобы не менять.
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 pt-3 mt-2 border-top">
                            @if(isset($editItem))
                            <button type="submit" class="btn btn-warning px-4 text-dark fw-bold">Сохранить изменения</button>
                            <a href="{{ route('admin') }}" class="btn btn-outline-secondary px-4 ms-2">Отмена</a>
                            @else
                            <button type="submit" class="btn btn-success w-100 text-white fw-bold">Добавить товар в каталог</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ТАБЛИЦА КАТАЛОГА --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Каталог товаров</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-secondary text-nowrap">
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 10%">Фото</th>
                                    <th style="width: 20%">Наименование</th>
                                    <th style="width: 12%">Модель</th>
                                    <th style="width: 10%">Цена</th>
                                    <th style="width: 8%">Склад</th>
                                    <th style="width: 15%">Категория</th>
                                    <th style="width: 10%">Страна</th>
                                    <th style="width: 5%">Год</th>
                                    <th style="width: 15%">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr class="{{ isset($editItem) && $editItem->id_product == $item->id_product ? 'table-warning' : '' }}">
                                    <td class="fw-bold text-center">{{ $item->id_product }}</td>

                                    {{-- Ячейка фото --}}
                                    <td class="text-center">
                                        @php
                                            $imgName = $item->img ? basename($item->img) : null;
                                            $imgPath = $imgName ? public_path('images/' . $imgName) : null;
                                            $exists  = $imgPath ? file_exists($imgPath) : false;
                                        @endphp

                                        @if($imgName && $exists)
                                        <img src="{{ asset('public/images/' . $imgName) }}"
                                            alt="{{ $item->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #dee2e6; border-radius: 4px;">
                                        @else
                                        <span class="text-muted" style="font-size: 11px;">
                                            Нет фото<br>
                                            <small class="text-danger">{{ $imgName ?? '—' }}</small>
                                        </span>
                                        @endif
                                    </td>

                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->model }}</td>
                                    <td class="fw-bold">{{ $item->cost }}</td>
                                    <td class="text-center">{{ $item->count }}</td>
                                    <td>
                                        @if($item->id_category == 1) Лазерные принтеры
                                        @elseif($item->id_category == 2) Струйные принтеры
                                        @else Термопринтеры @endif
                                    </td>
                                    <td>{{ $item->country }}</td>
                                    <td class="text-center">{{ $item->year }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin', ['edit' => $item->id_product]) }}"
                                               class="btn btn-warning btn-sm text-white px-2">
                                                Редактировать
                                            </a>
                                            <form action="{{ route('admin.destroy', $item->id_product) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Удалить этот товар?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm text-white px-2">Удалить</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection