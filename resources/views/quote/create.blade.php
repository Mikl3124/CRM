@extends('layouts.app')
@section('content')
  <div class="container">
    <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
    <div class="card" >
      <div class="card-header">
        <h4>Saisie du devis pour le projet "{{ $project->title}}"</h4>
      </div>
      <div class="card-body">
          <form action="{{ route('quote.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden", name="projectId" value="{{ $project->id }}">
            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">€</span>
                  </div>
                  <input type="number" name="amount" class="form-control" placeholder="Montant du devis" required>
                </div>
              </div>
              <input name="customer_id" type="hidden" value="{{ $project->customer->id }}">
              <div class="col-md-6 mb-3">
                <div class="form-group">
                    <input type="file" name="quoteFile" class="form-control-file @error('file_projet') is-invalid @enderror" id="file-message" value="{{ old('file-message') }}" name="file_message" required>
                    @error('file_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-2 col-sm-12">
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <span class="input-group-text">€</span>
                    </div>
                    <input type="number" class="form-control" placeholder="Prix de l'option 1" name="option1[]">
                  </div>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control" placeholder="Description" name="option1[]">
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-2 col-sm-12">
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <span class="input-group-text">€</span>
                    </div>
                    <input type="number" class="form-control" placeholder="Prix de l'option 2" name="option2[]">
                  </div>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control" placeholder="Description" name="option2[]">
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-2 col-sm-12">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">€</span>
                    </div>
                    <input type="number" class="form-control" placeholder="Prix de l'option 3" name="option3[]">
                  </div>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control" placeholder="Description" name="option3[]">
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Envoyer</button>
          </form>
        </div>
    </div>


  </div>


@endsection
