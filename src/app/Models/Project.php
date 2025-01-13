<?php

namespace App\Models;

use App\Enums\ProjectStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'start_date', 'end_date'];

    protected function casts(): array
    {
        return [
            'state' => ProjectStateEnum::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
