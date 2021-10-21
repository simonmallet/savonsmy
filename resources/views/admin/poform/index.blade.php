@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-3">
        <button class="btn btn-secondary bi bi-arrows-expand" onclick="showAllCategories();">Tout ouvrir</button>
        <button class="btn btn-secondary bi bi-arrows-collapse" onclick="hideAllCategories();">Tout fermer</button>
        <input class="btn btn-primary" type="button" onclick="addCategory()" value="Ajouter une categorie">
    </div>

    <form id="poform">

    {{ csrf_field() }}

    <div class="table-responsive" id="categories-container">
        @forelse($categories as $category)
            <fieldset>
            <table class="table table-striped table-hover">
                <thead class="table-secondary">
                <tr>
                    <th colspan="5" scope="col" style="width: 500px;">
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <i class="bi bi-eye-slash-fill mr-2" onclick="toggleCategoryItemView(this, {{ $category['id'] }});"></i>
                            <input type="text" class="input-header-form input-category-name font-weight-bold" name="category[{{$category['id']}}][name]" value="{{$category['name']}}" placeholder="Nom de catégorie">
                            (Prix <input type="text" class="input-header-form input-price font-weight-bold" name="category[{{$category['id']}}][price]" value="{{\App\Domain\Helpers\FormattingHelper::formatPrice($category['price'])}}" placeholder="0.00">)
                            (MSRP <input type="text" class="input-header-form input-price font-weight-bold" name="category[{{$category['id']}}][msrp]" value="{{\App\Domain\Helpers\FormattingHelper::formatPrice($category['msrp'])}}" placeholder="0.00">)
                            <div class="ml-auto"><input class="btn-sm btn-primary" type="button" onclick="addVariant('category-tbody-{{$category['id']}}', {{$category['id']}})" value="Ajouter un variant"></div>
                            <div class="my-handle-header ml-3"><span class="my-handle">::</span></div>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody class="category-items" style="display: none;" id="category-tbody-{{$category['id']}}">
                @forelse($category->items as $item)
                    <tr>
                        <td><input type="text" style="width: 350px;" class="input-header-form input-category-name" name="category[{{$category['id']}}][items][{{$item['id']}}][name]" value="{{$item['name']}}" placeholder="Nom de variant"></td>
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
        <div id="loading-icon" class="mr-2 d-none"><img width="37px" height="37px" src="{{ asset('images/iphone-spinner-2.gif') }}"></div>
        <div><button id="submit-btn" class="btn btn-success save-data">Sauvegarder</button></div>
    </div>
    </form>
@endsection

