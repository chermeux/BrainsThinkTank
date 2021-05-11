drop DATABASE if exists brains;
create database brains;
use brains;
create table articles
(
    id           int                                not null
        primary key,
    image        varchar(255)                       null,
    titre        varchar(255)                       not null,
    texte        longtext                           null,
    datedermodif datetime default CURRENT_TIMESTAMP not null
);

create table evenements
(
    id    int          not null
        primary key,
    image varchar(255) null,
    Titre varchar(255) not null,
    texte longtext     null,
    date  date         null,
    lieu  varchar(512) null
);

create table user
(
    ID       int          not null
        primary key,
    NAME     varchar(32)  not null,
    PASSWORD varchar(255) not null,
    EMAIL    varchar(255) not null,
    constraint USER_EMAIL_uindex
        unique (EMAIL),
    constraint USER_NAME_uindex
        unique (NAME)
);

