CREATE DATABASE caio2tianatal;

USE caio2tianatal;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'usuario') NOT NULL
);
CREATE TABLE marcas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_marca TEXT
);
CREATE TABLE produtos(
    serial_number INT PRIMARY KEY,
    nome VARCHAR(100),
    valor DECIMAL(10, 2),
    foto VARCHAR(255),
    quantidade INT,
    marca_id INT,
    user_id INT,
    FOREIGN KEY(user_id) REFERENCES usuarios(id),
    FOREIGN KEY (marca_id) REFERENCES marcas(id)
);

CREATE TABLE carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    produto_id INT,
    valor_total DECIMAL(10, 2),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(serial_number) ON DELETE CASCADE
);
CREATE TABLE mensagem(
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    mensagem TEXT(500),
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);

INSERT INTO usuarios (username, password, tipo) VALUES 
('admin', 'admin123', 'admin'),
('usuario1', 'senha123', 'usuario'),
('usuario2', 'senha456', 'usuario');
INSERT INTO marcas(id, nome_marca) VALUES(1, "Schecter"),
(2, "Gibson"),
(3, "ESP")