<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function invoiceList()
    {
        return view('invoice.invoiceList');
    }
    public function showInvoiceForm()
    {
        return view('invoice.invoice');
    }

    public function getAllInvoice(Request $request)
    {
        $length = $request->input('length');
        $start  = $request->input('start');
        $search = $request->input('search.value');

        $query = Invoice::with('user');

        $recordsTotal = $query->count();

        $invoices = $query->when($search, function ($query) use ($search) {
            $query->where('customer_name', 'like', "%{$search}%")
                ->orWhere('customer_email', 'like', "%{$search}%")
                ->orWhereHas('user', function ($query2) use ($search) {
                    $query2->where('userName', 'like', "%{$search}%");
                });
        })->get();

        $recordsFiltered = $query->count();

        $invoices = $query->skip($start)->take($length)->get();

        $data = $invoices->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'customer_name' => $invoice->customer_name,
                'customer_email' => $invoice->customer_email,
                'user' => $invoice->user->userName,
                'action' => '
                    <a href="' . route('showInvoiceForm', [$invoice->id]) . '" 
                       class="btn btn-success btn-sm text-white">Edit</a>
                    <button type="button" data-id="' . $invoice->id . '" 
                       class="btn btn-danger btn-sm text-white delete_btn">Delete</button>
                ',
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function addInvoice(Request $request)
    {
        $validation = $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required',
            'product_option' => 'required',
            'quantity' => 'required',
        ]);

        $invoice = Invoice::create([
            'customer_name' => $validation['customer_name'],
            'customer_email' => $validation['customer_email'],
            'user_id' => Auth::id(),
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'tax' => $request->tax,
            'shipping' => $request->shipping,
            'total' => $request->total,
        ]);

        foreach ($request->product_option as $index => $product_id) :
            $invoiceItem = new InvoiceItem;
            $invoiceItem->quantity = $validation['quantity'][$index];
            $invoiceItem->amount =  $request->amount[$index];
            $invoiceItem->product_id = $product_id;

            $invoiceItem->invoice_id = $invoice->id;

            $invoiceItem->save();
        endforeach;

        return redirect()->route('showInvoiceList');
    }
    public function getProduct()
    {
        return Product::get();
    }

    public function deleteInvoice($id)
    {
        return Invoice::where('id', $id)->delete();
    }
}
