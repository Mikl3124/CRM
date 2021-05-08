<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Interaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InteractionController extends Controller
{
    public function store(Request $request)
    {
        $interaction = new Interaction;
        $value = $request->all();

        $rules = [
            'date' => 'required',
        ];

        $validator = Validator::make($value, $rules, [
        ]);

        if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $interaction->created_at = $request->date;
            $interaction->customer_id = $request->customer_id;
            $interaction->canal = $request->canal;
            $interaction->content = $request->content;

            $interaction->save();

            return redirect()->route('customer.show', $interaction->customer_id)->with('success', "L'interaction a bien été ajouté");
        }
    }

    public function list($id)
    {
        $customer = Customer::find($id);
        $interactions = Interaction::where('customer_id', $id)->get();

        return view('interaction.list', compact('interactions', 'customer'));
    }
}
