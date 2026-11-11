@extends('layout')
@section('title',$register?'Crear cuenta':'Iniciar sesión')
@section('content')
<div class="row align-items-center g-5 auth-page"><section class="col-lg-7"><span class="eyebrow">UN ESPACIO PARA TUS FINANZAS</span><h1 class="display-3 fw-bold mt-3">Tu dinero.<br>Más claro.</h1><p class="lead text-secondary mt-4">Registra lo que recibes y lo que gastas.<br>Entiende tu mes, un movimiento a la vez.</p><p class="mt-4">Ingresos y gastos · Categorías · Balance mensual</p></section>
<section class="col-lg-5"><div class="surface p-4 p-md-5"><h2 class="h3">{{ $register?'Empieza con Lukia':'Qué bueno verte' }}</h2><p class="text-secondary">{{ $register?'Crea tu cuenta para organizar tus movimientos.':'Ingresa para consultar tus finanzas.' }}</p>
<form method="post" action="{{ $register ? route('register') : route('login') }}">@csrf
@if($register)<label class="form-label" for="name">Nombre</label><input class="form-control mb-3" id="name" name="name" value="{{ old('name') }}" required maxlength="80" autocomplete="name">@endif
<label class="form-label" for="email">Correo electrónico</label><input class="form-control mb-3" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
<label class="form-label" for="password">Contraseña</label><input class="form-control mb-3" type="password" id="password" name="password" required @if($register) minlength="8" aria-describedby="password-help" @endif autocomplete="{{ $register?'new-password':'current-password' }}">
@if($register)<p id="password-help" class="small text-secondary">Usa al menos 8 caracteres.</p><label class="form-label" for="password_confirmation">Repite tu contraseña</label><input class="form-control mb-3" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">@endif
<button class="btn btn-primary w-100 mt-2">{{ $register?'Crear mi cuenta':'Iniciar sesión' }}</button></form>
<p class="small mt-4 mb-0">{{ $register?'¿Ya tienes cuenta?':'¿Primera vez aquí?' }} <a href="{{ $register ? route('login') : route('register') }}">{{ $register?'Inicia sesión':'Crea tu cuenta' }}</a></p></div></section></div>
@endsection
