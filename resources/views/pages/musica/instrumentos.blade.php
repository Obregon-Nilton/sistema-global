<!-- resources\views\pages\musica\instrumentos.blade.php -->
@extends('layouts.app')

@section('title', 'INSTRUMENTOS')

@section('content')
<h2 class="tipo">Instrumentos</h2>

@include('components.alert')

<div class="acciones">
    <button id="btnAgregar" class="btn">✚ Agregar</button>
</div>

@include('components.table', [
    'id' => 'instrumentos-table',
    'columns' => ['ID', 'INSTRUMENTO', 'NIVEL', 'CATEGORIA', 'ACCIONES']
])

@include('components.musica.modalInstrumento', ['id' => 'modal-instrumento'])

<div id="paginacion" class="paginacion"></div>

<template id="plantilla-fila-instrumento" class="tabla">
    <tr>
        <td class="instrumento-id"></td>
        <td class="instrumento"></td>
        <td class="instrumento-nivel"></td>
        <td class="instrumento-categoria"></td>
        <td>
            <button class="editar" id="btnEditar">✏️ Editar</button>
            <button class="eliminar" id="btnEliminar">🗑️ Eliminar</button>
        </td>
    </tr>
</template>
@endsection
