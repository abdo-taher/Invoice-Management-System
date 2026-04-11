@extends('layout.app')

@section('title', 'تعديل الفاتورة')

@section('content')
    <div class="container mt-5">
        <h2 class="page-title text-center mb-5">تعديل الفاتورة</h2>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-4">
                                <label for="client_name" class="form-label">اسم العميل:</label>
                                <input type="text" id="client_name" class="form-control form-control-lg" value="{{ $invoice->client->full_name }}" readonly>
                                <input type="hidden" name="client_id" value="{{ $invoice->client->id }}">
                            </div>

                            <div class="form-group mb-4">
                                <label for="invoice_number" class="form-label">رقم الفاتورة:</label>
                                <input type="text" id="invoice_number" class="form-control form-control-lg" value="{{ $invoice->invoice_number }}" readonly>
                            </div>

                            <div class="form-group mb-4">
                                <label for="invoice_date" class="form-label">تاريخ الفاتورة:</label>
                                <input type="datetime-local" id="invoice_date" name="invoice_date" class="form-control form-control-lg" value="{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d\TH:i') }}" required>
                            </div>

                            <div id="invoice-items" class="mb-4">
                                <h4 class="mb-3">بنود الفاتورة</h4>
                                @foreach($invoice->items as $index => $item)
                                    <div class="item-row bg-light p-3 mb-3 rounded shadow-sm">
                                        <div class="form-group mb-3">
                                            <label for="service_name_{{ $index }}" class="form-label">اسم الخدمة:</label>
                                            <input type="text" id="service_name_{{ $index }}" name="items[{{ $index }}][service_name]" class="form-control form-control-lg" value="{{ $item->service_name }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="service_description_{{ $index }}" class="form-label">وصف الخدمة:</label>
                                            <input type="text" id="service_description_{{ $index }}" name="items[{{ $index }}][service_description]" class="form-control form-control-lg" value="{{ $item->service_description }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="unit_id_{{ $index }}" class="form-label">نوع الوحدة:</label>
                                            <select id="unit_id_{{ $index }}" name="items[{{ $index }}][unit_id]" class="form-control form-control-lg">
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ $unit->id == $item->unit_id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="quantity_{{ $index }}" class="form-label">الكمية:</label>
                                            <input type="number" id="quantity_{{ $index }}" name="items[{{ $index }}][quantity]" class="form-control form-control-lg calculate-subtotal" data-index="{{ $index }}" value="{{ $item->quantity }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="price_{{ $index }}" class="form-label">السعر:</label>
                                            <input type="number" id="price_{{ $index }}" name="items[{{ $index }}][price]" class="form-control form-control-lg calculate-subtotal" data-index="{{ $index }}" value="{{ $item->price }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="discount_{{ $index }}" class="form-label">الخصم:</label>
                                            <input type="number" id="discount_{{ $index }}" name="items[{{ $index }}][discount]" class="form-control form-control-lg calculate-subtotal" data-index="{{ $index }}" value="{{ $item->discount ?? 0 }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="subtotal_{{ $index }}" class="form-label">الإجمالي الفرعي:</label>
                                            <input type="text" id="subtotal_{{ $index }}" name="items[{{ $index }}][subtotal]" class="form-control form-control-lg" value="{{ $item->subtotal }}" readonly>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group mb-4">
                                <button type="button" id="add-item" class="btn btn-secondary btn-lg">إضافة بند جديد</button>
                            </div>

                            <div class="form-group mb-4">
                                <label for="tax_id" class="form-label">نوع الضريبة:</label>
                                <select id="tax_id" name="tax_id" class="form-control form-control-lg" required>
                                    @foreach($taxes as $tax)
                                        <option value="{{ $tax->id }}" {{ $tax->id == $invoice->tax_id ? 'selected' : '' }}>{{ $tax->name }} ({{ $tax->rate }}%)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="total_amount" class="form-label">الإجمالي الكلي:</label>
                                <input type="text" id="total_amount" name="total_amount" class="form-control form-control-lg" value="{{ $invoice->total_amount }}" readonly>
                            </div>

                            <div class="form-group mb-4">
                                <label for="paid_amount" class="form-label">المبلغ المدفوع:</label>
                                <input type="number" id="paid_amount" name="paid_amount" class="form-control form-control-lg" value="{{ $invoice->paid_amount }}">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-50">تعديل الفاتورة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-title {
            font-size: 2.5rem;
            color: #2c3e50;
            border-bottom: 3px solid #1abc9c;
            padding-bottom: 10px;
            font-weight: bold;
        }
        .card {
            border-radius: 15px;
            background-color: #ffffff;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .form-control-lg {
            font-size: 1.25rem;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control-lg:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 10px rgba(26, 188, 156, 0.25);
        }
        .btn-primary {
            background-color: #1abc9c;
            border-color: #1abc9c;
            font-size: 1.2rem;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #16a085;
            transform: translateY(-2px);
        }
        .btn-lg.w-50 {
            width: 50%;
        }
        .item-row {
            margin-bottom: 1.5rem;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .item-row:last-child {
            margin-bottom: 0;
        }
        .item-row .form-group {
            margin-bottom: 1rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = {{ count($invoice->items) }};

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
                itemRow.classList.add('item-row', 'bg-light', 'p-3', 'mb-3', 'rounded', 'shadow-sm');
                itemRow.innerHTML = `
                    <div class="form-group mb-3">
                        <label for="service_name_${itemIndex}" class="form-label">اسم الخدمة:</label>
                        <input type="text" id="service_name_${itemIndex}" name="items[${itemIndex}][service_name]" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="service_description_${itemIndex}" class="form-label">وصف الخدمة:</label>
                        <input type="text" id="service_description_${itemIndex}" name="items[${itemIndex}][service_description]" class="form-control form-control-lg">
                    </div>
                    <div class="form-group mb-3">
                        <label for="unit_id_${itemIndex}" class="form-label">نوع الوحدة:</label>
                        <select id="unit_id_${itemIndex}" name="items[${itemIndex}][unit_id]" class="form-control form-control-lg">
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="quantity_${itemIndex}" class="form-label">الكمية:</label>
                        <input type="number" id="quantity_${itemIndex}" name="items[${itemIndex}][quantity]" class="form-control form-control-lg calculate-subtotal" data-index="${itemIndex}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="price_${itemIndex}" class="form-label">السعر:</label>
                        <input type="number" id="price_${itemIndex}" name="items[${itemIndex}][price]" class="form-control form-control-lg calculate-subtotal" data-index="${itemIndex}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="discount_${itemIndex}" class="form-label">الخصم:</label>
                        <input type="number" id="discount_${itemIndex}" name="items[${itemIndex}][discount]" class="form-control form-control-lg calculate-subtotal" data-index="${itemIndex}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="subtotal_${itemIndex}" class="form-label">الإجمالي الفرعي:</label>
                        <input type="text" id="subtotal_${itemIndex}" name="items[${itemIndex}][subtotal]" class="form-control form-control-lg" readonly>
                    </div>
                `;
                document.getElementById('invoice-items').appendChild(itemRow);
                itemIndex++;
            });

            calculateTotal();
        });
    </script>
@endsection
