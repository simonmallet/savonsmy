@extends('layouts.app')

@section('content')
    <div class="card-body">
        <div><span id="custom_error_msg"></span></div>
        <form id="user_configs_form">

        {{ csrf_field() }}

        <div style="display: flex; flex-direction: row;">
            <div  style="display: flex; flex-direction: row;">
                @forelse($configs as $config)
                    <div class="mr-3 save-config"><input type="checkbox" name="{{ $config->name }}" {{ $config->value === \App\Constants\HTMLConst::CHECKBOX_CHECKED ? 'checked' : '' }}></div>
                    <div>{{ __("lang.config_".$config->name) }}</div>
                @empty
                    <div>{{ __("lang.label_no_configuration_found") }}</div>
                @endforelse
            </div>
        </div>
        </form>

        <div id="loading-icon" class="mr-2 d-none">Mise a jour en cours... <img width="37px" height="37px" src="{{ asset('images/iphone-spinner-2.gif') }}"></div>
    </div>
@endsection

@section('js_custom')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            $(".save-config").click(function(event){
                window.$('#custom_error_msg').text('');
                window.$('#loading-icon').removeClass('d-none');

                let values = $('#user_configs_form').serializeArray();
                values = values.concat(
                    jQuery('#user_configs_form input[type=checkbox]:not(:checked)').map(
                        function() {
                            return {"name": this.name, "value": "no"}
                        }).get());

                window.jQuery.ajax({
                    type:"POST",
                    data: values,
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
                        let msgs = '';
                        for (let k in errors.responseJSON.errors){
                            if (errors.responseJSON.errors.hasOwnProperty(k)) {
                                msgs += k + ': ' + errors.responseJSON.errors[k] + '\n';
                            }
                        }
                        window.$('#custom_error_msg').text(msgs);
                    },
                    complete: function() {
                        window.$('#loading-icon').addClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection
