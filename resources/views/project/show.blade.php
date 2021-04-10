@extends('layouts.app')

@section('content')
<div class="container">
  <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
  <h1>Le projet</h1>
  <a class="btn btn-primary my-4" href="{{ route('quote.create', $project->id) }}">Créer un devis</a>

  <div class="text-center">
    @isset($quotes)
        @foreach ($quotes as $quote)
            <h5><a href="{{ route('quote.show', $quote->token) }}">Créé le {{ \Carbon\Carbon::parse($quote->created_at)->locale('fr_FR')->translatedFormat('d F Y à H\hi') }}</h5></ul>
        @endforeach
    @endisset
  </div>
</div>


</div>


@endsection
