<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AgenceUser extends Model
{
    use HasFactory;
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $table = 'agences_user'; // Spécifie ici le nom exact de la table

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

    public function agence()
    {
        return $this->belongsTo(Agence::class, 'agence_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
