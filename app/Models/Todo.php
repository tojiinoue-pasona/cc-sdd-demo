<?php

namespace App\Models;

use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    protected $casts = [
        'status' => TodoStatus::class,
    ];
}
