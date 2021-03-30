#!/bin/env bash
set -e

useradd www-data
su www-data

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS reactions_db;
    DROP TABLE IF EXISTS reactions;
    DROP ROLE IF EXISTS "www-data";

    CREATE ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
    CREATE DATABASE "reactions" OWNER "www-data";

    \c reactions_db

    -- verifier que la table appartient bien à www-data (inherit from database ow)    
    CREATE TABLE reactions (
        id bigint,
        emoji varchar(10) UNIQUE,
        id_user int,
        id_post int,
        deleted boolean default false,

        PRIMARY KEY (id)
    );



EOSQL
