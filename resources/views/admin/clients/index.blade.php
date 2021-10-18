@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert {{ session('alert-class', 'alert-success') }}" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="lead mb-3">
        <a href="{{ route('admin.clients.add.index') }}" title="Ajouter un client" class="btn btn-primary">Ajouter un client</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-secondary">
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Adresse</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Courriel</th>
                <th scope="col">Rabais</th>
                <th scope="col">Actif</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ $client['name'] }}</td>
                    <td>{{ $client['address'] }}</td>
                    <td>{{ $client['phone_number'] }}</td>
                    <td>{{ $client['email'] }}</td>
                    <td>{{ $client['discount_from_retail'] }}%</td>
                    <td>{{ $client['active'] ? 'Oui' : 'Non' }}</td>
                    <td class="text-center" nowrap>
                        <a class="btn btn-primary bi bi-pencil" role="button" href="{{ route('admin.clients.update.index', $client['id']) }}"></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucun client est enregistré dans le système</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
