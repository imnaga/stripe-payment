<!DOCTYPE html>
<html>
<head>
    <title>Checkout Page</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Checkout</h1>

    <h1>Checkout</h1>
    <p>Selected Product:</p>
    @if(isset($product))
    <p><strong>{{ $product->name }}</strong></p>
    <p>Price: ${{ $product->price }}</p>
    <p>Description: {{ $product->description }}</p>
    @endif


    <form action="process-payment'" method="post" id="payment-form">
        @csrf

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
</body>
</html>

