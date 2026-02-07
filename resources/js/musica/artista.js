// resources/js/musica/artista.js

const axios = window.axios;
import Utilidad from "../Utils/Utilidad";

document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
       VARIABLES Y ELEMENTOS DEL DOM
    ===================================================== */
    const modal = document.getElementById("modal-artista");
    const modalTitulo = document.getElementById("modalTitulo");

    const inputNombre = document.getElementById("nombre");
    const inputNacionalidad = document.getElementById("nacionalidad");

    const btnGuardar = document.getElementById("btnGuardar");
    const btnCerrar = document.getElementById("btnCerrar");

    const tabla = document.getElementById("artistas-table");
    const plantillaFila = document.getElementById("plantilla-fila-artista");

    const inputBuscar = document.getElementById("inputBuscar");

    if (!tabla || !plantillaFila) return;

    /* =====================================================
       ESTADO
    ===================================================== */
    let editId = null;
    let paginaActual = 1;
    let terminoBusqueda = null;
    const mensajeDinamic = window.mensajeDinamico;

    /* =====================================================
       PINTAR TABLA
    ===================================================== */
    const pintarTabla = (artistas) => {

        const tbody = tabla.querySelector("tbody");
        if (!tbody) return;

        tbody.innerHTML = "";

        artistas.forEach(artista => {

            const clone = plantillaFila.content.cloneNode(true);

            clone.querySelector(".artista-id").textContent = artista.id;
            clone.querySelector(".artista-nombre").textContent = artista.nombre;
            clone.querySelector(".artista-nacionalidad").textContent = artista.nacionalidad;

            clone.querySelector(".editar")
                .addEventListener("click", () => abrirModalEditar(artista.id));

            clone.querySelector(".eliminar")
                .addEventListener("click", () => eliminarArtista(artista.id));

            tbody.appendChild(clone);
        });
    };

    /* =====================================================
       LISTAR Y BUSCAR
    ===================================================== */
    const listarArtistas = async (pagina = 1) => {

        try {
            let url = `/api/inicio/artistas/listar?page=${pagina}`;
            if(terminoBusqueda) url = `/api/inicio/artistas/buscar/${terminoBusqueda}?page=${pagina}`;
            const respuesta = await axios.get(url);
            const paginador = respuesta.data;

            pintarTabla(paginador.data);
            renderPaginacion(
                paginador.meta.current_page,
                paginador.meta.last_page);
            paginaActual = paginador.meta.current_page;
        } catch (error) {

            window.mensajeDinamico("Error al listar artistas", "error");
            console.error(error);
        }
    };

    /* =====================================================
       PAGINACIÓN
    ===================================================== */
    const renderPaginacion = (pagina, total) => {

        const contenedor = document.getElementById("paginacion");
        if (!contenedor) return;

        contenedor.innerHTML = "";

        const prev = document.createElement("button");
        prev.textContent = "<";
        prev.disabled = pagina === 1;
        prev.onclick = () => listarArtistas(pagina - 1);

        contenedor.appendChild(prev);

        for (let i = 1; i <= total; i++) {

            const btn = document.createElement("button");
            btn.textContent = i;

            if (i === pagina) btn.classList.add("activo");

            btn.onclick = () => listarArtistas(i);

            contenedor.appendChild(btn);
        }

        const next = document.createElement("button");
        next.textContent = ">";
        next.disabled = pagina === total;
        next.onclick = () => listarArtistas(pagina + 1);

        contenedor.appendChild(next);
    };

    /**Buscador */
    inputBuscar?.addEventListener("keyup", () => {
        const dato = inputBuscar.value.trim();
        terminoBusqueda = dato || null;
        listarArtistas(1);
    })

    /* =====================================================
       MODAL AGREGAR
    ===================================================== */
    const abrirModalAgregar = () => {

        editId = null;

        modalTitulo.textContent = "AGREGAR ARTISTA";

        inputNombre.value = "";
        inputNacionalidad.value = "";

        modal.style.display = "flex";
    };

    /* =====================================================
       MODAL EDITAR
    ===================================================== */
    const abrirModalEditar = (id) => {

        Utilidad.obtener({
            url: `/api/inicio/artistas/ver/${id}`,

            onSuccess: (artista) => {

                editId = id;

                modalTitulo.textContent = "EDITAR ARTISTA";

                inputNombre.value = artista.nombre;
                inputNacionalidad.value = artista.nacionalidad;

                modal.style.display = "flex";
            }
        });
    };

    /* =====================================================
       CERRAR MODAL
    ===================================================== */
    btnCerrar?.addEventListener("click", () => {
        modal.style.display = "none";
    });

    /* =====================================================
       GUARDAR
    ===================================================== */
    btnGuardar?.addEventListener("click", () => {

        const datos = {
            nombre: inputNombre.value.trim(),
            nacionalidad: inputNacionalidad.value.trim()
        };

        Utilidad.guardar({

            url: editId === null
                ? "/api/inicio/artistas/agregar"
                : `/api/inicio/artistas/editar/${editId}`,

            datos: datos,

            isEdit: editId !== null,

            successMsg: editId
                ? "Artista actualizado"
                : "Artista registrado",

            onSuccess: () => {

                modal.style.display = "none";

                listarArtistas(paginaActual);
            }
        });
    });

    /* =====================================================
       ELIMINAR
    ===================================================== */
    const eliminarArtista = (id) => {

        Utilidad.eliminar({

            url: `/api/inicio/artistas/eliminar/${id}`,

            successMsg: "Artista eliminado",

            onSuccess: () => listarArtistas(paginaActual)
        });
    };

    /* =====================================================
       BOTÓN AGREGAR
    ===================================================== */
    document.getElementById("btnAgregar")
        ?.addEventListener("click", abrirModalAgregar);

    /* =====================================================
       INIT
    ===================================================== */
    listarArtistas();

});
