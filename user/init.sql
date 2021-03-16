DROP DATABASE IF EXISTS lnpon;
DROP ROLE IF EXISTS "www-data";

CREATE ROLE "www-data" WITH LOGIN;
CREATE DATABASE "lnpon" OWNER "www-data";

DROP TABLE IF EXISTS users;
CREATE TABLE user (
    id       bigint      PRIMARY KEY,
    pseudo   varchar(50) NOT NULL UNIQUE,
    status   int         NOT NULL,
    email    text        NOT NULL UNIQUE,
    password text        NOT NULL
);
