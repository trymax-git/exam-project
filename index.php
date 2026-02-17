<?php
require_once 'config/database.php';
?>

<?php include 'header.php'; ?>

<h2>Добро пожаловать<?php echo isset($_SESSION['username']) ? ', ' . $_SESSION['username'] : ''; ?>!</h2>

<?php if(isset($_SESSION['user_id'])): ?>
    <p>Вы авторизованы в системе.</p>
    
    <h3>Ваши заявки</h3>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM requests WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $requests = $stmt->fetchAll();
    
    if(count($requests) > 0):
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['title']); ?></td>
                        <td><?php echo htmlspecialchars($request['description']); ?></td>
                        <td><?php echo $request['status']; ?></td>
                        <td><?php echo $request['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>У вас пока нет заявок. <a href="create_request.php">Создать заявку</a></p>
    <?php endif; ?>
    
<?php else: ?>
    <p>Пожалуйста, <a href="login.php">войдите</a> или <a href="register.php">зарегистрируйтесь</a>.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>