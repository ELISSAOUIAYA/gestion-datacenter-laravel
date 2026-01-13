@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenue {{ Auth::user()->name }}</h1>
    <p>Ceci est le tableau de bord de l'admin.</p>
</div>
@endsection
