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
  nom_usr TEXT NOT NULL,
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
  sal_wal DECIMAL(50,5) NOT NULL,
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
  ema_who -> Correo electrónico del usuario que recibe el depósito
  ema_frm -> Correo electrónico del usuario que realiza el depósito
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
  sal_dep DECIMAL(50,2) NOT NULL,
  tip_div VARCHAR(3) NOT NULL,
  con_dep VARCHAR(99) NOT NULL,
  stt_vst SET('0', '1') DEFAULT '0',
  fch_dep TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_dep),
  FOREIGN KEY (wal_who) REFERENCES wallet (idt_wal),
  FOREIGN KEY (wal_frm) REFERENCES wallet (idt_wal),
  FOREIGN KEY (ema_who) REFERENCES users (ema_usr),
  FOREIGN KEY (ema_frm) REFERENCES users (ema_usr)
);

/*
  TABLE SELL ORDER

  idt_sll -> Identificador unico de la orden de venta
  ema_usr -> Correo del usuario que vende
  idt_wal -> Identificador unico de la wallet del usuario
  mon_sll -> Monto del activo a vender
  tip_div -> Tipo de activo
  met_sll -> Método de pago
  tas_cmb -> Tasa de cambio de venta
  tip_act -> Tipo de activo que se desea recibir
  stt_sll -> Estatus de la venta
  fch_reg -> Fecha que se registró la orden de venta
*/

DROP TABLE IF EXISTS sell_order;
CREATE TABLE IF NOT EXISTS sell_order (
  idt_sll INT UNSIGNED NOT NULL AUTO_INCREMENT,
  ema_usr VARCHAR (50) NOT NULL,
  idt_wal VARCHAR(32) NOT NULL,
  mon_sll DECIMAL(50,2) NOT NULL,
  tip_div SET("USD","COP","VES") NOT NULL,
  met_sll SET("P2P", "Transferencia") NOT NULL,
  tas_cmb DECIMAL(10,2) NOT NULL,
  tip_act SET("USD","COP","VES") NOT NULL,
  stt_sll SET('0', '1') DEFAULT '1',
  fch_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_sll),
  FOREIGN KEY (ema_usr) REFERENCES users (ema_usr),
  FOREIGN KEY (idt_wal) REFERENCES wallet (idt_wal)
);

/*
  TABLE BUY ORDER

  ref_buy -> Número de referencia de compra
  idt_sll -> Identificador de la venta
  sll_wal -> Wallet del vendedor
  buy_wal -> Wallet del comprador
  mon_sll -> Monto comprado del activo
  tip_dvs -> Tipo de activo que se compró
  mon_buy -> Monto que se usó para comprar el activo
  tip_dvb -> Tipo de activo que se usó para comprar
  com_pag -> Comision que pagó por la compra
  stt_sll -> Estatus de la compra
  fch_reg -> Fecha en que se procesó la orden de compra
  fch_buy -> Fecha en que se completó la transaccion y se liberó el dinero
*/

DROP TABLE IF EXISTS buy_order;
CREATE TABLE IF NOT EXISTS buy_order (
  ref_buy VARCHAR(50)   NOT NULL,
  idt_sll INT UNSIGNED  NOT NULL,
  sll_wal VARCHAR(32)   NOT NULL,
  buy_wal VARCHAR(32)   NOT NULL,
  mon_sll DECIMAL(50,2) NOT NULL,
  tip_dvs SET("USD","COP","VES") NOT NULL,
  mon_buy DECIMAL(50,2) NOT NULL,
  tip_dvb SET("USD","COP","VES") NOT NULL,
  com_pag DECIMAL(10,5) NOT NULL,
  stt_sll SET('success', 'incompleted') DEFAULT 'success',
  fch_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fch_buy TIMESTAMP,
  PRIMARY KEY (ref_buy),
  FOREIGN KEY (idt_sll) REFERENCES sell_order (idt_sll),
  FOREIGN KEY (sll_wal) REFERENCES wallet (idt_wal),
  FOREIGN KEY (buy_wal) REFERENCES wallet (idt_wal)
);

/*
  TABLE ORDENANZAS COMPRA Y VENTA

  idt_ord -> Identificador único de la ordenanza
  tok_ord -> Token asociado a la ordenanza
  usu_def -> Usuario que creó la ordenanza
  ves_cop -> Tasa de cambio para VES y COP
  usd_ves -> Tasa de cambio para USD y VES
  cop_usd -> Tasa de cambio para COP y USD
  fch_reg -> Fecha de registro de la ordenanza
*/

