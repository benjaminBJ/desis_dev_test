-- Crear la base de datos
CREATE DATABASE sistema_votacion
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Chile.1252'
    LC_CTYPE = 'Spanish_Chile.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

-- Crear la tabla de candidatos
CREATE TABLE candidatos (
    id_candidato SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Crear la tabla de regiones
CREATE TABLE regiones (
    id_region SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Crear la tabla de comunas
CREATE TABLE comunas (
    id_comuna SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_region INT,
    FOREIGN KEY (id_region) REFERENCES regiones(id_region)
);

-- Crear tabla de votos
CREATE TABLE votos (
  id_voto SERIAL PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  rut VARCHAR(12) NOT NULL,
  id_candidato INT NOT NULL,
  id_region INT NOT NULL,
  id_comuna INT NOT NULL,
  como_se_entero VARCHAR(255) NOT NULL,
  fecha_voto TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_candidato) REFERENCES candidatos(id_candidato),
  FOREIGN KEY (id_region) REFERENCES regiones(id_region),
  FOREIGN KEY (id_comuna) REFERENCES comunas(id_comuna),
  CONSTRAINT unique_rut_voto UNIQUE (rut)
);

-- Insertar candidatos de ejemplo
INSERT INTO candidatos (nombre) VALUES ('Candidato 1');
INSERT INTO candidatos (nombre) VALUES ('Candidato 2');
INSERT INTO candidatos (nombre) VALUES ('Candidato 3');

-- Insertar regiones de ejemplo
INSERT INTO regiones (nombre) VALUES ('Región 1');
INSERT INTO regiones (nombre) VALUES ('Región 2');
INSERT INTO regiones (nombre) VALUES ('Región 3');

-- Insertar comunas de ejemplo
INSERT INTO comunas (nombre, id_region) VALUES ('Comuna 1', 1);
INSERT INTO comunas (nombre, id_region) VALUES ('Comuna 2', 1);
INSERT INTO comunas (nombre, id_region) VALUES ('Comuna 3', 2);
INSERT INTO comunas (nombre, id_region) VALUES ('Comuna 4', 2);
INSERT INTO comunas (nombre, id_region) VALUES ('Comuna 5', 3);
INSERT INTO comunas (nombre, id_region) VALUES ('Comuna 6', 3);