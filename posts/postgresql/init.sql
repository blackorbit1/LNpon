ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
CREATE DATABASE db_posts OWNER "www-data";

CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    nature int, -- 0 = post normal, 1+ = ???
    text_content text,
    created_at date default now(),
    id_user int,
    likes int default 0, -- là on a dit qu'on ferait pas comme ça parce que sinon tout le monde pourrait mettre autant de likes qu'il veut
    is_deleted boolean default false
);

ALTER TABLE posts OWNER TO "www-data";
