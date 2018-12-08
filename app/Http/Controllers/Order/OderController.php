<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Product;
use App\Customer;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class OrderController extends Controller
{


  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       

         $orders = Order::where([
            ['shipped', '=', false],
            ['payed', '=', false],
            ])->get();
         //Log::info($order);
         //$model = User::where('votes', '>', 100)->firstOrFail();
         //$products = Product::all();

         return response()->json(['orders' => $orders]);
    }
    

    public function addOrder(Request $request){

        $orderProducts = $request->all();

        return response()->json(['message' => 'success', 'orderProducts' => $orderProducts]);


    }


    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
       
    {   


                // 1    charge what for response.
                // 2    Add order and pass order id to customer.
                // 3    Add cusomer return response.

                $data= $request->all();
               
               // Charge

                $paydata = $data[count($data)-1]; 
                Log::info(['paydata', $paydata ]);
                $tokenId = $paydata['id'];
                Log::info(['token', $tokenId]);
                $amount = $paydata['amount'];
                Log::info(['amount', $amount]);


                try {
                      // Use Stripe's library to make requests...

                    $stripe = Stripe::make('sk_test_aLOFY3leWyOdLgxFGi0iS0wJ');
                        $charge = $stripe->charges()->create([
                        'currency' => 'SEK',
                        'amount'   => $amount,
                        'source' => $tokenId,
                    ]);


                    } catch(\Stripe\Error\Card $e) {
                      // Since it's a decline, \Stripe\Error\Card will be caught
                      $body = $e->getJsonBody();
                      $err  = $body['error'];

                      // print('Status is:' . $e->getHttpStatus() . "\n");
                      // print('Type is:' . $err['type'] . "\n");
                      // print('Code is:' . $err['code'] . "\n");
                      // // param is '' in this case
                      // print('Param is:' . $err['param'] . "\n");
                      // print('Message is:' . $err['message'] . "\n");
                        return response()->json(['Meassage' => 'error', 'error' => $err]);
                    } catch (\Stripe\Error\RateLimit $e) {
                      // Too many requests made to the API too quickly
                    } catch (\Stripe\Error\InvalidRequest $e) {
                      // Invalid parameters were supplied to Stripe's API
                    } catch (\Stripe\Error\Authentication $e) {
                      // Authentication with Stripe's API failed
                      // (maybe you changed API keys recently)
                    } catch (\Stripe\Error\ApiConnection $e) {
                      // Network communication with Stripe failed
                    } catch (\Stripe\Error\Base $e) {
                      // Display a very generic error to the user, and maybe send
                      // yourself an email
                    } catch (Exception $e) {
                      // Something else happened, completely unrelated to Stripe
                    }

                // Log::info(['StripeSuccess', $stripe->status]);
                Log::info(['Striperesponce', $stripe]);
                Log::info(['Striperchare', $charge['status']]);

                
                //Order  // inlagt mån natt

                $date = date("Ymd");
                $ordernummer = uniqid($date, true);
                $orderdata['ordernummer'] = $ordernummer;
                Log::info(['Ordummer', $ordernummer ]);

              
                $order = Order::create($orderdata);

                $orderId = $order->id;
                
                Log::info(['Kolla Order id', $order->id]);
                //Log::info(['vad inhelåller Order obj' , $order]);
                $qty = null;
                $id = null;
                $summa = null;
                
                foreach ( $data as $toparray ) {
                    foreach ( $toparray as $key => $value ) {
                if($key == 'id'){ 
                    $id = $value;
                    Log::info($id);
                    //Log::info('värde till id');
                    
                 }
                 

                 if($key == 'qty'){
                    $qty = $value;
                    Log::info($qty);
                    //Log::info('värde till qty');
                   
                 }

                 if($key == 'totalPrice'){
                    $summa = $value;
                    Log::info( $summa);
                    $order->products()->attach($id,['qty' => $qty, 'price' => $summa]);
                 }

             }

              
            }

                // Custome Adress
                 $customer = $data[count($data)-2]; 
                 
                 $customer['order_id'] = $orderId;
                 $newcustomer = Customer::create($customer);
                 Log::info(['Customer', $newcustomer ]);


              





               
                return response()->json(['message' => $charge['status'], 'ordernr' => $ordernummer ]);

                // return response()->json(['message' => 'success', 'order' => $order]);


    }


    // public function store(Request $request){

    //      $data= $request->all();

    //       $date = date("Ymd");
    //       $ordernummer = uniqid($date, true);
    //       $orderdata['ordernummer'] = $ordernummer;
    //       Log::info(['Ordummer', $ordernummer ]);

              
    //       $order = Order::create($orderdata);

    //       return response()->json(['message' => 'success', 'order' => $order]);




    // }


