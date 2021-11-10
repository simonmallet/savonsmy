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

    @include('admin.orders.partials.orders_list')

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
