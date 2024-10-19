<?php

namespace App\Http\Controllers;

use App\Http\Services\MusicService;
use Illuminate\Http\Request;
use App\Http\Requests\Music\MusicRequest;
use App\Http\Resources\Music\MusicResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MusicController extends Controller
{
    protected $musicService;

    public function __construct(MusicService $musicService)
    {
        $this->musicService = $musicService;
    }

    public function index()
    {
        try {
            $musics = $this->musicService->index();

            return response()->json([
                'data' => $musics,
                'message' => __('validation.success'),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(int $musicId)
    {
        $music = $this->musicService->show($musicId);
        return response()->json([
            'data' => new MusicResource($music),
            'message' => __('validation.success'),
        ], JsonResponse::HTTP_OK);
    }

    public function store(MusicRequest $request)
    {
        try {
            DB::beginTransaction();
            $music = $this->musicService->store($request);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.insert', ["model" => __('crud.model.music')]),
                'data' => new MusicResource($music),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(MusicRequest $request, int $musicId)
    {
        try {
            DB::beginTransaction();
            $music = $this->musicService->update($request, $musicId);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.update', ["model" => __('crud.model.music')]),
                'data' => new MusicResource($music),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int $musicId)
    {
        try {
            DB::beginTransaction();
            $this->musicService->destroy($musicId);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.delete', ["model" => __('crud.model.music')]),
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
