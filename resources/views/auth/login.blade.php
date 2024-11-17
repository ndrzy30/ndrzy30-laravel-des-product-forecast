<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - APLIKASI DES</title>

    <!-- Tambahkan favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <!-- Favicon untuk berbagai platform -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        .login-header h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
        }
        .form-label {
            color: #34495e;
            font-weight: 500;
        }
        .form-control {
            border: 2px solid #eef2f7;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #4099ff;
            box-shadow: 0 0 0 0.2rem rgba(64,153,255,0.1);
        }
        .btn-login {
            background: linear-gradient(45deg, #4099ff, #73b4ff);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: linear-gradient(45deg, #3088ee, #62a3ee);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(64,153,255,0.2);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .input-group-text {
            background: transparent;
            border: 2px solid #eef2f7;
            border-right: none;
        }
        .input-group .form-control {
            border-left: none;
        }
        .pharmacy-icon {
            color: #4099ff;
            font-size: 40px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header" style="text-align: center; margin-top: 20px;">
                <h2 style="font-family: 'Poppins', sans-serif; font-size: 2em; color: #4CAF50; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);">
                    APLIKASI DES
                </h2>
                <p style="font-size: 1.2em; color: #888888; font-style: italic;">
                    <b>UD DISON</b>
                </p>
                <i class="fas fa-seedling" style="font-size: 2em; color: #4CAF50; margin-top: 10px;"></i>
            </div>
            

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('username') }}
                </div>
            @endif

            <form method="POST" action="{{ route('auth') }}">
                @csrf
                
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user text-muted"></i>
                        </span>
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Masukkan nama pengguna"
                               value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Masukkan kata sandi" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>