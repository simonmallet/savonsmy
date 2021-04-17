@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <div class="d-grid d-md-flex justify-content-md-between">
                            <div class="align-self-center lead">{{ __('lang.purchase_order_add_main_title') }}</div>
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

                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            @foreach($items as $item)
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">{{ $item['name'] }} ({{ $item['price'] }} $)</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Particularites</th>
                                        <th scope="col" colspan="2">Quantite</th>
                                        <th scope="col">&nbsp;</th>
                                    </tr>
                                </thead>
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
                                            <td><input type="text" id="variant_qty_{{ $variant['id'] }}" name="variant_qty_{{ $variant['id'] }}" placeholder="0" onkeyup="testAlert({{ $variant['id'] }})"></td>
                                            <td>x @displayAmount($item['price'] * (100 - $user['discount_from_retail_price']) / 100) <input type="hidden" id="variant_user_price_{{ $variant['id'] }}" value="{{ $item['price'] * (100 - $user['discount_from_retail_price']) / 100 }}"></td>
                                            <td><span id="variant_total_{{ $variant['id'] }}">0,00 $ CA</span></td>
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
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <input class="btn btn-primary mr-2" type="submit" value="{{ __('lang.generic_send_button') }}">
                            <a class="btn btn-secondary" href="{{ route('purchase_orders.index') }}" role="button">{{ __('lang.generic_cancel_button') }}</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_custom')
    <script>
        function testAlert(variantId)
        {
            let qty = $('#variant_qty_' + variantId).val();
            let variantPrice = $('#variant_user_price_' + variantId).val();

            let formatter = new Intl.NumberFormat('fr-CA', {
                style: 'currency',
                currency: 'CAD',

                // These options are needed to round to whole numbers if that's what you want.
                //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
            });

            $('#variant_total_' + variantId).text(formatter.format(qty * variantPrice));
        }
    </script>
@endsection
