@extends('layout')
@section('title','Editar movimiento')
@section('content')
<div class="mx-auto" style="max-width:560px"><a href="{{ route('dashboard') }}">Volver al resumen</a><section class="surface p-4 mt-3"><h1 class="h3 mb-4">Editar movimiento</h1><form method="post" action="{{ route('transactions.update', $transaction) }}">@csrf @method('PUT') @include('transaction-form')</form></section></div>
@endsection
