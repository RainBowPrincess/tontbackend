<?php

namespace App;

use App\Product;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'ordernummer'
		
	];
    
      protected $hidden = [
        'pivot'
    ];

	 public function products()
    {
        return $this->belongsToMany('App\Product')
        ->withPivot('qty', 'price');
        //->withTimestamps();
        
        //->withTimestamps();
    }
    
     public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
