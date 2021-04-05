#!/usr/bin/env bash
set -e

useradd postgres
su postgres

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS relations_db;
    DROP TABLE IF EXISTS relations;
    DROP ROLE IF EXISTS "postgres";

    CREATE ROLE "postgres" WITH LOGIN PASSWORD 'postgres';
    CREATE DATABASE "relations_db" OWNER "postgres";

    \c relations_db

    -- verifier que la table appartient bien à postgres (inherit from database ow)
    CREATE TABLE relations (
        id       SERIAL      PRIMARY KEY,
    );

EOSQL
