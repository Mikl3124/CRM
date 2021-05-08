@extends('layouts.app')

@section('content')
<div class="container">
  <a class="text-secondary" href="{{ route('dashboard') }}"><i class="fas fa-home fa-2x"></i></a>
  <a href="{{ route('customer.show', $customer->id) }}">
    <h1 class="text-center text-black">Projets de {{$customer->firstname}} {{$customer->lastname}}</h1>
  </a>
  <hr>
        {{-- Modal pour création de projet --}}
  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#projetModal">
    <i class="fas fa-pen"></i> Créer un projet
  </button>
  @if ($projects->count() > 0)
    <table class="table table-striped mt-5">
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
  @else
    <h5 class="mt-5 text-secondary">😩 Aucun projet pour le moment...</h5>
  @endif

</div>
@endsection

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
