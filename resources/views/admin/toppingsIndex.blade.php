@extends ('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Menu <a href="/manage/toppings/add" class="btn btn-primary pull-right">Add</a></div>

                <div class="panel-body">
                    @foreach ($toppings as $topping)
                        <div class="topping">
                            <p href="#">{{ $topping->name }} <strong>{{ $topping->price }}</strong></p>
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
