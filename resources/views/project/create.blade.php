@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
    <div class="text-center">
        <h1>Création de projet pour {{ $customer->firstname }} {{ $customer->lastname }}</h1>
    </div>
    <div>
      <form action="{{ route('project.store') }}" method="post">
        @csrf
        <div class="form-row mt-5">
          <div class="form-group col-md-6 col-sm-12">
            <input type="text" class="form-control" name="title" placeholder="Titre du projet">
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
      </form>
    </div>
  </div>

</div>
@endsection