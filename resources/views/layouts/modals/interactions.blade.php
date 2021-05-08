<!-- Modal de création d'interaction-->
<div class="modal fade" id="interactionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Interaction avec {{ $customer->firstname }} {{ $customer->lastname }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('interaction.store')}}" method="post" enctype="multipart/form-data">
      @csrf
       <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="date-input">Date:</label>
            <input name="date" class="form-control" type="date"value="{{ date("Y-m-d") }}" id="date-input">
          </div>
            <div class="form-group">
              <label for="canalCommunication">Par:</label>
              <select name="canal" class="form-control" id="canalCommunication">
                <option>Mail</option>
                <option>Téléphone</option>
                <option>Visite</option>
                <option>Autre</option>
              </select>
            </div>
            <div class="form-group">
              <label for="content">Contenu:</label>
              <textarea name="content" class="form-control" id="content" rows="3"></textarea>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
