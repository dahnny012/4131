1.
A.
    CREATE TABLE customer (cid number(9),
    PRIMARY KEY(cid)
    );
    
    CREATE TABLE products(pid number(9),
    PRIMARY KEY(pid)
    );
    
    CREATE TABLE transactions(
    pid number(9), cid number(9),did varchar(255),
    PRIMARY KEY(cid,pid),
    FOREIGN KEY (cid) REFERENCES customer(cid),
    FOREIGN KEY (pid) REFERENCES products(pid),
    );
    
B.
    CREATE TABLE customer (cid number(9),
    PRIMARY KEY(cid)
    );
    
    CREATE TABLE products(pid number(9),
    PRIMARY KEY(pid)
    );
    
    CREATE TABLE transactions(
    pid number(9), cid number(9),did varchar(255),tid number(9)
    PRIMARY KEY(cid,pid,did),
    FOREIGN KEY (cid) REFERENCES customer(cid),
    FOREIGN KEY (pid) REFERENCES products(pid),
    );
C.

    CREATE TABLE products(pid number(9),
    PRIMARY KEY(pid)
    );
    
    CREATE TABLE transactions(
    pid number(9), cid number(9),did varchar(255) NOT NULL,
    PRIMARY KEY(cid,pid),
    FOREIGN KEY (pid) REFERENCES products(pid),
    );
D.
    CREATE TABLE product (pid number(9),
    PRIMARY KEY(pid)
    );
    
    CREATE TABLE transactions(
    pid number(9), cid number(9),
    did varchar(255) NOT NULL,
    PRIMARY KEY(cid),
    FOREIGN KEY (pid) REFERENCES product(pid),
    );
    
2.
    CREATE TABLE books(ISBN number(13), name varchar(255),authName varchar(255),pubName varchar(255)
    PRIMARY KEY(ISBN,authName)
    FOREIGN KEY(author_name) references authors(authName)
    FOREIGN KEY(pubName) references publishers(pubName)
    name NOT NULL,
    );
    
    CREATE TABLE publishers(pubName varchar(255),
    PRIMARY KEY(pubName)
    );
    
    CREATE TABLE authors(authName varchar(255),ISBN number(13)
    PRIMARY KEY(authName,ISBN),
    FOREIGN KEY(ISBN) references books(ISBN)
    );
    
    CREATE TABLE categories(catName varchar(255),
    parent varchar(255),
    PRIMARY KEY(catName,varchar)
    );
    
    CREATE TABLE bookstore(ISBN number(13),
    pubName varchar(255),
    authName varchar(255),
    catName(255),
    PRIMARY KEY(ISBN,pubName),
    FOREIGN KEY(ISBN) REFERENCES books(ISBN)
    ON DELETE CASCADE,
    FOREIGN KEY(authName) REFERENCES authors(authName),
    FOREIGN KEY(pubName) REFERENCES publishers(pubName),
    FOREIGN KEY(catName) REFERENCES categories(catName)
    );
  
3.
    CREATE TABLE professor(SSN number(8), salary num(7),
    phone varchar(10), DNO number(8),
    PRIMARY KEY(SSN),
    FOREIGN KEY(DNO) REFERENCES department(DNO)
    );
    
    CREATE TABLE department(DNO number(8), 
    budget num(7),
    name name(64),SSN number(8),
    PRIMARY KEY(DNO),
    FOREIGN KEY(SSN) REFERENCES professor(SSN)
    );
    
    CREATE TABLE grad_student(name varchar(55), 
    year number(4),
    SSN number(8),
    PRIMARY KEY(SSN,name,year),
    FOREIGN KEY(SSN) REFERENCES professor(SSN)
    );
    
    
C.
    1.
    Consider the following schema:
        - Students (sid: Integer, sname: String, year: Integer)
        - Courses (cid: Integer, cname: String, department: String)
        - OneStop (sid: Integer, cid: Integer, credits: Integer)

        
    a.
        Project(snames){
        Natural_join(Onestop Divided by Project(cids){Select(cname = "RDBMS" or "NoSQL"){Courses}},
                     Students)
        }
        
        
        
    b.
        Project(snames){
            Natural_join(Students, Onestop Divided By Project(cids){Select(department = "Computer Science"){Courses}})
        }
        
    c.
        Project(cid){
            Select(sid != sid2){
                Natural_join(Onestop,Rename(sid2,cid){Onestop})
            }
        }
    d.
        Project(sid,sid2){
            Select (year > year2){Cartesian(Students,Rename(sid2,year2){Students}}
        }
        
    e.
        Project(sid){
            natural_join(Students,
                Select(department = "Computer Science"){
                    natural_join(Onestop,Courses)
                },
                Select(department ="Electrical Engineering"){
                    natural_join(Onestop,Courses)
                }
            )
         }
         
         
         Project(sid){
            Students Difference Project(sid){
                Natural_join(Onestop, Select(department != "Computer Science" && department !="Electrical Engineering")
            {Courses})}
         }
         
    2.
        Consider the following schema:
        - SuppInfo (suppid: Integer, prodid: Integer)
        - Purchases (purchaseid: Integer, custid: Integer, prodid: Integer,purchaseMethod: Integer)
        
        a.
        Project(suppid,suppid2){
            Intersection(
                Project(suppid,prodid){SuppInfo},
                Project(suppid2,prodid2){
                    Rename(suppid2,prodid2){
                        SuppInfo
                    }
                }
            )
        }
        
        
        b.
        Project(custids){
			Select(suppid=suppid2 & prodid != proid2){
			Union(
                Project(suppid,prodid,purchaseMethod){Purchases},
                Project(suppid2,prodid2,purchaseMethod){
					Rename(Purchases2){
						Purchases
                }}
            )
        }
        
        
    3.
		- Bars(barId, location)
		- Beers(beerId, name)
		- Drinkers(did, age)
		- Serves(barId, beerId)
		- Frequents(did, barId)
		- Likes(did, beerId)

		
		
		Project(did){
			Natural_join(
				Natural_Join(
					Natural_Join(Drinkers,Frequents),Serves
				),
			Likes)
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
