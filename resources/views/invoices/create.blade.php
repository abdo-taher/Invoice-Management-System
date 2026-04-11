@extends('layout.app')

@section('title', 'إضافة فاتورة جديدة')

@section('content')
    <div class="container mt-5">
        <h2 class="page-title text-center mb-5">إضافة فاتورة جديدة</h2>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
                            @csrf
                            
                            <!-- اختيار العميل -->
                            <div class="form-group mb-4">
                                <label for="client_id" class="form-label">اسم العميل:</label>
                                <select id="client_id" name="client_id" class="form-control form-control-lg custom-select" required>
                                    <option value="" disabled selected>اختر العميل...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- تفاصيل العميل -->
                            <div id="client-details" class="mb-4 p-3 rounded bg-light shadow-sm border">
                                <!-- سيتم تحميل تفاصيل العميل هنا بعد اختياره -->
                            </div>

                            <!-- رقم الفاتورة -->
                            <div class="form-group mb-4">
                                <label for="invoice_number" class="form-label">رقم الفاتورة:</label>
                                <div class="input-group">
                                    <input type="text" id="invoice_number" name="invoice_number" class="form-control form-control-lg" placeholder="أدخل رقم الفاتورة" required>
                                    <button type="button" class="btn btn-outline-secondary" id="generate-invoice-number">إنشاء رقم تلقائي</button>
                                </div>
                            </div>

                            <!-- تاريخ الفاتورة -->
                            <div class="form-group mb-4">
                                <label for="invoice_date" class="form-label">تاريخ الفاتورة:</label>
                                <input type="datetime-local" id="invoice_date" name="invoice_date" class="form-control form-control-lg" required>
                            </div>

                            <!-- بنود الفاتورة -->
                            <div id="invoice-items" class="mb-4">
                                <h4 class="mb-3">بنود الفاتورة</h4>
                                <div class="item-row mb-4 p-4 rounded bg-light shadow-sm border">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="service_name_0" class="form-label">اسم الخدمة:</label>
                                                <input type="text" id="service_name_0" name="items[0][service_name]" class="form-control form-control-lg" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="service_description_0" class="form-label">وصف الخدمة:</label>
                                                <input type="text" id="service_description_0" name="items[0][service_description]" class="form-control form-control-lg">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label for="unit_id_0" class="form-label">نوع الوحدة:</label>
                                                <select id="unit_id_0" name="items[0][unit_id]" class="form-control form-control-lg custom-select">
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label for="quantity_0" class="form-label">الكمية:</label>
                                                <input type="number" id="quantity_0" name="items[0][quantity]" class="form-control form-control-lg calculate-subtotal" data-index="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label for="price_0" class="form-label">السعر:</label>
                                                <input type="number" id="price_0" name="items[0][price]" class="form-control form-control-lg calculate-subtotal" data-index="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label for="discount_0" class="form-label">الخصم:</label>
                                                <input type="number" id="discount_0" name="items[0][discount]" class="form-control form-control-lg calculate-subtotal" data-index="0" placeholder="نسبة أو مبلغ" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="subtotal_0" class="form-label">الإجمالي الفرعي:</label>
                                        <input type="text" id="subtotal_0" name="items[0][subtotal]" class="form-control form-control-lg bg-light" readonly>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-item" class="btn btn-outline-secondary mb-4">إضافة بند جديد</button>

                            <!-- نوع الضريبة -->
                            <div class="form-group mb-4">
                                <label for="tax_id" class="form-label">نوع الضريبة:</label>
                                <select id="tax_id" name="tax_id" class="form-control form-control-lg custom-select" required>
                                    <option value="" disabled selected>اختر الضريبة...</option>
                                    @foreach($taxes as $tax)
                                        <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}">{{ $tax->name }} ({{ $tax->rate }}%)</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الإجمالي الكلي -->
                            <div class="form-group mb-4">
                                <label for="total_amount" class="form-label">الإجمالي الكلي:</label>
                                <input type="text" id="total_amount" name="total_amount" class="form-control form-control-lg bg-light" readonly>
                            </div>

                            <!-- المبلغ المدفوع -->
                            <div class="form-group mb-4">
                                <label for="paid_amount" class="form-label">المبلغ المدفوع:</label>
                                <input type="number" id="paid_amount" name="paid_amount" class="form-control form-control-lg">
                            </div>

                            <!-- زر إضافة الفاتورة -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-50">إضافة الفاتورة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f6f9;
        }
        .page-title {
            font-size: 2.5rem;
            color: #2c3e50;
            border-bottom: 3px solid #1abc9c;
            padding-bottom: 10px;
            font-weight: bold;
            margin-bottom: 50px;
        }
        .card {
            border-radius: 15px;
            background-color: #ffffff;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 50px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control-lg {
            font-size: 1.2rem;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control-lg:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 15px rgba(26, 188, 156, 0.25);
        }
        .custom-select {
            appearance: none;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgdmlld0JveD0iMCAwIDE2IDE2Ij4gPHBhdGggZmlsbD0iIzEyM2I2ZCIgZD0iTTEzLjM1NyA2LjE3NEw4IDExLjcwNyAyLjY0MyA2LjE3NEwxIDcuODg1IDggMTVtMCAwIi8+IDwvc3ZnPg==') no-repeat right 10px center;
            background-size: 16px;
            padding-right: 40px;
        }
        .btn-primary {
            background-color: #1abc9c;
            border-color: #1abc9c;
            font-size: 1.2rem;
            padding: 12px 30px;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #16a085;
            transform: translateY(-3px);
        }
        .btn-lg.w-50 {
            width: 60%;
        }
        .btn-outline-secondary {
            border-color: #ced4da;
            color: #333;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-outline-secondary:hover {
            background-color: #e2e6ea;
            transform: translateY(-3px);
        }
        .item-row {
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .select2-container--default .select2-selection--single {
            height: 50px;
            padding: 10px;
            border-radius: 10px;
            border-color: #ced4da;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = 1;

            function calculateTotal() {
                let totalAmount = 0;
                document.querySelectorAll('.item-row').forEach(function(row, index) {
                    const quantity = parseFloat(document.getElementById(`quantity_${index}`).value) || 0;
                    const price = parseFloat(document.getElementById(`price_${index}`).value) || 0;
                    const discount = parseFloat(document.getElementById(`discount_${index}`).value) || 0;
                    const subtotal = (quantity * price) - discount;
                    document.getElementById(`subtotal_${index}`).value = subtotal.toFixed(2);
                    totalAmount += subtotal;
                });
                const taxRate = parseFloat(document.getElementById('tax_id').selectedOptions[0].getAttribute('data-rate')) || 0;
                const taxAmount = totalAmount * (taxRate / 100);
                const grandTotal = totalAmount + taxAmount;
                document.getElementById('total_amount').value = grandTotal.toFixed(2);
            }

            document.addEventListener('input', function (event) {
                if (event.target.classList.contains('calculate-subtotal') || event.target.id === 'tax_id') {
                    calculateTotal();
                }
            });

            document.getElementById('add-item').addEventListener('click', function () {
                const itemRow = document.createElement('div');
                itemRow.classList.add('item-row', 'mb-4', 'p-4', 'rounded', 'bg-light', 'shadow-sm', 'border');
                itemRow.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="service_name_${itemIndex}" class="form-label">اسم الخدمة:</label>
                                <input type="text" id="service_name_${itemIndex}" name="items[${itemIndex}][service_name]" class="form-control form-control-lg" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="service_description_${itemIndex}" class="form-label">وصف الخدمة:</label>
                                <input type="text" id="service_description_${itemIndex}" name="items[${itemIndex}][service_description]" class="form-control form-control-lg">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="unit_id_${itemIndex}" class="form-label">نوع الوحدة:</label>
                                <select id="unit_id_${itemIndex}" name="items[${itemIndex}][unit_id]" class="form-control form-control-lg custom-select">
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="quantity_${itemIndex}" class="form-label">الكمية:</label>
                                <input type="number" id="quantity_${itemIndex}" name="items[${itemIndex}][quantity]" class="form-control form-control-lg calculate-subtotal" data-index="${itemIndex}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="price_${itemIndex}" class="form-label">السعر:</label>
                                <input type="number" id="price_${itemIndex}" name="items[${itemIndex}][price]" class="form-control form-control-lg calculate-subtotal" data-index="${itemIndex}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="discount_${itemIndex}" class="form-label">الخصم:</label>
                                <input type="number" id="discount_${itemIndex}" name="items[${itemIndex}][discount]" class="form-control form-control-lg calculate-subtotal" data-index="${itemIndex}" placeholder="نسبة أو مبلغ" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="subtotal_${itemIndex}" class="form-label">الإجمالي الفرعي:</label>
                        <input type="text" id="subtotal_${itemIndex}" name="items[${itemIndex}][subtotal]" class="form-control form-control-lg bg-light" readonly>
                    </div>
                `;
                document.getElementById('invoice-items').appendChild(itemRow);
                itemIndex++;
            });

            document.getElementById('generate-invoice-number').addEventListener('click', function () {
                const randomInvoiceNumber = 'INV-' + Math.floor(Math.random() * 1000000);
                document.getElementById('invoice_number').value = randomInvoiceNumber;
            });
        });
    </script>
@endsection
