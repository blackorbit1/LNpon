DROP TABLE IF EXISTS reactions;
CREATE TABLE reactions (
    id bigint,
    emoji varchar(10) UNIQUE,
    id_user int,
    id_post int,
    deleted boolean default false,

    PRIMARY KEY (id)
);

