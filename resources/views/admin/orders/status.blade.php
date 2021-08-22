@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('admin.order.view.statusSubmit', ['orderId' => $orderId]) }}">
        @method('PUT')
        @csrf

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-secondary">
                <tr>
                    <th scope="col" style="vertical-align: middle;">Status actuel: {{ __('lang.order_status_'.$status) }}</th>
                    <th scope="col">
                        <div>
                            <label for="update_status">Nouveau status</label>
                            <select class="form-control" style="display: inline; width: 150px;" name="update_status" id="update_status">
                                @foreach($available_transitions as $transition )
                                    <option value="{{ $transition }}">{{ __('lang.order_status_'.$transition) }}</option>
                                @endforeach
                            </select>
                        </div>

                    </th>
                    <th scope="col" class="text-right"><button class="btn btn-primary">Mettre à jour</button> </th>
                </tr>
                </thead>
            </table>
        </div>
    </form>
    @include('admin.orders.partials.order_detail')
@endsection
