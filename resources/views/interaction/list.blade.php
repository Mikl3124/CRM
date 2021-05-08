@extends('layouts.app')

@section('content')
<div class="container">
  <a class="btn btn-primary my-4" href="{{ route('dashboard') }}">Retour au Dashboard</a>
  <h1>Liste des interactions </h1>
  <a class="btn btn-primary my-4" href="">Créer une interaction</a>
   <table class="table table-striped mt-3">
    <thead>
      <tr>
        <th scope="col">Interaction</th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($interactions as $interaction)
        <tr>
          <td>{{ $interaction->title }}</td>
          <td class="text-center">
              <!-- Modal Lunch Delete -->
            <form action="" method="post">
              @csrf
              <button type="submit" class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir effacer ce projet?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
  </table>
</div>

</div>
@endsection