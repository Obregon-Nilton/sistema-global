<?php
/**
 * Controller maneja la entrada y salida de datos.
 * Recibe Requests desde el frontend.
 * Llama al Service para lógica de negocio y procesamiento.
 * Devuelve Resources o JSON con formato y códigos HTTP adecuados.
 * No se hace lógica de negocio, acceso directo a base de datos,
 * validación de datos (FormRequest), ni manejo de excepciones de negocio.
 */

namespace App\Http\Controllers;
//controllerdecide que devolver
//ENTRADA DESD FRONTEND

use App\Http\Requests\NotaMusicalRequest;
use App\Http\Resources\NotaMusicalResource;
use App\Services\NotaMusicalService;

class NotaMusicalController extends Controller
{
    protected NotaMusicalService $service;

    public function __construct(NotaMusicalService $service){
        $this->service = $service;
    }

    public function index(){
        return view('pages.musica.notaMusical');
    }
    //Objeto → additional → toArray → JSON → response (envía)

    public function agregarNotaMusical(NotaMusicalRequest $request){//request de entrada
        $nota = $this->service->agregarNotaMusical(
            $request->only(['nota', 'tipo']));
            //creamos una instancia, nose guarda en variable ya q no se vuelve a usar
        return NotaMusicalResource::make($nota) //creamos instancia de resource, make = crear/construir un onjeto
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(201);//al q consume api le decimos q pasó, se agregó
    }

    public function editarNotaMusical($id, NotaMusicalRequest $request){ //Request entra al backend con datos
        $nota = $this->service->editarNotaMusical(
            $id, $request->only(['nota', 'tipo']));
        return NotaMusicalResource::make($nota)
            ->additional(['success' => true])// s falla no se envia false ni nada ya q no es booleano
            //aca se ejecuto el metdo toAray de l clase eredada -> definicion
            //aca es donde se comvierte a json, laravel ve q el dato ya va salir ahi es dnd transforma d array a json -> formato
            ->response() // Response sale del backend con resultados. es salida osea le envia en json ya
            ->setStatusCode(200);
    }

    public function verNotaMusical($id){
        $nota = $this->service->verNotaMusical($id);
        return NotaMusicalResource::make($nota)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(200);//termino con este
    }

    public function listarNotasMusicales(){
        $notas = $this->service->listarNotasMusicales();
        return NotaMusicalResource::collection($notas) //collection = muchos objetos crea osea varias filas
            ->additional(['success' => true]) //agrega dato extra al json
            ->response();
    }

    public function buscarNota($dato){
        $data = $this->service->buscar($dato);
        return NotaMusicalResource::collection($data)
            ->additional(['success' => true])
            ->response();
    }
//ELIMINAR (NO usa Resource)
    public function eliminarNotaMusical($id){
        $this->service->eliminarNotaMusical($id);
        return response()->json(['success' => true]);
    }

}

// | Acción           | Código        |
// | ---------------- | ------------- |
// | Agregar          | **201**       |
// | Editar           | **200**       |
// | Ver              | **200**       |
// | Listar           | **200**       |
// | Eliminar         | **200 o 204** |
// | Validación falla | **422**       |
// | No existe        | **404**       |
// | Error interno    | **500**       |
