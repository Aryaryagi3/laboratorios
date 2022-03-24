CREATE DATABASE laboratorios COLLATE 'utf8_unicode_ci';

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha CHAR(60) NOT NULL,
    administrador BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
)
ENGINE = InnoDB;

CREATE TABLE solicitacoes (
    id INT NOT NULL AUTO_INCREMENT,
    reservado VARCHAR(3) NOT NULL,
    data_inicio TIMESTAMP NOT NULL,
    data_fim TIMESTAMP NOT NULL,
    motivo VARCHAR(50) NOT NULL,
    laboratorio VARCHAR(30) NOT NULL,
    usuario_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
)

ENGINE = InnoDB;