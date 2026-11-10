<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>@yield('title','Tu dinero, en orden') · Lukia</title><link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}"><link rel="stylesheet" href="{{ asset('lukia.css') }}"></head><body>
<a class="visually-hidden-focusable" href="#contenido">Ir al contenido</a>
<header class="topbar"><div class="container d-flex justify-content-between align-items-center py-3"><a class="brand" href="/">lukia<span>●</span></a>@auth<div class="d-flex align-items-center gap-3"><span class="small">{{ auth()->user()->name }}</span><form method="post" action="/salir">@csrf<button class="btn btn-outline-dark btn-sm">Cerrar sesión</button></form></div>@else<span class="small">Finanzas personales</span>@endauth</div></header>
<main id="contenido" class="container py-5">
@if(session('status'))<div class="alert alert-success" role="status">{{ session('status') }}</div>@endif
@if($errors->any())<div class="alert alert-danger" role="alert"><strong>Revisa estos datos:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')</main><footer class="container pb-4 small text-secondary">Lukia · Proyecto académico de Mayer Gómez y Milton Muñoz</footer>
<script src="{{ asset('lukia.js') }}" defer></script></body></html>
