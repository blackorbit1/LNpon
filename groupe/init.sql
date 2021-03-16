DROP TABLE IF EXISTS groupes;
CREATE TABLE groupes (
    id serial,
    user_id bigint,
    chemin varchar(100) UNIQUE,
    nature int,

    PRIMARY KEY (id)
);

