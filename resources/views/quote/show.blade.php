  @extends('layouts.app-without-nav')



@section('content')

  <div class="container-fluid row">
    <div class="col-sm-12 col-md-12">
      <div class="container">
          @auth
            <a class="btn btn-primary" href="{{ route('dashboard') }}">Retour au Dashboard</a>
          @endauth
        <h4 class="text-center mt-2">Votre devis</h4>
        <div class="embed-responsive embed-responsive-1by1">
          <iframe class="embed-responsive-item" src="{{ Storage::disk('s3')->url($quote->url) }}"></iframe>
        </div>

        <div class="d-flex justify-content-between">
            <a target="_blank" href="https://nyleo.fr/cgv/">Consulter nos CGV</a>
        </div>
        <div class="text-center mt-5">
            @if ($quote->accepted == 0)
              <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#paymentModalCenter">
                Accepter le devis ({{ $quote->amount}}€)
              </button>
            @else
              <button type="button" class="btn btn-primary disabled mb-2">
                Vous avez déjà accepté le devis
              </button>
            @endif
        </div>
      </div>
    </div>
  </div>

  {{--   ----------- Modal Paiement-------------- --}}
    <div class="modal fade" id="paymentModalCenter" tabindex="-1" role="dialog" aria-labelledby="paymentModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
             {{--   ----------- Si le devis contient des options-------------- --}}
          @if ($options->isnotempty())
            <form action="{{ route('paiement')}}" method="post">
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
          {{--   ----------- Si le devis ne contient pas des options-------------- --}}
          @else
          <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLongTitle">Règlement de {{ $display_amount }}€ (30% du devis)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="#" class="my-4">
              <div id="card-element">
              <!-- Elements will create input elements here -->
              </div>
                    <!-- We'll put the error messages in this element -->
              <div id="card-errors" class="mb-3" role="alert"></div>
              <div class="text-center">
                  <button type="button" class="btn btn-secondary my-3" data-dismiss="modal">Retour</button>
                  <button id="submit" class="btn btn-success my-3" data-secret="<?= $intent->client_secret ?>">
                    Régler l'acompte
                    </button>
              </div>
            </form>
          </div>

          @endif

      </div>

@endsection
