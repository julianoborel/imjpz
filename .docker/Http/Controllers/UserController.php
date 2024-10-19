<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->index();

            return response()->json([
                'data' => $users,
                'message' => __('validation.success'),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(int $userId)
    {
        $user = $this->userService->show($userId);
        return response()->json([
            'data' => new UserResource($user),
            'message' => __('validation.success'),
        ], JsonResponse::HTTP_OK);
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->store($request);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.insert', ["model" => __('crud.model.user')]),
                'data' => new UserResource($user),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(UserRequest $request, int $userId)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->update($request, $userId);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.update', ["model" => __('crud.model.user')]),
                'data' => new UserResource($user),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int $userId)
    {
        try {
            DB::beginTransaction();
            $this->userService->destroy($userId);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.delete', ["model" => __('crud.model.user')]),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
