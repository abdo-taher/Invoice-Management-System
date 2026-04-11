@extends('layout.app')

@section('title', 'إضافة عميل جديد')

@section('content')
    <div class="form-container">
        <h2 class="form-title">إضافة عميل جديد</h2>

        <form action="{{ route('clients.store') }}" method="POST" class="client-form">
            @csrf
            <div class="form-group">
                <label for="full_name">اسم العميل بالكامل:</label>
                <input type="text" id="full_name" name="full_name" required class="form-input">
            </div>

            <div class="form-group">
                <label for="address">عنوان العميل:</label>
                <input type="text" id="address" name="address" class="form-input">
            </div>

            <div class="form-group">
                <label for="representative_name">اسم المفوض:</label>
                <input type="text" id="representative_name" name="representative_name" class="form-input">
            </div>

            <div class="form-group">
                <label for="client_phone">رقم هاتف العميل:</label>
                <input type="text" id="client_phone" name="client_phone" class="form-input">
            </div>

            <div class="form-group">
                <label for="representative_phone">رقم هاتف المفوض:</label>
                <input type="text" id="representative_phone" name="representative_phone" class="form-input">
            </div>

            <div class="form-group">
                <label for="tax_registration_number">رقم السجل الضريبي:</label>
                <input type="text" id="tax_registration_number" name="tax_registration_number" class="form-input">
            </div>

            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" class="form-input">
            </div>

            <button type="submit" class="submit-button">إضافة</button>
        </form>
    </div>
@endsection

<style>
    .form-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-title {
        font-size: 26px;
        margin-bottom: 20px;
        color: #34495e;
        text-align: center;
        border-bottom: 2px solid #1abc9c;
        padding-bottom: 10px;
    }

    .client-form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 16px;
        color: #34495e;
        margin-bottom: 5px;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    .form-input:focus {
        border-color: #1abc9c;
        outline: none;
    }

    .submit-button {
        background-color: #1abc9c;
        color: white;
        padding: 15px;
        font-size: 18px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-align: center;
    }

    .submit-button:hover {
        background-color: #16a085;
    }
</style>
