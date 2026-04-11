@extends('layout.app')

@section('title', 'إدارة العبور')

@section('content')
    <div class="container mt-5">
        <h2 class="page-title text-center mb-5">إدارة العبور</h2>

        <div class="row justify-content-between mb-5 align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <!-- زر إضافة عبور جديد في يسار الصفحة -->
                <button class="btn btn-lg shadow-lg btn-add-crossover w-100" data-bs-toggle="modal" data-bs-target="#addCrossoverModal">
                    <i class="fas fa-plus-circle"></i> إضافة عبور جديد
                </button>
            </div>
            <div class="col-md-8">
                <form action="#" method="GET" class="input-group shadow-sm">
                    <input type="text" name="query" placeholder="ابحث عن عبور..." class="form-control form-control-lg rounded-left border-0 bg-light text-dark">
                    <button type="submit" class="btn btn-primary btn-lg rounded-right border-0">
                        <i class="fas fa-search"></i> بحث
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive shadow-lg rounded">
            <table class="table table-striped table-hover bg-white rounded overflow-hidden">
                <thead class="bg-gradient-primary text-white">
                    <tr class="text-uppercase">
                        <th scope="col">الوزن</th>
                        <th scope="col">الصنع</th>
                        <th scope="col">الرقم المدني</th>
                        <th scope="col">اسم السائق</th>
                        <th scope="col">من محافظة</th>
                        <th scope="col">إلى محافظة</th>
                        <th scope="col">رمز الشاحنة</th>
                        <th scope="col">رقم الشاحنة</th>
                        <th scope="col">اسم الشركة</th>
                        <th scope="col">رقم الفاتورة</th>
                        <th scope="col">تاريخ الشحنة</th>
                        <th scope="col" class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($crossovers as $crossover)
                        <tr class="align-middle">
                            <td class="align-middle text-center">{{ $crossover->weight }}</td>
                            <td class="align-middle">{{ $crossover->manufacture }}</td>
                            <td class="align-middle">{{ $crossover->civil_number }}</td>
                            <td class="align-middle">{{ $crossover->driver_name }}</td>
                            <td class="align-middle">{{ $crossover->from_province }}</td>
                            <td class="align-middle">{{ $crossover->to_province }}</td>
                            <td class="align-middle">{{ $crossover->truck_code }}</td>
                            <td class="align-middle">{{ $crossover->truck_number }}</td>
                            <td class="align-middle">{{ $crossover->company_name }}</td>
                            <td class="align-middle">{{ $crossover->invoice_number }}</td>
                            <td class="align-middle">{{ $crossover->shipment_date }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editCrossoverModal{{ $crossover->id }}">
                                    <i class="fas fa-edit"></i> تعديل
                                </button>
                                <form action="{{ route('crossover.destroy', $crossover->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('هل أنت متأكد من حذف هذا العبور؟')">
                                        <i class="fas fa-trash-alt"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- نافذة تعديل بيانات العبور -->
                        <div class="modal fade" id="editCrossoverModal{{ $crossover->id }}" tabindex="-1" aria-labelledby="editCrossoverModalLabel{{ $crossover->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCrossoverModalLabel{{ $crossover->id }}">تعديل بيانات العبور</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('crossover.update', $crossover->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-3">
                                                <!-- الحقول الإضافية الجديدة -->
                                                <div class="col-md-6">
                                                    <label for="chassis_number{{ $crossover->id }}" class="form-label">رقم الشاصي</label>
                                                    <input type="text" class="form-control" id="chassis_number{{ $crossover->id }}" name="chassis_number" value="{{ $crossover->chassis_number }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="origin{{ $crossover->id }}" class="form-label">المنشأ</label>
                                                    <input type="text" class="form-control" id="origin{{ $crossover->id }}" name="origin" value="{{ $crossover->origin }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="color{{ $crossover->id }}" class="form-label">اللون</label>
                                                    <input type="text" class="form-control" id="color{{ $crossover->id }}" name="color" value="{{ $crossover->color }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="vehicle_type{{ $crossover->id }}" class="form-label">نوع المركبة</label>
                                                    <input type="text" class="form-control" id="vehicle_type{{ $crossover->id }}" name="vehicle_type" value="{{ $crossover->vehicle_type }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="plate_type{{ $crossover->id }}" class="form-label">نوع اللوحة</label>
                                                    <input type="text" class="form-control" id="plate_type{{ $crossover->id }}" name="plate_type" value="{{ $crossover->plate_type }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="plate_code{{ $crossover->id }}" class="form-label">رمز اللوحة</label>
                                                    <input type="text" class="form-control" id="plate_code{{ $crossover->id }}" name="plate_code" value="{{ $crossover->plate_code }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="plate_number{{ $crossover->id }}" class="form-label">رقم اللوحة</label>
                                                    <input type="text" class="form-control" id="plate_number{{ $crossover->id }}" name="plate_number" value="{{ $crossover->plate_number }}" required>
                                                </div>
                                                <!-- الحقول الأساسية الموجودة بالفعل -->
                                                <div class="col-md-6">
                                                    <label for="weight{{ $crossover->id }}" class="form-label">الوزن</label>
                                                    <input type="text" class="form-control" id="weight{{ $crossover->id }}" name="weight" value="{{ $crossover->weight }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="manufacture{{ $crossover->id }}" class="form-label">الصنع</label>
                                                    <input type="text" class="form-control" id="manufacture{{ $crossover->id }}" name="manufacture" value="{{ $crossover->manufacture }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="civil_number{{ $crossover->id }}" class="form-label">الرقم المدني</label>
                                                    <input type="text" class="form-control" id="civil_number{{ $crossover->id }}" name="civil_number" value="{{ $crossover->civil_number }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="driver_name{{ $crossover->id }}" class="form-label">اسم السائق</label>
                                                    <input type="text" class="form-control" id="driver_name{{ $crossover->id }}" name="driver_name" value="{{ $crossover->driver_name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="from_province{{ $crossover->id }}" class="form-label">من محافظة</label>
                                                    <input type="text" class="form-control" id="from_province{{ $crossover->id }}" name="from_province" value="{{ $crossover->from_province }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="to_province{{ $crossover->id }}" class="form-label">إلى محافظة</label>
                                                    <input type="text" class="form-control" id="to_province{{ $crossover->id }}" name="to_province" value="{{ $crossover->to_province }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="truck_code{{ $crossover->id }}" class="form-label">رمز الشاحنة</label>
                                                    <input type="text" class="form-control" id="truck_code{{ $crossover->id }}" name="truck_code" value="{{ $crossover->truck_code }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="truck_number{{ $crossover->id }}" class="form-label">رقم الشاحنة</label>
                                                    <input type="text" class="form-control" id="truck_number{{ $crossover->id }}" name="truck_number" value="{{ $crossover->truck_number }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="company_name{{ $crossover->id }}" class="form-label">اسم الشركة</label>
                                                    <input type="text" class="form-control" id="company_name{{ $crossover->id }}" name="company_name" value="{{ $crossover->company_name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="invoice_number{{ $crossover->id }}" class="form-label">رقم الفاتورة</label>
                                                    <input type="text" class="form-control" id="invoice_number{{ $crossover->id }}" name="invoice_number" value="{{ $crossover->invoice_number }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="shipment_date{{ $crossover->id }}" class="form-label">تاريخ الشحنة</label>
                                                    <input type="date" class="form-control" id="shipment_date{{ $crossover->id }}" name="shipment_date" value="{{ $crossover->shipment_date }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer mt-3">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- نهاية نافذة التعديل -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- نافذة إضافة عبور جديد -->
    <div class="modal fade" id="addCrossoverModal" tabindex="-1" aria-labelledby="addCrossoverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCrossoverModalLabel">إضافة عبور جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crossover.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <!-- الحقول الإضافية الجديدة -->
                            <div class="col-md-6">
                                <label for="chassis_number" class="form-label">رقم الشاصي</label>
                                <input type="text" class="form-control" id="chassis_number" name="chassis_number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="origin" class="form-label">المنشأ</label>
                                <input type="text" class="form-control" id="origin" name="origin" required>
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label">اللون</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>
                            <div class="col-md-6">
                                <label for="vehicle_type" class="form-label">نوع المركبة</label>
                                <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" required>
                            </div>
                            <div class="col-md-6">
                                <label for="plate_type" class="form-label">نوع اللوحة</label>
                                <input type="text" class="form-control" id="plate_type" name="plate_type" required>
                            </div>
                            <div class="col-md-6">
                                <label for="plate_code" class="form-label">رمز اللوحة</label>
                                <input type="text" class="form-control" id="plate_code" name="plate_code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="plate_number" class="form-label">رقم اللوحة</label>
                                <input type="text" class="form-control" id="plate_number" name="plate_number" required>
                            </div>
                            <!-- الحقول الأساسية الموجودة بالفعل -->
                            <div class="col-md-6">
                                <label for="weight" class="form-label">الوزن</label>
                                <input type="text" class="form-control" id="weight" name="weight" required>
                            </div>
                            <div class="col-md-6">
                                <label for="manufacture" class="form-label">الصنع</label>
                                <input type="text" class="form-control" id="manufacture" name="manufacture" required>
                            </div>
                            <div class="col-md-6">
                                <label for="civil_number" class="form-label">الرقم المدني</label>
                                <input type="text" class="form-control" id="civil_number" name="civil_number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="driver_name" class="form-label">اسم السائق</label>
                                <input type="text" class="form-control" id="driver_name" name="driver_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="from_province" class="form-label">من محافظة</label>
                                <input type="text" class="form-control" id="from_province" name="from_province" required>
                            </div>
                            <div class="col-md-6">
                                <label for="to_province" class="form-label">إلى محافظة</label>
                                <input type="text" class="form-control" id="to_province" name="to_province" required>
                            </div>
                            <div class="col-md-6">
                                <label for="truck_code" class="form-label">رمز الشاحنة</label>
                                <input type="text" class="form-control" id="truck_code" name="truck_code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="truck_number" class="form-label">رقم الشاحنة</label>
                                <input type="text" class="form-control" id="truck_number" name="truck_number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company_name" class="form-label">اسم الشركة</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="invoice_number" class="form-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="shipment_date" class="form-label">تاريخ الشحنة</label>
                                <input type="date" class="form-control" id="shipment_date" name="shipment_date" required>
                            </div>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-success">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
