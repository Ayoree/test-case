<?php
    include 'db_config.php';

    // Установка соединения с базой данных
    $conn = new mysqli(
        $db_config['servername'],
        $db_config['username'],
        $db_config['password'],
        $db_config['dbname']
    );
    $sql = "SELECT fm.id, t.name AS topic, fm.email, fm.message, fm.created_at 
            FROM messages fm 
            JOIN topics t ON fm.topic = t.id 
            ORDER BY fm.created_at DESC";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр сообщений</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Сообщения</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Тема</th>
                    <th>Email</th>
                    <th>Сообщение</th>
                    <th>Дата отправки</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
                            $topic = htmlspecialchars($row['topic'], ENT_QUOTES, 'UTF-8');
                            $email = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
                            $message = htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8');
                            $created_at = htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8');

                            echo "<tr>
                                    <td>{$id}</td>
                                    <td>{$topic}</td>
                                    <td>{$email}</td>
                                    <td>{$message}</td>
                                    <td>{$created_at}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Нет сообщений</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php
        $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
