const axios = window.axios;
import Utilidad from "../Utils/Utilidad";
document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
       VARIABLES Y ELEMENTOS DEL DOM
    ===================================================== */
    const modal = document.getElementById("modal-notaMusical");
    const modalTitulo = document.getElementById("modalTitulo");
    const inputNota = document.getElementById("nota");
    const tipo = document.getElementById("tipo");
    const btnGuardar = document.getElementById("btnGuardar");
    const btnCerrar = document.getElementById("btnCerrar");

    const inputBuscar = document.getElementById("inputBuscador");
    const tabla = document.getElementById("notaMusial-table");
    const plantillaFila = document.getElementById("plantilla-fila-notaMusical");

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
    const pintarTabla = (notaMusicales) => {
        const tbody = tabla.querySelector("tbody");
        if (!tbody) return;

        tbody.innerHTML = "";

        notaMusicales.forEach(notaMusical => {
            const clone = plantillaFila.content.cloneNode(true);
            // ID
            clone.querySelector(".notaMusical-id").textContent = notaMusical.id;
            // Nota con símbolo resaltado
            const notaCelda = clone.querySelector(".notaMusical-nota");
            const n = notaMusical.nota_formateada ?? notaMusical.nota ?? '';
            const ultimo = n.slice(-1);
            const tieneSimbolo = ["♯", "♭", "♮"].includes(ultimo);

            notaCelda.innerHTML = tieneSimbolo
                ? `${n.slice(0, -1)}<span style="color:red; font-size:1.3em;">${ultimo}</span>`
                : n;

            // Tipo
            clone.querySelector(".notaMusical-tipo").textContent = notaMusical.tipo;

            // Acciones
            clone.querySelector(".editar")
                .addEventListener("click", () => abrirModalEditar(notaMusical.id));

            clone.querySelector(".eliminar")
                .addEventListener("click", () => eliminarNotaMusical(notaMusical.id));

            tbody.appendChild(clone);
        });
    };

    /* =====================================================
       LISTAR / BUSCAR CON PAGINACIÓN
       Decide automáticamente qué endpoint usar
    ===================================================== */
    const listarNotasMusicales = async (pagina = 1) => {
        try {
            let url = `/api/inicio/notasMusicales/listar?page=${pagina}`;

            // Si hay búsqueda activa, usa endpoint buscar
            if (terminoBusqueda) {
                url = `/api/inicio/notasMusicales/buscar/${terminoBusqueda}?page=${pagina}`;
            }

            const respuesta = await axios.get(url);
            const paginador = respuesta.data;

            pintarTabla(paginador.data);
            renderPaginacion(paginador.meta.current_page, paginador.meta.last_page);

            paginaActual = paginador.meta.current_page;

        } catch (error) {
            mensajeDinamic("Error al listar notas musicales", "error");
            console.error(error);
        }
    };

    /* =====================================================
       RENDER DE PAGINACIÓN
       < 1 2 3 >
    ===================================================== */
    const renderPaginacion = (paginaActual, totalPaginas) => {
        const contenedor = document.getElementById("paginacion");
        if (!contenedor) return;

        contenedor.innerHTML = "";

        // Botón <
        const prev = document.createElement("button");
        prev.textContent = "<";
        prev.disabled = paginaActual === 1;
        prev.onclick = () => listarNotasMusicales(paginaActual - 1);
        contenedor.appendChild(prev);

        // Botones numéricos
        for (let i = 1; i <= totalPaginas; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;

            if (i === paginaActual) {
                btn.classList.add("activo");
            }

            btn.onclick = () => listarNotasMusicales(i);
            contenedor.appendChild(btn);
        }

        // Botón >
        const next = document.createElement("button");
        next.textContent = ">";
        next.disabled = paginaActual === totalPaginas;
        next.onclick = () => listarNotasMusicales(paginaActual + 1);
        contenedor.appendChild(next);
    };

    /* =====================================================
       BUSCADOR
       Activa modo búsqueda o vuelve al listado
    ===================================================== */
    const buscarNotaMusical = () => {
        const dato = inputBuscar.value.trim();

        // Si se borra el texto → listado normal
        if (dato === "") {
            terminoBusqueda = null;
            listarNotasMusicales(1);
            return;
        }

        // Activa búsqueda
        terminoBusqueda = dato;
        listarNotasMusicales(1);
    };

    inputBuscar?.addEventListener("keyup", buscarNotaMusical);

    /* =====================================================
       MODAL AGREGAR
    ===================================================== */
    const abrirModalAgregar = () => {
        editId = null;
        modalTitulo.textContent = "AGREGAR NOTA MUSICAL";
        inputNota.value = "";
        tipo.value = "";
        modal.style.display = "flex";
    };

    /* =====================================================
       MODAL EDITAR
    ===================================================== */
    const abrirModalEditar = (id) => {
         Utilidad.obtener({
             url: `/api/inicio/notasMusicales/ver/${id}`,
             onSuccess: (notaMusical) => {
                 editId = id;
                 modalTitulo.textContent = "MODIFICAR NOTA MUSICAL";
                 inputNota.value = notaMusical.nota;
                 tipo.value = notaMusical.tipo;
                 modal.style.display = "flex";
             }
         });
     };


    /* =====================================================
       CERRAR MODAL
    ===================================================== */
    const cerrarModal = () => {
        modal.style.display = "none";
    };

    /* =====================================================
       GUARDAR (AGREGAR / EDITAR)
    ===================================================== */
    const guardarNotaMusical = async () => {
        const datos = {
        nota: inputNota.value.trim(),
        tipo: tipo.value.trim()
    };
    // Llamamos a Utilidad.guardar pasando los datos y callbacks
    Utilidad.guardar({
        url: editId === null
            ? "/api/inicio/notasMusicales/agregar"
            : `/api/inicio/notasMusicales/editar/${editId}`,
        datos: datos,
        isEdit: editId !== null,
        onSuccess: () => {
            cerrarModal();
            listarNotasMusicales(paginaActual);
        }
    });
     }

    /* =====================================================
       ELIMINAR
    ===================================================== */
    const eliminarNotaMusical = async (id) => {
        Utilidad.eliminar({
            url: `/api/inicio/notasMusicales/eliminar/${id}`,
            successMsg: "Nota musical eliminada correctamente",
            onSuccess: () => listarNotasMusicales(paginaActual) // aca le estamos diciendo ejecuts esta funcion
        });
    }

    /* =====================================================
       EVENTOS
    ===================================================== */
    document.getElementById("btnAgregar")
        ?.addEventListener("click", abrirModalAgregar);

    btnCerrar?.addEventListener("click", cerrarModal);
    btnGuardar?.addEventListener("click", guardarNotaMusical);

    /* =====================================================
       INIT
    ===================================================== */
    listarNotasMusicales();
});
