CREATE TABLE Answers (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    anser_text VARCHAR(255) NOT NULL
);

CREATE TABLE Companies (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    is_anon BOOLEAN NOT NULL,
    max_answers INT NOT NULL,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE Users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255),
    second_name VARCHAR(255),
    last_name VARCHAR(255),
    post_position VARCHAR(255),
    is_anon BOOLEAN NOT NULL,
    company_id INT NOT NULL,
    FOREIGN KEY (company_id) REFERENCES Companies (id)
);

CREATE TABLE UserAnswers (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    answer_id INT NOT NULL,
    answer_priority INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users (id),
    FOREIGN KEY (answer_id) REFERENCES Answers (id)
);

CREATE TABLE Admins (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(255) NOT NULL,
    password LONGTEXT NOT NULL
);