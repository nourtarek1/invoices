<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\section;
use App\Models\proudects;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoices::all();

        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = section::all();
        return view('invoices.add_invoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Rate_VAT' => $request->Rate_VAT,
            'Value_VAT' => $request->Value_VAT,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'Total' => $request->Total,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_invoices' => $invoice_id,
            'Invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        if ($request->hasFile('pic')) {
            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $Invoice_number = $request->invoice_number;
            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $Invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();
            $imagwName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachment/' . $Invoice_number), $imagwName);
        }
        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();

        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $invoices = invoices::where('id', $id)->first();
        $sections = section::all();
        return view('invoices.edit_invoices', compact('sections', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {



        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $id_page = $request->id_page;
        if (!$id_page == 2) {
            $invoices->forceDelete();
            session()->flash('delete_invoice', 'تم تعديل الفاتورة بنجاح');
            return redirect('invoices');
        } else {
            $invoices->Delete();
            session()->flash('delete_Archive');
            return redirect('/Archive');
        }
    }
    public function getproduct($id)
    {

        $product = DB::table("proudects")->where("section_id", $id)->pluck("proudect_name", "id");

        return json_encode($product);
    }
    public function status_update($id, Request $request)
    {

        $invoices = invoices_details::find($id);


        if ($request->status === 'مدفوعه') {
            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'Payment_date' => $request->Payment_date,

            ]);
            invoices_details::create([
                'id_invoices' => $request->invoice_id,
                'Invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 1,
                'note' => $request->note,
                'Payment_date' => $request->Payment_date,
                'user' => (Auth::user()->name),


            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'Payment_date' => $request->Payment_date,

            ]);
            invoices_details::create([
                'id_invoices' => $request->invoice_id,
                'Invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 3,
                'note' => $request->note,
                'Payment_date' => $request->Payment_date,
                'user' => (Auth::user()->name),

            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }
    public function paid_bills()
    {
        $invoices = invoices::where('value_status', 1)->get();
        return view('invoices.paid_bills', compact('invoices'));
    }
    public function unpaid_bills()
    {
        $invoices = invoices::where('value_status', 2)->get();
        return view('invoices.unpaid_bills', compact('invoices'));
    }
    public function partially()
    {
        $invoices = invoices::where('value_status', 3)->get();
        return view('invoices.partially', compact('invoices'));
    }
}
