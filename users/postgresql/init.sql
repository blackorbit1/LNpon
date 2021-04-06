ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';

CREATE TABLE users (
    id       SERIAL      PRIMARY KEY,
    pseudo   varchar(50) NOT NULL UNIQUE,
    status   int         NOT NULL,
    email    text        NOT NULL UNIQUE,
    password text        NOT NULL
);

ALTER TABLE users OWNER TO "www-data";
