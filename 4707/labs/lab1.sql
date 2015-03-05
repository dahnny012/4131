CREATE TABLE student (SID number(9),Name varchar(255), Major varchar(255), Standing varchar(255), Age number(3),
PRIMARY KEY (SID)
);

CREATE TABLE class (Name varchar(255),Schedule varchar(255), Room varchar(255),
PRIMARY KEY (Name),
UNIQUE (Schedule,Room)
);

CREATE TABLE enrolled (SID number(9), Name varchar(255),
PRIMARY KEY (SID,Name),
FOREIGN KEY (SID) REFERENCES student(SID) 
	ON DELETE CASCADE,
FOREIGN KEY (Name) REFERENCES class(Name)
);

INSERT INTO student VALUES (051135593,'Maria White','English','SR',21);
INSERT INTO student VALUES (060839453,'Charles Harris', 'Architecture','SR', 22);
INSERT INTO student VALUES (099354543,'Susan Martin','Law','JR',20);
INSERT INTO student VALUES (112348546,'Joseph Thompson','Computer Science','SO', 19);
INSERT INTO student VALUES (115987938,'Christopher Garcia','Computer Science','JR', 20);
INSERT INTO student VALUES (132977562,'Angela Martinez','History','SR',20);
INSERT INTO student VALUES (269734834,'Thomas Robinson','Psychology','SO', 18);
INSERT INTO student VALUES (280158572, 'Margaret Clark', 'Animal Science', 'FR', 18);



INSERT INTO class VALUES ('Data Structures', 'MWF 10:00­-11:00','R128');
INSERT INTO class VALUES ('Database Systems', 'MWF 12:30-­1:45', '1320 DCL');
INSERT INTO class VALUES ('Operating System Design', 'TuTh 12-­1:20', '20 AVW');
INSERT INTO class VALUES ('Archaeology of the Incas', 'MWF 3­4:15', 'R128');


INSERT INTO enrolled VALUES (051135593, 'Data Structures');
INSERT INTO enrolled VALUES (060839453, 'Data Structures');
INSERT INTO enrolled VALUES (051135593, 'Database Systems');
INSERT INTO enrolled VALUES (060839453, 'Database Systems');
INSERT INTO enrolled VALUES (051135593, 'Operating System Design');
INSERT INTO enrolled VALUES (099354543, 'Operating System Design');
INSERT INTO enrolled VALUES (112348546, 'Operating System Design');

INSERT INTO student VALUES (112348546, 'Juan Rodriguez','Psychology','JR', 20);

INSERT INTO class VALUES ('Algorithms', 'MWF 12:30-­1:45', '1320 DCL');

INSERT INTO enrolled VALUES (561254634, 'Data Structures');
INSERT INTO enrolled VALUES (051135593, 'Communication Networks');

DELETE FROM STUDENT WHERE SID = 051135593

DROP TABLE enrolled;
DROP TABLE student;
DROP TABLE class;








