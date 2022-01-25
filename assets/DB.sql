DROP DATABASE IF EXISTS finex;
CREATE DATABASE IF NOT EXISTS finex;
USE finex;

/*
  TABLE USERS

  idt_usr -> Identificador único
  doc_usr -> Documento de identidad
  nom_usr -> Nombre completo
  tlf_usr -> Número telefónico
  ema_usr -> Correo electrónico
  psw_usr -> Contraseña
  gnd_usr -> Género
  pai_usr -> País
  ciu_usr -> Ciudad
  dir_usr -> Dirección exacta
  img_prf -> Foto de perfil
  log_usr -> Posibilidad de loguearse
  lst_upd -> Última actualización de datos
  lst_ini -> Último inicio de sesión
  del_usr -> Cuenta eliminada
  stt_usr -> Estatus (0,1,2,3)
  fch_reg -> Fecha de registro exacta
*/

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  idt_usr VARCHAR (64) NOT NULL,
  doc_usr VARCHAR (20),
  nom_usr VARCHAR (99) NOT NULL,
  tlf_usr VARCHAR (20) NOT NULL,
  ema_usr VARCHAR (50) NOT NULL,
  psw_usr VARCHAR (64) NOT NULL,
  gnd_usr SET('male', 'female'),
  pai_usr TEXT,
  ciu_usr TEXT,
  dir_usr VARCHAR (150),
  img_prf VARCHAR (300),
  log_usr BOOLEAN DEFAULT 0,
  lst_upd TIMESTAMP,
  lst_ini TIMESTAMP,
  del_usr BOOLEAN DEFAULT 0,
  stt_usr SET('circle', 'triangle', 'square', 'front'),
  fch_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_usr),
  CONSTRAINT UNIQUE (ema_usr),
  CONSTRAINT UNIQUE (tlf_usr)
);

/*
  TABLE CODE PHONE

  idt_cod -> Identificador único del código
  tlf_usr -> Número telefónico
  cod_2fa -> Código envíado al celular
  fch_cod -> Fecha de envío del código
  exp_cod -> Estatus de uso del codigo (0 expirado, 1 disponible)
*/

DROP TABLE IF EXISTS code_phone;
CREATE TABLE IF NOT EXISTS code_phone (
  idt_cod INT UNSIGNED NOT NULL AUTO_INCREMENT,
  tlf_usr VARCHAR (20) NOT NULL,
  cod_2fa VARCHAR(6) NOT NULL,
  fch_cod TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  exp_cod BOOLEAN DEFAULT 0,
  PRIMARY KEY (idt_cod),
  FOREIGN KEY (tlf_usr) REFERENCES users (tlf_usr),
  CONSTRAINT UNIQUE (cod_2fa)
);

/*
  TABLE CODE EMAIL

  idt_cod -> Identificador único del código
  ema_usr -> Correo electrónico
  cod_2fa -> Código envíado al correo
  fch_cod -> Fecha de envío del código
  exp_cod -> Estatus de uso del codigo (0 expirado, 1 disponible)
*/

DROP TABLE IF EXISTS code_email;
CREATE TABLE IF NOT EXISTS code_email (
  idt_cod INT UNSIGNED NOT NULL AUTO_INCREMENT,
  ema_usr VARCHAR (50) NOT NULL,
  cod_2fa VARCHAR(6) NOT NULL,
  fch_cod TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  exp_cod BOOLEAN DEFAULT 0,
  PRIMARY KEY (idt_cod),
  FOREIGN KEY (ema_usr) REFERENCES users (ema_usr),
  CONSTRAINT UNIQUE (cod_2fa)
);

/*
  TABLE LOGIN WITH CODES

  idt_ini -> Identificador único de inicio de sesión
  idt_usr -> Identificador único del usuario
  ema_usr -> Correo electrónico del usuario
  tlf_usr -> Número telefónico del usuario
  cod_pho -> Código envíado al celular
  cod_ema -> Código envíado al correo
  jwt_usr -> Json Web Token
  frs_tim -> Primera vez de inicio de sesión
  fch_log -> Fecha de inicio de sesión
*/

