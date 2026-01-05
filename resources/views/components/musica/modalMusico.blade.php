<!-- views/components/modalMusico.blade.php formulario para agregar o editar
     se maneja directamente desde el JS para llenarla dinámicamente.-->
<div id="modal-musico" class="modal">
    <div class="modal-content">
        <h2 id="modalTitulo"></h2>

        <input type="text" id="nombre" placeholder="Ingrese su nombre" required>

        <input type="text" name="apellido" id="apellido" placeholder="Ingrese su apellido" required>

        <input type="number" name="dni" id="dni" placeholder="Ingrese su DNI" required>

        <input type="number" name="telefono" id="telefono" placeholder="Ingrese su teléfono" required>

        <input type="date" name="fecha" id="fecha" placeholder="" required>

        <div>
            <button type="button" class="editar" id="btnGuardar">Guardar</button>
            <button type="button" class="eliminar" id="btnCerrar">Cerrar</button>
        </div>
    </div>
</div>
