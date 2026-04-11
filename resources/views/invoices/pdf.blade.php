<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة رقم {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f4f4f4;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .header, .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .header h1 {
            margin: 0;
            font-size: 2.5em;
            color: #1abc9c;
            border-bottom: 2px solid #1abc9c;
            padding-bottom: 10px;
            flex-grow: 1;
            text-align: center;
        }

        .details p {
            margin: 5px 0;
            font-size: 1.1em;
            color: #34495e;
        }

        .details span {
            font-weight: bold;
            color: #1abc9c;
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
            background-color: #fafafa;
            border-radius: 10px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: right;
            font-size: 1.1em;
        }

        th {
            background-color: #1abc9c;
            color: white;
        }

        .total, .paid, .status {
            font-weight: bold;
        }

        .status span {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            background-color: #1abc9c;
        }

        .status .paid {
            background-color: #28a745;
        }

        .status .partially_paid {
            background-color: #ffc107;
        }

        .status .unpaid {
            background-color: #dc3545;
        }

        .footer {
            font-size: 1em;
            color: #95a5a6;
        }

        .button-print {
            background-color: #1abc9c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-size: 1em;
            display: inline-block;
        }

        .button-print:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>فاتورة رقم {{ $invoice->invoice_number }}</h1>
            <a href="#" class="button-print" onclick="window.print();return false;">طباعة الفاتورة</a>
        </div>
        
        <div class="details">
            <p><span>اسم العميل:</span> {{ $invoice->client->full_name }}</p>
            <p><span>تاريخ الفاتورة:</span> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y H:i') }}</p>
            <p><span>الإجمالي الكلي:</span> {{ number_format($invoice->total_amount, 2) }} ج.م</p>
            <p><span>المبلغ المدفوع:</span> {{ number_format($invoice->paid_amount, 2) }} ج.م</p>
            <p class="status"><span class="{{ $invoice->status }}">{{ $invoice->status == 'paid' ? 'مدفوعة بالكامل' : ($invoice->status == 'partially_paid' ? 'مدفوعة جزئياً' : 'غير مدفوعة') }}</span></p>

            <!-- تفاصيل الضريبة -->
            <p><span>الضريبة:</span> {{ $invoice->tax->name }} ({{ $invoice->tax->rate }}%)</p>
            <p><span>قيمة الضريبة:</span> {{ number_format($invoice->total_amount * ($invoice->tax->rate / 100), 2) }} ج.م</p>
        </div>
        
        <h4>بنود الفاتورة</h4>
        <table>
            <thead>
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
                        <td>{{ number_format($item->price, 2) }} ج.م</td>
                        <td>{{ number_format($item->discount, 2) }} ج.م</td>
                        <td>{{ number_format($item->subtotal, 2) }} ج.م</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>دفعات الفاتورة</h4>
        <table>
            <thead>
                <tr>
                    <th>المبلغ المدفوع</th>
                    <th>الرصيد المتبقي</th>
                    <th>تاريخ الدفع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->payments as $payment)
                    <tr>
                        <td>{{ number_format($payment->amount_paid, 2) }} ج.م</td>
                        <td>{{ number_format($payment->remaining_balance, 2) }} ج.م</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>جميع الحقوق محفوظة &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
