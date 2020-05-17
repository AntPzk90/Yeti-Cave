DROP DATABASE IF EXISTS yeticave;
CREATE DATABASE yeticave
 DEFAULT CHARACTER SET utf8
 DEFAULT COLLATE utf8_general_ci;

USE yeticave;
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title CHAR(64) NOT NULL UNIQUE,
  symbol CHAR(64) NOT NULL UNIQUE
);
DROP TABLE IF EXISTS lots;
CREATE TABLE lots (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  title CHAR(80),
  dscr TEXT,
  img_path CHAR(255) DEFAULT NULL,
  start_price INT DEFAULT 0,
  price INT,
  step INT NOT NULL,
  dt_fin TIMESTAMP NOT NULL,
  id_user INT,
  id_winner INT,
  id_category INT
);
DROP TABLE IF EXISTS bids;
CREATE TABLE bids (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  price INT NOT NULL,
  id_lot INT,
  id_user INT
);
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email CHAR(64) NOT NULL UNIQUE ,
  date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name_user CHAR(64) NOT NULL UNIQUE,
  pass CHAR(64) NOT NULL,
  contacts CHAR(64),
  id_lot INT,
  id_bid INT
);



