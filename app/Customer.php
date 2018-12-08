<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
      protected $fillable = [
        'order_id',
    	  'email',
    	  'fname',
        'sname',

       	'adress',
        'pnumber',
        
       	'city',
        'phone',
       	
       	
       
    ];  

     public function order()
    {
        return $this->belongsTo('App\Order');
    }


   
}
