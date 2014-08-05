DROP TABLE IF EXISTS `users`;
CREATE TABLE "users" (
    "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
    "email" varchar(75) NOT NULL,
    "password_hash" varchar(128) NOT NULL,
    "auth_key" varchar(128) NOT NULL
);
DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` varchar(255) NOT NULL,
	`text` text NOT NULL,
	`user_id` integer NOT NULL,
	`pad_id` integer,
	`created_at` datetime NOT NULL,
	`updated_at` datetime NOT NULL
);
DROP TABLE IF EXISTS `pads`;
CREATE TABLE `pads` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` varchar(255) NOT NULL,
	`user_id` integerNOT NULL
);

INSERT INTO `users` VALUES (1,'exists@example.com', '$2y$13$s0dIWiJpvh3KlFZ5ZuyZA.iMm5Cw2KHGf5BYK9uNYF01d2auOmFPC', 'nUWe8LhAq35ITtrpekIk0F308bGcTZ0Z');
INSERT INTO `users` VALUES (2,'exists2@example.com', '$2y$13$s0dIWiJpvh3KlFZ5ZuyZA.iMm5Cw2KHGf5BYK9uNYF01d2auOmFPC', 'nUWe8LhAq35ITtrpekIk0F308bGcTZ0Z');

INSERT INTO `pads` VALUES (1, 'Pad name', '1');
INSERT INTO `pads` VALUES (2, 'Pad name 2', '2');

INSERT INTO `notes` VALUES (1, 'Note name', 'Note text', 1, 1, '04-04-2014', '04-04-2014');
