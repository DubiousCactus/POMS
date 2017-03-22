@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin panel</div>

				<div class="panel-body">
					<a href="/manage/items" type="button" class="btn btn-primary">Menu</a>
					<a href="/manage/toppings" type="button" class="btn btn-primary">Toppings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

