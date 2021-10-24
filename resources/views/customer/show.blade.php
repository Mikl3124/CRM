@extends('layouts.app')

@section('content')


<div class="container">
    <a class="text-secondary" href="{{ route('dashboard') }}"><i class="fas fa-home fa-2x"></i></a>
    <div class="text-center">
      <button data-toggle="modal" data-target="#editUserModal">
        <h1>{{ $customer->firstname }} {{ $customer->lastname }}</h1>
      </button>

    </div>

    <hr>

    <h3 class="text-center">Interactions</h3>
    {{-- Modal pour création d'interaction --}}
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#interactionModal">
      <i class="fas fa-pen"></i> Créer une interaction
    </button>
      @if($customer->interactions->count() > 0)
        <a class="btn btn-primary" href="{{ route('interactions.list', $customer->id) }}"><i class="fas fa-eye"></i> Voir les interactions ({{ $customer->interactions->count() }})</a>
      @endif
    <hr>
    <h3 class="text-center">Projets</h3>
    <div>
              {{-- Modal pour création de projet --}}
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#projetModal">
            <i class="fas fa-pen"></i> Créer un projet
          </button>
        {{-- Si un projet a déjà été créé pour le client --}}
        @if ($projects->count() >= 1)
          <a class="btn btn-primary" href="{{ route('projects.list', $customer->id) }}"><i class="fas fa-eye"></i> Voir les projets ({{ $projects->count() }})</a>
        {{-- Si il n'y a aucun projet pour ce client --}}
        @endif
    </div>
</div>

<!-- Modal de création de projet-->
<div class="modal fade" id="projetModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Création de projet </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('project.store') }}" method="post">
            @csrf
            <div class="form-group">
              <input type="text" class="form-control" name="title" placeholder="Titre du projet">
              <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@include('layouts.modals.edit-user')
@include('layouts.modals.interactions')


@endsection
