@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header lead">Mise a jour du formulaire (v{{ $currentVersion }} => v{{ $currentVersion + 1 }})</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="table-responsive" id="categories-container">
                            @forelse($categories as $category)
                                <table class="table table-striped table-hover">
                                    <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">{{ $category['name'] }} (Prix {{ $category['price'] }})</th>
                                        <th scope="col">Quantite</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tablesimon">
                                    @forelse($category->items as $item)
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['description'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">Aucun item trouve</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            @empty
                                <div>Hmm.. Il semble que vous n'avez jamais configuré de formulaire</div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_custom')
    <script>
        Sortable.create(document.getElementById('tablesimon'), {
            group: 'foo',
            animation: 200,
            ghostClass: 'ghost',
        });

        Sortable.create(document.getElementById('categories-container'), {
            group: 'foo',
            animation: 200,
            ghostClass: 'ghost',
        });
    </script>
@endsection
