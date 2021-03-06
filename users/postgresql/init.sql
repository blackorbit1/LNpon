ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';

CREATE TABLE users (
    id_user       SERIAL      PRIMARY KEY,
    pseudo   varchar(50) NOT NULL UNIQUE,
    status   int         NOT NULL DEFAULT 0,
    email    text        NOT NULL UNIQUE,
    password text        NOT NULL
);

ALTER TABLE users OWNER TO "www-data";
