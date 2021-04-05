#!/usr/bin/env bash
set -e

useradd postgres
su postgres

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS auth_db;
    DROP TABLE IF EXISTS auth;
    DROP ROLE IF EXISTS "postgres";

    CREATE ROLE "postgres" WITH LOGIN PASSWORD 'postgres';
    CREATE DATABASE "auth_db" OWNER "postgres";

    \c auth_db

    -- verifier que la table appartient bien à postgres (inherit from database ow)
    CREATE TABLE auth (
        id              SERIAL PRIMARY KEY,
        id_user         int    NOT NULL,
        token           int    NOT NULL UNIQUE,
        date_expiration date   NOT NULL DEFAULT now() + '1 hour'::interval
    );

EOSQL
