<?php
require_once 'config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<?php include 'header.php'; ?>

<h2>Профиль пользователя</h2>

<div style="border: 1px solid #ddd; padding: 20px;">
    <p><strong>ID:</strong> <?php echo $user['id']; ?></p>
    <p><strong>Имя пользователя:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Роль:</strong> <?php echo $user['role']; ?></p>
    <p><strong>Дата регистрации:</strong> <?php echo $user['created_at']; ?></p>
</div>

<h3>Статистика</h3>
<?php
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM requests WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total = $stmt->fetch();

$stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM requests WHERE user_id = ? GROUP BY status");
$stmt->execute([$_SESSION['user_id']]);
$stats = $stmt->fetchAll();
?>

<p>Всего заявок: <?php echo $total['total']; ?></p>

<?php if(count($stats) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Статус</th>
                <th>Количество</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($stats as $stat): ?>
                <tr>
                    <td><?php echo $stat['status']; ?></td>
                    <td><?php echo $stat['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include 'footer.php'; ?>