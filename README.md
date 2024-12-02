Внутри БД необходимо создать следующие таблицы:

CREATE TABLE topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


В таблицу topics добавить темы для тестов:

INSERT INTO topics (name) VALUES 
('Тема 1'), 
('Тема 2'), 
('Тема 3'), 
('Другое');
