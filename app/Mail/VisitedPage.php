<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitedPage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $customer;
    public $page;

    public function __construct($page, $customer)
    {
      $this->customer = $customer;
      $this->page = $page;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $customer = $this->customer;
      $page = $this->page;
      return $this->from('contact@nyleo.fr', 'Nyleo Conception')
        ->subject("Page visitée")
        ->view('emails.visited-page');
    }
}
