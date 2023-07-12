<?php

namespace App\Http\Controllers;
use App\Models\Topping;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Topping::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);
        return Topping::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Topping::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $topping = Topping::find($id);
        $topping->update($request->all());
        return $topping;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       return Topping::destroy($id);
    }

    /**
     * Search for a name.
     * @param str $name
     * @return \Illuminate\Http\Response
     */
    public function search(string $name)
    {
       return Topping::where('name', 'like', '%'.$name.'%')->get();
    }
}
