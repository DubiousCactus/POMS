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
							<a data-isPizza="{{ $item->isPizza() }}" data-id="{{ $item->id }}" class="add-basket btn btn-primary" href="#">Add to basket</a>
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
	<script src="{{ mix('js/home.js') }}"></script>
@stop

