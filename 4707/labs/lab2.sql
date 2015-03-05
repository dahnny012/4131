--1. Print the names of professors who work in departments that have fewer than 50 PhD students

Select pname
from prof p,dept d
where d.numphds < 50 and p.dname = d.dname;


--2. Print the name(s) of the student(s) with the lowest GPA.

Select S.sname
from Student S
where S.gpa = (Select min(gpa) from Student);

--3. For each Computer Sciences class, print the cno, sectno, and the average GPA of the students
--enrolled in the class.


Select e1.cno,e1.sectno,avg(s1.gpa)
from enroll e1,student s1
Where  e1.dname = 'Computer Sciences' and e1.sid = s1.sid
group by dname,cno,sectno;

 
---4. Print the course names, course numbers and section numbers of all classes with less than six
--students enrolled in them.


Select e1.cno,count(e1.sid)
from enroll e1,course c1
where e1.cno = c1.cno
group by e1.cno
having count(e1.sid) < 6;

--5 Print the name(s) and sid(s) of the student(s) enrolled in the most (highest number of) classes.
With taken as (Select s1.sname,e1.sid, count(e1.cno) as classes
from enroll e1,student s1
where e1.sid = s1.sid
group by s1.sname,e1.sid)
Select taken.sname,taken.sid,taken.classes from taken
where taken.classes = (select max(taken.classes) from taken);

	
--6 Print the names of departments that have one or more majors who are under 18 years old.

Select dname from
major m,student s
where m.sid = s.sid and
s.age < 18;

-- 7 Print the names and majors of students who are taking one of the College Geometry courses. (Hint:
-- You’ll need to use the “like” predicate and the string matching character in your query.)


Select e.dname,s.sname
from enroll e,student s,course c
where c.cname like 'College Geometry %' and
s.sid = e.sid and c.cno = e.cno;

--8 For those departments that have no majors taking a College Geometry course, print the department
--name and the number of PhD students in the department.

Select d.dname , d.numphds
from dept d
where d.dname not in
(Select m.dname
from enroll e,major m,course c
where c.cname like 'College Geometry %' and
m.sid = e.sid and c.cno = e.cno);

--9 Print the names of students who are taking both a Computer Sciences course and a Mathematics course.

Select s.sname 
from student s
where s.sid in
(Select e1.sid
from enroll e1,enroll e2
where e1.dname = 'Computer Sciences' and e2.dname = 'Mathematics'
and e1.sid = e2.sid);


--10 Print the age difference between the old and youngest Computer Science major(s).


Select max(s.age)-min(s.age)
from major m , student s
where m.sid = s.sid and m.dname = 'Computer Sciences';


--11 For each department that has one or more majors with a GPA under 1.0, print the name of the
-- department and the average GPA of its majors.

Select m.dname ,avg(s.gpa) 
from major m ,student s
where m.sid = s.sid
and m.dname in 
(Select m.dname
from major m,student s
where s.gpa < 1.0 and m.sid = s.sid)
group by m.dname;


-- 12 Print the IDs, names, and GPAs of the students who are currently taking all of the Civil Engineering
-- courses.


Select s.sname , s.sid , s.gpa
from Student s
where not exists
	((Select c.cno from course c 
	where c.dname ='Civil Engineering')
		minus
		(Select e.cno from enroll e
		where e.sid = s.sid and dname = 'Civil Engineering'));
		


