@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header lead">{{ __('lang.navigation_dashboard_title') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
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
                                        <td><a href="#">{{ __('lang.order_status_'.$item['status']) }}</a></td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['updated_at'] }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-primary bi bi-eye" role="button" href="{{ route('admin.order.view.index', $item['id']) }}"></a>
                                            <button title="Télécharger" class="btn btn-primary bi bi-download"></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Aucune commande est enregistrée dans le système</td>
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
                                    <th scope="col">Nom</th>
                                    <th scope="col">Client</th>
                                    <th scope="col" class="text-center">Courriel validé</th>
                                    <th scope="col" class="text-center">Partenaire approuvé</th>
                                    <th scope="col">Dernière connection</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['client_name'] }}</td>
                                        <td class="text-center">{{ $user['email_verified'] ? 'Oui' : 'Non' }}</td>
                                        <td class="text-center">{{ $user['partner_approved'] ? 'Oui' : 'Non' }}</td>
                                        <td>{{ $user['last_logon'] }}</td>
                                        <td class="text-center">
                                            @if($user['partner_approved'])
                                                <button class="btn btn-primary">Déapprouver</button>
                                            @else
                                                <button class="btn btn-primary">Approuver</button>
                                            @endif
                                            <button class="btn btn-primary">Modifier</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Aucun utilisateur est enregistré dans le système</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
