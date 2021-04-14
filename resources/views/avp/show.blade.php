@extends('layouts.app-without-nav')

@section('content')

  <div class="container-fluid">
    <div class="col-sm-12 col-md-12">
          @auth
            <a class="btn btn-primary" href="{{ route('dashboard') }}">Retour au Dashboard</a>
          @endauth
        <h3 class="text-center mt-2 mb-4">Votre avant projet</h3>
        <div class="text-center my-2">
            <form action="#" class="my-4">
              <div class="text-center">
                  <button id="submit" class="btn btn-success my-3" data-secret="">
                    Accepter le projet et régler l'acompte
                    </button>
              </div>
            </form>
        </div>
        <div>
          {!! $avp->url !!}
        </div>
        <div class="d-flex justify-content-between">
            <a target="_blank" href="https://nyleo.fr/cgv/">Consulter nos CGV</a>
        </div>
    </div>
  </div>

@endsection
