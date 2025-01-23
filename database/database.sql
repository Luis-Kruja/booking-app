SET FOREIGN_KEY_CHECKS = 0;

DROP DATABASE IF EXISTS dtkursi2;

CREATE DATABASE dtkursi2;

USE dtkursi2;

DROP TABLE IF EXISTS users;

CREATE TABLE users
(
    id                      INT          NOT NULL AUTO_INCREMENT,
    name                    VARCHAR(255) NOT NULL,
    email                   VARCHAR(255) NOT NULL,
    password                VARCHAR(255) NOT NULL,
    role                    VARCHAR(255) NOT NULL,
    login_attempts          INT          NULL,
    last_login_attempt      TIMESTAMP    NULL,
    email_verification_code INT          NULL,
    created_at              TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at              TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    email_verified_at       TIMESTAMP    NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS sessions;

CREATE TABLE sessions
(
    id             INT          NOT NULL AUTO_INCREMENT,
    user_id        INT          NOT NULL,
    remember_me_token VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

-- Apartments Table
DROP TABLE IF EXISTS apartments;

CREATE TABLE apartments
(
    id          INT          NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL,
    price       DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id)
);

-- Reviews Table
DROP TABLE IF EXISTS reviews;

CREATE TABLE reviews
(
    id            INT          NOT NULL AUTO_INCREMENT,
    apartment_id  INT          NOT NULL,
    user_id       INT          NULL,
    review        TEXT         NOT NULL,
    created_at    TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (apartment_id) REFERENCES apartments (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);


SET FOREIGN_KEY_CHECKS = 1;


