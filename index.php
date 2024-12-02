<?php
    include 'db_config.php';

    // Сообщение об ошибке или успехе
    $status = "";

    // Установка соединения с базой данных
    $conn = new mysqli(
        $db_config['servername'],
        $db_config['username'],
        $db_config['password'],
        $db_config['dbname']
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получение данных из формы
        $topic = $_POST['topic'];
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

        // Проверка подключения
        if ($conn->connect_error) {
            die("<div class='alert alert-danger'>Ошибка подключения к базе данных: " . $conn->connect_error . "</div>");
        }

        // SQL-запрос для вставки данных
        $sql = "INSERT INTO messages (topic, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $topic, $email, $message);

        if ($stmt->execute()) {
            $status = "<div class='alert alert-success'>Ваше сообщение успешно отправлено!</div>";
        } else {
            $status = "<div class='alert alert-danger'>Ошибка: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
    $topics_query = "SELECT id, name FROM topics";
    $topics_result = $conn->query($topics_query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма отправки сообщений</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Обратная связь</h2>
                        <?php
                            if (!empty($status)) {
                                echo $status;
                            }
                        ?>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="topic" class="form-label">Тема</label>
                                <select class="form-select" id="topic" name="topic" required>
                                    <option value="" hidden="true" disabled selected>Выберите тему</option>
                                    <?php
                                        if ($topics_result->num_rows > 0) {
                                            while ($row = $topics_result->fetch_assoc()) {
                                                $topic_name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                                                echo "<option value='{$row['id']}'>{$topic_name}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-Mail получателя</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Введите email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Сообщение</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Напишите ваше сообщение..." required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
