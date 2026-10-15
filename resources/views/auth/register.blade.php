@extends('template')
@section('title', 'Регистрация — WebManga')
@section('page-class', 'auth-page container')
@section('content')
    <section class="auth-card register-card" aria-labelledby="auth-title">
        <h1 id="auth-title">Регистрация</h1>
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="form-field"><label for="name">Никнейм</label><input id="name" name="name" placeholder="pixies" value="{{ old('name') }}" required maxlength="50" autocomplete="nickname" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>@error('name')<p class="field-error" id="name-error">{{ $message }}</p>@enderror</div>
            <div class="form-field"><label for="email">Почта</label><input id="email" name="email" type="email" placeholder="example@gmail.com" value="{{ old('email') }}" required autocomplete="email" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>@error('email')<p class="field-error" id="email-error">{{ $message }}</p>@enderror</div>
            <div class="form-field"><label for="password">Пароль</label><input id="password" name="password" type="password" placeholder="Введите пароль" required minlength="8" autocomplete="new-password" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>@error('password')<p class="field-error" id="password-error">{{ $message }}</p>@enderror</div>
            <button class="button auth-submit" type="submit">Зарегистрироваться</button>
        </form>
    </section>
@endsection
