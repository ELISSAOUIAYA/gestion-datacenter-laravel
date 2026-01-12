@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenue Manager {{ Auth::user()->name }}</h1>
    <p>Ceci est le tableau de bord du manager.</p>
</div>
@endsection
