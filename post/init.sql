DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    nature int, -- 0 = post normal, 1+ = ???
    texte text,
    date_ajout date,
    id_user int,
    likes int default 0, -- là on a dit qu'on ferait pas comme ça parce que sinon tout le monde pourrait mettre autant de likes qu'il veut
    deleted boolean default false,

    --PRIMARY KEY (id)
);

