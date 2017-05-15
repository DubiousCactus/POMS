@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Menu</div>
                <div class="panel-body">
                    @foreach($items as $item)
                        <div class="item">
                            <p>{{ $item->name }} <strong>{{ $item->price }}</strong></p>
                            <em>{{ $item->ingredients }}</em>
                            <br>
							<form method="POST" action="/basket">
								{{ csrf_field() }}
								<input type="hidden" name="itemId" value="{{ $item->id }}">
								<input type="hidden" name="qty" value=1>
								<button type="submit" class="btn btn-primary">Add to basket</button>
							</form>
                        </div>
                        <br><br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if(session()->has('success') && session('success'))
	@section('scripts')
		swal("Added to basket !");
	@endsection
@endif
