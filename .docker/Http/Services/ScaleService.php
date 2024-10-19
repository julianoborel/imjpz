<?php

namespace App\Http\Services;

use App\Http\Requests\Scale\ScaleRequest;
use App\Http\Resources\Scale\ScaleResource;
use App\Models\Scale;

class ScaleService extends BaseService
{
    protected $model = Scale::class;
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function store(ScaleRequest $request)
    {
        $data = $request->all();
        $scale = Scale::create($data);
        $scale->save();

        $scale->users()->attach($data['user_ids']);

        $phoneNumbers = $scale->users->pluck('number')->toArray();

        $msg = 'Você foi adicionado no grupo da escala. MENSAGEM DE TESTE';

        $this->whatsAppService->updateParticipants($phoneNumbers, 'add');
        $this->whatsAppService->sendMessage($phoneNumbers, $msg);

        return new ScaleResource($scale->load(['users']));
    }

    public function index()
    {
        $scales = Scale::with(['users'])->get(); // Carregando as relações
        return ScaleResource::collection($scales);
    }


    public function show(int $scaleId)
    {
        $scale = Scale::findOrFail($scaleId);
        return new ScaleResource($scale);
    }

    public function update(ScaleRequest $request, int $scaleId)
    {
        $scale = Scale::findOrFail($scaleId);

        $scale->update($request->all());
        $scale->users()->sync($request->input('user_ids'));

        return new ScaleResource($scale->load(['users']));
    }


    public function destroy(int $scaleId)
    {
        $scale = Scale::findOrFail($scaleId);
        $scale->delete();

        return true;
    }
}