//Test funktion för att slippa hela stripe processen
   
// public function store(Request $request){

//    $data= $request->all();

//    $paydata = $data[count($data)-1]; 
//     Log::info(['paydata', $paydata ]);
//      $tokenId = $paydata['id'];
//     Log::info(['paydataid', $tokenId ]);
//     $amount = $paydata['amount'];
//     Log::info(['amount', $amount]);

  

//     return response()->json(['message' => 'success']);

// }





    // Kanske måste sätta i en egen controller där man har med order id
    // för jag måste gå igen samma procedur som i store kolla lagersaldo och reducear osv
     public function addToOrder(Request $request, $id){

        
        $product = Product::find($request->item);

        if($request->qty > $product->qty){
           return response()->json(['message' => 'Lagrsaldo är överskridit']); 
        }

        return DB::transaction(function() use ($request, $product, $id){
                /*Log::info($request->qty);
                Log::info($product);*/
                $order = Order::find($id);
                $product->qty -= $request->qty;
                $product->save();

                $price = $product->price * $request->qty;
                $qty = $request->qty;
        
        $order->products()->attach($request->item, ['qty' => $qty, 'price' => $price]);

        return response()->json(['message' => 'succes', 'order' => $order, 201]);
    });
}








    //Testmdtod för att ta bort relationer
    public function removeFromOrder(Request $request, $id)
    {
        $product = Product::find($request->item);

        return DB::transaction(function() use ($request, $product, $id){

        $order = Order::find($id);
        $product->qty += $request->qty;
        $product->save();

        $price = $product->price * $request->qty;
        $qty = $request->qty;
        

        $order->products()->detach($request->item, ['qty' => $qty, 'price' => $price]);
        //$order->products()->detach();// tar bort alla relationer till denna ordern

        return response()->json(['message' => 'succesfuly remove item', 'order' => $order, 201]);
        });

    }



    /**
     * Find order by id primary key
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$order = Order::find($id);//->products()->get();
        //$products = Order::find($id)->products()->orderBy('color')->get();
        $order = Order::find($id);
            // foreach ($order->products as $product) {
            // echo $product->pivot->qty;



        $products = $order->products;

        $customer = $order->customer;
        $sum = 0;
        $sumitem = 0;
      foreach ($order->products as $product)
        {
            $sum += $product->pivot->price;
            $product->qty;
        }

        

        
        //$roles = App\User::find(1)->roles()->orderBy('name')->get();
        
        return response()->json(['products' => $products]);
    }


    //måste kolla på att generat och att söka efter nummer.
    //url https://www.drzon.net/posts/generate-random-order-number/
    // Har kanske redan en lösning i dodod  usr index kolla.
    public function findOrderNumber( $n){

       
    }



    //'summan' => $sum, 'summanprod' => $qty, 'customer' => $customer

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  /*  public function update(Request $request, $id)
    {
        $orderToUpdate = Order::find($id);
        $item = $request->item;
        $updatedOrder = $orderToUpdate->products()->attach($request->item);
        //return response()->json(['message' => 'Order Updated', 'order' => $updatedOrder, 201]);
        return response()->json(['item' => $item , 'order' => $orderToUpdate, 201]);


    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
