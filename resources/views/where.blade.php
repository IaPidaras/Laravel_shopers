@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Где нас найти?</h1>

        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="{{ asset('public/images/map.png') }}"
                     class="img-fluid rounded"
                     alt="Карта проезда"
                     style="width: 100%; height: 350px; object-fit: cover;"
                     loading="lazy">
            </div>
            <div class="col-md-6">
                <h3>Контакты</h3>
                <p><strong>Адрес:</strong> г. Ижевск, ул. 30 лет Победы, 100, Ижевск</p>
                <p><strong>Телефон:</strong> <a href="tel:+79501111234">+7 (950) 111-12-34</a></p>
                <p><strong>Email:</strong> <a href="mailto:contact@yourdomain.com">contact@yourdomain.com</a></p>
                <p><strong>Режим работы:</strong> Пн-Пт круглосуточно</p>
            </div>
        </div>
    </div>
@endsection

