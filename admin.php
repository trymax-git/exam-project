<?php
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: index.php');
    exit();
}

if (isset($_POST['update_status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $request_id]);
}

$stmt = $pdo->query("SELECT r.*, u.username, u.email FROM requests r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
$requests = $stmt->fetchAll();

$stmt = $pdo->query("SELECT status, COUNT(*) as count FROM requests GROUP BY status");
$stats = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
$users_count = $stmt->fetch();
?>
<?php include 'header.php'; ?>

<h2>Панель администратора</h2>

<div style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px;">
    <h3>Статистика</h3>
    <p>Всего пользователей: <?php echo $users_count['total']; ?></p>
    <p>Всего заявок: <?php echo count($requests); ?></p>

    <h4>Заявки по статусам:</h4>
    <ul>
        <?php foreach ($stats as $stat): ?>
            <li><?php echo $stat['status']; ?>: <?php echo $stat['count']; ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<h3>Управление заявками</h3>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Email</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Статус</th>
            <th>Дата</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requests as $request): ?>
            <tr>
                <td><?php echo $request['id']; ?></td>
                <td><?php echo htmlspecialchars($request['username']); ?></td>
                <td><?php echo htmlspecialchars($request['email']); ?></td>
                <td><?php echo htmlspecialchars($request['title']); ?></td>
                <td><?php echo htmlspecialchars(substr($request['description'], 0, 50)) . '...'; ?></td>
                <td><?php echo $request['status']; ?></td>
                <td><?php echo $request['created_at']; ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <select name="status">
                            <option value="pending" <?php echo $request['status'] == 'pending' ? 'selected' : ''; ?>>Ожидание
                            </option>
                            <option value="in_progress" <?php echo $request['status'] == 'in_progress' ? 'selected' : ''; ?>>В
                                работе</option>
                            <option value="completed" <?php echo $request['status'] == 'completed' ? 'selected' : ''; ?>>
                                Завершена</option>
                            <option value="rejected" <?php echo $request['status'] == 'rejected' ? 'selected' : ''; ?>>
                                Отклонена</option>
                        </select>
                        <button type="submit" name="update_status" class="btn">Обновить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>