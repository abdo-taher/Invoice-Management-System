@extends('layout.app')

@section('title', 'إدارة الضرائب')

@section('content')
    <div class="container-fluid mt-5">
        <h2 class="page-title text-center mb-5">إدارة الضرائب</h2>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('taxes.create') }}" class="btn btn-success btn-lg shadow">
                <i class="fas fa-plus-circle"></i> إضافة ضريبة جديدة
            </a>
        </div>

        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-hover table-bordered bg-white">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">اسم الضريبة</th>
                        <th scope="col">معدل الضريبة (%)</th>
                        <th scope="col" class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taxes as $tax)
                        <tr>
                            <td>{{ $tax->name }}</td>
                            <td>{{ $tax->rate }}%</td>
                            <td class="text-center">
                                <a href="{{ route('taxes.edit', $tax->id) }}" class="btn btn-warning btn-sm mx-1 shadow-sm">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form action="{{ route('taxes.destroy', $tax->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1 shadow-sm" onclick="return confirm('هل أنت متأكد من حذف هذه الضريبة؟')">
                                        <i class="fas fa-trash-alt"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            background-color: #f7f8fc;
            color: #2c3e50;
            font-family: 'Tajawal', sans-serif;
        }

        .page-title {
            font-size: 2.75rem;
            color: #2c3e50;
            font-weight: 700;
            border-bottom: 4px solid #1abc9c;
            padding-bottom: 15px;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-lg {
            padding: 12px 30px;
            font-size: 1.3rem;
            border-radius: 50px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-lg.shadow {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .table-responsive {
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table thead {
            background-color: #007bff;
            color: #ffffff;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td, .table th {
            vertical-align: middle;
            font-size: 1.2rem;
            padding: 20px;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f2f6;
        }

        .btn-warning {
            background-color: #f39c12;
            border-color: #e67e22;
            color: #ffffff;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e67e22;
            border-color: #d35400;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-danger {
            background-color: #e74c3c;
            border-color: #c0392b;
            color: #ffffff;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #a93226;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-sm {
            font-size: 1rem;
            padding: 8px 20px;
            border-radius: 50px;
        }

        .shadow-sm {
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .fas {
            margin-right: 7px;
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
@endsection
