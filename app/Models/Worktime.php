<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worktime extends Model
{
    use HasFactory;
    protected $fillable = ['clock_in', 'clock_out'];
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function breaktimes(): HasMany
{
    return $this->hasMany(Breaktime::class);
}
}
