<?php

namespace App\Http\Services;

use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Services\BaseService;
use App\Models\User;

class UserService extends BaseService
{
    protected $model = User::class;

    public function index()
    {
        // Carregar os atributos associados a cada usuário
        $users = User::with('attributes')->get();

        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        // Criar o usuário
        $user = User::create($request->except('attribute_id'));

        // Associar os atributos passados no request
        if ($request->has('attribute_id')) {
            $user->attributes()->sync($request->input('attribute_id'));
        }

        return new UserResource($user->load('attributes'));
    }

    public function show(int $userId)
    {
        // Carregar o usuário com os atributos associados
        $user = User::with('attributes')->findOrFail($userId);
        return new UserResource($user);
    }

    public function update(UserRequest $request, int $userId)
    {
        $user = User::findOrFail($userId);
        $user->update($request->except('attribute_id'));

        // Atualizar os atributos associados ao usuário
        if ($request->has('attribute_id')) {
            $user->attributes()->sync($request->input('attribute_id'));
        }

        return new UserResource($user->load('attributes'));
    }

    public function destroy(int $userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return true;
    }
}
