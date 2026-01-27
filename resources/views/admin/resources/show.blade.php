@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <a href="{{ route('admin.resources.index') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 1.5rem;">
            ← Retour
        </a>

        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h1 style="margin: 0 0 2rem 0; color: #1a1a1a;">{{ $resource->name }}</h1>
            
            <form method="POST" action="{{ route('admin.resources.update', $resource) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; gap: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Nom</label>
                        <input type="text" name="name" value="{{ $resource->name }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;" required>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Catégorie</label>
                        <select name="resource_category_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $resource->resource_category_id === $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Manager Technique</label>
                        <select name="tech_manager_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Aucun</option>
                            @foreach($techManagers as $manager)
                            <option value="{{ $manager->id }}" {{ $resource->tech_manager_id === $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">CPU</label>
                            <input type="text" name="cpu" value="{{ $resource->cpu }}" placeholder="Ex: 8 vCPU" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">RAM</label>
                            <input type="text" name="ram" value="{{ $resource->ram }}" placeholder="Ex: 16GB" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Status</label>
                        <select name="is_active" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;" required>
                            <option value="1" {{ $resource->is_active ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ !$resource->is_active ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>

                    <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">
                        <i class='bx bx-save'></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
