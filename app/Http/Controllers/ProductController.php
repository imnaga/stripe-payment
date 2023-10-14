<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Laravel\Cashier\Billable;

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
            return "test";
            $amount = 10.00;
            // Use Cashier to create a one-time charge.
            Cashier::charge($amount, $request->input('stripe_token'));
            // Handle successful payment and any additional logic here.
            return redirect('/success')->with('message', 'Payment successful');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
