CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  email VARCHAR(75) NOT NULL,
  password VARCHAR(128) NOT NULL
);

CREATE TABLE IF NOT EXISTS pads (
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  name VARCHAR(100) NOT NULL,
  user_id INTEGER NOT NULL REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS notes (
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  pad_id INTEGER REFERENCES pads(id),
  user_id INTEGER NOT NULL REFERENCES users(id),
  name VARCHAR(100) NOT NULL,
  text text NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
);

INSERT INTO `notes` (`id`, `pad_id`, `user_id`, `name`, `text`, `created_at`, `updated_at`) VALUES
  (1, NULL, 1, 'Note 1', 'Lorem ipsum', '2015-11-14 20:24:14', '2015-11-14 20:29:08'),
  (2, 1, 1, 'Note 2', 'Lorem ipsum', '2015-11-14 20:29:47', '2015-11-14 20:29:47'),
  (3, 2, 1, 'Note 3', 'Lorem ipsum', '2015-11-14 20:29:53', '2015-11-14 20:29:53'),
  (4, 3, 1, 'Note 4', 'Lorem ipsum', '2015-11-14 21:09:34', '2015-11-14 21:35:56'),
  (5, NULL, 2, 'Other Note', 'Lorem ipsum', '2015-11-14 21:09:34', '2015-11-14 21:35:56');

INSERT INTO `pads` (`id`, `name`, `user_id`) VALUES
  (1, 'Pad 1', 1),
  (2, 'Pad 2', 1),
  (3, 'Pad 3', 1),
  (4, 'Other Pad', 2);

INSERT INTO `users` (`id`, `email`, `password`) VALUES
  (1, 'john.doe@example.com', '$2y$10$WEqgzJ/Q2UOcxfJc4qbTWup0.gZM6qxiINVeO.bElUtEBtamZiV5m'),
  (2, 'johnny.doey@example.com', '$2y$10$WEqgzJ/Q2UOcxfJc4qbTWup0.gZM6qxiINVeO.bElUtEBtamZiV5m');
