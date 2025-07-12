
-- Estrutura da base de dados
CREATE TABLE utilizadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    apelido VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefone VARCHAR(20),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('admin','cliente') NOT NULL,
    data_registo DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    resumo TEXT NOT NULL,
    conteudo TEXT NOT NULL,
    imagem VARCHAR(255),
    data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projetos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descricao TEXT NOT NULL,
    imagem VARCHAR(255),
    tecnologia VARCHAR(150),
    duracao VARCHAR(50),
    data_inicio DATE,
    data_fim DATE
);

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilizador_id INT NOT NULL,
    data_consulta DATETIME NOT NULL,
    observacoes TEXT,
    estado ENUM('pendente', 'confirmada', 'concluída') DEFAULT 'pendente',
    FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id)
);

-- Inserir utilizador administrador
INSERT INTO utilizadores (nome, apelido, email, telefone, username, password, tipo)
VALUES ('Admin', 'Master', 'admin@example.com', '999999999', 'admin', '$2y$10$hDLEbmikDcRTt8MghZVZVewLUJ8wUVaAZl5ARfOXzjz.CE3OSXHeu', 'admin');
