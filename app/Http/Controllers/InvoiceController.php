<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
