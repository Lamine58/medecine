<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerContribution extends Model
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

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'contribution_id');
    }

    public static function isExist($customer_id,$contribution_id){

        return CustomerContribution::where('customer_id', $customer_id)
                ->where('contribution_id', $contribution_id)
                ->count() > 0;
    }
}
