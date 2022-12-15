@extends('layouts.app')

@section('content')
    <div class="row container justify-content-between align-items-center mb-2">
        <div class="col-sm-6 col-md-2">
            <a href="{{route('clients.syncPublic')}}">
                <button type="button" class="btn btn-primary">
                    Sincronizar clientes
                </button>
            </a>
        </div>
    </div>
    @include('client.table')
@endsection
