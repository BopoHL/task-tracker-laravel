<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string task_name
 * @property string task_description
 * @property string status
 * @property string priority
 * @property User $assigner
 * @property Project $project
 * @property int project_id
 * @property int assigner_id
 * @property  DateTime|string deadline
 * @property  DateTime|string created_at
 * @property  DateTime|string updated_at
 */

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['task_name', 'task_description', 'status', 'priority', 'deadline'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigner_id');
    }
}
