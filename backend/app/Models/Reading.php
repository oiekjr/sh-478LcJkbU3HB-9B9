<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'read_on',
        'impression',
        'user_id',
    ];

    protected $casts = [
        'read_on' => 'date',
    ];

    protected function readOn(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::parse($value)->tz(config('app.timezone'))->format('Y-m-d')
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
