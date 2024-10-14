<?php

namespace App\Http\Controllers;


use App\Models\invoices_details;
use App\Models\invoices;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);
        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();
        $attachments = new invoice_attachments();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();

        $imagwName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imagwName);
        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoice_attachments = invoice_attachments::findOrFail($request->id_file);
        $invoice_attachments->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return back();
    }

    public function get_file(Request $request, $file_name)
    {

        return response()->download(public_path('Attachment/' . $file_name));
    }
}
