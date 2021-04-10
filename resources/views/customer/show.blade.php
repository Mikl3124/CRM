@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
    <div class="text-center">
        <h1>{{ $customer->firstname }} {{ $customer->lastname }}</h1>
    </div>
    <div>
        @if ($projects->count() >= 1)
          <a class="btn btn-primary" href="{{ route('projects.list', $customer->id) }}">Voir les projets</a>
        @elseif ($projects->count() == 0)
          <a class="btn btn-primary my-4" href="{{ route('project.create', $customer->id) }}">Créer un projet</a>
        @endif
    </div>


  </div>

</div>
@endsection
