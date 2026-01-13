<div style="border: 1px solid #ccc; padding: 20px; max-width: 400px; margin: 20px auto;">
    <h2>Réserver : {{ $resource->name }}</h2>
    
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="resource_id" value="{{ $resource->id }}">

        <p>
            <label>Date de début :</label><br>
            <input type="datetime-local" name="start_date" required>
        </p>

        <p>
            <label>Date de fin :</label><br>
            <input type="datetime-local" name="end_date" required>
        </p>

        <button type="submit">Confirmer la réservation (Backend Test)</button>
        <a href="{{ route('welcome') }}">Annuler</a>
    </form>
</div>