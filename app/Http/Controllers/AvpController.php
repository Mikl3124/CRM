<?php

namespace App\Http\Controllers;

use App\Models\Avp;
use App\Models\Quote;
use App\Models\Option;
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
    if ($quote === null) {
      return redirect()->back()->with('error', "Veuillez d'abord saisir un devis !");
    }
    $paiement = Payment::where('quote_id', $quote->id)->first();

    if ($paiement === null) {
      $paiement = new Payment;
      $paiement->amount = 0;
      $paiement->quote_id = $quote->id;
    }
    $options = $quote->options;

    $result = 0;

    // On récupère les options
    foreach ($options as $option) {
      $result += $option->amount;
    }

    // On totalise le montant du devis + options - l'acompte
    $to_pay = ($quote->amount + $result) - ($paiement->amount / 100);

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

  public function show($token)
  {
    $avp = Avp::where('token', $token)->first();

    if (!Auth::check()) {
      views($avp)->record();
    }

    return view('avp.show', compact('avp'));
  }
}
