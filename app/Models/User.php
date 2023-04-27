<?php

namespace App\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\QueryBuilder\QueryBuilder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, PaginationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
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

    protected array $allowedFilters = [
        'id',
        'name',
        'surname',
        'email',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'surname',
        'email',
        'updated_at',
        'created_at',
    ];

    const PASSWORD_VALIDATION = [
        "required",
        "min:8",
        "confirmed",
        'regex:/[a-z]/',
        'regex:/[A-Z]/',
        'regex:/[0-9]/',
        'regex:/[@$!%*#?&_.;]/',
    ];

    public function getStatus()
    {
        return [
            0 => __("Non Attivo"),
            1 => __("Attivo")
        ];
    }

    public static function getQueryForApi($search = [])
    {
        $query = self::query();

        $query->where("users.status", 1);

        return $query;
    }

    public static function paginatorSorts()
    {
        return "surname";
    }

    public static function paginatorSortable()
    {
        return [
            'name',
            'surname',
            'email',
        ];
    }

    public static function paginatorFilterable()
    {
        return [
            'name',
            'surname',
            'email',
        ];
    }
}
