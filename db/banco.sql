CREATE DATABASE smartcash;

USE smartcash;

CREATE TABLE Usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome_usuario VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    foto_usuario LONGBLOB
);

CREATE TABLE Categoria (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nome_categoria VARCHAR(255) NOT NULL
);

CREATE TABLE MovimentacaoFinanceira (
    id_movimentacao INT PRIMARY KEY AUTO_INCREMENT,
    data_movimentacao DATE NOT NULL,
    descricao TEXT,
    tipo_movimentacao ENUM('entrada', 'saida') NOT NULL,
    valor_movimentacao DECIMAL(10, 2) NOT NULL,
    id_categoria INT,
    id_usuario INT,
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria) ON DELETE SET NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
);

-- seeds de categoria
INSERT INTO Categoria (nome_categoria) VALUES 
('Alimentação'),
('Moradia'),
('Luz'),
('Água'),
('Salário'),
('Freelance'),
('Transporte'),
('Educação'),
('Saúde'),
('Entretenimento'),
('Roupas'),
('Viagem'),
('Impostos'),
('Poupança'),
('Investimentos'),
('Presentes'),
('Assinaturas'),
('Seguros'),
('Manutenção do carro'),
('Telefone/Internet'),
('Animais de estimação'),
('Doações'),
('Imprevistos'),
('Outros');