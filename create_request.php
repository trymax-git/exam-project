<?php
require_once 'config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("INSERT INTO requests (user_id, title, description) VALUES (?, ?, ?)");
    if($stmt->execute([$user_id, $title, $description])) {
        header('Location: index.php?request_created=1');
        exit();
    } else {
        $error = "Ошибка при создании заявки";
    }
}
?>
<?php include 'header.php'; ?>

<h2>Создание заявки</h2>

<?php if(isset($error)): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="title">Название заявки:</label>
        <input type="text" id="title" name="title" required>
    </div>
    
    <div class="form-group">
        <label for="description">Описание:</label>
        <textarea id="description" name="description" rows="5" required></textarea>
    </div>
    
    <button type="submit" class="btn">Создать заявку</button>
</form>

<?php include 'footer.php'; ?>