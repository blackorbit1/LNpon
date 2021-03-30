#!/bin/env bash
set -e

useradd www-data
su www-data

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS auth_db;
    DROP TABLE IF EXISTS auth;
    DROP ROLE IF EXISTS "www-data";

    CREATE ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
    CREATE DATABASE "auth_db" OWNER "www-data";

    \c auth_db

    -- verifier que la table appartient bien à www-data (inherit from database ow)
    CREATE TABLE auth (
        id              SERIAL      PRIMARY KEY,
        id_user         int         NOT NULL,
        token           int         NOT NULL UNIQUE,
        date_expiration date        NOT NULL,
        password        text        NOT NULL
    );

EOSQL
