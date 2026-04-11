<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Client;
use App\Models\Unit;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf; // تأكد من تضمين مكتبة mPDF

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('client')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $clients = Client::all();
        $units = Unit::all();
        $taxes = Tax::all();
        return view('invoices.create', compact('clients', 'units', 'taxes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'items.*.service_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0', // إضافة حقل الخصم للبند
            'tax_id' => 'required|exists:taxes,id',
            'total_discount' => 'nullable|numeric|min:0', // إضافة حقل الخصم الإجمالي للفاتورة
        ]);

        DB::transaction(function () use ($request) {
            $invoice = Invoice::create([
                'client_id' => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'tax_id' => $request->tax_id, // تأكد من تضمين tax_id هنا
                'total_discount' => $request->total_discount ?? 0, // حفظ الخصم الإجمالي
                'total_amount' => 0, // سيتم تحديثه لاحقًا
                'paid_amount' => $request->paid_amount ?? 0,
                'status' => 'unpaid',
            ]);

            $totalAmount = 0;

            foreach ($request->items as $itemData) {
                $subtotal = $itemData['quantity'] * $itemData['price'];

                // حساب الخصم للبند
                if (isset($itemData['discount']) && $itemData['discount'] > 0) {
                    $subtotal -= $itemData['discount'];
                }

                $totalAmount += $subtotal;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_name' => $itemData['service_name'],
                    'service_description' => $itemData['service_description'] ?? '',
                    'unit_id' => $itemData['unit_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'discount' => $itemData['discount'] ?? 0, // حفظ الخصم للبند
                    'subtotal' => $subtotal,
                ]);
            }

            // خصم إجمالي الفاتورة
            if ($invoice->total_discount > 0) {
                $totalAmount -= $invoice->total_discount;
            }

            $tax = Tax::find($request->tax_id);
            $totalAmount += $totalAmount * ($tax->rate / 100);

            $remainingBalance = $totalAmount - $invoice->paid_amount;

            $invoice->update([
                'total_amount' => $totalAmount,
                'status' => $remainingBalance <= 0 ? 'paid' : ($remainingBalance > 0 && $invoice->paid_amount > 0 ? 'partially_paid' : 'unpaid'),
            ]);
        });

        return redirect()->route('invoices.index')->with('success', 'تم إضافة الفاتورة بنجاح.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('client', 'items.unit', 'payments');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::all();
        $units = Unit::all();
        $taxes = Tax::all();
        $invoice->load('items');
        return view('invoices.edit', compact('invoice', 'clients', 'units', 'taxes'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $invoice->id,
            'invoice_date' => 'required|date',
            'items.*.service_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0', // إضافة حقل الخصم للبند
            'tax_id' => 'required|exists:taxes,id',
            'total_discount' => 'nullable|numeric|min:0', // إضافة حقل الخصم الإجمالي للفاتورة
        ]);

        DB::transaction(function () use ($request, $invoice) {
            $invoice->update([
                'client_id' => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'total_discount' => $request->total_discount ?? 0, // تحديث الخصم الإجمالي
                'total_amount' => 0, // سيتم تحديثه لاحقًا
                'paid_amount' => $request->paid_amount ?? 0,
                'status' => 'unpaid',
            ]);

            $invoice->items()->delete();

            $totalAmount = 0;

            foreach ($request->items as $itemData) {
                $subtotal = $itemData['quantity'] * $itemData['price'];

                // حساب الخصم للبند
                if (isset($itemData['discount']) && $itemData['discount'] > 0) {
                    $subtotal -= $itemData['discount'];
                }

                $totalAmount += $subtotal;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_name' => $itemData['service_name'],
                    'service_description' => $itemData['service_description'] ?? '',
                    'unit_id' => $itemData['unit_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'discount' => $itemData['discount'] ?? 0, // حفظ الخصم للبند
                    'subtotal' => $subtotal,
                ]);
            }

            // خصم إجمالي الفاتورة
            if ($invoice->total_discount > 0) {
                $totalAmount -= $invoice->total_discount;
            }

            $tax = Tax::find($request->tax_id);
            $totalAmount += $totalAmount * ($tax->rate / 100);

            $remainingBalance = $totalAmount - $invoice->paid_amount;

            $invoice->update([
                'total_amount' => $totalAmount,
                'status' => $remainingBalance <= 0 ? 'paid' : ($remainingBalance > 0 && $invoice->paid_amount > 0 ? 'partially_paid' : 'unpaid'),
            ]);
        });

        return redirect()->route('invoices.index')->with('success', 'تم تعديل الفاتورة بنجاح.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة بنجاح.');
    }

    public function print(Invoice $invoice)
    {
        // إعداد mPDF
        $mpdf = new Mpdf([
            'default_font' => 'Cairo',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);

        // توليد HTML من عرض Blade
        $html = view('invoices.pdf', compact('invoice'))->render();

        // كتابة HTML إلى PDF
        $mpdf->WriteHTML($html);

        // عرض PDF في المتصفح
        return $mpdf->Output('invoice.pdf', 'I'); // 'I' يعني العرض في المتصفح
    }

    public function download(Invoice $invoice, $format)
    {
        if ($format == 'pdf') {
            $mpdf = new Mpdf([
                'default_font' => 'Cairo',
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
            ]);

            $html = view('invoices.pdf', compact('invoice'))->render();

            $mpdf->WriteHTML($html);

            return $mpdf->Output('invoice.pdf', 'D'); // 'D' يعني التنزيل كملف
        } elseif ($format == 'excel') {
            // قم بتنزيل الفاتورة بتنسيق Excel (يمكن استخدام مكتبة مثل Maatwebsite Excel)
        }

        return redirect()->back()->with('error', 'تنسيق غير مدعوم.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $invoices = Invoice::where('invoice_number', 'LIKE', "%$query%")
                    ->orWhereHas('client', function($q) use ($query) {
                        $q->where('full_name', 'LIKE', "%$query%");
                    })->get();

        return view('invoices.index', compact('invoices'));
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01|max:' . ($invoice->total_amount - $invoice->paid_amount),
        ]);

        DB::transaction(function () use ($request, $invoice) {
            $remainingBalance = $invoice->total_amount - $invoice->paid_amount - $request->amount_paid;

            InvoicePayment::create([
                'invoice_id' => $invoice->id,
                'amount_paid' => $request->amount_paid,
                'remaining_balance' => $remainingBalance,
                'payment_date' => now(),
            ]);

            $invoice->paid_amount += $request->amount_paid;
            $invoice->status = $remainingBalance <= 0 ? 'paid' : ($remainingBalance > 0 && $invoice->paid_amount > 0 ? 'partially_paid' : 'unpaid');
            $invoice->save();
        });

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'تم إضافة الدفعة بنجاح.');
    }
}
