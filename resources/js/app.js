// resources/js/app.js

import './bootstrap';
import './sidebar';
import './roles';
import './musica/musicos';
import './musica/notaMusical';
import './usuario/usuarios';
import './musica/artista';
import './musica/instrumento';
import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';

const token = document.head.querySelector('meta[name="csrf-token"]');
if(token){
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error("CSRF token not found!");
}

window.mensajeDinamico = function (mensaje, tipo = "success"){
    const toast = document.getElementById("toast");
    if(!toast) return;

    toast.textContent = "";

    const icono = document.createElement("span");
    icono.textContent = tipo === "error" ? "⚠️" : "✅";

    const texto = document.createElement("span");
    texto.textContent = mensaje;

    toast.appendChild(icono);
    toast.appendChild(texto);

    toast.classList.remove("success", "error", "show");
    toast.classList.add(tipo, "show");

    setTimeout(() => toast.classList.remove("show"), 3000);
}


