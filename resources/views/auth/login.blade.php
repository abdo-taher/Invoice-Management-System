<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center; /* توسيط النصوص في الصفحة بأكملها */
        }
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
            text-align: center;
            border-bottom: 3px solid #1abc9c;
            padding-bottom: 10px;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555555;
            text-align: center; /* توسيط النصوص داخل العناصر */
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .login-container input:focus {
            border-color: #1abc9c;
            outline: none;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #1abc9c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
        }
        .login-container button:hover {
            background-color: #16a085;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center; /* توسيط رسالة الخطأ */
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>تسجيل الدخول</h1>

        @if($errors->has('login_error'))
            <p class="error-message">{{ $errors->first('login_error') }}</p>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <label for="login">البريد الإلكتروني أو اسم المستخدم:</label>
            <input type="text" id="login" name="login" value="admin@admin.com" required>

            <label for="password">كلمة السر:</label>
            <input type="password" id="password" name="password" value="12345678" required>

            <button type="submit">تسجيل الدخول</button>
        </form>
    </div>

</body>
</html>
