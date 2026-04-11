@extends('layout.app')

@section('content')
<div class="container">
    <h1>تعديل الدور</h1>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">إسم الدور</label>
            <input type="text" name="name" class="form-control" value="{{$role->name}}">
        </div>
        <button type="submit" class="btn btn-success">تحديث</button>
    </form>
</div>
@endsection
