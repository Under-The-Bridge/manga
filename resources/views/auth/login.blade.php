@extends('template')
@section('title', 'Вход — WebManga')
@section('page-class', 'auth-page container')
@section('content')
    <section class="auth-card login-card" aria-labelledby="auth-title">
        <h1 id="auth-title">Вход</h1>
        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="form-field"><label for="email">Почта</label><input id="email" name="email" type="email" placeholder="example@gmail.com" value="{{ old('email') }}" required autocomplete="email" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>@error('email')<p class="field-error" id="email-error">{{ $message }}</p>@enderror</div>
            <div class="form-field"><div class="field-label"><label for="password">Пароль</label><button class="forgot-link" type="button" data-dialog-title="Забыли пароль?" data-dialog-copy="Восстановление пароля пока недоступно. Обратитесь к администратору сайта.">Забыли пароль?</button></div><input id="password" name="password" type="password" placeholder="Введите пароль" required autocomplete="current-password" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>@error('password')<p class="field-error" id="password-error">{{ $message }}</p>@enderror</div>
            <button class="button auth-submit" type="submit">Войти</button>
        </form>
    </section>
@endsection
