@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert {{ session('alert-class', 'alert-success') }}" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="table-responsive">
        <form method="POST" action="{{ route('admin.clients.add.submit') }}">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">Nom de la compagnie</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Joe Inc">
            </div>

            <div class="form-group">
                <label for="address">Adresse complète</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="123 Main ST, New York, New York, 10044">
            </div>

            <div class="form-group">
                <label for="phone_number">Telephone</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="514-555-5555">
            </div>

            <div class="form-group">
                <label for="email">Adresse courriel</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
            </div>

            <div class="form-group">
                <label for="discount_from_retail">Rabais accordé en pourcentage</label>
                <input type="text" class="form-control" id="discount_from_retail" name="discount_from_retail" placeholder="30">
            </div>


            <input class="btn btn-primary" type="submit" value="{{ __('lang.generic_send_button') }}">
        </form>
    </div>
@endsection
