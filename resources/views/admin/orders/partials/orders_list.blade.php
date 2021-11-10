<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-secondary">
        <tr>
            <th scope="col">Numéro de commande</th>
            <th scope="col">Client</th>
            <th scope="col">Nombre d'articles</th>
            <th scope="col">Status</th>
            <th scope="col">Envoyé le</th>
            <th scope="col">Dernière mise à jour</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($purchaseOrders as $item)
            <tr>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item->client->name}}</td>
                <td>{{ $item->totalItemsWithQuantities }}</td>
                <td nowrap><a href="{{ route('admin.order.view.status', $item['id']) }}">{{ __('lang.order_status_'.$item['status']) }}</a></td>
                <td>{{ $item['created_at'] }}</td>
                <td>{{ $item['updated_at'] }}</td>
                <td class="text-center" nowrap>
                    <a class="btn btn-primary bi bi-eye" role="button" href="{{ route('admin.order.view.index', $item['id']) }}"></a>
                    <a class="btn btn-primary bi bi-download" role="button" href="{{ route('admin.order.download', $item['id']) }}"></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Aucune commande est enregistrée dans le système</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
