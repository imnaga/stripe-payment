<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::all();
        return view('product.index', compact('products')); 
    }

    public function checkout(Request $request){
        $postId = $request->post("product_id");
        $product = Product::find($postId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRETE_KEY'));
        $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => [[
            'price_data' => [
            'currency' => 'inr',
            'product_data' => [
                'name' => $product->name,
            ],
            'unit_amount' => round($product->price * 100),
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('checkout.success', [], true),
        'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return redirect($checkout_session->url);
    }
}
