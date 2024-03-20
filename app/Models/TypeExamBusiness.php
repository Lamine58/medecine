<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TypeExamBusiness extends Model
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

    public static function day ($index){

        $week = [
            1 => "Lundi",
            2 => "Mardi",
            3 => "Mercredi",
            4 => "Jeudi",
            5 => "Vendredi",
            6 => "Samedi",
            7 => "Dimanche"
        ];

        return $week[$index];
    }
}
