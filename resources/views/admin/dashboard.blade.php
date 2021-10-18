@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert {{ session('alert-class', 'alert-success') }}" role="alert">
            {{ session('status') }}
        </div>
    @endif

        <div class="lead">
            Dernières commandes
        </div>

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

    <div class="lead">
        Utilisateurs
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-secondary">
            <tr>
                <th scope="col">Nom du responsable</th>
                <th scope="col">Nom de la compagnie</th>
                <th scope="col">Courriel</th>
                <th scope="col">Client assigné</th>
                <th scope="col" class="text-center">Courriel validé</th>
                <th scope="col" class="text-center">Partenaire approuvé</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                @if(!$user->hasRole(\App\Models\User::ROLE_SUPER_ADMIN))
                <tr>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['company_name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ count($user->client) > 0 ? $user->client[0]->name : 'Aucun' }}</td>
                    <td class="text-center">{{ $user['email_verified_at'] ? 'Oui' : 'Non' }}</td>
                    <td class="text-center">{{ $user['partner_approved'] ? 'Oui' : 'Non' }}</td>
                    <td class="text-center">
                        @if(count($user->client) === 0)
                            <a class="btn btn-primary" role="button" href="{{ route('admin.user.assign_client.index', $user['id']) }}">Assigner</a>
                        @else
                            @if($user['partner_approved'])
                                <a class="btn btn-primary" role="button" href="{{ route('admin.user.suspend.submit', $user['id']) }}">Suspendre</a>
                            @else
                                <a class="btn btn-primary" role="button" href="{{ route('admin.user.approve.submit', $user['id']) }}">Approuver</a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="4">Aucun utilisateur est enregistré dans le système</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
