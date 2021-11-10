@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert {{ session('alert-class', 'alert-success') }}" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @include('admin.orders.partials.orders_list')
@endsection
