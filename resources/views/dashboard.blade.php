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
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($customers as $customer)
            <tr>
              <td>{{ $customer->lastname }}</td>
              <td>{{ $customer->firstname }}</td>
              <td>{{ $customer->email }}</td>
              <td>{{ $customer->phone }}</td>
              <td class="text-center"><a class="btn btn-primary" href="{{ route('customer.show', $customer->id) }}">Accéder</a></td>
              <td class="text-center">
                <!-- Modal Lunch Delete -->
              <form action="{{ route('customer.delete') }}" method="post">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir effacer ce client?')">Supprimer</button>
              </form>
              </td>
            </tr>
          @endforeach
          </tbody>
      </table>
  @endisset

</div>


@endsection

