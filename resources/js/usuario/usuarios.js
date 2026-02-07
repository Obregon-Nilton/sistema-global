import axios from "axios";
import Utilidad from "../Utils/Utilidad";

document.addEventListener("DOMContentLoaded", () => {

    /* =========================
       DOM
    ========================= */
    const modal = document.getElementById("modal-usuario");
    const modalTitulo = document.getElementById("modalTituloUsuario");
    const inputEmail = document.getElementById("email");
    const inputPassword = document.getElementById("password");
    const btnGuardar = document.getElementById("btnGuardarUsuario");
    const btnCerrar = document.getElementById("btnCerrarUsuario");
    const tabla = document.getElementById("usuarios-table");
    const plantillaFila = document.getElementById("plantilla-fila-usuario");

    if (!tabla || !plantillaFila) return;

    /* =========================
       ESTADO
    ========================= */
    let editId = null;
    let paginaActual = 1;
    const mensaje = window.mensajeDinamico;

    /* =========================
       PINTAR TABLA
    ========================= */
    const pintarTabla = (usuarios) => {
        const tbody = tabla.querySelector("tbody");
        tbody.innerHTML = "";

        usuarios.forEach(usuario => {
            const clone = plantillaFila.content.cloneNode(true);

            clone.querySelector(".usuario-id").textContent = usuario.id_user;
            clone.querySelector(".usuario-email").textContent = usuario.email;

            clone.querySelector(".editar")
                .addEventListener("click", () => abrirModalEditar(usuario.id_user));

            clone.querySelector(".eliminar")
                .addEventListener("click", () => eliminarUsuario(usuario.id_user));

            tbody.appendChild(clone);
        });
    };

    /* =========================
       LISTAR
    ========================= */
    const listarUsuarios = async (pagina = 1) => {
        try {
            const res = await axios.get(`/api/inicio/usuarios/listar?page=${pagina}`);
            pintarTabla(res.data.data);
            paginaActual = res.data.meta.current_page;
        } catch (e) {
            mensaje("Error al listar usuarios", "error");
            console.error(e);
        }
    };

    /* =========================
       MODAL AGREGAR
    ========================= */
    const abrirModalAgregar = () => {
        editId = null;
        modalTitulo.textContent = "AGREGAR USUARIO";
        inputEmail.value = "";
        inputPassword.value = "";
        modal.style.display = "flex";
    };

    /* =========================
       MODAL EDITAR
    ========================= */
    const abrirModalEditar = (id) => {
        Utilidad.obtener({
            url: `/api/inicio/usuarios/ver/${id}`,
            onSuccess: (usuario) => {
                editId = id;
                modalTitulo.textContent = "EDITAR USUARIO";
                inputEmail.value = usuario.email;
                inputPassword.value = ""; // opcional
                modal.style.display = "flex";
            }
        });
    };

    /* =========================
       GUARDAR
    ========================= */
    btnGuardar?.addEventListener("click", () => {
        const datos = {
            email: inputEmail.value.trim(),
            password: inputPassword.value.trim()
        };

        Utilidad.guardar({
            url: editId === null
                ? "/api/inicio/usuarios/agregar"
                : `/api/inicio/usuarios/editar/${editId}`,
            datos,
            isEdit: editId !== null,
            onSuccess: () => {
                modal.style.display = "none";
                listarUsuarios(paginaActual);
            }
        });
    });

    /* =========================
       ELIMINAR
    ========================= */
    const eliminarUsuario = (id) => {
        Utilidad.eliminar({
            url: `/api/inicio/usuarios/eliminar/${id}`,
            successMsg: "Usuario eliminado",
            onSuccess: () => listarUsuarios(paginaActual)
        });
    };

    /* =========================
       CERRAR MODAL
    ========================= */
    btnCerrar?.addEventListener("click", () => modal.style.display = "none");

    /* =========================
       BOTÓN AGREGAR
    ========================= */
    document.getElementById("btnAgregar")
        ?.addEventListener("click", abrirModalAgregar);

    /* =========================
       INIT
    ========================= */
    listarUsuarios();
});
