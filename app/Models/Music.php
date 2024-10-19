<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $table = "musics"; // Tabela correspondente
    protected $fillable = ['title', 'artist', 'repertory_id'];

    public function repertory()
    {
        return $this->belongsTo(Repertory::class);
    }
}
