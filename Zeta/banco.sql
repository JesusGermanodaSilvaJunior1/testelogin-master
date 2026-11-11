CREATE DATABASE IF NOT EXISTS zeta_transporte
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE zeta_transporte;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NULL,
    preco DECIMAL(10,2) NOT NULL,
    preco_promocional DECIMAL(10,2) NULL,
    imagem VARCHAR(255) NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    nome_cliente VARCHAR(120) NOT NULL,
    email_cliente VARCHAR(150) NOT NULL,
    forma_pagamento ENUM('pix','cartao') NOT NULL,
    parcelas TINYINT NOT NULL DEFAULT 1,
    gateway ENUM('mercadopago','paypal','santander') NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    status ENUM('pendente','pago','cancelado') NOT NULL DEFAULT 'pendente',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS curriculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    arquivo VARCHAR(255) NOT NULL,
    consentimento_lgpd TINYINT(1) NOT NULL DEFAULT 0,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO produtos (nome, descricao, preco, preco_promocional, imagem) VALUES
('Caixa de papelão 40x30x30', 'Caixa reforçada para envio de mercadorias.', 12.90, 9.90, 'produto1.jpg'),
('Fita adesiva 48mm x 100m', 'Fita transparente para lacre de caixas.', 7.50, NULL, 'produto2.jpg'),
('Filme stretch 500mm', 'Rolo de filme para paletização.', 54.00, 49.90, 'produto3.jpg'),
('Palete plástico', 'Palete resistente para armazenagem.', 189.00, NULL, 'produto4.jpg'),
('Etiquetas de envio (100 un.)', 'Etiquetas adesivas para identificação.', 18.00, 15.00, 'produto5.jpg'),
('Envelope de segurança', 'Envelope lacrável com proteção antiviolação.', 3.20, NULL, 'produto6.jpg');
