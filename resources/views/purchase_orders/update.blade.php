@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('purchase_orders.update.submit', ['orderId' => $order_id]) }}">

            {{ csrf_field() }}

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    @forelse($categories as $category)
                        <thead class="table-secondary">
                        <tr>
                            <th scope="col" nowrap>{{ $category['name'] }} ({{ App\Domain\Helpers\FormattingHelper::formatPrice($category['price']) }} $)</th>
                            <th scope="col">Description</th>
                            <th scope="col" colspan="2">Quantite</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                        </thead>
                        @forelse($category->items as $item)
                            @php
                                $orderItem = $order_items->filter(function (\App\Domain\DTO\OrderItemDTO $orderItemDTO) use ($item) {
                                    return $item->id === $orderItemDTO->getCategoryItemId();
                                })->first();
                            @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['description'] }}</td>
                                @if (isset($item['enabled']) && $item['enabled'])
                                    <td><input type="number" min="0" id="variant_qty_{{ $item['id'] }}"
                                               name="{{ $item['id'] }}" placeholder="0"
                                               value="{{ $orderItem ? $orderItem->getQuantity() : 0 }}"
                                               onkeyup="updateItemPrice({{ $item['id'] }})"
                                               onchange="updateItemPrice({{ $item['id'] }})"></td>
                                    <td nowrap>x @displayAmount($category['price'] * (100 -
                                        $user['discount_from_retail_price']) / 100) <input type="hidden"
                                                                                           id="variant_user_price_{{ $item['id'] }}"
                                                                                           value="@displayAmount($category['price'] * (100 - $user['discount_from_retail_price']) / 100)">
                                    </td>
                                    <td nowrap><span id="variant_total_{{ $item['id'] }}">0,00 $ CA</span></td>
                                @else
                                    <td>-</td>
                                    <td>N/D</td>
                                    <td>-</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Aucun variant pour cette categorie</td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td>Aucun element trouve</td>
                        </tr>
                    @endforelse
                </table>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div>Sous total</div>
                <div style="width: 120px; text-align: right;"><span id="sub-total">0.00 $ CA</span></div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div>TPS</div>
                <div style="width: 120px; text-align: right;"><span id="tps">0.00 $ CA</span></div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div>TVQ</div>
                <div style="width: 120px; text-align: right;"><span id="tvq">0.00 $ CA</span></div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="font-weight-bold">Grand Total</div>
                <div class="font-weight-bold" style="width: 120px; text-align: right;"><span
                            id="grand-total">0.00 $ CA</span></div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                <input class="btn btn-primary mr-2" type="submit" value="{{ __('lang.generic_send_button') }}">
                <a class="btn btn-secondary" href="{{ route('purchase_orders.index') }}"
                   role="button">{{ __('lang.generic_cancel_button') }}</a>
            </div>
        </form>
    </div>
@endsection

@section('js_custom')
    <script>
        let subTotalItems = [];

        let formatter = new Intl.NumberFormat('fr-CA', {
            style: 'currency',
            currency: 'CAD',

            // These options are needed to round to whole numbers if that's what you want.
            minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
            maximumFractionDigits: 2, // (causes 2500.99 to be printed as $2,501)
        });

        document.addEventListener("DOMContentLoaded", function () {
            @php
                foreach($categories as $category) {
                    foreach ($category->items as $item) {
                        if ($item->enabled) {
                            echo "updateItemPrice({$item->id});";
                        }
                    }
                }
            @endphp
        });

        function updateItemPrice(variantId) {
            let qty = $('#variant_qty_' + variantId).val();
            let variantPrice = $('#variant_user_price_' + variantId).val();

            let totalForItem = qty * variantPrice;
            if (totalForItem < 0) return;
            $('#variant_total_' + variantId).text(formatter.format(totalForItem));

            updateSubTotal(variantId, totalForItem);
        }

        function updateSubTotal(variantId, total) {
            let subTotal = 0;
            subTotalItems[variantId] = total;

            subTotalItems.forEach((itemTotal) => {
                subTotal += itemTotal;
            });

            let tps = subTotal * 0.05;
            let tvq = subTotal * 0.09975;
            $('#sub-total').text(formatter.format(subTotal));
            $('#tps').text(formatter.format(tps))
            $('#tvq').text(formatter.format(tvq))
            $('#grand-total').text(formatter.format(subTotal + tps + tvq))
        }
    </script>
@endsection
