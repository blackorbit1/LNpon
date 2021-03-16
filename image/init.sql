DROP TABLE IF EXISTS images;
CREATE TABLE images (
    id serial,
    user_id bigint,
    chemin varchar(100) UNIQUE,
    nature int,

    PRIMARY KEY (id)
);

