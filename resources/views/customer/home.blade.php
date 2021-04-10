@extends('layouts.app')

@section('content')
<div class="container">
  <div>
    <h2>Bienvenue {{ $customer->firstname }} {{ $customer->lastname }}</h2>
  </div>
</div>
@endsection