DROP TABLE IF EXISTS login_with_codes;
CREATE TABLE IF NOT EXISTS login_with_codes (
  idt_ini INT UNSIGNED NOT NULL AUTO_INCREMENT,
  idt_usr VARCHAR (64) NOT NULL,
  ema_usr VARCHAR (50) NOT NULL,
  tlf_usr VARCHAR (20) NOT NULL,
  cod_pho VARCHAR (6)  NOT NULL,
  cod_ema VARCHAR (6)  NOT NULL,
  jwt_usr VARCHAR (64) NOT NULL,
  frs_tim BOOLEAN DEFAULT 0,
  fch_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_ini),
  FOREIGN KEY (idt_usr) REFERENCES users (idt_usr),
  FOREIGN KEY (ema_usr) REFERENCES users (ema_usr),
  FOREIGN KEY (tlf_usr) REFERENCES users (tlf_usr),
  FOREIGN KEY (cod_pho) REFERENCES code_phone (cod_2fa),
  FOREIGN KEY (cod_ema) REFERENCES code_email (cod_2fa),
  CONSTRAINT UNIQUE (jwt_usr)
);

/*
  TABLE LOGIN WITHOUT CODES

  idt_ini -> Identificador único de inicio de sesión
  idt_usr -> Identificador único del usuario
  ema_usr -> Correo electrónico del usuario
  tlf_usr -> Número telefónico del usuario
  jwt_usr -> Json Web Token
  fch_log -> Fecha de inicio de sesión
*/

DROP TABLE IF EXISTS login_without_code;
CREATE TABLE IF NOT EXISTS login_without_code (
  idt_ini INT UNSIGNED NOT NULL AUTO_INCREMENT,
  idt_usr VARCHAR (64) NOT NULL,
  ema_usr VARCHAR (50) NOT NULL,
  tlf_usr VARCHAR (20) NOT NULL,
  jwt_usr VARCHAR (64) NOT NULL,
  fch_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_ini),
  FOREIGN KEY (idt_usr) REFERENCES users (idt_usr),
  FOREIGN KEY (ema_usr) REFERENCES users (ema_usr),
  FOREIGN KEY (tlf_usr) REFERENCES users (tlf_usr),
  CONSTRAINT UNIQUE (jwt_usr)
);

/*
  TABLE LOGIN FAILED

  idt_ini -> Identificador único de inicio de sesión
  idt_usr -> Identificador único del usuario
  ema_usr -> Correo electrónico del usuario
  tlf_usr -> Número telefónico del usuario
  cod_pho -> Código envíado al celular
  cod_ema -> Código envíado al correo
  jwt_usr -> Json Web Token
  frs_tim -> Primera vez de inicio de sesión
  fch_log -> Fecha de inicio de sesión
  raz_fal -> Razón de fallo de inicio de sesión
*/

DROP TABLE IF EXISTS login_failed;
CREATE TABLE IF NOT EXISTS login_failed (
  idt_ini INT UNSIGNED NOT NULL AUTO_INCREMENT,
  idt_usr VARCHAR (64) NOT NULL,
  ema_usr VARCHAR (50) NOT NULL,
  tlf_usr VARCHAR (20) NOT NULL,
  cod_pho VARCHAR (6)  NOT NULL,
  cod_ema VARCHAR (6)  NOT NULL,
  jwt_usr VARCHAR (64) NOT NULL,
  frs_tim BOOLEAN DEFAULT 0,
  fch_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  rzn_fal TEXT NOT NULL,
  PRIMARY KEY (idt_ini),
  FOREIGN KEY (idt_usr) REFERENCES users (idt_usr),
  FOREIGN KEY (ema_usr) REFERENCES users (ema_usr),
  FOREIGN KEY (tlf_usr) REFERENCES users (tlf_usr),
  FOREIGN KEY (cod_pho) REFERENCES code_phone (cod_2fa),
  FOREIGN KEY (cod_ema) REFERENCES code_email (cod_2fa),
  CONSTRAINT UNIQUE (jwt_usr)
);

/*
  TABLE WALLET

  idt_wal -> Identificador único de la billetera
  ema_usr -> Correo electrónico del usuario
  sal_wal -> Saldo de la billetera
  fch_wal -> Fecha de creación de la billetera
*/

