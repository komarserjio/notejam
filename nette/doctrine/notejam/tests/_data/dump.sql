CREATE TABLE "notes" (
  "id" INTEGER NOT NULL,
  "user_id" INTEGER NOT NULL,
  "pad_id" INTEGER DEFAULT NULL,
  "name" VARCHAR(100) NOT NULL,
  "text" CLOB NOT NULL,
  "updated_at" DATETIME NOT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "FK_11BA68CA76ED395" FOREIGN KEY ("user_id") REFERENCES "users" ("id") NOT DEFERRABLE INITIALLY IMMEDIATE,
  CONSTRAINT "FK_11BA68C33F68EE9" FOREIGN KEY ("pad_id") REFERENCES "pads" ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE INDEX "IDX_11BA68CA76ED395" ON "notes" ("user_id");
CREATE INDEX "IDX_11BA68C33F68EE9" ON "notes" ("pad_id");
CREATE TABLE "pads" (
  "id" INTEGER NOT NULL,
  "user_id" INTEGER NOT NULL,
  "name" VARCHAR(100) NOT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "FK_CBF350B2A76ED395" FOREIGN KEY ("user_id") REFERENCES "users" ("id") NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE INDEX "IDX_CBF350B2A76ED395" ON "pads" ("user_id");
CREATE TABLE "users" (
  "id" INTEGER NOT NULL,
  "email" VARCHAR(60) NOT NULL,
  "password" VARCHAR(64) NOT NULL,
  "is_active" BOOLEAN NOT NULL,
  PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "UNIQ_1483A5E9E7927C74" ON "users" ("email");

INSERT INTO `notes` (`id`, `pad_id`, `user_id`, `name`, `text`, `updated_at`) VALUES
  (1, NULL, 1, 'Note 1', 'Lorem ipsum', '2015-11-14 20:29:08'),
  (2, 1, 1, 'Note 2', 'Lorem ipsum', '2015-11-14 20:29:47'),
  (3, 2, 1, 'Note 3', 'Lorem ipsum', '2015-11-14 20:29:53'),
  (4, 3, 1, 'Note 4', 'Lorem ipsum', '2015-11-14 21:35:56'),
  (5, NULL, 2, 'Other Note', 'Lorem ipsum', '2015-11-14 21:35:56');

INSERT INTO `pads` (`id`, `name`, `user_id`) VALUES
  (1, 'Pad 1', 1),
  (2, 'Pad 2', 1),
  (3, 'Pad 3', 1),
  (4, 'Other Pad', 2);

INSERT INTO `users` (`id`, `email`, `password`, `is_active`) VALUES
  (1, 'john.doe@example.com', '$2y$10$WEqgzJ/Q2UOcxfJc4qbTWup0.gZM6qxiINVeO.bElUtEBtamZiV5m', 1),
  (2, 'johnny.doey@example.com', '$2y$10$WEqgzJ/Q2UOcxfJc4qbTWup0.gZM6qxiINVeO.bElUtEBtamZiV5m', 1);
