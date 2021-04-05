#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS posts_db;
    DROP TABLE IF EXISTS posts;
    CREATE DATABASE "posts_db" OWNER "postgres";

    \c posts_db

    DROP TABLE IF EXISTS posts;
    CREATE TABLE posts (
        id SERIAL PRIMARY KEY,
        nature int, -- 0 = post normal, 1+ = ???
        texte text,
        date_ajout date,
        id_user int,
        likes int default 0, -- là on a dit qu'on ferait pas comme ça parce que sinon tout le monde pourrait mettre autant de likes qu'il veut
        deleted boolean default false
    );

EOSQL
