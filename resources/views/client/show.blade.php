@extends('layouts.app')

@section('content')
    <div class="row container justify-content-center align-content-center align-items-center">
        <div class="col-12">
            <h4>Transacciones del cliente
                #{{explode('/', $transactions->getOptions()['path'])[count(explode('/', $transactions->getOptions()['path'])) - 1]}}
            </h4>
        </div>
        <a href="{{route('clients.index')}}">
            <button type="button" class="btn btn-primary">Volver atrás</button>
        </a>
    </div>
    @if(count($transactions) == 0)
        <div class="row container justify-content-center align-content-center align-items-center mt-3">
            <div class="col-12">
                <h6>Sin transacciones</h6>
            </div>
        </div>
    @else
        @include('transaction.table')
    @endif
@endsection
