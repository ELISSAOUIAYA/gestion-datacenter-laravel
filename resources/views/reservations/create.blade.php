<div class="card" style="max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h2>Réserver : {{ $resource->name }}</h2>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="resource_id" value="{{ $resource->id }}">

        <div style="margin-bottom: 15px;">
            <label>Date de début :</label><br>
            <input type="datetime-local" name="start_date" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Date de fin :</label><br>
            <input type="datetime-local" name="end_date" required style="width: 100%;">
        </div>

        <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Confirmer la réservation
        </button>
        <a href="{{ route('welcome') }}" style="margin-left: 10px; color: #666;">Annuler</a>
    </form>
</div>