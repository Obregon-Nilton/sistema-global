<!-- views/components/modalRol.blade.php formulario para agregar o editar
     se maneja directamente desde el JS para llenarla dinámicamente.-->
<div id="modal-rol" class="modal">
    <div class="modal-content">

        <h2 id="modalTitulo">AgregarRol</h2>

        <input type="text" id="nombre" placeholder="Ingrese el rol" required>

        <div>
            <button type="button" class="editar" id="btnGuardar">Guardar</button>
            <button type="button" class="eliminar" id="btnCerrar">Cerrar</button>
        </div>
    </div>
</div>
