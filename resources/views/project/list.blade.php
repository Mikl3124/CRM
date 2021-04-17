@extends('layouts.app')

@section('content')
<div class="container">
  <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
  <h1>Liste des Projets </h1>
  <a class="btn btn-primary my-4" href="{{ route('project.create', $customer->id) }}">Créer un projet</a>
  <div class="list-group">
    @foreach ($projects as $project)
        <a class="list-group-item list-group-item-action" href="{{ route('project.show', $project->id) }}">{{ $project->title }} </a>
    @endforeach
  </div>
</div>

</div>
@endsection
