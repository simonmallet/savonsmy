@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header lead">{{ __('lang.navigation_dashboard_title') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('lang.welcome_message', ['user' => Auth::user()->name]) }}

                        @cannot(\App\Models\User::PERMISSION_FILL_PURCHASE_ORDER)
                            <div>
                                Votre compte n'a pas encore été activé par l'administrateur de ce site. Si la situation perdure, svp écrire à <a href="mailto:{{ config('contact.email') }}?subject=Activation compte partenaire">{{ config('contact.email') }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
