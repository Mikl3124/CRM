<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteAccepted extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */

  public $quote;
  public $customer;

  public function __construct($quote, $customer)
  {
    $this->quote = $quote;
    $this->customer = $customer;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $customer = $this->customer;
    return $this->from('contact@nyleo.fr', 'Nyleo Conception')
      ->subject("Devis Accepté")
      ->view('emails.accepted-quote');
  }
}
