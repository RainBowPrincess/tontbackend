<?php

namespace App\Http\Controllers\Payment;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class PaymentController extends Controller
{

    public function charge(Request $request)
    {

    	//$charge = $request->all();
        $tokenId = $request->id;
        $amount = $request->amount;

        Log::info(['amount', $amount]);
    
/*       
$stripe = Stripe::make('sk_test_dAdVzlDXd6O8ntiPQOqATTgm');

    $charge = $stripe->charges()->create([
    
    'currency' => 'SEK',
    'amount'   => 50.49,
    'source' => $tokenId,
]);

    return response()->json(['message' => 'succes', 'stripe' => $stripe, 'id' => $tokenId]);*/


    }

     public function test(Request $request)
    {
        return response()->json(['message' => 'succes']);

    }

  
}
