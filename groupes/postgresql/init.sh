#!/usr/bin/env bash
set -e

useradd postgres
su postgres

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS groupes_db;
    DROP TABLE IF EXISTS groupes;
    DROP TABLE IF EXISTS groupes_members;
    DROP TABLE IF EXISTS groupes_posts;
    DROP ROLE IF EXISTS "postgres";

    CREATE ROLE "postgres" WITH LOGIN PASSWORD 'postgres';
    CREATE DATABASE "groupes" OWNER "postgres";

    \c groupes_db

    -- verifier que la table appartient bien à postgres (inherit from database owner)
    CREATE TABLE groupes (
        id SERIAL       PRIMARY KEY,
        admin_id bigint NOT NULL
    );

    CREATE TABLE groupes_members (
        id SERIAL       PRIMARY KEY,
        user_id bigint  NOT NULL,
        group_id bigint NOT NULL
    );

    CREATE TABLE groupes_posts (
        id SERIAL       PRIMARY KEY,
        post_id bigint  NOT NULL,
        group_id bigint NOT NULL
    );

EOSQL
