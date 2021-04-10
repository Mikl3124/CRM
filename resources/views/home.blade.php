@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <div class="mb-5">
                    <img src="https://nyleo.fr/wp-content/uploads/2015/02/Logo-nyleoxhdpi-1024x467.png" width="400" class="rounded mx-auto d-block" alt="Nyleo Conception">
                </div>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <form action="{{ route('access') }}" method="post">
                      @csrf
                      <div class="form-group">
                        <label for="Email">Veuillez saisir votre adresse email:</label>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" aria-label="Large" placeholder="example@mail.com" required>

                      </div>
                      <button type="submit" class="btn btn-primary btn-lg btn-block">Entrer</button>
                    </form>

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
