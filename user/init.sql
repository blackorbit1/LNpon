DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id       bigint      PRIMARY KEY,
    pseudo   varchar(50) NOT NULL UNIQUE,
    status   int         NOT NULL,
    email    text        NOT NULL UNIQUE,
    password text        NOT NULL
);
