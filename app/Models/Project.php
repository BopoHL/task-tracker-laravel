<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property int id
 * @property string project_name
 * @property string project_description
 * @property User[] users
 * @property Task[] tasks
 * @var DateTime|string created_at
 * @var DateTime|string updated_at
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
