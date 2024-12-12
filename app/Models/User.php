<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'created_at',
        'updated_at',
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
        'password' => 'hashed',
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission($permission)
    {
       if (!$this->role) {
            return false;
        }
        return $this->role->permissions()->where('name', $permission)->exists();
    }

    public function access($permission)
    {
       if (!$this->role || !$this->role->permissions()->where('name', $permission)->exists()) {
            abort(403);
        }
    }

    public function agences_user()
    {
        return $this->hasMany(AgenceUser::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

}
