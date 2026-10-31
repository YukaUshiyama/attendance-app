<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Breaktime extends Model
{
    use HasFactory;
    protected $fillable = [
        'worktime_id',
        'break_in',
        'break_out',
    ];
public function worktime(): BelongsTo
{
    return $this->belongsTo(Worktime::class);
}
}
