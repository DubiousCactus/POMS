@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ mix("css/delivery.css") }}">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Choose a delivery mean</div>
                <div class="panel-body">
                	<form action="/basket/delivery" method="POST" class="form-horizontal" role="form">
                		{{ csrf_field() }}

						<input type="radio" name="choice" value="pick-up" checked>&nbsp;Pick up at restaurant
						<br><hr>
						<input type="radio" name="choice" value="delivery">&nbsp;Delivery
						<br><br>
						<div id="delivery-form" class="disabled">
							@if (Auth::user()->addresses->count() > 0)
								<p>Use existing address:<p>
								<ul>
								@foreach(Auth::user()->addresses as $address)
									<li>{{ $address->getCanonicalForm() }}</li>
								@endforeach
								<ul>
							@else
								<p>You don't have any registered address.</p>
							@endif
							<br><br>
							<p>Add a new address:</p>
							
							<div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
								<label for="street" class="col-md-4 control-label">Street</label>

								<div class="col-md-6">
									<input id="street" type="text" class="form-control" name="street" value="{{ old('street') }}" autofocus disabled>

									@if ($errors->has('street'))
										<span class="help-block">
											<strong>{{ $errors->first('street') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
								<label for="city" class="col-md-4 control-label">City</label>

								<div class="col-md-6">
									<input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" autofocus disabled>

									@if ($errors->has('city'))
										<span class="help-block">
											<strong>{{ $errors->first('city') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
								<label for="zip" class="col-md-4 control-label">Zip</label>

								<div class="col-md-6">
									<input id="zip" type="text" pattern="[0-9]{4}" class="form-control" name="zip" value="{{ old('zip') }}" autofocus disabled>

									@if ($errors->has('zip'))
										<span class="help-block">
											<strong>{{ $errors->first('zip') }}</strong>
										</span>
									@endif
								</div>
							</div>
						</div>
						<br><hr>
						<div class="form-group">
							<div class="col-md-2 col-md-offset-10">
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</div>
                	</form>
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
@endsection

@section('scripts')
	<script src="{{ mix('js/delivery.js') }}"></script>
@stop

