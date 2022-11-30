<?php

namespace App\Models;

use App\Enums\BalanceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 *
 * @property Balance[] $refills
 * @property Balance[] $spends
 *
 * @property int $refills_sum_amount
 * @property int $spends_sum_amount
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function refills(): HasMany
    {
        return $this->hasMany(Balance::class, 'user_id', 'id')->where(['type' => BalanceTypeEnum::REFILL->value]);
    }

    public function spends(): HasMany
    {
        return $this->hasMany(Balance::class, 'user_id', 'id')->where(['type' => BalanceTypeEnum::SPEND->value]);
    }
}
