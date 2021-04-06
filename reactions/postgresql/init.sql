ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
--CREATE DATABASE reactions_db OWNER "www-data";

CREATE TABLE reactions (
   id      SERIAL PRIMARY KEY,
   emoji   varchar(10),
   id_user int,
   id_post int,
   deleted boolean DEFAULT false
);

ALTER TABLE reactions OWNER TO "www-data";
