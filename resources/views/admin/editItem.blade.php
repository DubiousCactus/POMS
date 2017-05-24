@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add item</div>
                <div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ route('item.update', ['item' => $item]) }}">
						{{ csrf_field() }}
						{{ method_field('PATCH') }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
								<input id="name" type="text" class="form-control" name="name" value="{{ $item->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ingredients') ? ' has-error' : '' }}">
                            <label for="ingredients" class="col-md-4 control-label">Ingredients</label>

                            <div class="col-md-6">
								<input id="ingredients" type="text" class="form-control" name="ingredients" value="{{ $item->ingredients }}" required>

                                @if ($errors->has('ingredients'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ingredients') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Price</label>

                            <div class="col-md-6">
								<input id="price" type="decimal" class="form-control" name="price" value={{ $item->price }} required>

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
