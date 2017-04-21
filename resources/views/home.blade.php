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
                            <p href="#">{{ $item->name }} <strong>{{ $item->price }}</strong></p>
                            <em>{{ $item->ingredients }}</em>
                            <br>
							<a href="#" class="btn btn-primary {{ $item->isPizza() ? 'pizza' : '' }}">Add to basket</a>
                        </div>
                        <br><br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
	$('.pizza').click(function(e) {
		e.preventDefault();
		swal("Hello world!");
	});
@endsection
