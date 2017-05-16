@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ mix("css/basket.css") }}">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Basket</div>
                <div class="panel-body">
					<div class="row">
                        <div class="total">
							Total: {{ Cart::total() }} Kr.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <h2 class="basket-header">Products</h2>
                        </div>
                        <div class="col-md-3">
								<h2 class="basket-header">Price</h2>
                        </div>
                        <div class="col-md-2">
                            <h2 class="basket-header">Quantity</h2>
                        </div>
                    </div>
                    <hr class="delimiter">
            		@foreach(Cart::all() as $cartItem)
                        <div class="row product">
                            <div class="col-md-7">
                                <div class="col-md-8 item-details">
									<p>
										<a id="remove" href="/basket/{{ $cartItem->getHash() }}" data-method="DELETE" data-token="{{ csrf_token() }}">
											<span class="glyphicon glyphicon-trash"></span>
										</a>
										{{ $cartItem->getItem()->name }}
										@if ($cartItem->isPizza())
											(<strong>{{ $cartItem->getSize()->name ?? '' }}</strong>)
											
											@if ($cartItem->getToppings())
												<br><em>
												@foreach ($cartItem->getToppings() as $topping)
													@if ($loop->first)
														+ {{ $topping->name }}
													@else
														, {{ $topping->name }}
													@endif
												@endforeach
												</em>
											@endif
										@endif
									</p><br>
                                </div>
                            </div>
                            <div class="col-md-3">
								{{ $cartItem->getItem()->price * $cartItem->getQuantity() }} Kr.
                            </div>
							<input class="changeQuantity" type="number" value="{{ $cartItem->getQuantity() }}" data-hash="{{ $cartItem->getHash() }}" data-token="{{ csrf_token() }}">
                        </div>
            		@endforeach
					@if(count(Cart::all()) > 0)
                        <a href="#" class="btn btn-primary" role="button" disabled>Purchase</a>
                    @endif
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

