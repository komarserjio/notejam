CREATE TABLE "notes" (
    "id" integer NOT NULL PRIMARY KEY,
    "pad_id" integer REFERENCES "pads" ("id"),
    "user_id" integer NOT NULL REFERENCES "users" ("id"),
    "name" varchar(100) NOT NULL,
    "text" text NOT NULL,
    "created_at" datetime NOT NULL,
    "updated_at" datetime NOT NULL
)
;

CREATE TABLE "pads" (
    "id" integer NOT NULL PRIMARY KEY,
    "name" varchar(100) NOT NULL,
    "user_id" integer NOT NULL REFERENCES "users" ("id")
)
;


CREATE TABLE "users" (
    "id" integer NOT NULL PRIMARY KEY,
    "email" varchar(75) NOT NULL,
    "password" varchar(128) NOT NULL
);
