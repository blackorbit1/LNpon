DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id bigint,
    pseudo varchar(100) UNIQUE,
    etat int,
    email text,
    mdp text,

    PRIMARY KEY (id)
);

