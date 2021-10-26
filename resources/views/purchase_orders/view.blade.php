@extends('layouts.app')

@section('content')
<div class="table-responsive">
    @include('purchase_orders/helpers/go_back_button')
    <table class="table table-striped table-hover">
        @forelse($categories as $category)
            <thead class="table-secondary">
            <tr>
                <th scope="col">{{ $category['name'] }} ({{ App\Domain\Helpers\FormattingHelper::formatPrice($category['price']) }} $)</th>
                <th scope="col">SKU</th>
                <th scope="col" colspan="2">Quantite</th>
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
                        <td>{{ $category_item['sku'] }}</td>
                        <td>{{ $order_item->getQuantity()}}</td>
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
</div>
@endsection
