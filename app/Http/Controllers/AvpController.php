<?php

namespace App\Http\Controllers;

use App\Models\Avp;
use App\Models\File;
use App\Models\Quote;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    $options = Option::where('quote_id', $quote->id)->where('select', 1)->get();

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
    $customer = Customer::find($avp->project->customer_id);
    $avp->customer_id = $customer->id;
    $avp->amount = $request->to_pay * 100;

    if ($files = $request->file('quoteFile')) {

      $filenamewithextension = $request->file('quoteFile')->getClientOriginalName();

      //get filename without extension
      $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

      //get file extension
      $extension = $request->file('quoteFile')->getClientOriginalExtension();

      //filename to store
      //$path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

      $filenametostore = $filename . '_' . time() . '.' . $extension;


      $filename = $files->storeAs(
        'documents',
        $filenametostore
      );
      File::create([
        'customer_id' => $customer->id,
        'url' => Storage::disk('s3')->url('documents/' . $filenametostore),
        'filename' => $filenamewithextension,
        'project_id' => $request->project_id,
        'direction' => $filenametostore,
        'type' => "project"
      ]);
      //Store $filenametostore in the database
      $avp->avp_url = $filename;
      $avp->filename = $filenamewithextension;
    }

    $avp->save();

    return redirect()->route('customer.show', $avp->project->customer_id)->with('success', "L'avant projet a bien été ajouté");
  }

  public function show($token)
  {
    $avp = Avp::where('token', $token)->first();

    if ($avp->payed === 1) {
      return view('avp.success', compact('avp'));
      //return Storage::download($avp->avp_url);
    }

    return view('avp.show', compact('avp'));
  }

  public function delete(Request $request)
  {

    $avp = Avp::find($request->avp_id);

    $project = Project::find($avp->project_id);

    if (Auth::user()->id === $project->customer->user->id) {

      $files = File::where('project_id', $project->id)->where('type', 'project')->get();

      foreach ($files as $file) {
        Storage::delete("documents/$file->direction");
      }
      File::where('project_id', $project->id)->where('type', 'project')->delete();

      if ($avp->delete()) {

        $avp = Avp::where('project_id', $project->id)->first();
        return redirect()->route('project.show', $project->id)->with('success', "L'avant projet a été supprimé avec succès");
      }
    }

    return redirect()->back()->with('error', "Une erreur est survenue, suppression impossible");
  }


  public function download(Request $request)
  {
    $avp = Avp::where('id', $request->avp_id)->first();
    return Storage::download($avp->avp_url);
  }
}
