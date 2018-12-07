CREATE DATABASE IF NOT EXISTS notejam;

CREATE TABLE IF NOT EXISTS notejam.users (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  email VARCHAR(75) NOT NULL,
  password VARCHAR(128) NOT NULL
);

CREATE TABLE IF NOT EXISTS notejam.pads (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  name VARCHAR(100) NOT NULL,
  user_id INT NOT NULL REFERENCES notejam.users(id)
);

CREATE TABLE IF NOT EXISTS notejam.notes (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  pad_id INT REFERENCES notejam.pads(id),
  user_id INT NOT NULL REFERENCES notejam.users(id),
  name VARCHAR(100) NOT NULL,
  text text NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW()
);

INSERT INTO notejam.users
  (id, email, password)
VALUES
  (1, 'user1@example.com', '$2a$10$mhkqpUvPPs.zoRSTiGAEKODOJMljkOY96zludIIw.Pop1UvQCTx8u'),
  (2, 'user2@example.com', '$2a$10$mhkqpUvPPs.zoRSTiGAEKODOJMljkOY96zludIIw.Pop1UvQCTx8u');

INSERT INTO notejam.pads
  (id, name, user_id)
VALUES
  (1, 'Pad 1', 1),
  (2, 'Pad 2', 1),
  (3, 'Pad A', 2),
  (4, 'Pad B', 2);

INSERT INTO notejam.notes
  (id, pad_id, user_id, name, text)
VALUES
  (1, 1, 1, 'Note 1', 'Text'),
  (2, 2, 1, 'Note 2', 'Text'),
  (3, 3, 2, 'Note A', 'Text'),
  (4, 4, 2, 'Note B', 'Text');
