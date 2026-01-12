<h1>Liste des Serveurs du Data Center</h1>
<table border="1">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resources as $resource)
        <tr>
            <td>{{ $resource->name }}</td>
            <td>{{ $resource->type }}</td>
            <td>{{ $resource->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>