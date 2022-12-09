<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property $questions
 */
class Survey extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string[] */
    protected $fillable = ['name', 'is_published'];

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('weight');
    }
}
