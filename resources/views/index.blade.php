@extends('layouts.app')

@section('content')
    <div class="container">
        <p>Это главная страница мб</p>
        @foreach($roles as $item)
            <div class="row">
                <div class="col-1">
                    {{-- Выводим ID роли --}}
                    <p>{{ $item->id_role }}</p>
                </div>
                <div class="col-1">
                    {{-- Выводим название роли (например, admin) --}}
                    <p>{{ $item->name }}</p>

                </div>
            </div>
        @endforeach
    </div>
@endsection
