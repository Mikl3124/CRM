@extends('layouts.app')

@section('content')
<div class="container">
  <a class="text-secondary" href="{{ route('dashboard') }}"><i class="fas fa-home fa-2x"></i></a>
  <h1 class="text-center">{{ $project->title }}</h1>

  @isset($quote)
      @if ($quote->state === 'payed')
        <a class="btn btn-secondary my-4" href="{{ route('quote.show', $quote->token) }}">😃 Devis Payé</a>
      @else
        <a class="btn btn-secondary my-4" href="{{ route('quote.show', $quote->token) }}">Voir le devis</a>
      @endif
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
