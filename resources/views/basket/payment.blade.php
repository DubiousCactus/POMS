@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ mix("css/delivery.css") }}">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Payment</div>
                <div class="panel-body">
					@if (session('delivery.choice') == 'pick-up')
						<p>To be picked up at the restaurant.</p>
					@elseif (session('delivery.choice') == 'delivery')
						<p>Delivering at: {{ $address->getCanonicalForm() }}</p>
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
@endsection

@section('scripts')
	<script src="{{ mix('js/delivery.js') }}"></script>
@stop

