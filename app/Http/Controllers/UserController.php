<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function agregarUser(
        PersonaRequest $personaRequest,
        UserRequest $userRequest)
    {
        $user = $this->service->agregarUser(
            array_merge( /** validated() devuelve solo los datos que fueron validados en el FormRequest */
                $personaRequest->validated(),
                $userRequest->validated()
            )
        );
        return UserResource::make($user)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(201);
    }

    public function editarUser(
        int $usuario,
        PersonaRequest $personaRequest,
        UserRequest $userRequest)
        {
            $user = $this->service->editarUser(
                $usuario, array_merge(
                    $personaRequest->validated(),
                    $userRequest->validated()
                )
            );
            return UserResource::make($user)
                ->additional(['success' => true])
                ->response()
                ->setStatusCode(200);
        }

    public function verUser(int $idUser)
    {
        $user = $this->service->verUser($idUser);
        return UserResource::make($user)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(200);
    }

    public function eliminarUser(int $idUser)
    {
        $this->service->eliminarUser($idUser);
        return response()->json(['success' => true]);
    }

    public function listarUsers()
    {
        $users = $this->service->listarUsers();
        return UserResource::collection($users)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(200);
    }

    public function index()
    {
        return view('pages.usuario.user');
    }
}
