<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'description'];

    // Relate each log back to the user who performed the action
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
