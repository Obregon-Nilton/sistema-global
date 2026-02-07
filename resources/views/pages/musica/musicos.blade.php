<!-- viewa/pages/musicos.blade.php vista unica para crud roles  -->
@extends('layouts.app')

@section('title', 'MÚSICOS')

@section('content')
<h2 class="tipo">Músicos</h2>

@include('components.alert')

<div class="acciones">
    <button id="btnAgregar" class="btn">✚ Agregar</button>

    <div class="menu-select">
        <select name="mostrarPorEdad" id="mostrarPorEdad">
            <option value="">🌐 Todos</option>
            <option value="0">🧒 Menores</option>
            <option value="1">🧑 Mayores</option>
        </select>
    </div>

    <div class="buscador">
        <input type="text" id="inputBuscar" class="input" placeholder="🔍 Buscar">
    </div>
</div>

{{-- Tabla principal --}}
@include('components.table', [
    'id' => 'musicos-table',
    'columns' => ['ID','NOMBRE','APELLIDO','DNI','TELEFONO','FECHA NACIMIENTO','ACCIONES']
])

{{-- Modal para agregar/editar músicos --}}
@include('components.musica.modalMusico', ['id' => 'modal-musico'])

{{-- Contenedor para la paginación dinámica --}}
<div id="paginacion" class="paginacion"></div>

{{-- Template para una fila de músico --}}
<template id="plantilla-fila-musico" class="tabla">
    <tr>
        <td class="musico-id"></td>
        <td class="musico-nombre"></td>
        <td class="musico-apellido"></td>
        <td class="musico-dni"></td>
        <td class="musico-telefono"></td>
        <td class="musico-fecha"></td>
        <td>
            <button class="editar" id="btnEditar">✏️ Editar</button>
            <button class="eliminar" id="btnEliminar">🗑️ Eliminar</button>
        </td>
    </tr>
</template>
@endsection

