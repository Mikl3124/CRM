<!-- Modal create user-->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog"aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createUserModal">Création de client</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if (isset($errors) && $errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

        <form action="{{ route('customer.store') }}" method="post">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-12 col-sm-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="email" class="form-control" placeholder="Email" name="email">
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6 col-sm-12">
              <div class="input-group md-3">
                <input type="text" class="form-control" name="firstname" placeholder="Prénom">
              </div>
            </div>
            <div class="form-group col-md-6 col-sm-12">
              <input type="text" class="form-control" name="lastname" placeholder="Nom">
            </div>
            <div class="form-group col-md-12 col-sm-12">
              <input type="text" class="form-control" name="phone" placeholder="Téléphone">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12 col-sm-12">
              <input type="text" class="form-control" name="address" placeholder="Adresse">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6 col-sm-12">
              <input type="text" class="form-control" name="zip" placeholder="Code Postal">
            </div>
            <div class="form-group col-md-6 col-sm-12">
              <input type="text" class="form-control" name="town" placeholder="Ville">
            </div>
          </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Créer</button>
      </div>
    </form>
    </div>
  </div>
</div>
