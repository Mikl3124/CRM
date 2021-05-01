@extends('layouts.app-without-nav')

@section('content')
<div class="main-container">
  <a href="https://nyleo.fr"><img src="https://nyleo.s3.eu-west-3.amazonaws.com/Logo-nyleoxhdpi.png" width="500" class="img-fluid mb-5" alt="Responsive image"></a>
	<div class="check-container">
		<div class="check-background">
			<svg viewBox="0 0 65 51" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M7 25L27.3077 44L58.5 7" stroke="white" stroke-width="13" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
		</div>
		<div class="check-shadow"></div>
	</div>

  <div class="text-center">
    <h1 class="mt-1 mb-5">Paiement effectué</h1>
    <form action="{{ route('download-avp')}}" method="post">
      @csrf
      <input type="hidden" name="avp_id" value="{{ $avp->id }}">
      <button class="btn btn-success" type="submit">Télécharger votre projet</button>
    </form>
  </div>

</div>


@endsection
