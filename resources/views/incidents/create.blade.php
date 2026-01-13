@extends('layouts.app')

@section('content')
<style>
    .incident-card { max-width: 600px; margin: 40px auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 5px solid #e74c3c; }
    .form-group { margin-bottom: 15px; }
    label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
    textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: sans-serif; }
    .btn-send { background: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; width: 100%; font-weight: bold; }
</style>

<div class="incident-card">
    <h2><i class='bx bxs-error-alt'></i> Signaler un problème</h2>
    <p>Ressource concernée : <strong>{{ $resource->name }}</strong></p>
    <hr>
    <form action="{{ route('incidents.store') }}" method="POST">
        @csrf
        <input type="hidden" name="resource_id" value="{{ $resource->id }}">
        
        <div class="form-group">
            <label>Description du problème technique</label>
            <textarea name="description" rows="5" required placeholder="Décrivez précisément la panne ou le conflit constaté..."></textarea>
        </div>

        <button type="submit" class="btn-send">ENVOYER LE SIGNALEMENT</button>
    </form>
</div>
@endsection