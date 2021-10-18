@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert {{ session('alert-class', 'alert-success') }}" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <div class="table-responsive">
        <form method="POST" action="{{ route('admin.clients.update.submit', ['clientId' => $client->id]) }}">

            {{ csrf_field() }}

            @include('admin/clients/partials/client_form')
        </form>
    </div>
@endsection
