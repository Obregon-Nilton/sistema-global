/**resources/js/Utils/Utilidad.js */
import axios from "axios";

const Utilidad = {

    eliminar: async ({
        url,//obligatorio darle un valor
        onSuccess = null, //por defecto es null, si llamaos una funcion deja de ser null
        onError = null, // por defecto es null,
        successMsg = "Eliminado corrtamente",
        errorMsg =  "Error al eliminar"
    }) => {
        try{
            await axios.delete(url);
            window.mensajeDinamico(successMsg, "success");
            onSuccess && onSuccess(); // si no es null ejecutamos una funcion
        }catch(error){
            window.mensajeDinamico(errorMsg, "error");//mensaje dinamico
            console.error(error);//muestra en consola
            onError && onError(error);//nunca deja de ser null ya q no le paso funcion
        }
    },

    guardar: async ({
    url,
    datos,
    isEdit = false,
    onSuccess = null,
    onError = null,
    successMsg = "Guardado correctamente",
    errorMsg = "Error al guardar"
}) => {
    try {
        if (isEdit) {
            await axios.put(url, datos);
        } else {
            await axios.post(url, datos);
        }

        window.mensajeDinamico(successMsg, "success");
        onSuccess && onSuccess();
    } catch (error) {
    // Si viene de backend (Handler) con DomainException o ValidationException
    const msg = error.response?.data?.message
                || error.response?.data?.errors
                || errorMsg;

    // Si es un objeto de errores, conviértelo a string
    const finalMsg = typeof msg === 'object' ? Object.values(msg).flat().join(', ') : msg;

    window.mensajeDinamico(finalMsg, "error");
    console.error(error);
    onError && onError(error);
}

},


    obtener: async ({
        url,
        onSuccess = null,
        onError = null,
        errorMsg = "Error al obtener datos"
       }) => {
        try {
             const respuesta = await axios.get(url);
            onSuccess && onSuccess(respuesta.data.data); // Devuelve los datos
          } catch (error) {
             window.mensajeDinamico(errorMsg, "error");
            console.error(error);
            onError && onError(error);
           }
    },

}

export default Utilidad;
