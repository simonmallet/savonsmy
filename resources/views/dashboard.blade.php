<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('lang.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('lang.welcome_message') }}
                </div>
                @cannot(\App\Models\User::PERMISSION_FILL_PURCHASE_ORDER)
                    <div class="p-6 bg-white border-b border-gray-200">
                        Votre compte n'a pas encore été activé par l'administrateur de ce site. Si le problème perdure, svp écrire à <a href="mailto:{{ config('contact.email') }}?subject=Activation compte partenaire">{{ config('contact.email') }}</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
