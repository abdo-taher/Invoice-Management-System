@extends('layout.app')

@section('title', 'إضافة وحدة جديدة')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="page-title text-center mb-4">إضافة وحدة جديدة</h2>

            <form action="{{ route('units.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" class="form-label">اسم الوحدة:</label>
                    <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="أدخل اسم الوحدة" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg">إضافة</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .page-title {
            font-size: 2.5rem;
            color: #34495e;
            border-bottom: 3px solid #1abc9c;
            padding-bottom: 10px;
            font-weight: bold;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            color: #555;
        }

        .form-control-lg {
            font-size: 1.2rem;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control-lg:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 10px rgba(26, 188, 156, 0.25);
        }

        .btn-success {
            background-color: #1abc9c;
            border-color: #1abc9c;
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-success:hover {
            background-color: #16a085;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }
    </style>
@endsection
