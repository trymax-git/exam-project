<?php
require_once 'config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if($stmt->execute([$username, $email, $password])) {
            header('Location: login.php?registered=1');
            exit();
        }
    } catch(PDOException $e) {
        $error = "Ошибка регистрации. Возможно email уже используется.";
    }
}
?>
<?php include 'header.php'; ?>

<h2>Регистрация</h2>

<?php if(isset($error)): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <button type="submit" class="btn">Зарегистрироваться</button>
</form>

<?php include 'footer.php'; ?>