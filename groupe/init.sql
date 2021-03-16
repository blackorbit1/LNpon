DROP TABLE IF EXISTS groupes;
CREATE TABLE groupes (
    id SERIAL       PRIMARY KEY,
    admin_id bigint NOT NULL,
    
);

DROP TABLE IF EXISTS groupes_members;
CREATE TABLE groupes_members (
    id SERIAL       PRIMARY KEY,
    user_id bigint  NOT NULL,
    group_id bigint NOT NULL,

);


DROP TABLE IF EXISTS groupes_posts;
CREATE TABLE groupes_posts (
    id SERIAL       PRIMARY KEY,
    post_id bigint  NOT NULL,
    group_id bigint NOT NULL,
);

