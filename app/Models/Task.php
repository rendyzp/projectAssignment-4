<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
}
