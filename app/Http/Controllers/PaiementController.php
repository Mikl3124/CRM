<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Avp;
use App\Models\Quote;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Customer;
use Stripe\PaymentIntent;
use App\Mail\QuoteAccepted;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class PaiementController extends Controller
{
  public function createQuotePayement(Request $request)
  {

    $quote = Quote::find($request->quote_id);
    $customer = Customer::find($quote->project->customer_id);

    // On récupère la somme des options

    $sum_options = 0;
    if (isset($request->options)) {
      foreach ($request->options as $option) {
        if (isset($option))
          $sum_options += $option;
      }
    }

    //On calcul l'acompte
    $total = ((int)(($quote->amount + $sum_options) * 30));

    // On enregistre le nouveau montant du devis
    // $quote->amount = $sum_options + $quote->amount;
    // $quote->save();

    Stripe::setApiKey(env("STRIPE_SECRET"));
    $intent = PaymentIntent::create([
      'amount' => $total,
      'currency' => 'eur',
      // Verify your integration in this guide by including this parameter
      'metadata' => ['integration_check' => 'accept_a_payment'],
    ]);


    $clientSecret = Arr::get($intent, 'client_secret');
    if (!isset($customer->stripe_id)) {
      $stripeCustomer = $customer->createAsStripeCustomer();
    } else {
      $stripeCustomer = Cashier::findBillable($customer->stripe_id);
    }

    return view('payment.quote', [
      'clientSecret' => $clientSecret,
      'intent' => $intent,
      'total' => $total,
      'acount' => $total * 30,
      'amount' =>  $total * 100,
      'customer' => $customer,
      'quote' => $quote,
    ]);
  }

  public function createAvpPayement(Request $request)
  {

    $avp = Avp::find($request->avp_id);
    $customer = Customer::find($avp->project->customer_id);
    $options = Option::where('quote_id', $avp->project->quote->id)->get();

    $sum_options = 0;
    foreach ($options as $key => $value) {

      if (isset($value->amount))
        $sum_options += $value->amount;
    }


    //On récupère l'acompte
    $acount = $avp->project->quote->payment;

    //On enregistre le montant à payer + options
    $project_amount = $avp->project->quote->amount + $sum_options;
    if ($acount === null) {
      $total = ($project_amount * 100);
    } else {
      $total = ($project_amount * 100) - ($acount->amount * 100);
    }

    Stripe::setApiKey(env("STRIPE_SECRET"));
    $intent = PaymentIntent::create([
      'amount' => $total,
      'currency' => 'eur',
      // Verify your integration in this guide by including this parameter
      'metadata' => ['integration_check' => 'accept_a_payment'],
    ]);


    $clientSecret = Arr::get($intent, 'client_secret');
    if (!isset($customer->stripe_id)) {
      $stripeCustomer = $customer->createAsStripeCustomer();
    } else {
      $stripeCustomer = Cashier::findBillable($customer->stripe_id);
    }

    return view('payment.avp', [
      'clientSecret' => $clientSecret,
      'intent' => $intent,
      'total' => $total,
      'acount' => $total * 30,
      'amount' =>  $total * 100,
      'customer' => $customer,
      'quote' => $avp,
    ]);
  }

  public function successQuote(Request $request)
  {

    $customer = Customer::find($request->customer_id);
    $payment = new Payment;
    $payment->quote_id = $request->quote_id;
    $payment->amount = $request->amount;
    $payment->customer_id = $request->customer_id;
    $payment->save();

    $quote = Quote::find($request->quote_id);
    $quote->state = 'payed';
    $quote->save();


    Mail::to(env("MAIL_ADMIN"))
      ->send(new QuoteAccepted($quote, $customer));

    return view('payment.quote-success')->with('success', "Votre règlement a bien été enregistré");
  }

  public function successAvp(Request $request)
  {

    $quote = Quote::find($request->quote_id);
    $avp = $quote->project->avp;
    $avp->payed = 1;
    $customer = Customer::find($request->customer_id);
    $payment = new Payment;
    $payment->quote_id = $request->quote_id;
    $payment->amount = $request->amount;
    $payment->customer_id = $request->customer_id;

    $payment->save();
    $avp->save();

    Mail::to(env("MAIL_ADMIN"))
      ->send(new QuoteAccepted($quote, $customer));

    return view('payment.avp-success', compact('avp'))->with('success', "Votre règlement a bien été enregistré");
  }
}
