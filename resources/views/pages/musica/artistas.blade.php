<!--sistema_global\resources\views\pages\musica\artistas.blade.php -->
@extends('layouts.app')

@section('title', 'ARTISTAS')

@section('content')
<h2 class="tipo">Artistas</h2>

@include('components.alert')

<div class="acciones">
    <button id="btnAgregar" class="btn">✚ Agregar</button>

    <div class="buscador">
        <input type="text" name="" id="inputBuscar" class="input" placeholder="🔍 Buscar">
    </div>
</div>

@include('components.table', [
    'id' => 'artistas-table',
    'columns' => ['ID', 'NOMBRE', 'NACIONALIDAD', 'ACCIONES']
])


@include('components.musica.modalArtista', ['id' => 'modal-artista'])

<div id="paginacion" class="paginacion"></div>

<template id="plantilla-fila-artista" class="tabla">
    <tr>
        <td class="artista-id"></td>
        <td class="artista-nombre"></td>
        <td class="artista-nacionalidad"></td>
        <td>
            <button class="editar" id="btnEditar">✏️ Editar</button>
            <button class="eliminar" id="btnEliminar">🗑️ Eliminar</button>
        </td>
    </tr>
</template>
@endsection
