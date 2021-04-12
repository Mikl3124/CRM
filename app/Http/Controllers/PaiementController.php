<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Quote;
use App\Models\Customer;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Redirect;

class PaiementController extends Controller
{
  public function create(Request $request)
  {
    $quote = Quote::find($request->quote_id);
    $result = 0;
    $customer = Customer::find($quote->project->customer_id);
    if ($request->options) {
      foreach ($request->options as $option) {
        $result += $option;
      }
    }
    $total = ((int)(($quote->amount + $result) * 30));

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

    return view('payment.create', [
      'clientSecret' => $clientSecret,
      'intent' => $intent,
      'total' => $total,
      'acount' => $total * 30,
      'amount' =>  $total * 100,
      'customer' => $customer,
      'quote' => $quote,
    ]);
  }

  public function success(Request $request)
  {
    dd($request);
    return view('payment.success')->with('success', "Votre règlement a bien été enregistré");
  }
}
