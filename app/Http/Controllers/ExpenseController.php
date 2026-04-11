<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Client;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all(); // جلب جميع المصاريف
        $clients = Client::all(); // جلب جميع العملاء
        return view('expenses.index', compact('expenses', 'clients')); // تمرير البيانات إلى صفحة العرض
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'car_number' => 'required|string',
            'load_type' => 'required|string',
            'project_value' => 'required|numeric',
            'basic_value' => 'required|numeric',
            'transport_price' => 'required|numeric',
            'oman_khatmat_milah' => 'required|numeric',
            'sharjah_khatmat_milah' => 'required|numeric',
            'ras_dura' => 'required|numeric',
            'dura_oman' => 'required|numeric',
            'sharjah_daba' => 'required|numeric',
            'other_expenses' => 'required|numeric',
            'tarif' => 'required|numeric',
            'warad' => 'required|numeric',
            'total_paid_expenses' => 'required|numeric',
            'total_unpaid_expenses' => 'required|numeric',
            'net_amount' => 'required|numeric',
            'payment_status' => 'required|string',
            'invoice_number' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Expense::create($request->all()); // حفظ البيانات في قاعدة البيانات

        return redirect()->route('expenses.index')->with('success', 'تمت إضافة المصاريف بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'car_number' => 'required|string',
            'load_type' => 'required|string',
            'project_value' => 'required|numeric',
            'basic_value' => 'required|numeric',
            'transport_price' => 'required|numeric',
            'oman_khatmat_milah' => 'required|numeric',
            'sharjah_khatmat_milah' => 'required|numeric',
            'ras_dura' => 'required|numeric',
            'dura_oman' => 'required|numeric',
            'sharjah_daba' => 'required|numeric',
            'other_expenses' => 'required|numeric',
            'tarif' => 'required|numeric',
            'warad' => 'required|numeric',
            'total_paid_expenses' => 'required|numeric',
            'total_unpaid_expenses' => 'required|numeric',
            'net_amount' => 'required|numeric',
            'payment_status' => 'required|string',
            'invoice_number' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update($request->all()); // تحديث البيانات في قاعدة البيانات

        return redirect()->route('expenses.index')->with('success', 'تم تعديل المصاريف بنجاح!');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete(); // حذف المصاريف من قاعدة البيانات

        return redirect()->route('expenses.index')->with('success', 'تم حذف المصاريف بنجاح!');
    }
}
