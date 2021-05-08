@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-around">
      <form class="form-inline" action="{{ route("customer.search") }}" method="POST" role="search">
        @csrf
        <input class="form-control mr-sm-2" type="search" name="searchWord" placeholder="Rechercher un client" aria-label="Search">
        <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
      </form>
      <!-- Button trigger modal create user-->
      <button type="button" class="text-secondary" data-toggle="modal" data-target="#createUserModal">
        <i class="fas fa-user-plus fa-2x"></i>
      </button>
    </div>

  @isset($customers)
      <table class="table table-striped mt-3">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Téléphone</th>
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
              <td class="text-center"><a href="{{ route('customer.show', $customer->id) }}"><i class="fas fa-eye fa-2x text-secondary"></a></td>
              <td class="text-center">
                <!-- Modal Lunch Delete -->
              <form action="{{ route('customer.delete') }}" method="post">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <button type="submit" onclick="return confirm('Etes vous sûr de vouloir effacer ce client?')"><i class="fas fa-trash fa-2x text-danger"></i></button>
              </form>
              </td>
            </tr>
          @endforeach
          </tbody>
      </table>
  @endisset

  @include('layouts.modals.create-user')
@endsection
