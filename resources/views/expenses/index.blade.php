@extends('layout.app')

@section('title', 'إدارة المصاريف')

@section('content')
<div class="container mt-5">
    <h2 class="page-title text-center mb-5">إدارة المصاريف</h2>

    <div class="row justify-content-between mb-5 align-items-center">
        <div class="col-md-4 mb-3 mb-md-0">
            <!-- زر إضافة مصاريف جديدة -->
            <button class="btn btn-lg shadow-lg btn-add-expense w-100" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                <i class="fas fa-plus-circle"></i> إضافة مصاريف جديدة
            </button>
        </div>
    </div>

    <!-- جدول عرض المصاريف -->
    <div class="table-responsive shadow-lg rounded">
        <table class="table table-striped table-hover bg-white rounded overflow-hidden">
            <thead class="bg-gradient-primary text-white">
                <tr class="text-uppercase">
                    <th scope="col">التاريخ</th>
                    <th scope="col">اسم العميل</th>
                    <th scope="col">رقم السيارة</th>
                    <th scope="col">نوع الحمولة</th>
                    <th scope="col">قيمة المشروع</th>
                    <th scope="col">حالة الدفع</th>
                    <th scope="col" class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr class="align-middle">
                        <td class="align-middle">{{ $expense->date }}</td>
                        <td class="align-middle">{{ $expense->client->name }}</td>
                        <td class="align-middle">{{ $expense->car_number }}</td>
                        <td class="align-middle">{{ $expense->load_type }}</td>
                        <td class="align-middle">{{ $expense->project_value }}</td>
                        <td class="align-middle">{{ $expense->payment_status }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editExpenseModal{{ $expense->id }}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('هل أنت متأكد من حذف هذه المصاريف؟')">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                    <!-- نافذة تعديل المصاريف -->
                    <div class="modal fade" id="editExpenseModal{{ $expense->id }}" tabindex="-1" aria-labelledby="editExpenseModalLabel{{ $expense->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editExpenseModalLabel{{ $expense->id }}">تعديل المصاريف</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="date{{ $expense->id }}" class="form-label">التاريخ</label>
                                                <input type="date" class="form-control" id="date{{ $expense->id }}" name="date" value="{{ $expense->date }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="client_id{{ $expense->id }}" class="form-label">اسم العميل</label>
                                                <select class="form-control" id="client_id{{ $expense->id }}" name="client_id" required>
                                                    @foreach($clients as $client)
                                                        <option value="{{ $client->id }}" {{ $client->id == $expense->client_id ? 'selected' : '' }}>{{ $client->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- أضف هنا الحقول الأخرى المطلوبة كما في نافذة الإضافة -->
                                            <!-- (رقم السيارة، نوع الحمولة، إلخ...) -->
                                        </div>
                                        <div class="modal-footer mt-3">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                            <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- نهاية نافذة التعديل -->
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- نافذة إضافة مصاريف جديدة -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">إضافة مصاريف جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">التاريخ</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="client_id" class="form-label">اسم العميل</label>
                            <select class="form-control" id="client_id" name="client_id" required>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="car_number" class="form-label">رقم السيارة</label>
                            <input type="text" class="form-control" id="car_number" name="car_number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="load_type" class="form-label">نوع الحمولة</label>
                            <input type="text" class="form-control" id="load_type" name="load_type" required>
                        </div>
                        <div class="col-md-6">
                            <label for="project_value" class="form-label">قيمة المشروع</label>
                            <input type="number" class="form-control" id="project_value" name="project_value" required>
                        </div>
                        <div class="col-md-6">
                            <label for="basic_value" class="form-label">القيمة الأساسية</label>
                            <input type="number" class="form-control" id="basic_value" name="basic_value" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transport_price" class="form-label">سعر النقل</label>
                            <input type="number" class="form-control" id="transport_price" name="transport_price" required>
                        </div>
                        <div class="col-md-6">
                            <label for="oman_khatmat_milah" class="form-label">عمان خطمة ملاحة</label>
                            <input type="number" class="form-control" id="oman_khatmat_milah" name="oman_khatmat_milah" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sharjah_khatmat_milah" class="form-label">الشارقة خطمة ملاحة</label>
                            <input type="number" class="form-control" id="sharjah_khatmat_milah" name="sharjah_khatmat_milah" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ras_dura" class="form-label">رأس الدرة</label>
                            <input type="number" class="form-control" id="ras_dura" name="ras_dura" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dura_oman" class="form-label">الدرة عمان</label>
                            <input type="number" class="form-control" id="dura_oman" name="dura_oman" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sharjah_daba" class="form-label">الشارقة دبا</label>
                            <input type="number" class="form-control" id="sharjah_daba" name="sharjah_daba" required>
                        </div>
                        <div class="col-md-6">
                            <label for="other_expenses" class="form-label">مصاريف أخرى</label>
                            <input type="number" class="form-control" id="other_expenses" name="other_expenses" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tarif" class="form-label">التفاريغ</label>
                            <input type="number" class="form-control" id="tarif" name="tarif" required>
                        </div>
                        <div class="col-md-6">
                            <label for="warad" class="form-label">الوراد</label>
                            <input type="number" class="form-control" id="warad" name="warad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="total_paid_expenses" class="form-label">إجمالي المصاريف (مدفوع)</label>
                            <input type="number" class="form-control" id="total_paid_expenses" name="total_paid_expenses" required>
                        </div>
                        <div class="col-md-6">
                            <label for="total_unpaid_expenses" class="form-label">إجمالي المصاريف (غير مدفوع)</label>
                            <input type="number" class="form-control" id="total_unpaid_expenses" name="total_unpaid_expenses" required>
                        </div>
                        <div class="col-md-6">
                            <label for="net_amount" class="form-label">الصافي</label>
                            <input type="number" class="form-control" id="net_amount" name="net_amount" required>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_status" class="form-label">حالة الدفع</label>
                            <select class="form-control" id="payment_status" name="payment_status" required>
                                <option value="مدفوع">مدفوع</option>
                                <option value="غير مدفوع">غير مدفوع</option>
                                <option value="جزئي">جزئي</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="invoice_number" class="form-label">رقم الفاتورة</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
