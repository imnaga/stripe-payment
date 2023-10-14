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
            $email = "m.nagarajanbtech@gmail.com";
            $amount = 10.00;
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
                if($result && $result->status){
                    /* 
                    sample success response need to work based on this response
                    {
                    "id": "ch_1O1DrUHWljDTRHuTQy1LWDL6",
                    "object": "charge",
                    "amount": 1000,
                    "amount_captured": 1000,
                    "amount_refunded": 0,
                    "application": null,
                    "application_fee": null,
                    "application_fee_amount": null,
                    "balance_transaction": "txn_1O1DrVHWljDTRHuT0VdqgETs",
                    "billing_details": {
                        "address": {
                            "city": null,
                            "country": null,
                            "line1": null,
                            "line2": null,
                            "postal_code": "42424",
                            "state": null
                        },
                        "email": null,
                        "name": null,
                        "phone": null
                    },
                    "calculated_statement_descriptor": "Stripe",
                    "captured": true,
                    "created": 1697313060,
                    "currency": "inr",
                    "customer": "cus_OorTpGZejbFmkw",
                    "description": null,
                    "destination": null,
                    "dispute": null,
                    "disputed": false,
                    "failure_balance_transaction": null,
                    "failure_code": null,
                    "failure_message": null,
                    "fraud_details": [],
                    "invoice": null,
                    "livemode": false,
                    "metadata": [],
                    "on_behalf_of": null,
                    "order": null,
                    "outcome": {
                        "network_status": "approved_by_network",
                        "reason": null,
                        "risk_level": "normal",
                        "risk_score": 12,
                        "seller_message": "Payment complete.",
                        "type": "authorized"
                    },
                    "paid": true,
                    "payment_intent": null,
                    "payment_method": "card_1O1DknHWljDTRHuTevEvNAjx",
                    "payment_method_details": {
                        "card": {
                            "amount_authorized": 1000,
                            "brand": "visa",
                            "checks": {
                                "address_line1_check": null,
                                "address_postal_code_check": "pass",
                                "cvc_check": "pass"
                            },
                            "country": "US",
                            "exp_month": 4,
                            "exp_year": 2024,
                            "extended_authorization": {
                                "status": "disabled"
                            },
                            "fingerprint": "KNUus7tjbMkLplqW",
                            "funding": "credit",
                            "incremental_authorization": {
                                "status": "unavailable"
                            },
                            "installments": null,
                            "last4": "4242",
                            "mandate": null,
                            "multicapture": {
                                "status": "unavailable"
                            },
                            "network": "visa",
                            "network_token": null,
                            "overcapture": {
                                "maximum_amount_capturable": 1000,
                                "status": "unavailable"
                            },
                            "three_d_secure": null,
                            "wallet": null
                        },
                        "type": "card"
                    },
                    "receipt_email": null,
                    "receipt_number": null,
                    "receipt_url": "https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xSUlaaEpIV2xqRFRSSHVUKKXiq6kGMgZIFymQif86LBbVQ3DBf2SU5C1DOZx3b0IlfG29LxjgfBi5q5KgH2G6k40DcGSXtdSI9YDt",
                    "refunded": false,
                    "refunds": {
                        "object": "list",
                        "data": [],
                        "has_more": false,
                        "total_count": 0,
                        "url": "\\/v1\\/charges\\/ch_1O1DrUHWljDTRHuTQy1LWDL6\\/refunds"
                    },
                    "review": null,
                    "shipping": null,
                    "source": {
                        "id": "card_1O1DknHWljDTRHuTevEvNAjx",
                        "object": "card",
                        "address_city": null,
                        "address_country": null,
                        "address_line1": null,
                        "address_line1_check": null,
                        "address_line2": null,
                        "address_state": null,
                        "address_zip": "42424",
                        "address_zip_check": "pass",
                        "brand": "Visa",
                        "country": "US",
                        "customer": "cus_OorTpGZejbFmkw",
                        "cvc_check": "pass",
                        "dynamic_last4": null,
                        "exp_month": 4,
                        "exp_year": 2024,
                        "fingerprint": "KNUus7tjbMkLplqW",
                        "funding": "credit",
                        "last4": "4242",
                        "metadata": [],
                        "name": null,
                        "tokenization_method": null,
                        "wallet": null
                    },
                    "source_transfer": null,
                    "statement_descriptor": null,
                    "statement_descriptor_suffix": null,
                    "status": "succeeded",
                    "transfer_data": null,
                    "transfer_group": null
                }

                    */
                    return "payment success";
                } else {
                    return $result->status;
                }
            }

            return $result;
            
                   
            return $customer;
            // $stripeCustomerId = \Stripe\Customer::retrieve($request->post("stripe_token"));
            // return $stripeCustomerId;


            return $request->post("stripe_token");
            // Use Cashier to create a one-time charge.
            Cashier::charge($amount, $request->post("stripe_token"));
            // Handle successful payment and any additional logic here.
            return redirect('/success')->with('message', 'Payment successful');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
