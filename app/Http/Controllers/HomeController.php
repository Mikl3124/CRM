<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    return view('home');
  }

  public function dashboard()
  {
    $customers = Customer::all()->sortByDesc("created_at");
    return view('dashboard', compact('customers'));
  }

  public function access(Request $request)
  {
    return view('customer.home', compact('customer', 'projects'));
  }

  public function return()
  {
    return Redirect::back();
  }
}
