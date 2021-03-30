#!/bin/env bash
set -e

useradd www-data
su www-data

psql -v ON_ERROR_STOP=1 <<-EOSQL
    DROP DATABASE IF EXISTS groupes_db;
    DROP TABLE IF EXISTS groupes;
    DROP TABLE IF EXISTS groupes_members;
    DROP TABLE IF EXISTS groupes_posts;
    DROP ROLE IF EXISTS "www-data";

    CREATE ROLE "www-data" WITH LOGIN PASSWORD 'www-data';
    CREATE DATABASE "groupes" OWNER "www-data";

    \c groupes_db

    -- verifier que la table appartient bien à www-data (inherit from database ow)    
    CREATE TABLE groupes (
        id SERIAL       PRIMARY KEY,
        admin_id bigint NOT NULL,
        
    );
    CREATE TABLE groupes_members (
        id SERIAL       PRIMARY KEY,
        user_id bigint  NOT NULL,
        group_id bigint NOT NULL,

    );
    CREATE TABLE groupes_posts (
        id SERIAL       PRIMARY KEY,
        post_id bigint  NOT NULL,
        group_id bigint NOT NULL,
    );




EOSQL
