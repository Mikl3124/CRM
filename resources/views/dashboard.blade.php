@extends('layouts.app')

@section('content')
<div class="container">

  <h4>Bienvenue {{ Auth::user()->name }}</h4>

    <a class="btn btn-primary" href="{{route("customer.create")}}">Ajouter un client</a>

  @isset($customers)
      <table class="table table-striped mt-3">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col" class="text-center">Accéder</th>
            <th scope="col" class="text-center">Supprimer</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($customers as $customer)
            <tr>
              <td>{{ $customer->lastname }}</td>
              <td>{{ $customer->firstname }}</td>
              <td>{{ $customer->email }}</td>
              <td>{{ $customer->phone }}</td>
              <td class="text-center"><a href="{{ route('customer.show', $customer->id) }}">Voir</a></td>
              <td class="text-center"><a href="#">Delete</a></td>
            </tr>
          @endforeach
          </tbody>
      </table>

  @endisset



</div>


@endsection

