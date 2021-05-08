@extends('layouts.app')

@section('content')


<div class="container">
    <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
    <div class="text-center">
        <h1>{{ $customer->firstname }} {{ $customer->lastname }}</h1>
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
          <a class="btn btn-primary" href="{{ route('projects.list', $customer->id) }}"><i class="fas fa-eye"></i> Voir les projets</a>
        {{-- Si il n'y a aucun projet pour ce client --}}
        @endif
    </div>
</div>


<!-- Modal de création d'interaction-->
<div class="modal fade" id="interactionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Interaction avec {{ $customer->firstname }} {{ $customer->lastname }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('interaction.store')}}" method="post" enctype="multipart/form-data">
      @csrf
       <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="date-input">Date:</label>
            <input name="date" class="form-control" type="date"value="{{ date("Y-m-d") }}" id="date-input">
          </div>
            <div class="form-group">
              <label for="canalCommunication">Par:</label>
              <select name="canal" class="form-control" id="canalCommunication">
                <option>Mail</option>
                <option>Téléphone</option>
                <option>Visite</option>
                <option>Autre</option>
              </select>
            </div>
            <div class="form-group">
              <label for="content">Contenu:</label>
              <textarea name="content" class="form-control" id="content" rows="3"></textarea>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
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





@endsection
