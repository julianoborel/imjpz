<?php

namespace App\Http\Services;

use App\Http\Requests\Music\MusicRequest;
use App\Http\Resources\Music\MusicResource;
use App\Http\Services\BaseService;
use App\Models\Music;

class MusicService extends BaseService
{
    protected $model = Music::class;

    public function index()
    {
        $musics = Music::all();

        return MusicResource::collection($musics);
    }

    public function store(MusicRequest $request)
    {
        $music = Music::create($request->all());

        return new MusicResource($music);
    }

    public function show(int $musicId)
    {
        $music = Music::findOrFail($musicId);
        return new MusicResource($music);
    }

    public function update(MusicRequest $request, int $musicId)
    {
        $music = Music::findOrFail($musicId);
        $music->update($request->all());

        return new MusicResource($music);
    }

    public function destroy(int $musicId)
    {
        $music = Music::findOrFail($musicId);
        $music->delete();

        return true;
    }
}
