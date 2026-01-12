@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenue {{ Auth::user()->name }}</h1>
    <p>Ceci est votre tableau de bord utilisateur.</p>
</div>
@endsection
