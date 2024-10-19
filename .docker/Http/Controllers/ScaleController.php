<?php

namespace App\Http\Controllers;

use App\Http\Services\ScaleService;
use Illuminate\Http\Request;
use App\Http\Requests\Scale\ScaleRequest;
use App\Http\Resources\Scale\ScaleResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ScaleController extends Controller
{
    protected $scaleService;

    public function __construct(ScaleService $scaleService)
    {
        $this->scaleService = $scaleService;
    }

    public function index()
    {
        try {
            $scales = $this->scaleService->index();

            return response()->json([
                'data' => $scales,
                'message' => __('validation.success'),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(int $scaleId)
    {
        $scale = $this->scaleService->show($scaleId);
        return response()->json([
            'data' => new ScaleResource($scale),
            'message' => __('validation.success'),
        ], JsonResponse::HTTP_OK);
    }

    public function store(ScaleRequest $request)
    {
        try {
            DB::beginTransaction();
            $scale = $this->scaleService->store($request);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.insert', ["model" => __('crud.model.scale')]),
                'data' => new ScaleResource($scale),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(ScaleRequest $request, int $scaleId)
    {
        try {
            DB::beginTransaction();
            $scale = $this->scaleService->update($request, $scaleId);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.update', ["model" => __('crud.model.scale')]),
                'data' => new ScaleResource($scale),
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(
                ["message" => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int $scaleId)
    {
        try {
            DB::beginTransaction();
            $this->scaleService->destroy($scaleId);
            DB::commit();

            return response()->json([
                'message' => __('crud.message.delete', ["model" => __('crud.model.scale')]),
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
