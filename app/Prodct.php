<?php

namespace App;

use App\Order;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'prod_type',
    	'name',
       	'description',
       	'color',
       	'qty',
        'price',
       	'image'
       
    ];

     protected $hidden = [
        //'pivot',
        'qty',
        //'price',
        
        //'created_at',
        //'updated_at'
    ];

     public function orders()
    {
        return $this->belongsToMany('App\Order')
        ->withPivot('qty', 'price');
    }
}
