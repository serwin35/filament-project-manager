<?php

namespace App\Models;

use App\Enums\ProjectStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'start_date', 'end_date'];

    protected function casts()
    {
        return [
            'state' => ProjectStateEnum::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
