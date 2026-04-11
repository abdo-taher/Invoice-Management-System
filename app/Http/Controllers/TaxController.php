<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::all();
        return view('taxes.index', compact('taxes'));
    }

    public function create()
    {
        return view('taxes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|between:0,100',
        ]);

        Tax::create($request->only(['name', 'rate']));

        return redirect()->route('taxes.index')->with('success', 'تم إضافة الضريبة بنجاح');
    }

    public function edit(Tax $tax)
    {
        return view('taxes.edit', compact('tax'));
    }

    public function update(Request $request, Tax $tax)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|between:0,100',
        ]);

        $tax->update($request->only(['name', 'rate']));

        return redirect()->route('taxes.index')->with('success', 'تم تعديل بيانات الضريبة بنجاح');
    }

    public function destroy(Tax $tax)
    {
        $tax->delete();

        return redirect()->route('taxes.index')->with('success', 'تم حذف الضريبة بنجاح');
    }
}
