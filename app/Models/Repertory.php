<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repertory extends Model
{
    protected $fillable = ['title', 'notes', 'scale_id'];

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function musics()
    {
        return $this->hasMany(Music::class);
    }
}
