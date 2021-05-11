<?php

namespace App\Http\Controllers;

use App\Models\Avp;
use App\Models\File;
use App\Models\Quote;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Customer;
use App\Mail\CreateQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{
  public function create($id)
  {
    $project = Project::find($id);
    if ($project->customer->user_id === Auth::user()->id) {
      return view('quote.create', compact('project'));
    }
  }

  public function show($token)
  {
    $quote = Quote::where('token', $token)->first();

    $options = Option::where('quote_id', $quote->id)->get();
    return view('quote.show', compact('quote', 'options'));
  }

  public function createAcount(Request $request)
  {

    $quote = Quote::where('id', $request->quote_id)->first();
    if (Auth::check()) {
      $customer = Customer::find($quote->project->customer_id);
      $payment = new Payment;
      $payment->quote_id = $request->quote_id;
      $payment->amount = $request->quote_amount * 100;
      $payment->customer_id = $customer->id;
      $payment->save();
    }

    return redirect()->route('customer.show', $quote->project->customer_id)->with('success', "L'acompte de {$payment->amount}€ a bien été enregistré");
  }

  public function store(Request $request)
  {
    $quote = new Quote;
    $customer = Customer::find($request->customer_id);
    $quote->amount = $request->amount;
    $quote->project_id = $request->projectId;
    $quote->customer_id = $customer->id;
    $quote->token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 6)), 0, 6);

    if ($customer->user_id === Auth::user()->id) {
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
          'direction' => $filenametostore,
          'project_id' => $quote->project->id,
          'type' => "quote"
        ]);
        //Store $filenametostore in the database
        $quote->url = $filename;
        $quote->filename = $filenamewithextension;
      }
      if ($quote->save()) {
        if ($request->option1[0] != null) {
          $option = new Option;
          $option->amount = $request->option1[0];
          $option->customer_id = $customer->id;
          $option->description = $request->option1[1];
          $option->quote_id = $quote->id;
          $option->save();
        }
        if ($request->option2[0] != null) {
          $option = new Option;
          $option->amount = $request->option2[0];
          $option->customer_id = $customer->id;
          $option->description = $request->option2[1];
          $option->quote_id = $quote->id;
          $option->save();
        }

        if ($request->option3[0] != null) {
          $option = new Option;
          $option->amount = $request->option3[0];
          $option->customer_id = $customer->id;
          $option->description = $request->option3[1];
          $option->quote_id = $quote->id;
          $option->save();
        }
      }
      // Notification

      // Mail::to($customer->email)
      //   ->send(new CreateQuote($quote, $customer));

      return redirect()->route('customer.show', $quote->project->customer_id)->with('success', "Le devis a bien été ajouté");
    }
    return redirect()->back()->with('errors', "Vous n'êtes pas autorisé à créer un devis pour ce client");
  }

  public function delete(Request $request)
  {

    $quote = Quote::find($request->quote_id);

    $project = Project::find($quote->project_id);

    if (Auth::user()->id === $project->customer->user->id) {

      $files = File::where('project_id', $project->id)->get();

      foreach ($files as $file) {
        Storage::delete("documents/$file->direction");
      }
      File::where('project_id', $project->id)->delete();

      if ($quote->delete()) {

        Avp::where('project_id', $project->id)->delete();
        return redirect()->route('project.show', $project->id)->with('success', "Le devis a été supprimé avec succès");
      }
    }

    return redirect()->back()->with('error', "Une erreur est survenue, suppression impossible");
  }
}
