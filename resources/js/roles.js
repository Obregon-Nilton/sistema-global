import axios from "axios";
import Utilidad from "./Utils/Utilidad";

document.addEventListener('DOMContentLoaded', () => {

    //modalRol.blade.php -> modal agregar o editar
    const modal = document.getElementById("modal-rol");
    const modalTitulo = document.getElementById("modalTitulo");
    const inputNombre = document.getElementById("nombre");
    const btnGuardar = document.getElementById("btnGuardar");
    const btnCerrar = document.getElementById("btnCerrar");

    // BUSCADOR (solo input)
    const inputBuscar = document.getElementById("inputBuscar");

    //tabla roles
    const tabla = document.getElementById("roles-table");
    const plantillaFila = document.getElementById("plantilla-fila-rol");

    if (!tabla || !plantillaFila) return;

    let editId = null;
    const mensajeDinamic = window.mensajeDinamico;

    // =============================
    // PINTAR TABLA
    // =============================
    const pintarTabla = (roles) => {
        const tbody = tabla.querySelector("tbody");
        if (!tbody) return;

        tbody.innerHTML = "";

        roles.forEach(rol => {
            const clone = plantillaFila.content.cloneNode(true);
            clone.querySelector(".rol-id").textContent = rol.id_rol;
            clone.querySelector(".rol-nombre").textContent = rol.nombre;

            const btnEditar = clone.querySelector(".editar");
            const btnEliminar = clone.querySelector(".eliminar");

            btnEditar.addEventListener("click", () => abrirModalEditar(rol.id_rol));
            btnEliminar.addEventListener("click", () => eliminaRol(rol.id_rol));

            tbody.appendChild(clone);
        });
    };

    // =============================
    // BUSCAR DINÁMICO
    // =============================
    const buscarPorNombre = async () => {

        const dato = inputBuscar.value.trim();

        // Si está vacío → cargar todos
        if (dato === "") {
            listarRoles();
            return;
        }

        try {
            const respuesta = await axios.get(`/api/inicio/roles/buscar/${dato}`);
            pintarTabla(respuesta.data.data);
        } catch (error) {
            console.error(error);
        }
    };

    if (inputBuscar) {
        inputBuscar.addEventListener("keyup", buscarPorNombre);
    }

    // =============================
    // ABRIR MODAL AGREGAR
    // =============================
    const abrirModalAgregar = () => {
        editId = null;
        modalTitulo.textContent = "AGREGAR ROL";
        inputNombre.value = "";
        modal.style.display = "flex";
    };

    // =============================
    // ABRIR MODAL EDITAR
    // =============================
    const abrirModalEditar = async (id) => {
     Utilidad.obtener({
           url: `/api/inicio/roles/ver/${id}`,
         onSuccess: (rol) => {
              editId = id;
             modalTitulo.textContent = "MODIFICAR ROL";
             inputNombre.value = rol.nombre;
              modal.style.display = "flex";
         }
     });
    };

    // =============================
    // CERRAR MODAL
    // =============================
    const cerrarModal = () => {
        if (modal) modal.style.display = "none";
    };

    // =============================
    // GUARDAR (AGREGAR / EDITAR)
    // =============================
    const guardarRol = async () => {
        const datos = {nombre: inputNombre.value.trim()}
        Utilidad.guardar({
            url: editId === null
            ? '/api/inicio/roles/agregar'
            : `/api/inicio/roles/editar/${editId}`,
            datos: datos,
            isEdit: editId !== null,
            onSuccess: () => {
                cerrarModal();
                listarRoles();
            }
        });
    }

    /* =====================================================
       ELIMINAR
    ===================================================== */
    const eliminaRol = async (id) => {
        Utilidad.eliminar({
            url: `/api/inicio/roles/eliminar/${id}`,
            successMsg: "Rol eliminada correctamente",
            onSuccess: () => listarRoles()
        });
    }

    // =============================
    // LISTAR TODOS
    // =============================
    const listarRoles = async () => {
        try {
            const respuesta = await axios.get('/api/inicio/roles/listar');
            pintarTabla(respuesta.data.data);
        } catch (error) {
            mensajeDinamic("Ocurrió un error al cargar Roles", "error");
            console.error(error);
        }
    };

    // =============================
    // EVENTOS
    // =============================
    const btnAgregarRol = document.getElementById("btnAgregar");
    if (btnAgregarRol) btnAgregarRol.addEventListener("click", abrirModalAgregar);

    if (btnCerrar) btnCerrar.addEventListener("click", cerrarModal);

    if (btnGuardar) btnGuardar.addEventListener("click", guardarRol);

    // =============================
    // INICIO
    // =============================
    listarRoles();

});
