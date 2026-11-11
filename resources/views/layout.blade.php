<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>@yield('title','Tu dinero, en orden') · Lukia</title><link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}"><link rel="stylesheet" href="{{ asset('lukia.css') }}?v={{ filemtime(public_path('lukia.css')) }}"></head><body>
<a class="visually-hidden-focusable" href="#contenido">Ir al contenido</a>
<header class="topbar"><div class="container d-flex justify-content-between align-items-center py-3"><a class="brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}">lukia<span>●</span></a>@auth<div class="d-flex align-items-center gap-3"><span class="small">{{ auth()->user()->name }}</span><form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-dark btn-sm">Cerrar sesión</button></form></div>@else<span class="small">Finanzas personales</span>@endauth</div></header>
@if(session('status') || $errors->any())
<div class="notification-stack" aria-live="assertive" aria-atomic="true">
@if(session('status'))<div class="lukia-notice lukia-notice-success" role="status" data-notice><div><strong>Listo</strong><p>{{ session('status') }}</p></div><button type="button" class="notice-close" data-notice-close aria-label="Cerrar notificación">×</button></div>@endif
@if($errors->any())<div class="lukia-notice lukia-notice-error" role="alert" data-notice><div><strong>Revisa estos datos</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div><button type="button" class="notice-close" data-notice-close aria-label="Cerrar notificación">×</button></div>@endif
</div>
@endif
<main id="contenido" class="container py-5">
@yield('content')</main><footer class="container pb-4 small text-secondary">Lukia · Proyecto académico de Mayer Gómez y Milton Muñoz</footer>
<script src="{{ asset('lukia.js') }}?v={{ filemtime(public_path('lukia.js')) }}" defer></script></body></html>
