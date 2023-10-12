<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sumanas Products</title>
    </head>
    <body class="antialiased">
        <div style="display: flex; gap: 1rem">
            @foreach($products as $product)
                    <div class="flex: 1">
                        <img src="{{$product->image}}" style="max-width:100%">
                        <h5>{{$product->name}}</h5>
                        <p>{{$product->price}}</p>
                        <p>
                            <form action="{{route('checkout')}}" method="POST" >
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}" />
                                <button type="submit">Buy Now</button>
                            </form>
                        </p>
                    </div>
            @endforeach
        </div>
    </body>
</html>
