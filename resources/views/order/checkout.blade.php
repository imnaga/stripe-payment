@extends('layouts.default')
@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/stripe.css') }}">
<script src="https://js.stripe.com/v3/"></script>
@if(isset($product))
<div class="cart-section">
  
  <div class="table-heading">
    <h2 class="cart-product">Product</h2>
    <h2 class="cart-price">Price</h2>
    <h2 class="cart-quantity">Quantity</h2>
    <h2 class="cart-total">Total</h2>
  </div>
  
  <div class="table-content">
    <div class="cart-product">  
      <div class="cart-image-box">
        <div class="cart-images" id="image-3"></div>
      </div>
      <h2 class="cart-item">{{ $product->name }}</h2>
      <p class="cart-description">
        I am using Stripe as my payment processor on BigCommerce. 
        It works perfectly. The problem is that my site theme has a black background.
      </p>
    </div>
    <div class="cart-price">
      <h3 class="price">&#8377;{{ $product->price }}</h3>
    </div>
    <div class="cart-quantity">
      <input type="text" name="cart-1-quantity" id="cart-1-quantity" value="1">
    </div>
    <div class="cart-total">
      <h3 class="price">&#8377;{{ $product->price }}</h3>
      <button type="button" class="remove" name="remove-3" id="remove-3">x</button>
    </div>
  </div>
  <div class="table-heading">
    <div>
        <h1>Payment</h2>
    </div>
</div>

</div>
  <div>
    <form action="/payment" method="post" id="payment-form">
        @csrf
        <input type="hidden" name="stripe_token" id="stripe_token" />
        <div class="form-group">
            <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
            </div>
            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
        </div>
        <button type="submit">Pay Now</button> 
    </form>
    <script src="{{ asset('js/stripe.js') }}"></script>
  </div>


        
@endif
@stop