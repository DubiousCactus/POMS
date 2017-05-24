@extends ('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Toppings <a href="/manage/toppings/add" class="btn btn-primary pull-right">Add</a></div>

                <div class="panel-body">
                    @foreach ($toppings as $topping)
                        <div class="topping">
                            <p href="#">{{ $topping->name }} <strong>{{ $topping->price }}</strong></p>
                            <br>
							<a href="/manage/toppings/{{ $topping->id }}/edit" class="btn btn-primary">Edit</a>
							<a href="{{ route('topping.destroy', ['topping' => $topping]) }}" data-method="DELETE" data-confirm="Are you sure?" data-token="{{ csrf_token() }}" class="btn btn-primary">Delete</a>
                        </div>
                        <br><br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
