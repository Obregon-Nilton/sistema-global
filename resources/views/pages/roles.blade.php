<!-- viewa/pages/roles.blade.php vista unica para crud roles  -->
@extends('layouts.app')

@section('title', 'ROL')

@section('content')
<h2 class="tipo">Roles</h2>

@include('components.alert')

<div class="acciones">
<button id="btnAgregar" class="btn">✚ Agregar</button>
<div class="buscador">
<input type="text" id="inputBuscar" class="input" placeholder="🔍 Buscar por nombre">
</div>
</div>

<!--tabla roles-->
@include('components.table', ['id' => 'roles-table', 'columns' => ['ID','NOMBRE','ACCIONES']])
<!-- modal para agregar o editar -->
@include('components.modalRol', ['id' => 'modal-rol'])

<template id="plantilla-fila-rol" class="tabla">
    <tr>
        <td class="rol-id"></td>
        <td class="rol-nombre"></td>
        <td>
            <button class="editar" id="btnEditar">✏️ Editar</button>
            <button class="eliminar" id="btnEliminar">🗑️ Eliminar</button>
        </td>
    </tr>
</template>

@endsection
