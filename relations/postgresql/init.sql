ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';

CREATE TABLE relations (
    id SERIAL PRIMARY KEY,
    nature int,
    id_user_a int,
    id_user_b int,
    is_deleted boolean default false
);

ALTER TABLE relations OWNER TO "www-data";
