<!DOCTYPE html>
<html>
<head>
    <title>Checkout Page</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
        /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
        .StripeElement {
            background-color: white;
            height: 40px;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
</head>
<body>
    <h1>Checkout</h1>

    <p>Selected Product:</p>
    @if(isset($product))
    <p><strong>{{ $product->name }}</strong></p>
    <p>Price: ${{ $product->price }}</p>
    <p>Description: {{ $product->description }}</p>
    
    <form action="/payment" method="post" name="payment_form" id="payment_form">
        @csrf
        <input type="hidden" name="stripe_token" />
        <div class="form-group">
            <label for="card-element">Credit or debit card</label>
            <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
            </div>
            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
        </div>
       
        <button type="submit">Pay Now</button> 
    </form>

    <script src="{{ asset('js/stripe.js') }}"></script>

    @endif
</body>
</html>

