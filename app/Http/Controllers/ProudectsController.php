<?php

namespace App\Http\Controllers;

use App\Models\proudects;
use App\Models\section;
use Illuminate\Http\Request;

class ProudectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
        $proudects = proudects::all();

        return view('section.proudects', compact('proudects', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        proudects::create([
            'proudect_name' => $request->proudect_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return redirect('/proudects');
    }

    /**
     * Display the specified resource.
     */
    public function show(proudects $proudects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(proudects $proudects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $id = section::where('section_name', $request->section_name)->first()->id;

        $products = proudects::findOrfail($request->pro_id);

        $products->update([
            'proudect_name' => $request->proudect_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('edit', 'تم تعديل القسم بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Products = proudects::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
