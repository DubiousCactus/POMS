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
                        <div class="row">
                            <div class="col-md-7">
								<p>
									<a id="remove" href="/basket/{{ $cartItem->getHash() }}" data-method="DELETE" data-token="{{ csrf_token() }}">
										<span class="glyphicon glyphicon-trash"></span>
									</a>
									{{ $cartItem->getItem()->name }}
									@if ($cartItem->isPizza())
										(<strong>{{ $cartItem->getSize()->name }} size</strong>)
										
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
                            <div class="col-md-3">
								{{ $cartItem->getTotalPrice() }} Kr.
                            </div>
							<input class="changeQuantity" type="number" min=1 value="{{ $cartItem->getQuantity() }}" data-hash="{{ $cartItem->getHash() }}" data-token="{{ csrf_token() }}">
                        </div>
            		@endforeach
					@if(count(Cart::all()) > 0)
                        <a href="/basket/delivery" class="btn btn-primary" role="button">Purchase</a>
						<div class="total">
							Total: {{ Cart::total() }} Kr.
                        </div>
                    @endif
                </div>
				 @if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
	<script src="{{ mix('js/basket.js') }}"></script>
@stop

