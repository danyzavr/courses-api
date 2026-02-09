<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    use HasUuids;
    protected $table = 'courses';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'uuid',
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'course_id', 'id');
    }
}
