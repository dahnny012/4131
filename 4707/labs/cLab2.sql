drop table enroll;
drop table section;
drop table major;
drop table course;
drop table prof;
drop table dept;
drop table student;

CREATE TABLE student (sid number(5),sname varchar(32), sex varchar(3), age number(3),year number(4) ,gpa float,
PRIMARY KEY (sid)
);

CREATE TABLE dept (dname varchar(32),numphds number(5),
Primary key (dname)
);

CREATE TABLE prof (pname varchar(32),dname varchar(32),
primary key (pname)
);


CREATE TABLE course(cno number(5),cname varchar(32),dname varchar(32),
primary key (cno,dname),
foreign key (dname) references dept(dname)
);

create table major(dname varchar(32),sid number(5),
primary key (dname,sid),
foreign key (dname) references dept(dname),
foreign key (sid) references student(sid)
);

create table section (dname varchar(32),cno number(5),sectno number(5),pname varchar(32),
primary key(dname,cno,sectno),
foreign key(cno,dname) references course(cno,dname)
);

create table enroll(sid number(5),grade number(4),dname varchar(32),cno number(5),sectno number(5),
primary key(sid,dname,cno,sectno),
foreign key(sid) references student(sid),
foreign key(dname,cno,sectno) references section(dname,cno,sectno)
);
