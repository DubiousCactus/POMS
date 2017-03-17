@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Menu <a href="/manage/items/add" class="btn btn-primary pull-right">Add</a></div>

                <div class="panel-body">
                    @foreach($items as $item)
                        <div class="item">
                            <p href="#">{{ $item->name }} <strong>{{ $item->price }}</strong></p>
                            <em>{{ $item->ingredients }}</em>
                            <br>
                            <button>Edit</button>
                            <button>Remove</button>
                        </div>
                        <br><br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
