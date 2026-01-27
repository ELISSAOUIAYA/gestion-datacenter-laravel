@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 700px; margin: 0 auto;">
        <a href="{{ route('admin.maintenances.index') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 1.5rem;">
            ← Retour
        </a>

        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h1 style="margin: 0 0 2rem 0; color: #1a1a1a;">Planifier une Maintenance</h1>
            
            <form method="POST" action="{{ route('admin.maintenances.store') }}">
                @csrf

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Ressource</label>
                    <select name="resource_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;" required>
                        <option value="">Sélectionner une ressource</option>
                        @foreach($resources as $res)
                        <option value="{{ $res->id }}">{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('resource_id') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Début</label>
                        <input type="datetime-local" name="start_date" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;" required>
                        @error('start_date') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Fin</label>
                        <input type="datetime-local" name="end_date" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;" required>
                        @error('end_date') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Description</label>
                    <textarea name="description" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; min-height: 100px;"></textarea>
                </div>

                <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    <i class='bx bx-plus'></i> Planifier
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
