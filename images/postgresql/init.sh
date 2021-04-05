#!/usr/bin/env bash
set -e

useradd postgres
su postgres

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS images_db;
    DROP TABLE IF EXISTS images;
    DROP ROLE IF EXISTS "postgres";

    CREATE ROLE "postgres" WITH LOGIN PASSWORD 'postgres';
    CREATE DATABASE "images_db" OWNER "postgres";

    \c images_db

    CREATE TABLE images (
        id SERIAL           PRIMARY KEY,
        user_id int         NOT NULL,
        chemin varchar(100) NOT NULL,
        nature int          NOT NULL
    );

EOSQL
