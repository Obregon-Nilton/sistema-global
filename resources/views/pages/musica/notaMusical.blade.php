<!-- viewa/pages/notaMusical.blade.php vista unica para crud notaMusical  -->
@extends('layouts.app')

@section('title', 'Nota Musical')

@section('content')
<h2 class="tipo">Notas Musiales</h2>

@include('components.alert')

<div class="acciones">
    <button id="btnAgregar" class="btn">✚ Agregar</button>
    <div class="buscador">
        <input type="text" class="input" id="inputBuscador" placeholder="🔍 Buscar">
    </div>
</div>

@include('components.table', ['id' => 'notaMusial-table', 'columns' => ['ID', 'NOTA', 'TIPO', 'ACCIONES']])
@include('components.musica.modalNotaMusical', ['id' => 'modal-notaMusical'])

<template id="plantilla-fila-notaMusical" class="tabla">
    <tr>
        <td class="notaMusical-id"></td>
        <td class="notaMusical-nota"></td>
        <td class="notaMusical-tipo"></td>
        <td>
            <button class="editar" id="btnEditar">✏️ Editar</button>
            <button class="eliminar" id="btnEliminar">🗑️ Eliminar</button>
        </td>
    </tr>
</template>
<div id="paginacion" class="paginacion"></div>
@endsection
