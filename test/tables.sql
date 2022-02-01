use `mereph`;

create table `products`
(
    `id`          INT auto_increment,
    `name`        VARCHAR(64)                                               not null,
    `description` TEXT                                                      null,
    `price`       INT                                                       not null,
    `type`        ENUM ('TEXT', 'FILE', 'ACTION') default 'TEXT'            not null,
    `value`       TEXT                                                      null,
    `createdAt`   TIMESTAMP                       default CURRENT_TIMESTAMP not null,
    constraint id
        primary key (`id`)
);

create unique index product_name
    on `products` (`name`);

