@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <div class="d-grid d-md-flex justify-content-md-between">
                            <div class="align-self-center">{{ __('lang.purchase_order_add_main_title') }}</div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('purchase_orders.add.submit') }}">

                        {{ csrf_field() }}

                        <table class="table table-striped table-hover">
                            @foreach($items as $item)
                                <tr>
                                    <td><strong> {{ $item['name'] }} ({{ $item['price'] }} $) </strong></td>
                                    <td>Description</td>
                                    <td>Particularites</td>
                                    <td colspan="2">Quantite</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @foreach($item['variants'] as $variant)
                                    <tr>
                                        <td>{{ $variant['name'] }}</td>
                                        <td>{{ $variant['description'] }}</td>
                                        <td>
                                            @if (isset($variant['flags']['quality_essential_oils']) && $variant['flags']['quality_essential_oils'])
                                                <div class="custom-icon-essential-oils"></div>
                                            @endif
                                            @if (isset($variant['flags']['no_perfume_no_oils']) && $variant['flags']['no_perfume_no_oils'])
                                                <div class="custom-icon-no-perfume"></div>
                                            @endif
                                        </td>
                                        @if (isset($variant['availability']) && $variant['availability'])
                                            <td><input type="text" name="qty" placeholder="0"></td>
                                            <td>x @displayAmount($item['price'] * 70 / 100)</td>
                                            <td>0.00 $</td>
                                        @else
                                            <td>-</td>
                                            <td>N/D</td>
                                            <td>-</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <input class="btn btn-primary" type="submit" value="{{ __('lang.generic_send_button') }}">
                            <a class="btn btn-secondary" href="{{ route('purchase_orders.index') }}" role="button">{{ __('lang.generic_cancel_button') }}</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
