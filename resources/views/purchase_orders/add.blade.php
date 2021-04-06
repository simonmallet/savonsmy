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

                        <table class="table table-striped table-hover">
                            @foreach($items as $item)
                                <tr>
                                    <td><strong> {{ $item['name'] }} ({{ $item['price'] }} $) </strong></td>
                                    <td>Description</td>
                                    <td>Particularites</td>
                                    <td colspan="2">Quantite</td>
                                    <td>Total</td>
                                </tr>
                                @foreach($item['variants'] as $variant)
                                    <tr>
                                        <td>{{ $variant['name'] }}</td>
                                        <td>{{ $variant['description'] }}</td>
                                        <td>Particularites</td>
                                        @if (isset($variant['availability']) && $variant['availability'])
                                            <td><input type="text" name="qty" placeholder="0"></td>
                                            <td>x 4.20</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
