DROP TABLE IF EXISTS images;
CREATE TABLE images (
    id SERIAL           PRIMARY KEY,
    user_id int         NOT NULL,
    chemin varchar(100) NOT NULL,
    nature int          NOT NULL,

);