@section('js_custom')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            const elementList = document.getElementsByClassName('category-items');

            for (let i = 0; i < elementList.length; i++) {
                createSortable(elementList[i]);
            }

            createSortable(document.getElementById('categories-container'), 'foo');

            $(".save-data").click(function(event){
                event.preventDefault();
                window.$('#submit-btn').prop('disabled', true);
                window.$('#loading-icon').removeClass('d-none');

                window.jQuery.ajax({
                    type:"POST",
                    data: $('#poform').serialize(),
                    success: function (response) {
                        $.toast({
                            text: "Mise a jour avec succès!", // Text that is to be shown in the toast
                            heading: 'Succès', // Optional heading to be shown on the toast
                            icon: 'success', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#CCCCCC',  // Background color of the toast loader
                            beforeShow: function () {}, // will be triggered before the toast is shown
                            afterShown: function () {}, // will be triggered after the toat has been shown
                            beforeHide: function () {}, // will be triggered before the toast gets hidden
                            afterHidden: function () {}  // will be triggered after the toast has been hidden
                        });

                    },
                    error: function(errors) {
                        console.log(errors);
                    },
                    complete: function() {
                        window.$('#submit-btn').prop('disabled', false);
                        window.$('#loading-icon').addClass('d-none');
                    }
                });
            });
        });

        function createSortable(element, groupName)
        {
            let sortable = Sortable.create(element, {
                animation: 200,
                ghostClass: 'ghost',
                handle: ".my-handle",
            });
            if (groupName) {
                sortable.option('group', groupName);
            }
        }

        let categoryIndex = {{$nextAvailableCategoryId}};
        let categoryItemIndex = {{$nextAvailableCategoryItemId}};
        function addCategory()
        {
            $('#categories-container').append(
                '<table class="table table-striped table-hover">' +
                '<thead class="table-secondary">' +
                '<tr>' +
                '<th scope="col" colspan="5" style="width: 500px;">' +
                    '<div class="d-flex flex-row align-items-center justify-content-start">' +
                        '<i class="bi bi-eye-fill mr-2" onclick="toggleCategoryItemView(this, '+categoryIndex+');"></i>' +
                        '<input type="text" class="input-header-form input-category-name font-weight-bold" name="category['+categoryIndex+'][name]" placeholder="Nom de catégorie">' +
                        '(Prix <input type="text" class="input-header-form input-price font-weight-bold" name="category['+categoryIndex+'][price]" placeholder="0.00">)' +
                        '(MSRP <input type="text" class="input-header-form input-price font-weight-bold" name="category['+categoryIndex+'][msrp]" placeholder="0.00">)' +
                        '<div class="ml-auto"><input class="btn-sm btn-primary" type="button" onclick="addVariant(\'category-tbody-'+categoryIndex+'\', '+categoryIndex+')" value="Ajouter un variant"></div>' +
                        '<div class="my-handle-header ml-3"><span class="my-handle">::</span></div>' +
                    '</div>' +
                '</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="category-items" id="category-tbody-'+categoryIndex+'"><tr><td colspan="5">Aucun item trouve</td>' +
                '</tr></tbody></table>');

            createSortable(document.getElementById('category-tbody-'+categoryIndex));

            categoryIndex++;
        }

        function addVariant(elementId, categoryId)
        {
            const selector = $('#' + elementId);
            if (selector.html().search('Aucun item trouve') !== -1) {
                selector.children('tr').remove();
            }
            selector.append('<tr>' +
                '<td><input type="text" style="width: 350px;" class="input-header-form" name="category['+categoryId+'][items]['+categoryItemIndex+'][name]" placeholder="Nom de variant"></td>' +
                '<td style="width: 450px;"><input type="text" style="width: 450px;" class="input-header-form" name="category['+categoryId+'][items]['+categoryItemIndex+'][description]" placeholder="Description"></td>' +
                '<td>Sku: <input type="text" style="width: 40px;" class="input-header-form" name="category['+categoryId+'][items]['+categoryItemIndex+'][sku]" placeholder="0000"></td>' +
                '<td>Actif <input type="checkbox" name="category['+categoryId+'][items]['+categoryItemIndex+'][enabled]" checked></td>' +
                '<td><span class="my-handle">::</span></td>' +
                '</tr>');
            categoryItemIndex++;
        }

        function showAllCategories()
        {
            const categoriesList = document.getElementsByClassName('category-items');
            const eyeIconElements = document.getElementsByClassName("bi-eye-slash-fill");

            while (eyeIconElements.length) eyeIconElements[0].className = eyeIconElements[0].className.replace( /bi-eye-slash-fill/g , 'bi-eye-fill' );

            for (let i = 0; i < categoriesList.length; i++) {
                categoriesList[i].style.display = 'contents';
            }
        }

        function hideAllCategories()
        {
            const categoriesList = document.getElementsByClassName('category-items');
            const eyeIconElements = document.getElementsByClassName("bi-eye-fill");

            while (eyeIconElements.length) eyeIconElements[0].className = eyeIconElements[0].className.replace( /bi-eye-fill/g , 'bi-eye-slash-fill' );

            for (let i = 0; i < categoriesList.length; i++) {
                categoriesList[i].style.display = 'none';
            }
        }

        function toggleCategoryItemView(eyeIconElement, categoryId)
        {
            const tBodyElement = document.getElementById('category-tbody-' + categoryId);
            if (tBodyElement.style.display === 'none') {
                tBodyElement.style.display = 'contents';
                eyeIconElement.classList.remove('bi-eye-slash-fill');
                eyeIconElement.classList.add('bi-eye-fill');
            } else {
                tBodyElement.style.display = 'none';
                eyeIconElement.classList.remove('bi-eye-fill');
                eyeIconElement.classList.add('bi-eye-slash-fill');
            }
        }
    </script>
@endsection
