<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crossover;

class CrossoverController extends Controller
{
    public function show()
    {
        $crossovers = Crossover::all(); // جلب جميع بيانات العبور من قاعدة البيانات
        return view('crossover', compact('crossovers')); // تمرير البيانات إلى صفحة العرض
    }

    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required|string',
            'manufacture' => 'required|string',
            'civil_number' => 'required|string',
            'driver_name' => 'required|string',
            'from_province' => 'required|string',
            'to_province' => 'required|string',
            'truck_code' => 'required|string',
            'truck_number' => 'required|string',
            'company_name' => 'required|string',
            'invoice_number' => 'required|string',
            'shipment_date' => 'required|date',
            // الحقول الجديدة
            'chassis_number' => 'required|string',
            'origin' => 'required|string',
            'color' => 'required|string',
            'vehicle_type' => 'required|string',
            'plate_type' => 'required|string',
            'plate_code' => 'required|string',
            'plate_number' => 'required|string',
        ]);

        Crossover::create($request->all()); // حفظ البيانات في قاعدة البيانات

        return redirect()->route('crossover')->with('success', 'تمت إضافة العبور بنجاح!');
    }

    public function edit($id)
    {
        $crossover = Crossover::findOrFail($id); // البحث عن العبور باستخدام المعرف
        return view('crossover_edit', compact('crossover')); // تمرير بيانات العبور إلى صفحة التعديل
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'weight' => 'required|string',
            'manufacture' => 'required|string',
            'civil_number' => 'required|string',
            'driver_name' => 'required|string',
            'from_province' => 'required|string',
            'to_province' => 'required|string',
            'truck_code' => 'required|string',
            'truck_number' => 'required|string',
            'company_name' => 'required|string',
            'invoice_number' => 'required|string',
            'shipment_date' => 'required|date',
            // الحقول الجديدة
            'chassis_number' => 'required|string',
            'origin' => 'required|string',
            'color' => 'required|string',
            'vehicle_type' => 'required|string',
            'plate_type' => 'required|string',
            'plate_code' => 'required|string',
            'plate_number' => 'required|string',
        ]);

        $crossover = Crossover::findOrFail($id);
        $crossover->update($request->all()); // تحديث البيانات في قاعدة البيانات

        return redirect()->route('crossover')->with('success', 'تم تعديل العبور بنجاح!');
    }

    public function destroy($id)
    {
        $crossover = Crossover::findOrFail($id);
        $crossover->delete(); // حذف العبور من قاعدة البيانات

        return redirect()->route('crossover')->with('success', 'تم حذف العبور بنجاح!');
    }
}
