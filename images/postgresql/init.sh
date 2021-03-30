#!/bin/env bash
set -e

su www-data

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS images_db;
    DROP TABLE IF EXISTS images;
    DROP ROLE IF EXISTS "www-data";

    CREATE ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
    CREATE DATABASE "images_db" OWNER "www-data";

    \c images_db

    DROP TABLE IF EXISTS images;
    CREATE TABLE images (
        id SERIAL           PRIMARY KEY,
        user_id int         NOT NULL,
        chemin varchar(100) NOT NULL,
        nature int          NOT NULL,
    );

EOSQL
