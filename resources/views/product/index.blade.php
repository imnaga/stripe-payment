@extends('layouts.default')
@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<div class="listing-section">
    @foreach($products as $product)
        <div class="product">
            <div class="image-box">
                <img src="{{$product->image}}" style="max-width:100%">
            </div>
            <div class="text-box">
                <h2 class="item">{{$product->name}}</h2>
                <h3 class="price">&#8377;{{$product->price}}</h3>
                <p class="description">A bag of delicious oranges!</p>
                <label for="item-1-quantity">Quantity:</label>
                <input type="text" name="item-1-quantity" id="item-1-quantity" value="1">
                <form action="{{route('checkout')}}" method="POST" >
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}" />
                    <button type="submit" >Buy Now</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@stop