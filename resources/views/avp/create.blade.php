@extends('layouts.app')
@section('content')
  <div class="container">
    <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
    <div class="card" >
      <div class="card-header">
        <h4>Saisie de l'avp pour le projet "{{ $project->title }}"</h4>
      </div>
      <div class="card-body">
          <form action="{{ route('avp.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <input name="customer_id" type="hidden" value="{{ $project->customer->id }}">

            <div class="form-group">
              <label for="to_pay">Montant à payer:</label>
              <input type="number" step="0.01" name="to_pay" class="form-control" id="to_pay" value="{{ $to_pay }}" required>
            </div>

            <div class="form-group">
              <label for="avp-link">Veuillez coller le lien</label>
              <textarea name="url" class="form-control" id="avp-link" rows="3" required></textarea>
            </div>

            <div class="form-group">
              <input type="file" name="quoteFile" class="form-control-file @error('file_projet') is-invalid @enderror" id="file-message" value="{{ old('file-message') }}" name="file_message" required>
              @error('file_message')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

            <button class="btn btn-primary" type="submit">Envoyer</button>
          </form>
        </div>
    </div>


  </div>


@endsection
