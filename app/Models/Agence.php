<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Agence extends Model
{
    use HasFactory;
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $guarded = [
        'created_at',
        'updated_at', 
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function agences_user()
    {
        return $this->hasMany(AgenceUser::class);
    }

    public function employes()
    {
        return $this->hasMany(Employe::class);
    }
}
