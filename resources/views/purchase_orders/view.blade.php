@extends('layouts.app')

@section('content')
<div class="table-responsive">
    @include('purchase_orders/helpers/go_back_button')
    <table class="table table-striped table-hover">
        @forelse($categories as $category)
            <thead class="table-secondary">
            <tr>
                <th scope="col">{{ $category['name'] }} ({{ App\Domain\Helpers\FormattingHelper::formatPrice($category['price']) }} $)</th>
                <th scope="col">Description</th>
                <th scope="col">Quantite</th>
                <th scope="col">Prix à l'unité</th>
                <th scope="col">Prix total</th>
            </tr>
            </thead>
            @forelse($order_items as $order_item)
                @php
                    $category_item = $category->items->filter(function ($categoryItem) use ($order_item) {
                        return $categoryItem->id === $order_item->getCategoryItemId();
                    })->first();
                @endphp
                @if($category_item)
                    <tr>
                        <td>{{ $category_item['name'] }}</td>
                        <td>{{ $category_item['description'] }}</td>
                        <td>{{ $order_item->getQuantity() }}</td>
                        <td>@displayAmount($category['price'] * (100 - $user['discount_from_retail_price']) / 100)</td>
                        <td>@displayAmount(App\Domain\Helpers\FormattingHelper::formatPrice($category['price'] * (100 - $user['discount_from_retail_price']) / 100) * $order_item->getQuantity()) $ CA</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="3">Aucun variant pour cette categorie</td>
                </tr>
            @endforelse
        @empty
            <tr><td>Aucun element trouve</td></tr>
        @endforelse
    </table>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <div>Sous total</div>
        <div style="width: 120px; text-align: right;"><span id="sub-total">@displayAmount($order_sub_total) $ CA</span></div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <div>TPS</div>
        <div style="width: 120px; text-align: right;"><span id="tps">@displayAmount($order_sub_total * 0.05) $ CA</span></div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <div>TVQ</div>
        <div style="width: 120px; text-align: right;"><span id="tvq">@displayAmount($order_sub_total * 0.09975) $ CA</span></div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <div class="font-weight-bold">Grand Total</div>
        <div class="font-weight-bold" style="width: 120px; text-align: right;"><span
                    id="grand-total">@displayAmount($order_sub_total + ($order_sub_total * 0.05) + ($order_sub_total * 0.09975)) $ CA</span></div>
    </div>
</div>
@endsection
