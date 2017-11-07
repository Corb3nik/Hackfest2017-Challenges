# Challenge users
CREATE USER IF NOT EXISTS 'level1'@'%' IDENTIFIED BY 'level1';
CREATE USER IF NOT EXISTS 'level2'@'%' IDENTIFIED BY 'level2';
CREATE USER IF NOT EXISTS 'level3'@'%' IDENTIFIED BY 'level3';
CREATE USER IF NOT EXISTS 'level4'@'%' IDENTIFIED BY 'level4';
CREATE USER IF NOT EXISTS 'level5'@'%' IDENTIFIED BY 'level5';

# Create databases
CREATE DATABASE IF NOT EXISTS level1;
CREATE DATABASE IF NOT EXISTS level2;
CREATE DATABASE IF NOT EXISTS level3;
CREATE DATABASE IF NOT EXISTS level4;
CREATE DATABASE IF NOT EXISTS level5;

# Create tables
CREATE TABLE IF NOT EXISTS level1.secrets (id int, secret varchar(255));
CREATE TABLE IF NOT EXISTS level2.secrets (id int, secret varchar(255));
CREATE TABLE IF NOT EXISTS level3.recipes (id int, recipe varchar(255));
CREATE TABLE IF NOT EXISTS level3.tokens  (id int, token varchar(255));
CREATE TABLE IF NOT EXISTS level4.recipes (id int, recipe varchar(255));
CREATE TABLE IF NOT EXISTS level4.`TOKEN{edf65cdde5abaf16e4a7a5f378ee302c}` (
  id int
);
CREATE TABLE IF NOT EXISTS level5.comic_books (id int, comic_book varchar(255));
CREATE TABLE IF NOT EXISTS level5.`mysterious_secret_table` (
  id int,
  1337_leet_haxor_token_column varchar(255),
  some_useless_column int
);

# Add rows
INSERT INTO level1.secrets (id, secret) VALUES
  (0, "Shhh don't tell anyone"),
  (1, "I love Britney Spears"),
  (2, "I wake up at 4AM to eat ice cream"),
  (3, "I killed my hamster when I was 11"),
  (4, "I ate my dog's food cause I was hungry once."),
  (12349127, "TOKEN{27ad9e262cdb63fa072ef4457a20526b}");

INSERT INTO level2.secrets (id, secret) VALUES
  (0, "Shhh don't tell anyone"),
  (1, "I love Britney Spears"),
  (2, "I wake up at 4AM to eat ice cream"),
  (3, "I killed my hamster when I was 11"),
  (4, "I ate my dog's food cause I was hungry once."),
  (99123315, "TOKEN{3de29c4befd158c9bb98570d9b8a052d}");

INSERT INTO level3.recipes (id, recipe) VALUES
  (0, "Spaghetti and meatballs"),
  (1, "Mac & Cheese"),
  (2, "Poutine"),
  (3, "Pogos"),
  (4, "Chicken alfredo"),
  (5, "Sushis");

INSERT INTO level3.tokens (id, token) VALUES (
  0, "TOKEN{81fbb5f37be58266f89dc381f62890ef}"
);

INSERT INTO level4.recipes (id, recipe) VALUES
  (0, "Spaghetti and meatballs"),
  (1, "Mac & Cheese"),
  (2, "Poutine"),
  (3, "Pogos"),
  (4, "Chicken alfredo"),
  (5, "Sushis");

INSERT INTO level5.comic_books (id, comic_book) VALUES
  (0, "Tintin"),
  (1, "Asterix and Obelix"),
  (2, "Superman"),
  (3, "Batman"),
  (4, "Wonder Woman"),
  (5, "Aquaman");

INSERT INTO level5.mysterious_secret_table (id, 1337_leet_haxor_token_column, some_useless_column)
VALUES (
  0, "TOKEN{aca23600d45ffd33a07dddd0668d04b1}", 0
);

# Grant permissions
GRANT ALL PRIVILEGES ON level1.* TO 'level1'@'%';
GRANT ALL PRIVILEGES ON level2.* TO 'level2'@'%';
GRANT ALL PRIVILEGES ON level3.* TO 'level3'@'%';
GRANT ALL PRIVILEGES ON level4.* TO 'level4'@'%';
GRANT ALL PRIVILEGES ON level5.* TO 'level5'@'%';
