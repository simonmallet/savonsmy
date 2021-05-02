@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header lead d-flex flex-row justify-content-between">
                        <div>Mise a jour du formulaire (v{{ $currentVersion }} => v{{ $currentVersion + 1 }})</div>
                        <div><input class="btn btn-primary" type="button" onclick="addCategory()" value="Ajouter une categorie"></div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form name="poform" method="POST" id="poform">

                        {{ csrf_field() }}

                        <div class="table-responsive" id="categories-container">
                            @forelse($categories as $category)
                                <fieldset>
                                <table class="table table-striped table-hover">
                                    <thead class="table-secondary">
                                    <tr>
                                        <th scope="col" style="width: 285px;"><input type="text" class="input-header-form font-weight-bold" name="category[{{$category['id']}}][name]" value="{{$category['name']}}" placeholder="Nom de catégorie">
                                            (Prix <input type="text" class="input-header-form input-price font-weight-bold" name="category[{{$category['id']}}][price]" value="{{$category['price']}}" placeholder="0.00">)</th>
                                        <th colspan="4" scope="col">
                                            <div class="d-flex flex-row justify-content-end">
                                                <div><input class="btn-sm btn-primary" type="button" onclick="addVariant('category-tbody-'+{{$category['id']}})" value="Ajouter un variant"></div>
                                                <div class="my-handle-header ml-3"><span class="my-handle">::</span></div>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="category-items" id="category-tbody-{{$category['id']}}">
                                    @forelse($category->items as $item)
                                        <tr>
                                            <td><input type="text" style="width: 285px;" class="input-header-form" name="category[{{$category['id']}}][items][{{$item['id']}}][name]" value="{{$item['name']}}" placeholder="Nom de variant"></td>
                                            <td style="width: 450px;"><input type="text" style="width: 450px;" class="input-header-form" name="category[{{$category['id']}}][items][{{$item['id']}}][description]" value="{{$item['description']}}" placeholder="Description"></td>
                                            <td>Sku: <input type="text" style="width: 40px;" class="input-header-form" name="category[{{$category['id']}}][items][{{$item['id']}}][sku]" value="{{$item['sku']}}" placeholder="0000"></td>
                                            <td>Actif <input type="checkbox" name="category[{{$category['id']}}][items][{{$item['id']}}][enabled]" value="{{$item['enabled']}}" {{$item['enabled'] ? 'checked' : ''}}></td>
                                            <td><span class="my-handle">::</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Aucun item trouve</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                </fieldset>
                            @empty
                                <div>Hmm.. Il semble que vous n'avez jamais configuré de formulaire</div>
                            @endforelse
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                            <div><input class="btn btn-primary" type="submit" value="Sauvegarder"></div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_custom')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            const elementList = document.getElementsByClassName('category-items');

            for (let i = 0; i < elementList.length; i++) {
                Sortable.create(elementList[i], {
                    animation: 200,
                    ghostClass: 'ghost',
                    handle: ".my-handle",
                });
            }

            Sortable.create(document.getElementById('categories-container'), {
                group: 'foo',
                animation: 200,
                ghostClass: 'ghost',
                handle: ".my-handle",
            });
        });

        let categoryIndex = {{$nextAvailableCategoryId}};
        function addCategory()
        {
            $('#categories-container').append(
                '<table class="table table-striped table-hover">' +
                '<thead class="table-secondary">' +
                '<tr>' +
                '<th scope="col" style="width: 285px;"><input type="text" class="input-header-form font-weight-bold" name="category['+categoryIndex+'][name]" placeholder="Nom de catégorie">' +
                '(Prix <input type="text" class="input-header-form input-price font-weight-bold" name="category['+categoryIndex+'][price]" placeholder="0.00">)</th>' +
                '<th colspan="4" scope="col">' +
                    '<div class="d-flex flex-row justify-content-end">' +
                        '<div><input class="btn-sm btn-primary" type="button" onclick="addVariant(\'category-tbody-\''+categoryIndex+')" value="Ajouter un variant"></div>' +
                        '<div class="my-handle-header ml-3"><span class="my-handle">::</span></div>' +
                    '</div>' +
                '</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="category-items"><tr><td colspan="5">Aucun item trouve</td>' +
                '</tr></tbody></table>');
            categoryIndex++;
        }

        function addVariant(elementId)
        {
            $('#' + elementId).append('<tr><td>test</td></tr>');
        }
    </script>
@endsection
