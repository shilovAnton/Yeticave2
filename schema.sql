CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeticave;


create table categories
(
    id             int auto_increment
        primary key,
    category_name  varchar(50) not null,
    character_code varchar(50) not null,
    constraint categories_category_name_uindex
        unique (category_name)
);


create table users
(
    id          int auto_increment
        primary key,
    user_name   varchar(30)  not null,
    email       varchar(60)  not null,
    passport    varchar(60)  not null,
    data_reg    timestamp    null,
    contact_inf varchar(500) not null,
    tel         varchar(20)  not null,
    constraint users_email_uindex
        unique (email),
    constraint users_user_name_uindex
        unique (user_name)
);


create table lots
(
    id              int auto_increment
        primary key,
    author_id       int         not null,
    lot_name        varchar(50) not null,
    category_id     int         not null,
    description_lot text        null,
    date_add        timestamp   not null,
    initial_rate    int         not null,
    rate_step       int         not null,
    img             varchar(50) null,
    constraint lots_categories_id_fk
        foreign key (category_id) references categories (id),
    constraint lots_users_id_fk
        foreign key (author_id) references users (id)
);

create index lots_date_add_index
    on lots (date_add);

create index lots_lot_name_index
    on lots (lot_name);


create table rates
(
    id        int auto_increment
        primary key,
    lot_id    int       not null,
    author_id int       not null,
    rate      int       not null,
    date_rate timestamp not null,
    constraint rates_lots_id_fk
        foreign key (lot_id) references lots (id),
    constraint rates_users_id_fk
        foreign key (author_id) references users (id)
);

create index rates_rate_index
    on rates (rate);

