<h1>Liste des Serveurs du Data Center</h1>

<table border="1" style="width:100%; text-align:left; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Nom</th>
            <th>Type</th>
            <th>Configuration</th>
            <th>Status</th>
            <th>Action</th> </tr>
    </thead>
    <tbody>
        @foreach($resources as $resource)
        <tr>
            <td><strong>{{ $resource->name }}</strong></td>
            <td>{{ $resource->type }}</td>
            <td>
                <small>
                    CPU: {{ $resource->cpu }} | RAM: {{ $resource->ram }} | OS: {{ $resource->os }}
                </small>
            </td>
            <td>
                @if($resource->status == 'available')
                    <span style="color: green;">Disponible</span>
                @else
                    <span style="color: red;">En maintenance</span>
                @endif
            </td>
            <td>
                @auth
                    {{-- Si l'utilisateur est connecté, il peut réserver --}}
                    @if($resource->status == 'available')
                        <button type="button">Réserver ce serveur</button>
                    @else
                        <button disabled title="Indisponible">Indisponible</button>
                    @endif
                @endauth

                @guest
                    {{-- Si c'est un invité, on lui demande de se connecter --}}
                    <a href="{{ route('login') }}" style="font-size: 0.8em;">Connectez-vous pour réserver</a>
                @endguest
            </td>
        </tr>
        @endforeach
    </tbody>
</table>