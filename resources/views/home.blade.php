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
                            <button>Add to basket</button>
                            <em>{{ $item->ingredients }}</em>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
