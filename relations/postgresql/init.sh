#!/bin/env bash
set -e

su www-data

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS relations_db;
    DROP TABLE IF EXISTS relations;
    DROP ROLE IF EXISTS "www-data";

    CREATE ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
    CREATE DATABASE "users_db" OWNER "www-data";

    \c users_db

    -- verifier que la table appartient bien à www-data (inherit from database ow)
    CREATE TABLE relations (
        id       SERIAL      PRIMARY KEY,
    );

EOSQL
