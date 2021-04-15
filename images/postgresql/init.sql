ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';

CREATE TABLE images (
    id SERIAL           PRIMARY KEY,
    user_id int         NOT NULL,
    chemin varchar(100) NOT NULL,
    nature int          NOT NULL
);

ALTER TABLE images OWNER TO "www-data";
