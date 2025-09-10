<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
    public function getProduct()
    {
        return Product::get();
    }
}
