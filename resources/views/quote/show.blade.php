@extends('layouts.app-without-nav')

@section('content')

  <div class="container-fluid row">
    <div class="col-sm-12 col-md-12">
          @auth
            <a class="btn btn-primary" href="{{ route('dashboard') }}">Retour au Dashboard</a>
          @endauth
        <h3 class="text-center mt-2 mb-4">Votre devis</h3>
        <div class="text-center my-2">
          @auth
          <form action="{{ route('create.acount') }}" method="post">
            @csrf
              <input type="hidden" name="quote_id" value="{{ $quote->id }}">
              <input type="number" step="0.01" name="quote_amount" required>
              <button class="btn btn-success my-3" type="submit">Saisir un acompte</button>
          </form>
          @endauth
          @if ($quote->accepted == 0)
            @if ($options->isnotempty())
              <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#paymentModalCenter">
                Accepter le devis et régler l'acompte
              </button>
            @else
            <form action="{{ route('createQuotePayement')}}" method="post">
              @csrf
                <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                <button class="btn btn-success my-3" type="submit">Accepter le devis et régler l'acompte (30%)</button>
            </form>
            @endif
          @else
            <button type="button" class="btn btn-primary disabled mb-2">
              Vous avez déjà accepté le devis
            </button>
          @endif
      </div>
      <div class='embed-responsive' style='padding-bottom:100%'>
        <object data="{{ Storage::disk('s3')->url($quote->url) }}" type='application/pdf' width='100%' height='100%'></object>
      </div>
      <div class="d-flex justify-content-between">
          <a target="_blank" href="https://nyleo.fr/cgv/">Consulter nos CGV</a>
      </div>
    </div>
  </div>

  {{--   ----------- Modal Paiement-------------- --}}
    <div class="modal fade" id="paymentModalCenter" tabindex="-1" role="dialog" aria-labelledby="paymentModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
             {{--   ----------- Si le devis contient des options-------------- --}}

            <form action="{{ route('createQuotePayement')}}" method="post">
              @csrf
              <div class="modal-header">
                <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                <h5 class="modal-title" id="paymentModalLongTitle">Souhaitez-vous souscrire aux options?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                @foreach ($options as $option)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $option->amount }}" id="flexCheckDefault" multiple="multiple" name="options[]"checked>
                    <label class="form-check-label" for="flexCheckDefault">
                    {{ $option->description }} (+{{ $option->amount }}€)
                    </label>
                  </div>
                @endforeach
              </div>
              <div class="text-center">
                <button class="btn btn-success my-3" type="submit">Règler l'acompte</button>
              </div>
            </form>
        </div>

      </div>

@endsection
