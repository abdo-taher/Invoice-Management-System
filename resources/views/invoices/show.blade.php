@extends('layout.app')

@section('title', 'تفاصيل الفاتورة')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">تفاصيل الفاتورة</h2>
            <div>
                <a href="{{ route('invoices.print', $invoice->id) }}" class="btn btn-secondary btn-lg mx-2">
                    <i class="fas fa-print"></i> طباعة الفاتورة
                </a>
                <a href="{{ route('invoices.download', ['invoice' => $invoice->id, 'format' => 'pdf']) }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-file-pdf"></i> تنزيل PDF
                </a>
            </div>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h4 class="mb-4">رقم الفاتورة: <span class="text-primary">{{ $invoice->invoice_number }}</span></h4>
                <p><strong>اسم العميل:</strong> {{ $invoice->client->full_name }}</p>
                <p><strong>تاريخ الفاتورة:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d H:i') }}</p>
                <p><strong>الإجمالي الكلي:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
                <p><strong>المبلغ المدفوع:</strong> {{ number_format($invoice->paid_amount, 2) }}</p>
                <p><strong>الحالة:</strong> 
                    <span class="badge badge-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'partially_paid' ? 'warning' : 'danger') }}">
                        {{ $invoice->status == 'paid' ? 'مدفوعة بالكامل' : ($invoice->status == 'partially_paid' ? 'مدفوعة جزئياً' : 'غير مدفوعة') }}
                    </span>
                </p>

                <!-- عرض تفاصيل الضريبة -->
                <p><strong>الضريبة:</strong> {{ $invoice->tax->name }} ({{ $invoice->tax->rate }}%)</p>
                <p><strong>قيمة الضريبة:</strong> {{ number_format($invoice->total_amount * ($invoice->tax->rate / 100), 2) }}</p>
            </div>
        </div>

        <div class="mt-4">
            <h4 class="mb-3">بنود الفاتورة</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>اسم الخدمة</th>
                            <th>وصف الخدمة</th>
                            <th>نوع الوحدة</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الخصم</th>
                            <th>الإجمالي الفرعي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->service_name }}</td>
                                <td>{{ $item->service_description }}</td>
                                <td>{{ $item->unit->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ number_format($item->discount, 2) }}</td>
                                <td>{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h4 class="mb-3">دفعات الفاتورة</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>المبلغ المدفوع</th>
                            <th>الرصيد المتبقي</th>
                            <th>تاريخ الدفع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->payments as $payment)
                            <tr>
                                <td>{{ number_format($payment->amount_paid, 2) }}</td>
                                <td>{{ number_format($payment->remaining_balance, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($invoice->status != 'paid')
            <div class="mt-5">
                <h4 class="mb-3">إضافة دفعة جديدة</h4>
                <form action="{{ route('invoices.addPayment', $invoice->id) }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="amount_paid" class="form-label">المبلغ المراد تسديده:</label>
                        <input type="number" id="amount_paid" name="amount_paid" class="form-control form-control-lg" placeholder="أدخل المبلغ" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg">تسديد الدفعة</button>
                </form>
            </div>
        @endif
    </div>

    <style>
        .page-title {
            font-size: 2.5rem;
            color: #2c3e50;
            font-weight: bold;
            border-bottom: 3px solid #1abc9c;
            padding-bottom: 10px;
        }
        .card {
            border-radius: 10px;
            background-color: #ffffff;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 40px;
        }
        .badge {
            font-size: 1rem;
            padding: 10px 15px;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .table {
            margin-bottom: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .btn-lg {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .fas {
            margin-right: 5px;
        }
    </style>
@endsection
