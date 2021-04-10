<?php

namespace App\Http\Controllers {

  use App\Models\Project;

  use Illuminate\Support\Facades\Auth;

  use Illuminate\Support\Facades\Redirect;
  use Illuminate\Support\Facades\Validator;

  use App\Models\User;
  use App\Models\Customer;

  use Illuminate\Http\Request;

  class CustomerController extends Controller
  {
    public function create()
    {
      return view('customer.create');
    }

    public function show($id)
    {
      $customer = Customer::find($id);
      $projects = Project::where('customer_id', $customer->id)->get();

      if (($customer->user->id) === Auth::user()->id) {
        return view('customer.show', compact('customer', 'projects'));
      }
    }

    public function store(Request $request)
    {
      $customer = new Customer;
      $value = $request->all();

      $rules = [
        'email' => 'required | unique:customers',
      ];

      $validator = Validator::make($value, $rules, [
        'email.required' => "L'adresse email est obligatoire",
        'email.unique' => "Cette adresse email est déjà utilisée",
      ]);

      if ($validator->fails()) {

        return Redirect::back()
          ->withErrors($validator)
          ->withInput();
      } else {
        $customer->email = $request->email;
        $customer->user_id = Auth::user()->id;
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->zip = $request->zip;
        $customer->town = $request->town;

        $customer->save();
        return redirect()->route('dashboard')->with('success', "Le client a bien été ajouté");
      }
    }
  }
}
