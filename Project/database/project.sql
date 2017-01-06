pragma foreign_keys=on;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS polls;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS choices;
DROP TABLE IF EXISTS answered;

CREATE TABLE users(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	username VARCHAR,
	password VARCHAR,
	name VARCHAR,
	email VARCHAR
);

create TABLE polls(
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	title VARCHAR NOT NULL,
	imageurl VARCHAR NOT NULL,
	description VARCHAR, 
	privateStatus INTEGER NOT NULL CHECK (privateStatus = 0 or privateStatus=1),
	owner INTEGER REFERENCES users (id)
);

create TABLE questions(
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	title VARCHAR NOT NULL,
	timesAnswered INTEGER NOT NULL DEFAULT 0,
	poll INTEGER REFERENCES polls (id)
);

create TABLE choices(
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	title VARCHAR NOT NULL,
	timesAnswered INTEGER NOT NULL DEFAULT 0,
	question INTEGER REFERENCES questions (id)
);

create TABLE answered(
	userID INTEGER REFERENCES users (id),
	poll INTEGER REFERENCES polls (id)
);

INSERT INTO users VALUES(NULL, 'user1', 'password1', 'Joao Pedro Milano Silva Cardoso', 'email@service.com');
INSERT INTO users VALUES(NULL, 'user2', 'password2', 'Joao Maria', 'emai2l@service.com');

INSERT INTO polls VALUES(NULL, 'First Poll', 'http://d3jgkzl5mcxi5w.cloudfront.net/2014/04/Poll_what-product_featured.jpg', 'Choose Yes or No', 0, 1);

INSERT INTO questions VALUES(NULL, 'Pergunta Generica 1', 0, 1);
INSERT INTO questions VALUES(NULL, 'Pergunta Generica 2', 0, 1);

INSERT INTO choices VALUES(NULL, 'Yes', 0, 1);
INSERT INTO choices VALUES(NULL, 'No', 0, 1);

INSERT INTO choices VALUES(NULL, 'Yes2', 0, 2);
INSERT INTO choices VALUES(NULL, 'No2', 0, 2);