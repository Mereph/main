use `mereph`;

create table products
(
    id          int auto_increment
        primary key,
    name        varchar(64)                                                 null,
    description text                                                        null,
    price       int                                                         not null,
    type        enum ('TEXT', 'FILE', 'ACTION') default 'TEXT'              not null,
    value       text                                                        null,
    createdAt   timestamp                       default current_timestamp() not null,
    constraint name
        unique (name)
);

create table products_history
(
    id           INT auto_increment
        primary key,
    productionId INT                                   not null,
    userId       int                                   not null,
    boughtAt     timestamp default current_timestamp() not null
);

create table users
(
    id        int auto_increment
        primary key,
    login     varchar(32)                           not null,
    firstName varchar(32)                           null,
    lastName  varchar(32)                           null,
    email     varchar(64)                           null,
    password  char(32)                              not null,
    balance   int       default 0                   not null,
    changedAt timestamp default current_timestamp() not null on update current_timestamp(),
    createdAt timestamp default current_timestamp() not null,
    constraint email
        unique (email),
    constraint login
        unique (login)
);
