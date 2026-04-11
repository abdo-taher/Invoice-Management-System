<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'رفيق')</title>

    <!-- تضمين Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- تضمين Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            direction: rtl;
            background-color: #f4f6f9;
        }
        .top-bar {
            background-color: #1abc9c;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 18px;
        }
        .logout-button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .logout-button:hover {
            background-color: #c0392b;
        }
        .sidebar {
            background-color: #2c3e50;
            color: white;
            padding: 25px;
            width: 250px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            order: 1;
            z-index: 1000;
        }
        .sidebar h3 {
            font-size: 22px;
            margin-bottom: 20px;
            border-bottom: 2px solid #1abc9c;
            padding-bottom: 10px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
            position: relative;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }
        .sidebar ul li a:hover {
            color: #1abc9c;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #34495e;
            padding: 10px;
            border-radius: 4px;
            z-index: 1;
            width: 200px;
        }
        .dropdown-content li {
            margin-bottom: 10px;
        }
        .dropdown-content li a {
            color: white;
            text-decoration: none;
        }
        .settings-dropdown:hover .dropdown-content {
            display: block;
        }
        .content {
            flex-grow: 1;
            padding: 30px;
            order: 2;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin: 20px;
            border-radius: 10px;
        }
        .footer {
            background-color: #1abc9c;
            color: white;
            text-align: center;
            padding: 15px;
            flex-shrink: 0;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            position: relative;
            z-index: 1000;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="top-bar">
        <div>اسم المشروع: رفيق</div>
        <div id="datetime"></div>

        <!-- نموذج تسجيل الخروج -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <button class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            تسجيل الخروج
        </button>
    </div>

    <div style="display: flex; flex-grow: 1;">
        <div class="sidebar">
            <h3>القائمة</h3>
            <ul>
                <li><a href="{{ route('clients.index') }}">العملاء</a></li>
                <li><a href="{{ route('invoices.index') }}">الفواتير</a></li>
                <li><a href="{{ route('crossover') }}">العبور</a></li>
                <li><a href="{{ route('expenses.index') }}">المصاريف</a></li>
                <!-- رابط إدارة المستخدمين -->
                @role('admin')
                <li><a href="{{ route('users.index') }}">إدارة المستخدمين</a></li>
                <li><a href="{{ route('roles.index') }}">أدوار المستخدمين</a></li>
                @endrole
                <li class="settings-dropdown">
                    <a href="#">الإعدادات</a>
                    <ul class="dropdown-content">
                        <li><a href="{{ route('units.index') }}">إعدادات الوحدات</a></li>
                        <li><a href="{{ route('taxes.index') }}">إعدادات الضرائب</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <div class="footer">
        جميع حقوق التصميم والبرمجة محفوظة لرفيق
    </div>

    <!-- تضمين Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function updateDateTime() {
            var now = new Date();
            var datetime = now.toLocaleDateString('ar-EG') + ' ' + now.toLocaleTimeString('ar-EG');
            document.getElementById('datetime').textContent = datetime;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

</body>
</html>
