<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Furniture;

class FurnitureController extends Controller
{
    public function index(){

        $furniture = Furniture::latest()->get();

        return view('furniture.index',['furniture'=>$furniture]);
    }

    public function welcome(){

        $furniture = Furniture::latest()->get();

        return view('welcome',['furniture'=>$furniture]);
    }

    public function show($id){

        $furniture = Furniture::findOrFail($id);

        return view('furniture.show',['furniture'=>$furniture]);
    }

    

        public function store(Request $request) { 

            $furniture = new Furniture(); 

            $furniture->name = $request->input('name'); 
            $furniture->price = $request->input('price'); 
            $furniture->quantity = $request->input('quantity'); 
            $furniture->colors = $request->input('colors'); 
            $furniture->size = $request->input('size'); 

            if ($request->hasfile('image')) 
            { $file = $request->file('image'); 
            $extension = $file->getClientOriginalExtension(); // getting image extension 
            $filename = time() . "." . $extension; 
            $file->move('uploads/furniture/', $filename); 
            $furniture->image = $filename; 
            }else{
                
           return $request; 
           $furniture->image = ''; 
            } 
            

      $furniture->save();
     
     return redirect('furniture.create')->with('furniture',$furniture);
    }



    public function create(){

      return view('furniture.create');
    }


    public function destroy($id){

        $furniture = Furniture::findOrFail($id);

        $furniture->delete();

        return redirect('furniture')->with('mssg','Furniture Deleted');
    }


    public function edit($id){

        $furniture = Furniture::findOrFail($id);

        return view('furniture.edit')->with('furniture',$furniture);
    }

    
    public function update(Request $request,$id){

        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'colors' => 'required',
            'size' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg'
        ]);

        $furniture = Furniture::findOrFail($id);

        $furniture->name = $request->input('name'); 
        $furniture->price = $request->input('price'); 
        $furniture->quantity = $request->input('quantity'); 
        $furniture->colors = $request->input('colors'); 
        $furniture->size = $request->input('size'); 

        if ($request->hasfile('image')) 
        { $file = $request->file('image'); 
        $extension = $file->getClientOriginalExtension(); // getting image extension 
        $filename = time() . "." . $extension; 
        $file->move('uploads/furniture/', $filename); 
        $furniture->image = $filename; 
        }else{
            
       return $request; 
       $furniture->image = ''; 
        } 
        

  $furniture->save();
 
 return redirect('/furniture')->with('furniture',$furniture);
    }

    




}
