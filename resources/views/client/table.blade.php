<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Identificación</th>
        <th scope="col" class="text-center">Activo</th>
        <th scope="col" class="text-center">Fecha creación</th>
        <th scope="col" class="text-center">Fecha actualización</th>
        <th scope="col" class="text-center">Acciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <th scope="row" class="text-center">{{$client->id_api}}</th>
            <td class="text-center">{{$client->identification_number}}</td>
            <td class="text-center">{{$client->active ? 'Si' : 'No'}}</td>
            <td class="text-center">{{$client->created_at->format('Y-M-d h:i A')}}</td>
            <td class="text-center">{{$client->updated_at->format('Y-M-d h:i A')}}</td>
            <td class="row container justify-content-center">
                <a href="{{route('clients.show', $client)}}">
                    <button type="button" class="btn btn-primary">Ver</button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if (count($clients) > 0)
    <div class="row container justify-content-center align-content-center align-items-center">
        <div class="col-12">{{ $clients->links() }}</div>
    </div>
@endif
