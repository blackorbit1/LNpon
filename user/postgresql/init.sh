#!/bin/bash
set -e

useradd www-data
su www-data

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS users_db;
    DROP TABLE IF EXISTS users;
    DROP ROLE IF EXISTS "www-data";

    CREATE ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
    CREATE DATABASE "users_db" OWNER "www-data";

    \c users_db

    -- verifier que la table appartient bien à www-data (inherit from database ow)
    CREATE TABLE users (
        id       SERIAL      PRIMARY KEY,
        pseudo   varchar(50) NOT NULL UNIQUE,
        status   int         NOT NULL,
        email    text        NOT NULL UNIQUE,
        password text        NOT NULL
    );

EOSQL