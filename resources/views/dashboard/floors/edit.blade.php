@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title pt-2">Edit Floor | {{ $floor->name }}</h3>

                <div class="card-tools">
                    <a href="{{ route('dashboard.floors.index') }}" type="button" class="btn btn-default bg-primary">
                        <i class="fa fa-backspace"></i> Back
                    </a>
                </div>
            </div>

            <form class="p-3" action="{{ route('dashboard.floors.update', $floor) }}" method="post"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <!-- Name Input -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-at"></i> </span>
                        </div>
                        <input type="text" name='name' class="form-control" placeholder="name of Floor :" value="{{ old('name') ?? $floor->name }}">
                    </div>
                    @error('name') <span class="red"> {{ $message }} </span> @enderror
                </div>

                <!-- Number Input -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input type="number" name='number' class="form-control" placeholder="Number Or Floor : " value="{{ old('number') ?? $floor->number }}">
                    </div>
                    @error('number') <span class="red"> {{ $message }} </span> @enderror
                </div>

                <button type="submit" class="btn btn-primary d-block " style="width: 100%">Save</button>

            </form>
            <!-- /.form-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

@endsection
