@extends('layout.app')

@section('title', 'قائمة العملاء')

@section('content')
    <div class="clients-container">
        <h2 class="page-title">قائمة العملاء</h2>

        <div class="search-container">
            <form action="{{ route('clients.search') }}" method="GET" class="search-form">
                <input type="text" name="query" placeholder="ابحث عن عميل..." class="search-input">
                <button type="submit" class="search-button">بحث</button>
            </form>
            <a href="{{ route('clients.create') }}" class="add-client-button">إضافة عميل جديد</a>
        </div>

        <table class="clients-table">
            <thead>
                <tr>
                    <th>الاسم الكامل</th>
                    <th>العنوان</th>
                    <th>اسم المفوض</th>
                    <th>رقم هاتف العميل</th>
                    <th>رقم هاتف المفوض</th>
                    <th>رقم السجل الضريبي</th>
                    <th>البريد الإلكتروني</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->full_name }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $client->representative_name }}</td>
                        <td>{{ $client->client_phone }}</td>
                        <td>{{ $client->representative_phone }}</td>
                        <td>{{ $client->tax_registration_number }}</td>
                        <td>{{ $client->email }}</td>
                        <td class="actions">
                            <a href="{{ route('clients.edit', $client->id) }}" class="edit-button">تعديل</a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<style>
    .clients-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #34495e;
        border-bottom: 2px solid #1abc9c;
        padding-bottom: 10px;
    }

    .search-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-form {
        display: flex;
        align-items: center;
    }

    .search-input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px 0 0 4px;
        outline: none;
    }

    .search-button {
        padding: 10px 20px;
        background-color: #1abc9c;
        color: white;
        border: none;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .search-button:hover {
        background-color: #16a085;
    }

    .add-client-button {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .add-client-button:hover {
        background-color: #2980b9;
    }

    .clients-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .clients-table th, .clients-table td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .clients-table th {
        background-color: #1abc9c;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }

    .clients-table tbody tr:hover {
        background-color: #f4f4f4;
    }

    .actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .edit-button, .delete-button {
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        transition: background-color 0.3s;
        border: none;
        cursor: pointer;
    }

    .edit-button {
        background-color: #f39c12;
    }

    .edit-button:hover {
        background-color: #e67e22;
    }

    .delete-button {
        background-color: #e74c3c;
    }

    .delete-button:hover {
        background-color: #c0392b;
    }

    .delete-form {
        display: inline-block;
    }
</style>
