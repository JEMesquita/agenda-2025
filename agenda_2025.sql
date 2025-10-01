CREATE DATABASE agenda_2025;
USE agenda_2025;

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
    instituicao VARCHAR(100) NOT NULL,
    nome_vara VARCHAR(200) NOT NULL,
    contato VARCHAR(500),
    email VARCHAR(100),
    endereco TEXT,
    link_balcao VARCHAR(255)
);

-- Tabela advogados
CREATE TABLE advogados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    oab VARCHAR(20),
    contato VARCHAR(100),
    email VARCHAR(100),
    instituicao VARCHAR(100)
);

-- Tabela cgd
CREATE TABLE cgd (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela contato_pessoais
CREATE TABLE contato_pessoais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    observacao TEXT
);

-- Tabela detran
CREATE TABLE detran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela fórum
CREATE TABLE forum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    comarca VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela PCCE
CREATE TABLE pcce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela PMCE
CREATE TABLE pmce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela PEFOCE
CREATE TABLE pefoce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela SAP
CREATE TABLE sap (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela juizados
CREATE TABLE juizados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela MPCE
CREATE TABLE mpce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    setor VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);

-- Tabela outras_instituicoes
CREATE TABLE outras_instituicoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo VARCHAR(100),
    contato VARCHAR(100),
    email VARCHAR(100)
);