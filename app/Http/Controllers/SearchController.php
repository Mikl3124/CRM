<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class SearchController extends Controller
{
  public function searchCustomer(Request $request)
  {
    $searchWord = $request->searchWord;
    if ($searchWord === null ){
      return redirect()->route('dashboard')->with('error', "Essaye de saisir au moins un mot ...");
    }

    $customers = Customer::where('firstname', 'LIKE', "%{$searchWord}%")
                          ->orWhere('lastname', 'LIKE', "%{$searchWord}%")
                          ->orWhere('email', 'LIKE', "%{$searchWord}%")->get();

    if($customers->count() > 0){
      return view('dashboard', compact('customers'));
    }else{
      return redirect()->route('dashboard',)->with('error', "Aucun client trouvé ...");
    }
  }
}

