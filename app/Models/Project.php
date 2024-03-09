<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $projectName
 * @property string $projectDescription
 * @property int $ownerId
 * @property User $owner
 * @property User[] $users
 * @property Task[] $tasks
 * @var DateTime|string $createdAt
 * @var DateTime|string $updatedAt
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = ['project_name', 'project_description', 'owner_id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }
}
