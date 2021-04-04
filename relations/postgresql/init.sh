#!/usr/bin/env bash
set -e

useradd www-data
su www-data

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS relations_db;
    DROP TABLE IF EXISTS relations;
    DROP ROLE IF EXISTS "www-data";

    CREATE ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
    CREATE DATABASE "relations_db" OWNER "www-data";

    \c relations_db

    -- verifier que la table appartient bien à www-data (inherit from database ow)
    CREATE TABLE relations (
        id       SERIAL      PRIMARY KEY,
    );

EOSQL
