<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 15px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-size: 13px;
        }
        p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verifikasi Email</h2>
        <form method="POST" action="{{ route('verify') }}">
            @csrf
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label>Kode Verifikasi:</label>
            <input type="text" name="code">
            @error('code') <div class="error">{{ $message }}</div> @enderror

            <button type="submit">Verifikasi</button>
        </form>
        <p><a href="{{ route('login') }}">Kembali ke Login</a></p>
    </div>
</body>
</html>
