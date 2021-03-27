@extends('layouts.ui')

@section('content')
<div>
    @include('includes.alerts.message')
</div><!-- /.col -->
<div class="card">
    <div class="card-header"> Unreserved Rooms : {{ $count }} </div>

    <div class="card-body">
        <div class="card-body table-responsive p-0">
            {!! $dataTable->table() !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{  $dataTable->scripts()  }}
@endpush
