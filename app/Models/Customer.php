<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function scopeAccessibleBy($query, $user)
    {
        if ($user->permission('LISTE CLIENT')) {
            return $query; // Tous les clients
        } 

        if ($user->permission('LISTE CLIENT PERSONNEL')) {
            return $query->where('user_id', $user->id); // Clients créés par l'utilisateur
        }

        // Aucun client si pas de permission
        return $query->whereRaw('0 = 1');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'client_id'); 
    }


    
}
 