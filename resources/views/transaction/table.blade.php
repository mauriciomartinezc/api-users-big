<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Monto</th>
        <th scope="col" class="text-center">Detalle</th>
        <th scope="col" class="text-center">Fecha creación</th>
        <th scope="col" class="text-center">Fecha actualización</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <th scope="row" class="text-center">{{$transaction->id_api}}</th>
            <td class="text-center">{{$transaction->amount}}</td>
            <td class="text-center">{{$transaction->transaction_detail}}</td>
            <td class="text-center">{{$transaction->created_at->format('Y-M-d h:i A')}}</td>
            <td class="text-center">{{$transaction->updated_at->format('Y-M-d h:i A')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@if (count($transactions) > 0)
    <div class="row container justify-content-center align-content-center align-items-center">
        <div class="col-12">{{ $transactions->links() }}</div>
    </div>
@endif
