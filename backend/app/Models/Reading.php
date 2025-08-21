<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'read_on',
        'impression',
    ];

    protected $casts = [
        'read_on' => 'date',
    ];
}
