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
    $all_options = Option::where('quote_id', $quote->id)->get();

    if (isset($all_options)) {
      foreach ($all_options as $option) {
        $option->select = 0;
        $option->save();
      }
    }

    if (isset($request->options)) {
      foreach ($request->options as $option) {
        if (isset($option)){
          $option = Option::find($option);
          $option->select = 1;
          $option->save();
          $sum_options += $option->amount;
        }
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
      'amount' =>  $total,
      'customer' => $customer,
      'quote' => $quote,
    ]);
  }

  public function createAvpPayement(Request $request)
  {

    $avp = Avp::find($request->avp_id);

    $customer = Customer::find($avp->project->customer_id);

    $quote = $avp->project->quote->first();

    $total = $avp->amount;

    Stripe::setApiKey(env("STRIPE_SECRET"));
    $intent = PaymentIntent::create([
      'amount' => $total - 2000,
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
      'quote' => $quote,
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

    return view('avp.success', compact('avp'));
  }
}
