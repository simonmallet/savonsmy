@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <p>{{ __('lang.welcome_message', ['user' => Auth::user()->name]) }}</p>

            <p><a href="{{ route('purchase_orders.index') }}">Cliquer ici</a> pour accéder à la section Bons de commandes</p>

        @cannot(\App\Models\User::PERMISSION_FILL_PURCHASE_ORDER)
            <div>
                Votre compte n'a pas encore été activé par l'administrateur de ce site. Si la situation perdure, svp écrire à <a href="mailto:{{ config('contact.main_contact') }}?subject=Activation compte partenaire">{{ config('contact.main_contact') }}</a>
            </div>
        @endcan
    </div>
@endsection
