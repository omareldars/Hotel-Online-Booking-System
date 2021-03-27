@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title pt-2"> Users : {{ $count }} </h3>

        @if (auth()->user()->hasRole('admin'))
        <div class="card-tools">
            <a href="{{ route('dashboard.users.create') }}" type="button" class="btn btn-primary">
                <i class="fa fa-plus"></i> Create New User
            </a>
        </div>
        @endif
    </div>

    <div class="card-body table-responsive p-0">
        {!! $dataTable->table() !!}
    </div>

</div>
<!-- /.card -->

@endsection

@push('scripts')
    {{  $dataTable->scripts()  }}
@endpush
