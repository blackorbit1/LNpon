ALTER ROLE "www-data" WITH LOGIN PASSWORD 'www-data';

CREATE TABLE groupes (
                         id SERIAL       PRIMARY KEY,
                         admin_id bigint NOT NULL,
                         group_name varchar(100) NOT NULL,
                         deleted boolean default false
);

CREATE TABLE groupes_members (
                                 id SERIAL       PRIMARY KEY,
                                 user_id bigint  NOT NULL,
                                 group_id bigint NOT NULL,
                                 deleted boolean default false
);

CREATE TABLE groupes_posts (
                               id SERIAL       PRIMARY KEY,
                               post_id bigint  NOT NULL,
                               group_id bigint NOT NULL,
                               deleted boolean default false
);

ALTER TABLE groupes OWNER TO "www-data";
ALTER TABLE groupes_members OWNER TO "www-data";
ALTER TABLE groupes_posts OWNER TO "www-data";