DROP TABLE IF EXISTS wallet;
CREATE TABLE IF NOT EXISTS wallet (
  idt_wal VARCHAR(32) NOT NULL,
  ema_usr VARCHAR(50) NOT NULL,
  sal_wal DECIMAL(10,2) NOT NULL,
  tip_div SET("USD","COP","VES") NOT NULL,
  fch_crc TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_wal),
  FOREIGN KEY (ema_usr) REFERENCES users (ema_usr)
);

/*
  TABLE DEPOSIT

  idt_dep -> Identificador único del depósito
  wal_who -> Identificador único de la billetera a la que depositan
  wal_frm -> Identificador único de la billetera que hace el deposito
  ema_who -> Correo electrónico del usuario que realiza el depósito
  ema_frm -> Correo electrónico del usuario que recibe el depósito
  sal_dep -> Saldo del depósito
  tip_dep -> Tipo de divisa del depósito
  fch_dep -> Fecha de creación del depósito
*/

DROP TABLE IF EXISTS deposit;
CREATE TABLE IF NOT EXISTS deposit (
  idt_dep INT UNSIGNED NOT NULL AUTO_INCREMENT,
  wal_who VARCHAR(32) NOT NULL,
  wal_frm VARCHAR(32) NOT NULL,
  ema_who VARCHAR(50) NOT NULL,
  ema_frm VARCHAR(50) NOT NULL,
  sal_dep DECIMAL(10,2) NOT NULL,
  tip_div VARCHAR(3) NOT NULL,
  con_dep VARCHAR(99) NOT NULL,
  fch_dep TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_dep),
  FOREIGN KEY (wal_who) REFERENCES wallet (idt_wal),
  FOREIGN KEY (wal_frm) REFERENCES wallet (idt_wal),
  FOREIGN KEY (ema_who) REFERENCES users (ema_usr),
  FOREIGN KEY (ema_frm) REFERENCES users (ema_usr)
);

/*
  TRIGGERS
*/
/*
  Trigger para descontar el saldo de la billetera cuando se realiza un depósito
*/

CREATE TRIGGER wallet_deposit AFTER INSERT ON deposit
FOR EACH ROW
UPDATE wallet
SET sal_wal = sal_wal - NEW.sal_dep
WHERE idt_wal = NEW.wal_frm;

/*
  Trigger para sumar el saldo de la billetera cuando alguien deposita en ella
*/

CREATE TRIGGER wallet_deposit_back AFTER INSERT ON deposit
FOR EACH ROW
UPDATE wallet
SET sal_wal = sal_wal + NEW.sal_dep
WHERE idt_wal = NEW.wal_who;

/*
  INSERTS BY DEFAULT
*/

/*
  USERS
*/

INSERT INTO 
users
(idt_usr,doc_usr,nom_usr,tlf_usr,ema_usr,psw_usr,gnd_usr,pai_usr,ciu_usr,dir_usr,img_prf,log_usr,lst_upd,lst_ini,del_usr,stt_usr,fch_reg)
VALUES
('c81e728d9d4c2f636f067f89cc14862c','26068764','Andi Montilla','+5804120625089','beltz.18kyodai@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','male','United Kingdom','Liverpool',NULL,NULL,'1',current_timestamp(),'0000-00-00 00:00:00.000000','0','front',current_timestamp());

INSERT INTO 
users
(idt_usr,doc_usr,nom_usr,tlf_usr,ema_usr,psw_usr,gnd_usr,pai_usr,ciu_usr,dir_usr,img_prf,log_usr,lst_upd,lst_ini,del_usr,stt_usr,fch_reg)
VALUES
('c4ca4238a0b923820dcc509a6f75849b','28195228','José Colmenares','+5804247407404','jose.omar0100@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','male','France','Auxerre',NULL,NULL,'1',current_timestamp(),'0000-00-00 00:00:00.000000','0','square',current_timestamp());

/*
  WALLETS
*/

INSERT INTO
wallet
(idt_wal,ema_usr,sal_wal,tip_div,fch_crc)
VALUES
('40a23b5a1941760e4052e5fbb695fa3f','beltz.18kyodai@gmail.com','1500',"USD",current_timestamp());

INSERT INTO
wallet (idt_wal,ema_usr,sal_wal,tip_div,fch_crc)
VALUES
('8425c885e1df56c06f979ca8677732ff','jose.omar0100@gmail.com','1500',"USD",current_timestamp());