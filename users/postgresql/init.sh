#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS users_db;
    DROP TABLE IF EXISTS users;
    CREATE DATABASE "users_db" OWNER "postgres";

    \c users_db

    -- verifier que la table appartient bien à postgres (inherit from database ow)
    CREATE TABLE users (
        id       SERIAL      PRIMARY KEY,
        pseudo   varchar(50) NOT NULL UNIQUE,
        status   int         NOT NULL,
        email    text        NOT NULL UNIQUE,
        password text        NOT NULL
    );

EOSQL
