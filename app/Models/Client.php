<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'paiement_id'); 
    }

    public function disponibilites()
    {
        return $this->hasMany(Disponibilite::class, 'disponibilite_id'); 
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'contrat_id'); 
    }
}
