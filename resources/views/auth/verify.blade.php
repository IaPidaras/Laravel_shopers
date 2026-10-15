@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Подтвердите ваш Email-адрес</div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Свежая ссылка для подтверждения аккаунта была отправлена на ваш email-адрес.
                        </div>
                    @endif
                    <p>Перед тем как продолжить, пожалуйста, проверьте вашу электронную почту на наличие ссылки для подтверждения.</p>
                    <p>Если вы не получили письмо, нажмите на кнопку ниже, чтобы отправить запрос повторно.</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Отправить ссылку повторно</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
