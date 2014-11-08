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
    session_user_id BIGINT UNSIGNED,
    session_timestart TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    session_timefinish TIMESTAMP NULL DEFAULT NULL,

    FOREIGN KEY (session_user_id)
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
    drink_calories INT,
    drink_type1 VARCHAR(100) NULL,
    drink_type2 VARCHAR(100) NULL,
    drink_type1_ml FLOAT NULL,
    drink_type2_ml FLOAT NULL
) ENGINE=INNODB;

CREATE TABLE sessiondrink (
    sessdr_id SERIAL,
    sessdr_session_id BIGINT UNSIGNED,
    sessdr_drink_id BIGINT UNSIGNED,
    sessdr_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sessdr_volume INT,
    sessdr_ebac_before FLOAT NOT NULL,
    sessdr_ebac_after FLOAT NOT NULL,

    FOREIGN KEY (sessdr_session_id)
        REFERENCES session(session_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (sessdr_drink_id)
        REFERENCES drink(drink_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=INNODB;
