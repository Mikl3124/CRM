@extends('layouts.app')

@section('content')
<div class="container">
  <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
  <h1>Le projet</h1>

  @isset($quote)
    <a class="btn btn-secondary my-4" href="{{ route('quote.show', $quote->token) }}">Voir le devis ({{$quote->amount}}€)</a>

  @else
  <a class="btn btn-success my-4" href="{{ route('quote.create', $project->id) }}">Créer un devis</a>
  @endisset

  @isset($avp)
  <a class="btn btn-secondary my-4" href="{{ route('avp.show', $avp->token) }}">Voir l'avant projet </a>
  @else
  <a class="btn btn-success my-4" href="{{ route('avp.create', $project->id) }}">Créer un avp</a>
  @endisset


</div>


</div>


@endsection
