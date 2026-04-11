@extends('layout.app')

@section('title', 'إدارة الوحدات')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">إدارة الوحدات</h2>
            <a href="{{ route('units.create') }}" class="btn btn-success btn-lg shadow">
                <i class="fas fa-plus-circle"></i> إضافة وحدة جديدة
            </a>
        </div>

        <div class="table-responsive shadow-lg rounded">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">اسم الوحدة</th>
                        <th scope="col" class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                        <tr>
                            <td class="align-middle">{{ $unit->name }}</td>
                            <td class="text-center align-middle">
                                <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning btn-sm mx-1 shadow-sm">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form action="{{ route('units.destroy', $unit->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1 shadow-sm" onclick="return confirm('هل أنت متأكد من حذف هذه الوحدة؟')">
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
@endsection

<style>
    .page-title {
        font-size: 2.75rem;
        color: #2c3e50;
        font-weight: 700;
        border-bottom: 3px solid #1abc9c;
        padding-bottom: 15px;
        margin-bottom: 25px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .btn-lg {
        font-size: 1.3rem;
        padding: 12px 30px;
        border-radius: 10px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-lg.shadow {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        background-color: #fdfdfd;
    }

    .table thead {
        background-color: #007bff;
        color: #ffffff;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f2f6;
    }

    .table td, .table th {
        vertical-align: middle;
        font-size: 1.15rem;
        padding: 18px;
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
        padding: 8px 15px;
        border-radius: 5px;
    }

    .shadow-sm {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .fas {
        margin-right: 7px;
    }
</style>
