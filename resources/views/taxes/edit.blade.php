@extends('layout.app')

@section('title', 'تعديل الضريبة')

@section('content')
    <div class="container mt-5">
        <h2 class="page-title text-center mb-5">تعديل الضريبة</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <form action="{{ route('taxes.update', $tax->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-4">
                                <label for="name" class="form-label">اسم الضريبة:</label>
                                <input type="text" id="name" name="name" class="form-control form-control-lg" value="{{ $tax->name }}" required>
                            </div>
                            <div class="form-group mb-5">
                                <label for="rate" class="form-label">معدل الضريبة (%):</label>
                                <input type="number" id="rate" name="rate" class="form-control form-control-lg" value="{{ $tax->rate }}" step="0.01" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-50">تعديل الضريبة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f7f8fc; /* لون خلفية أكثر نعومة */
        }
        .page-title {
            font-size: 2.75rem;
            color: #34495e;
            border-bottom: 4px solid #1abc9c;
            padding-bottom: 10px;
            font-weight: 700;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .card {
            border-radius: 15px; /* زوايا أكثر نعومة */
            background-color: #ffffff;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* زيادة الظلال لجعل التصميم أكثر جاذبية */
        }
        .card-body {
            padding: 50px; /* زيادة التباعد الداخلي لجعل التصميم أكثر راحة */
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.2rem; /* زيادة حجم النص */
        }
        .form-control-lg {
            font-size: 1.25rem;
            padding: 20px; /* زيادة التباعد الداخلي */
            border-radius: 10px; /* زوايا أكثر نعومة */
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control-lg:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 15px rgba(26, 188, 156, 0.25); /* تحسين تأثير الفوكس */
        }
        .btn-primary {
            background-color: #1abc9c;
            border-color: #1abc9c;
            font-size: 1.3rem;
            padding: 15px 30px;
            border-radius: 10px; /* زوايا أكثر نعومة */
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #16a085;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(22, 160, 133, 0.2); /* تحسين تأثير التحويم */
        }
        .btn-lg.w-50 {
            width: 50%;
        }
    </style>
@endsection
