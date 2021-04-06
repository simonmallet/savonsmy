@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <div class="d-grid d-md-flex justify-content-md-between">
                            <div class="align-self-center">{{ __('lang.navigation_purchase_order_title') }}</div>
                            <a class="btn btn-primary" href="{{ route('purchase_orders.add.index') }}" role="button">{{ __('lang.purchase_order_add_new_button') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Coucou...

                        @cannot(\App\Models\User::PERMISSION_FILL_PURCHASE_ORDER)
                            <div>
                                Votre compte n'a pas encore été activé par l'administrateur de ce site. Si le problème perdure, svp écrire à <a href="mailto:{{ config('contact.email') }}?subject=Activation compte partenaire">{{ config('contact.email') }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
