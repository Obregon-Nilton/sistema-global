// resources/js/musica/musicos.js

import axios from "axios";
import Utilidad from "../Utils/Utilidad";

document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
       VARIABLES Y ELEMENTOS DEL DOM
    ===================================================== */
    const modal = document.getElementById("modal-musico");
    const modalTitulo = document.getElementById("modalTitulo");
    const inputNombre = document.getElementById("nombre");
    const inputApellido = document.getElementById("apellido");
    const inputDni = document.getElementById("dni");
    const inputTelefono = document.getElementById("telefono");
    const inputFecha = document.getElementById("fecha");
    const btnGuardar = document.getElementById("btnGuardar");
    const btnCerrar = document.getElementById("btnCerrar");
    const inputBuscar = document.getElementById("inputBuscar");
    const selectEdad = document.getElementById("mostrarPorEdad");
    const tabla = document.getElementById("musicos-table");
    const plantillaFila = document.getElementById("plantilla-fila-musico");

    if (!tabla || !plantillaFila) return;

    /* =====================================================
       ESTADO DE LA VISTA
    ===================================================== */
    let editId = null;
    let paginaActual = 1;
    let terminoBusqueda = null;
    const mensajeDinamic = window.mensajeDinamico;

    /* =====================================================
       PINTAR TABLA = Dibuja SOLO los registros recibidos
    ===================================================== */
    const pintarTabla = (musicos) => {
        const tbody = tabla.querySelector("tbody");
        if(!tbody) return;
        tbody.innerHTML = "";

        musicos.forEach(musico => {
            const clone = plantillaFila.content.cloneNode(true);
            clone.querySelector(".musico-id").textContent = musico.id_musico;
            clone.querySelector(".musico-nombre").textContent = musico.persona.nombre;
            clone.querySelector(".musico-apellido").textContent = musico.persona.apellido;
            clone.querySelector(".musico-dni").textContent = musico.persona.dni;
            clone.querySelector(".musico-telefono").textContent = musico.persona.telefono;
            clone.querySelector(".musico-fecha").textContent = musico.persona.fecha_nacimiento;

            clone.querySelector(".editar").addEventListener("click", () => abrirModalEditar(musico.id_musico));
            clone.querySelector(".eliminar").addEventListener("click", () => eliminarMusico(musico.id_musico));

            tbody.appendChild(clone);
        });
    };

    /* =====================================================
       LISTAR / BUSCAR CON PAGINACIÓN
       Decide automáticamente qué endpoint usar
    ===================================================== */
    const listarMusicos = async (pagina = 1) => {
        try {
            let url = `/inicio/musicos/listar?page=${pagina}`;
            if(terminoBusqueda) url = `/inicio/musicos/buscar/${terminoBusqueda}?page=${pagina}`;

            const respuesta = await axios.get(url);
            const paginador = respuesta.data;

            pintarTabla(paginador.data);
            renderPaginacion(paginador.meta.current_page, paginador.meta.last_page);
            paginaActual = paginador.meta.current_page;
        } catch(error) {
            mensajeDinamic("Error al listar músicos","error");
            console.error(error);
        }
    };

    /* =====================================================
       RENDER DE PAGINACIÓN
       < 1 2 3 >
    ===================================================== */
    const renderPaginacion = (paginaActual, totalPaginas) => {
        const contenedor = document.getElementById("paginacion");
        if(!contenedor) return;
        contenedor.innerHTML = "";

        const prev = document.createElement("button");
        prev.textContent = "<";
        prev.disabled = paginaActual === 1;
        prev.onclick = () => listarMusicos(paginaActual - 1);
        contenedor.appendChild(prev);

        for(let i=1; i<=totalPaginas; i++){
            const btn = document.createElement("button");
            btn.textContent = i;
            if(i === paginaActual) btn.classList.add("activo");
            btn.onclick = () => listarMusicos(i);
            contenedor.appendChild(btn);
        }

        const next = document.createElement("button");
        next.textContent = ">";
        next.disabled = paginaActual === totalPaginas;
        next.onclick = () => listarMusicos(paginaActual + 1);
        contenedor.appendChild(next);
    };

    /* =====================================================
       BUSCADOR
    ===================================================== */
    inputBuscar?.addEventListener("keyup", () => {
        const dato = inputBuscar.value.trim();
        terminoBusqueda = dato || null;
        listarMusicos(1);
    });

    /* =====================================================
       FILTRAR POR EDAD
       Usa el select "mostrarPorEdad"
    ===================================================== */
    selectEdad?.addEventListener("change", () => {
    const valor = selectEdad.value;
    terminoBusqueda = null;

    let url = `/inicio/musicos/filtrarPorEdad?page=1`;
    if(valor !== "") url += `&mostrarPorEdad=${valor}`;

    axios.get(url)
        .then(respuesta => {
            const paginador = respuesta.data; // LengthAwarePaginator
            pintarTabla(paginador.data);
            renderPaginacion(paginador.meta.current_page, paginador.meta.last_page); // ✅ dinámico
            paginaActual = paginador.meta.current_page;
        })
        .catch(error => {
            mensajeDinamic("Error al filtrar por edad", "error");
            console.error(error);
        });
});


    /* =====================================================
       MODAL AGREGAR
    ===================================================== */
    const abrirModalAgregar = () => {
        editId = null;
        modalTitulo.textContent = "AGREGAR MÚSICO";
        inputNombre.value = "";
        inputApellido.value = "";
        inputDni.value = "";
        inputTelefono.value = "";
        inputFecha.value = "";
        modal.style.display = "flex";
    };

    /* =====================================================
       MODAL EDITAR
    ===================================================== */
    const abrirModalEditar = (id) => {
        Utilidad.obtener({
            url: `/inicio/musicos/ver/${id}`,
            onSuccess: (musico) => {
                editId = id;
                modalTitulo.textContent = "MODIFICAR MÚSICO";
                inputNombre.value = musico.persona.nombre;
                inputApellido.value = musico.persona.apellido;
                inputDni.value = musico.persona.dni;
                inputTelefono.value = musico.persona.telefono;
                inputFecha.value = musico.persona.fecha_nacimiento;
                modal.style.display = "flex";
            }
        });
    };

    /* =====================================================
       CERRAR MODAL
    ===================================================== */
    btnCerrar?.addEventListener("click", () => modal.style.display = "none");

    /* =====================================================
       GUARDAR (AGREGAR / EDITAR)
    ===================================================== */
    btnGuardar?.addEventListener("click", () => {
        const datos = {
            nombre: inputNombre.value.trim(),
            apellido: inputApellido.value.trim(),
            dni: inputDni.value.trim(),
            telefono: inputTelefono.value.trim(),
            fecha_nacimiento: inputFecha.value.trim()
        };

        Utilidad.guardar({
            url: editId === null
                ? "/inicio/musicos/agregar"
                : `/inicio/musicos/editar/${editId}`,
            datos: datos,
            isEdit: editId !== null,
            onSuccess: () => {
                modal.style.display = "none";
                listarMusicos(paginaActual);
            }
        });
    });

    /* =====================================================
       ELIMINAR
    ===================================================== */
    const eliminarMusico = (id) => {
        Utilidad.eliminar({
            url: `/inicio/musicos/eliminar/${id}`,
            successMsg: "Músico eliminado correctamente",
            onSuccess: () => listarMusicos(paginaActual)
        });
    };

    /* =====================================================
       BOTÓN AGREGAR
    ===================================================== */
    document.getElementById("btnAgregar")?.addEventListener("click", abrirModalAgregar);

    /* =====================================================
       INIT
    ===================================================== */
    listarMusicos();

});
