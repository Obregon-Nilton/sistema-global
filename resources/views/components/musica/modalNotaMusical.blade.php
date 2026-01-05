<!-- views/components/modalnotaMusical.blade.php formulario para agregar o editar
     se maneja directamente desde el JS para llenarla dinámicamente.-->

     <div id="modal-notaMusical" class="modal">
        <div class="modal-content">
            <h2 id="modalTitulo"></h2>

            <input type="text" id="nota" placeholder="Ingrese la Nota musical" required>

            <label for="tipo">Seleccionar: </label>
            <select name="tipo" id="tipo">
                <option value="natural">natural</option>
                <option value="sostenido">sostenido</option>
                <option value="bemol">bemol</option>
            </select>

            <div>
                <button type="button" class="editar" id="btnGuardar">Guardar</button>
                <button type="button" class="eliminar" id="btnCerrar">Cerrar</button>
            </div>
        </div>
     </div>
