@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title pt-2"> Receptionist : {{ $count }} </h3>

       
        <div class="card-tools">
            <a href="{{ route('dashboard.receptionists.create') }}" type="button" class="btn btn-default bg-primary">
                <i class="fa fa-plus"></i> Create New Receptionist
            </a>
        </div>
        
    </div>

    <div class="card-body table-responsive p-0">
        {!! $dataTable->table() !!}
    </div>

    <!-- /.card-body -->
</div>
<!-- /.card -->

@endsection

@push('scripts')
    {{  $dataTable->scripts()  }}
@endpush
