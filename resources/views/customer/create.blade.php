@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body">
      <div class="text-center">
        <h1>Créer un client</h1>
      </div>
      @if (isset($errors) && $errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <form action="{{ route('customer.store') }}" method="post">
        @csrf
        <div class="form-row mt-5">
          <div class="form-group col-md-6 col-sm-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="email" class="form-control" placeholder="Email" name="email">
            </div>
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <input type="text" class="form-control" name="phone" placeholder="Téléphone">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6 col-sm-12">
            <div class="input-group md-3">
              <input type="text" class="form-control" name="firstname" placeholder="Prénom">
            </div>
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <input type="text" class="form-control" name="lastname" placeholder="Nom">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-7">
            <input type="text" class="form-control" name="address" placeholder="Adresse">
          </div>
          <div class="form-group col-md-2">
            <input type="text" class="form-control" name="zip" placeholder="Code Postal">
          </div>
          <div class="form-group col-md-3">
            <input type="text" class="form-control" name="town" placeholder="Ville">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
      </form>
    </div>
  </div>

</div>
@endsection