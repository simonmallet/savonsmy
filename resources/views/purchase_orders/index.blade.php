@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <div class="d-grid d-md-flex justify-content-md-between">
                            <div class="align-self-center lead">{{ __('lang.navigation_purchase_order_title') }}</div>
                            <a class="btn btn-primary" href="{{ route('purchase_orders.add.index') }}" role="button">{{ __('lang.purchase_order_add_new_button') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-secondary">
                                <tr>
                                    <th scope="col">Numéro de commande</th>
                                    <th scope="col">Nombre d'articles</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Envoyé le</th>
                                    <th scope="col">Dernière mise à jour</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                @forelse($historicalPurchaseOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->totalItemsWithQuantities }}</td>
                                        <td>{{ __('lang.order_status_'.$order->status) }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td class="text-center">
                                            @switch($order->status)
                                                @case(\App\Constants\OrderStatus::NOT_TREATED)
                                                    <a class="btn btn-primary" href="{{ route('purchase_orders.update.index', $order->id) }}" role="button">Modifier</a>
                                                    <form method="POST" style="display: inline-block;" action="{{ route('purchase_orders.delete.submit', $order->id) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}

                                                        <input type="submit" class="btn btn-danger delete-form" value="Supprimer">
                                                    </form>
                                                    @break
                                                @default
                                                    <button class="btn btn-primary">Voir</button>
                                            @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Aucune commande est enregistrée dans le système</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_custom')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('.delete-form').click(function(e){
                e.preventDefault() // Don't post the form, unless confirmed
                if (confirm('Êtes-vous certain de vouloir supprimer ce bon de commande?')) {
                    // Post the form
                    $(e.target).closest('form').submit() // Post the surrounding form
                }
            });
        });
    </script>
@endsection
