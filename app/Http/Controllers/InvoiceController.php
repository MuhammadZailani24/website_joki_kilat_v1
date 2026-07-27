<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Memanggil fungsi PDF

class InvoiceController extends Controller
{
    public function download($id)
    {
        // Cari data order milik user yang sedang login
        $order = Order::with('user')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Menyusun tampilan (view) ke dalam format PDF
        $pdf = Pdf::loadView('order.invoice', compact('order'));
        
        // Mengatur ukuran kertas (A4)
        $pdf->setPaper('a4', 'portrait');

        // Mengunduh file PDF secara otomatis
        return $pdf->download('Invoice_JokiKilat_Order_'.$order->id.'.pdf');
    }
}