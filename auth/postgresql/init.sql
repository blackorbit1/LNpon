ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
CREATE DATABASE auth_db OWNER "www-data";

CREATE TABLE auth (
    id              SERIAL PRIMARY KEY,
    id_user         int    NOT NULL,
    token           int    NOT NULL UNIQUE,
    date_expiration date   NOT NULL DEFAULT now() + '1 hour'::interval
);

ALTER TABLE auth OWNER TO "www-data";
