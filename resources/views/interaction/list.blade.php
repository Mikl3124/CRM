@extends('layouts.app')

@section('content')
<div class="container">
  <a class="text-secondary" href="{{ route('dashboard') }}"><i class="fas fa-home fa-2x"></i></a>
  <h1 class="text-center">Liste des interactions </h1>
  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#interactionModal">
    <i class="fas fa-pen"></i> Créer une interaction
  </button>
   <table class="table table-striped mt-3">
    <tbody>
      @foreach ($interactions as $interaction)
          <tr>
            <td>{{ Carbon\Carbon::parse($interaction->created_at)->isoFormat('ll') }}</td>
            <td>{{ $interaction->content }}</td>
            <td class="text-center">
              <a href="#"><i class="fas fa-eye fa-2x text-secondary"></i></a>
            </td>
            <td class="text-center">
              <!-- Modal Lunch Delete -->
              <form action="" method="post">
                @csrf
                <button type="submit" onclick="return confirm('Etes vous sûr de vouloir effacer ce projet?')"><i class="fas fa-trash fa-2x text-danger"></i></button>
              </form>
            </td>
          </tr>
      @endforeach
      </tbody>
  </table>
</div>
@include('layouts.modals.interactions')
@endsection
