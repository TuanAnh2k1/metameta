<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Base extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user?->id;
        });
        static::deleting(function ($model) {
            $user = Auth::user();
            $model->deleted_by = $user?->id;
            $model->save();
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user?->id;
        });
    }

    /**
     * Get the creator.
     */
    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }
}