DROP TABLE IF EXISTS ordenanzas_compra;
CREATE TABLE IF NOT EXISTS ordenanzas_compra (
  idt_ord INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  tok_ord VARCHAR(64)   NOT NULL,
  usu_def VARCHAR(50)   NOT NULL,
  ves_cop DECIMAL(10,2) NOT NULL,
  usd_ves DECIMAL(10,2) NOT NULL,
  cop_usd DECIMAL(10,2) NOT NULL,
  fch_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_ord),
  FOREIGN KEY (usu_def) REFERENCES users (ema_usr)
);

DROP TABLE IF EXISTS ordenanzas_venta;
CREATE TABLE IF NOT EXISTS ordenanzas_venta (
  idt_ord INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  tok_ord VARCHAR(64)   NOT NULL,
  usu_def VARCHAR(50)   NOT NULL,
  ves_cop DECIMAL(10,2) NOT NULL,
  usd_ves DECIMAL(10,2) NOT NULL,
  cop_usd DECIMAL(10,2) NOT NULL,
  fch_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_ord),
  FOREIGN KEY (usu_def) REFERENCES users (ema_usr)
);

/*
  TABLE ORDENANZAS COMPRA Y VENTA

  idt_ord -> Identificador único de la ordenanza
  tok_ord -> Token asociado a la ordenanza
  usu_def -> Usuario que creó la ordenanza
  cnt_cms -> Cantidad de comisión que se debita a Finex
  fch_reg -> Fecha de registro de la ordenanza
*/

DROP TABLE IF EXISTS ordenanzas_comision;
CREATE TABLE IF NOT EXISTS ordenanzas_comision (
  idt_ord INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  tok_ord VARCHAR(64)   NOT NULL,
  usu_def VARCHAR(50)   NOT NULL,
  cnt_com DECIMAL(10,5) NOT NULL,
  fch_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (idt_ord),
  FOREIGN KEY (usu_def) REFERENCES users (ema_usr)
);

/*
  TABLE CONVERSION
*/

/*DROP TABLE IF EXISTS conversion;
CREATE TABLE IF NOT EXISTS conversion (
  
);*/

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
  Trigger para descontar el saldo de la billetera cuando alguien vende
*/

CREATE TRIGGER sell_success AFTER UPDATE ON buy_order
FOR EACH ROW
UPDATE wallet
SET sal_wal = sal_wal - OLD.mon_sll
WHERE idt_wal = NEW.sll_wal AND tip_dvs = OLD.tip_dvs;

/*
  Trigger para sumar el saldo de la billetera cuando alguien compra
*/

CREATE TRIGGER buy_success AFTER UPDATE ON buy_order
FOR EACH ROW
UPDATE wallet
SET sal_wal = sal_wal + OLD.mon_sll
WHERE idt_wal = OLD.buy_wal;

/*
  Trigger para cambiar el status de una orden de venta, de activa a inactiva.
  Apenas un usuario procesa una orden de compra sobre ella
*/

CREATE TRIGGER deactivate_sell_order AFTER INSERT ON buy_order
FOR EACH ROW
UPDATE sell_order
SET stt_sll = '0'
WHERE idt_sll = NEW.idt_sll;

/*
  Trigger para descontar la comisión de la wallet de la persona que compra un activo
*/

CREATE TRIGGER discount_comission AFTER INSERT ON buy_order
FOR EACH ROW
UPDATE wallet
SET sal_wal = sal_wal - NEW.com_pag
WHERE idt_wal = NEW.buy_wal;

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

INSERT INTO
users
(idt_usr,doc_usr,nom_usr,tlf_usr,ema_usr,psw_usr,gnd_usr,pai_usr,ciu_usr,dir_usr,img_prf,log_usr,lst_upd,lst_ini,del_usr,stt_usr,fch_reg)
VALUES
('a87ff679a2f3e71d9181a67b7542122c', NULL, 'finex capital', '012346789', 'admin@finex.capital', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'Venezuela', 'San Cristóbal, Táchira', NULL, NULL, '0', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000', '0', 'front', CURRENT_TIMESTAMP);

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

INSERT INTO
wallet
(idt_wal,ema_usr,sal_wal,tip_div,fch_crc)
VALUES
('80b1e88ac33ef0ed48016082e779352f', 'admin@finex.capital', '0', 'USD', CURRENT_TIMESTAMP);

INSERT INTO
wallet
(idt_wal,ema_usr,sal_wal,tip_div,fch_crc)
VALUES
('f36cb6f626b70549c217be79c509b991', 'admin@finex.capital', '0', 'COP', CURRENT_TIMESTAMP);

INSERT INTO
wallet
(idt_wal,ema_usr,sal_wal,tip_div,fch_crc)
VALUES
('685bacca8030fe664dc21be7b78f0540', 'admin@finex.capital', '0', 'VES', CURRENT_TIMESTAMP);