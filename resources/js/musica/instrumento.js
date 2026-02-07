// resources\js\musica\instrumento.js

const axios = window.axios;
import Utilidad from "../Utils/Utilidad";

document.addEventListener("DOMContentLoaded", () => {

    /**VARIABLES Y ELEMENTOS DEL DOM */
    const modal = document.getElementById("modal-instrumento");
    const modalTitulo = document.getElementById("modalTitulo");

    const inputInstrumento = document.getElementById("instrumento");
    const selectNivel = document.getElementById("nivel");
    const selectCategoria = document.getElementById("categoria");

    const btnGuardar = document.getElementById("btnGuardar");
    const btnCerrar = document.getElementById("btnCerrar");

    const tabla = document.getElementById("instrumentos-table");
    const plantillaFila = document.getElementById("plantilla-fila-instrumento");

    if(!tabla || !plantillaFila) return;

    /**Estados */
    let editId = null;
    let paginaActual = 1;
    let terminoBusqueda = null;
    const mensajeDinamic = window.mensajeDinamico;

    /**Pintar tabla */
    const pintarTabla = (instrumentos) => {
        const tbody = tabla.querySelector("tbody");
        if(!tbody) return;
        tbody.innerHTML = "";

        instrumentos.forEach(instrumento => {

            const clone =plantillaFila.content.cloneNode(true);

            clone.querySelector(".instrumento-id").textContent = instrumento.id;
            clone.querySelector(".instrumento").textContent = instrumento.instrumento;
            clone.querySelector(".instrumento-nivel").textContent = instrumento.nivel;
            clone.querySelector(".instrumento-categoria").textContent = instrumento.categoria;

            clone.querySelector(".editar")
                .addEventListener ("click", () => abrirModalEditar(instrumento.id));

            clone.querySelector(".eliminar")
                .addEventListener("click", () => eliminarInstrumento(instrumento.id));

            tbody.appendChild(clone);
        });
    }

    /**Listar y buscar */
    const listarInstrumentos = async (pagina = 1) => {
        try{
            let url = `/api/inicio/instrumentos/listar?page=${pagina}`;
        }catch(error){};
    }

})
