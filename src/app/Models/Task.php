<?php

namespace App\Models;

use App\Enums\TaskStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'state',
        'start_date',
        'end_date',

    ];

    protected function casts()
    {
        return [
            'state' => TaskStateEnum::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
