<?php

namespace App\Http\Controllers;

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
      $payment->amount = $request->quote_amount;
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
          'user_id' => $customer->id,
          'url' => Storage::disk('s3')->url('documents/' . $filenametostore),
          'filename' => $filenamewithextension
        ]);
        //Store $filenametostore in the database
        $quote->url = $filename;
        $quote->filename = $filenamewithextension;
      }
      if ($quote->save()) {
        if ($request->option1[0] != null) {
          $option = new Option;
          $option->amount = $request->option1[0];
          $option->description = $request->option1[1];
          $option->quote_id = $quote->id;
          $option->save();
        }
        if ($request->option2[0] != null) {
          $option = new Option;
          $option->amount = $request->option2[0];
          $option->description = $request->option2[1];
          $option->quote_id = $quote->id;
          $option->save();
        }

        if ($request->option3[0] != null) {
          $option = new Option;
          $option->amount = $request->option3[0];
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
}
