@extends('layout.app')

@section('title', 'قائمة الفواتير')

@section('head')
    <!-- تضمين مكتبة Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dypFg+YSL+swNUCqydRkq6JDj/PHf/6OMJbLBZFsE+xgGTPKEheF5KHtbTL5y+i8Mueu9lc+CxRp10/C7LFf0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- تضمين خط Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap">
@endsection

@section('content')
    <div class="container mt-5">
        <h2 class="page-title text-center mb-5">قائمة الفواتير</h2>

        <div class="row justify-content-between mb-5 align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <!-- زر إضافة فاتورة جديدة في يسار الصفحة -->
                <a href="{{ route('invoices.create') }}" class="btn btn-lg shadow-lg btn-add-invoice w-100">
                    <i class="fas fa-plus-circle"></i> إضافة فاتورة جديدة
                </a>
            </div>
            <div class="col-md-8">
                <form action="{{ route('invoices.search') }}" method="GET" class="input-group shadow-sm">
                    <input type="text" name="query" placeholder="ابحث عن فاتورة برقم الفاتورة أو اسم العميل..." class="form-control form-control-lg rounded-left border-0 bg-light text-dark">
                    <button type="submit" class="btn btn-primary btn-lg rounded-right border-0">
                        <i class="fas fa-search"></i> بحث
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive shadow-lg rounded">
            <table class="table table-striped table-hover bg-white rounded overflow-hidden">
                <thead class="bg-gradient-primary text-white">
                    <tr class="text-uppercase">
                        <th scope="col">رقم الفاتورة</th>
                        <th scope="col">اسم العميل</th>
                        <th scope="col">الإجمالي</th>
                        <th scope="col">المبلغ المدفوع</th>
                        <th scope="col">المبلغ المتبقي</th>
                        <th scope="col">الحالة</th>
                        <th scope="col" class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr class="align-middle">
                            <td class="align-middle text-center">{{ $invoice->invoice_number }}</td>
                            <td class="align-middle">{{ $invoice->client ? $invoice->client->full_name : 'عميل غير معروف' }}</td>
                            <td class="align-middle text-success">{{ number_format($invoice->total_amount, 2) }} <i class="fas fa-dollar-sign"></i></td>
                            <td class="align-middle text-info">{{ number_format($invoice->paid_amount, 2) }} <i class="fas fa-hand-holding-usd"></i></td>
                            <td class="align-middle text-danger">{{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }} <i class="fas fa-money-bill-wave"></i></td>
                            <td class="align-middle text-center">
                                @if($invoice->paid_amount >= $invoice->total_amount)
                                    <span class="badge badge-pill badge-success shadow-sm">مدفوعة بالكامل</span>
                                @elseif($invoice->paid_amount > 0)
                                    <span class="badge badge-pill badge-partially-paid shadow-sm">مدفوعة جزئياً</span>
                                @else
                                    <span class="badge badge-pill badge-danger shadow-sm">غير مدفوعة</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning btn-icon mx-1 shadow-sm" title="تعديل">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-icon mx-1 shadow-sm" title="عرض">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon mx-1 shadow-sm" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟')">
                                            <i class="fas fa-trash-alt"></i> حذف
                                        </button>
                                    </form>
                                    <a href="{{ route('invoices.print', $invoice->id) }}" class="btn btn-secondary btn-icon mx-1 shadow-sm" title="طباعة">
                                        <i class="fas fa-print"></i> طباعة
                                    </a>
                                    <a href="{{ route('invoices.download', ['invoice' => $invoice->id, 'format' => 'pdf']) }}" class="btn btn-secondary btn-icon mx-1 shadow-sm" title="تنزيل PDF">
                                        <i class="fas fa-file-pdf"></i> تنزيل PDF
                                    </a>
                                    <a href="{{ route('invoices.download', ['invoice' => $invoice->id, 'format' => 'excel']) }}" class="btn btn-secondary btn-icon mx-1 shadow-sm" title="تنزيل Excel">
                                        <i class="fas fa-file-excel"></i> تنزيل Excel
                                    </a>
                                    @if($invoice->paid_amount < $invoice->total_amount)
                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-primary btn-icon mx-1 shadow-sm" title="تسديد دفعة">
                                            <i class="fas fa-money-bill-wave"></i> تسديد دفعة
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }

        .page-title {
            font-size: 2.75rem;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 40px;
            padding-bottom: 15px;
            position: relative;
        }

        .page-title::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 4px;
            background-color: #1abc9c;
            border-radius: 2px;
        }

        .input-group {
            display: flex;
            width: 100%;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .input-group .form-control {
            border: none;
            border-radius: 0;
            padding-left: 20px;
            font-size: 1.1rem;
        }

        .input-group .btn {
            border-radius: 0 50px 50px 0;
            background-color: #1abc9c;
            color: white;
            padding: 10px 20px;
            font-size: 1.1rem;
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            margin-top: 20px;
        }

        .table thead {
            background: linear-gradient(90deg, #1abc9c 0%, #16a085 100%);
            color: #ffffff;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.05em;
            font-size: 1rem;
        }

        .table-hover tbody tr:hover {
            background-color: #e8f8f5;
        }

        .table td, .table th {
            vertical-align: middle;
            font-size: 1.1rem;
            padding: 18px;
            transition: all 0.3s ease;
        }

        .btn-icon {
            padding: 10px 15px;
            font-size: 1rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-icon i {
            margin-right: 5px;
        }

        .btn-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .btn-add-invoice {
            background-color: #ff5e5e;
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.25rem;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-add-invoice::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 0, 0, 0.2);
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .btn-add-invoice:hover::before {
            opacity: 0;
        }

        .btn-add-invoice:hover {
            background-color: #ff3b3b;
            transform: scale(1.05);
        }

        .badge-pill {
            font-size: 1rem;
            padding: 0.5em 1.2em;
            border-radius: 50px;
            text-transform: capitalize;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #856404;
            background-image: linear-gradient(45deg, #fff3cd 25%, #ffeeba 100%);
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-partially-paid {
            background-color: #f0ad4e;
            background-image: linear-gradient(45deg, #f7c58f 25%, #f0ad4e 100%);
            color: white;
            font-weight: bold;
            padding: 0.4em 1.2em;
        }

        .fas {
            margin-right: 0;
        }
    </style>
@endsection
