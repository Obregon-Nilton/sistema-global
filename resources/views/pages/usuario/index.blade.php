@extends('layouts.app')

@section('content')
<h2>Usuarios</h2>

@include('components.alert')

<button id="btnAgregar">✚ Agregar</button>

@include('components.table', [
    'id' => 'usuarios-table',
    'columns' => ['ID','EMAIL','ACCIONES']
])

@include('components.usuario.modalUsuario')

@endsection
