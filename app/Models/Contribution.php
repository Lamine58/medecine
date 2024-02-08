<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contribution extends Model
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

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'type_exam_businesses', 'type_exam_id', 'business_id');
    }

    public static function period($period)
    {
        if($period=='day'){
            return 'Journnalier';
        }elseif($period=='month'){
            return 'Mensuel';
        }else{
            return 'Annuel';
        }
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'contribution_id');
    }
    
    public function getCustomersForContribution()
    {
        return CustomerContribution::where('contribution_id', $this->id)->with('customer')->get()->pluck('customer');
    }

}
