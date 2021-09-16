@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert {{ session('alert-class', 'alert-success') }}" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="lead font-weight-bold">
        Utilisateur {{ $user->name }}
    </div>

    <div class="table-responsive">
        <form method="POST" action="{{ route('admin.user.assign_client.submit', ['userId' => $user['id']]) }}">

            {{ csrf_field() }}

            <div class="form-text">Client
                actuel: {{ count($user->client) > 0 ? $user->client[0]->name : 'Aucun' }}</div>
            <div>Choisir nouveau client
                <select class="form-control" style="display: inline; width: 150px;" name="client" id="client">
                    @foreach($clients as $client )
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <input class="btn btn-primary" type="submit" value="{{ __('lang.generic_send_button') }}">
        </form>
    </div>
@endsection
