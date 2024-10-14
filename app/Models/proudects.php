<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proudects extends Model
{
    protected $guarded = [];
    
    public function section()
    {
        return $this->belongsTo(section::class);
    }
}
