<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
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


        return view('dashboard');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('User.edit', ['user' => $user]);
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'workno' => 'required',
            'cellno' => 'required',
            'address' => 'required',

        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->cellno = $request->input('cellno');
        $user->workno = $request->input('workno');
        $user->address = $request->input('address');

        if (request()->hasFile('payslip')) {
            $file = request()->file('payslip');
            //            dd($file);
            $extension = $file->getClientOriginalExtension();
            $filename = $user->name . $user->email . '_' . $user->id . '.' . $extension;
            $file->move('payslip/' . $user->id . '/', $filename);
            $user->payslip = $filename;
            $user->save();
        }

        if (request()->hasFile('id_image')) {
            $file = request()->file('id_image');
            //            dd($file);
            $extension = $file->getClientOriginalExtension();
            $filename = $user->name . $user->email . '_' . $user->id . '.' . $extension;
            $file->move('id_image/' . $user->id . '/', $filename);
            $user->id_image = $filename;
            $user->save();
        }

        if (request()->hasFile('proof_of_res')) {
            $file = request()->file('proof_of_res');
            //            dd($file);
            $extension = $file->getClientOriginalExtension();
            $filename = $user->name . $user->email . '_' . $user->id . '.' . $extension;
            $file->move('proof_of_res/' . $user->id . '/', $filename);
            $user->proof_of_res = $filename;
            $user->save();
        }

        $user->save();

        return redirect('/dashboard')->with('user', $user);
    }
}
