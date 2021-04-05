#!/usr/bin/env bash
set -e

useradd postgres
su postgres

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS reactions_db;
    DROP TABLE IF EXISTS reactions;
    DROP ROLE IF EXISTS "postgres";

    CREATE ROLE "postgres" WITH LOGIN PASSWORD 'postgres';
    CREATE DATABASE "reactions" OWNER "postgres";

    \c reactions_db

    -- verifier que la table appartient bien à postgres (inherit from database owner)
    CREATE TABLE reactions (
        id      SERIAL PRIMARY KEY,
        emoji   varchar(10) UNIQUE,
        id_user int,
        id_post int,
        deleted boolean DEFAULT false
    );

EOSQL
