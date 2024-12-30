<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Facture extends Model
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

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id');
    }
} 
