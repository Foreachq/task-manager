<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by_id');
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'assigned_to_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'tasks_m2m_labels');
    }
}
