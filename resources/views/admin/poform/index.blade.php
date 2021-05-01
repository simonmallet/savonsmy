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

                        <form name="poform" id="poform">
                        <div class="table-responsive" id="categories-container">
                            @forelse($categories as $category)
                                <table class="table table-striped table-hover">
                                    <thead class="table-secondary">
                                    <tr>
                                        <th scope="col" style="width: 285px;"><input type="text" class="input-header-form font-weight-bold" name="category_name_{{$category['id']}}" id="category_name_{{$category['id']}}" value="{{$category['name']}}" placeholder="Nom de catégorie">
                                            (Prix <input type="text" class="input-header-form input-price font-weight-bold" name="category_price_{{$category['id']}}" id="category_price_{{$category['id']}}" value="{{$category['price']}}" placeholder="0.00">)</th>
                                        <th colspan="3" scope="col"></th>
                                        <th class="my-handle-header"><span class="my-handle">::</span></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tablesimon">
                                    @forelse($category->items as $item)
                                        <tr>
                                            <td><input type="text" style="width: 285px;" class="input-header-form" name="item_name_{{$item['id']}}" id="item_name_{{$item['id']}}" value="{{$item['name']}}" placeholder="Nom de variant"></td>
                                            <td style="width: 450px;"><input type="text" style="width: 450px;" class="input-header-form" name="item_description_{{$item['id']}}" id="item_description_{{$item['id']}}" value="{{$item['description']}}" placeholder="Description"></td>
                                            <td>Sku: <input type="text" style="width: 40px;" class="input-header-form" name="item_sku_{{$item['id']}}" id="item_sku_{{$item['id']}}" value="{{$item['sku']}}" placeholder="0000"></td>
                                            <td>Actif <input type="checkbox" name="item_enabled_{{$item['id']}}" id="item_enabled_{{$item['id']}}" value="{{$item['enabled']}}" {{$item['enabled'] ? 'checked' : ''}}></td>
                                            <td><span class="my-handle">::</span></td>
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
                        </form>

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
            handle: ".my-handle",
        });

        Sortable.create(document.getElementById('categories-container'), {
            group: 'foo',
            animation: 200,
            ghostClass: 'ghost',
            handle: ".my-handle",
        });
    </script>
@endsection
