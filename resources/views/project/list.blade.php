@extends('layouts.app')

@section('content')
<div class="container">
  <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
  <h1>Liste des Projets </h1>
  <a class="btn btn-primary my-4" href="{{ route('project.create', $customer->id) }}">Créer un projet</a>
   <table class="table table-striped mt-3">
    <thead>
      <tr>
        <th scope="col">Projet</th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($projects as $project)
        <tr>
          <td>{{ $project->title }}</td>
          <td class="text-center"><a class="btn btn-primary" href="{{ route('project.show', $project->id) }}">Accéder</a></td>
          <td class="text-center">
              <!-- Modal Lunch Delete -->
            <form action="{{ route('project.delete') }}" method="post">
              @csrf
              <input type="hidden" name="project_id" value="{{ $project->id }}">
              <input type="hidden" name=" customer_id" value="{{ $customer->id }}">
              <button type="submit" class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir effacer ce projet?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
  </table>
</div>

</div>
@endsection
