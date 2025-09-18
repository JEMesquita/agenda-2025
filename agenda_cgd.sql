CREATE DATABASE agenda_cgd;
USE agenda_cgd;

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('Usuario', 'Administrador', 'Desenvolvimento', 'Suporte') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de varas (agenda)
CREATE TABLE varas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_vara VARCHAR(200) NOT NULL,
    contato VARCHAR(500),
    email VARCHAR(100),
    endereco TEXT,
    link_balcao VARCHAR(255)
);