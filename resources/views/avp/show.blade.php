@extends('layouts.app-without-nav')

@section('content')

  <div class="container-fluid">
    <div class="col-sm-12 col-md-12">
          @auth
            <a class="btn btn-primary" href="{{ route('dashboard') }}">Retour au Dashboard</a>
          @endauth
        <h3 class="text-center my-2">Votre avant projet</h3>
        <div class="text-center my-2">
          <form action="{{ route('createAvpPayement')}}" method="post">
            @csrf
              <input type="hidden" name="avp_id" value="{{ $avp->id }}">
              <button class="btn btn-success my-3" type="submit">Accepter le projet et régler le solde</button>
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
