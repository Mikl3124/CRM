<?php

namespace App\Http\Controllers;

use App\Models\Avp;
use App\Models\Quote;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvpController extends Controller
{
  public function create($id)
  {
    $project = Project::find($id);
    $quote = Quote::where('project_id', $project->id)->first();
    $paiement = Payment::where('quote_id', $quote->id)->first();

    if ($paiement === null) {
      $paiement = new Payment;
      $paiement->amount = 0;
      $paiement->quote_id = $quote->id;
    }

    $to_pay = $quote->amount - ($paiement->amount / 100);

    if ($project->customer->user_id === Auth::user()->id) {
      return view('avp.create', compact('project', 'to_pay'));
    }
  }

  public function store(Request $request)
  {

    $avp = new Avp;
    $avp->url = $request->url;
    $avp->project_id = $request->project_id;
    $avp->token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 6)), 0, 6);
    $avp->save();

    return redirect()->route('customer.show', $avp->project->customer_id)->with('success', "L'avant projet a bien été ajouté");
  }
}
