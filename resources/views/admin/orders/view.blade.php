@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header lead">{{ __('lang.navigation_admin_view_title', ['orderId' => $orderId]) }}</div>

                    <div class="card-body">
                        <div class="lead">
                            Client
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-secondary">
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Courriel</th>
                                    <th scope="col">Pourcentage déduction</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ $client->phone_number }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->discount_from_retail }} %</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="lead">
                            Détails
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                @forelse($categories as $category)
                                    <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">{{ $category['name'] }} ({{ $category['price'] }} $)</th>
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
                                        <tr>
                                            <td>{{ $category_item['name'] }}</td>
                                            <td>{{ $category_item['sku'] }}</td>
                                            <td>{{ $order_item->getQuantity()}}</td>
                                        </tr>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
