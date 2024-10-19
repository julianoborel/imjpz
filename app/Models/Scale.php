<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    protected $table = "scales";
    protected $fillable = ['date', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function repertory()
    {
        return $this->hasOne(Repertory::class);
    }
}
