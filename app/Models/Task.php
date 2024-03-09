<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $taskName
 * @property string $taskDescription
 * @property string $status
 * @property string $priority
 * @property User $assigner
 * @property Project $project
 * @property int $projectId
 * @property int $assignerId
 * @var DateTime|string $createdAt
 * @var DateTime|string $updatedAt
 * @var DateTime|string $deadline
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
