<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contrat extends Model
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
        if ($user->permission('LISTE CONTRAT')) {
            return $query; // Tous les clients
        } 

        if ($user->permission('LISTE CONTRAT PERSONNELLE')) {
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    } 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class, 'agence_id');
    }

    public function factures()
    {
        return $this->hasMany(Facture::class, 'facture_id'); 
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'paiement_id'); 
    }

    public function disponibilites()
    {
        return $this->hasMany(Disponibilite::class, 'disponibilite_id'); 
    }

}
 