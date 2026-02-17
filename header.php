<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Project</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: #f4f4f4; padding: 1rem; margin-bottom: 2rem; }
        .nav { display: flex; gap: 20px; }
        .nav a { color: #333; text-decoration: none; }
        .nav a:hover { text-decoration: underline; }
        .content { min-height: 400px; }
        .footer { background: #f4f4f4; padding: 1rem; margin-top: 2rem; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
        }
        .btn { 
            display: inline-block; 
            padding: 10px 20px; 
            background: #f4f4f4; 
            border: 1px solid #ddd; 
            cursor: pointer; 
            text-decoration: none; 
            color: #333; 
        }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .alert { padding: 10px; margin: 10px 0; border: 1px solid #ddd; }
        .alert-success { background: #d4edda; }
        .alert-error { background: #f8d7da; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="nav">
                <a href="index.php">Главная</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">Профиль</a>
                    <a href="create_request.php">Создать заявку</a>
                    <?php if($_SESSION['user_role'] == 'admin'): ?>
                        <a href="admin.php">Панель администратора</a>
                    <?php endif; ?>
                    <a href="logout.php">Выйти</a>
                <?php else: ?>
                    <a href="login.php">Вход</a>
                    <a href="register.php">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="content"></div>