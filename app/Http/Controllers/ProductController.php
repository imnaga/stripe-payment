<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Guest;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Billable;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class ProductController extends Controller
{
    use Billable;

    public function index(Request $request){
        $products = Product::all();
        return view('product.index', compact('products')); 
    }

    public function checkout(Request $request){
        $postId = $request->post("product_id");
        $product = Product::find($postId);
        
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRETE_KEY'));
        // $checkout_session = $stripe->checkout->sessions->create([
        // 'line_items' => [[
        //     'price_data' => [
        //     'currency' => 'inr',
        //     'product_data' => [
        //         'name' => $product->name,
        //     ],
        //     'unit_amount' => round($product->price * 100),
        //     ],
        //     'quantity' => 1,
        // ]],
        // 'mode' => 'payment',
        // 'success_url' => route('checkout.success', [], true),
        // 'cancel_url' => route('checkout.cancel', [], true),
        // ]);

        return view('order.checkout', compact('product')); 
    }

    public function payment(Request $request) {
        // Create a one-time charge using Laravel Cashier
        try {
            $email = "am.naga6@gmail.com";
            $amount = $request->input("amount");
            // Set your Stripe API key
            Stripe::setApiKey(env("STRIPE_SECRETE_KEY"));
            $guest = Guest::whereEmail($email)->first();
            if(!$guest){
                // Retrieve the customer object from Stripe
                $customer = Customer::create([
                    'source' => $request->post("stripe_token"), // Replace with your actual token
                    'email' => $email, // The customer's email
                ]);
                if($customer->id){
                    $guest = Guest::create([
                        'stripe_customer_id' => $customer->id, // Store the Stripe customer ID
                        'email' => $email,         // Store the guest's email
                    ]);
                }
            }
            if($guest){
                // Create a charge for the guest
                $result = Charge::create([
                    'amount' => $amount * 100, // Replace with the amount in cents
                    'currency' => 'inr',
                    'customer' => $guest->stripe_customer_id,
                ]);
                if($result && $result->id && $result->status == "succeeded"){
                    $guest = Guest::create([
                        'session_id' => $result->id,
                        'status' => $result->status,
                        'guest_id' => $result->$guest->id,
                        'total_price' => $amount,

                    ]);
                } else {
                    return $result->status;
                }
            }
            // Handle successful payment and any additional logic here.
            return redirect('/success')->with('message', 'Payment successful');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
