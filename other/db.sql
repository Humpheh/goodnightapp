CREATE TABLE user (
    user_id SERIAL,
    user_username VARCHAR(20) NOT NULL,
    user_password VARCHAR(100) NOT NULL,
    user_weight INT NULL,
    user_gender ENUM('none', 'male', 'female'),
    user_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB;

CREATE TABLE session (
    session_id SERIAL,
    session_user BIGINT UNSIGNED,
    session_timestart TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    session_timefinish TIMESTAMP NULL DEFAULT NULL,

    FOREIGN KEY (session_id)
        REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE drink (
    drink_id SERIAL,
    drink_name VARCHAR(100) NOT NULL,
    drink_percent FLOAT NOT NULL,
    drink_congener FLOAT NULL,
    drink_picture VARCHAR(200) NULL,
    drink_calories INT
) ENGINE=INNODB;

CREATE TABLE sessiondrink (
    sessdr_id SERIAL,
    sessdr_session_id BIGINT UNSIGNED,
    sessdr_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sessdr_volume INT
) ENGINE=INNODB;
