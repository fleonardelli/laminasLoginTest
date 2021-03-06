-- I could have done a command to run the migrations here.

CREATE TABLE `user`
(
    id         INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    username   VARCHAR(100) NOT NULL UNIQUE KEY,
    password   VARCHAR(150) NOT NULL,
    last_login DATETIME DEFAULT NULL
);

CREATE TABLE content
(
    id      INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INTEGER UNSIGNED,
    title   VARCHAR(150) NOT NULL,
    `text`    VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES `user`(id)
);

