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
    pid number(9), cid number(9),did varchar(255),
    PRIMARY KEY(cid,pid,did),
    FOREIGN KEY (cid) REFERENCES customer(cid),
    FOREIGN KEY (pid) REFERENCES products(pid),
    );
    
C.

    CREATE TABLE product (pid number(9),
    PRIMARY KEY(pid)
    );
    
    CREATE TABLE customer (cid number(9),pid number(9),
    PRIMARY KEY(cid)
    FOREIGN KEY(pid) REFERENCES products(pid)
    );
    
    CREATE TABLE transactions(
    pid number(9), cid number(9),did varchar(255),
    PRIMARY KEY(cid,pid),
    FOREIGN KEY (cid) REFERENCES customer(cid),
    FOREIGN KEY (pid) REFERENCES product(pid),
    );
    
D.

    CREATE TABLE customer (cid number(9),
    PRIMARY KEY(cid)
    );
    
    CREATE TABLE products(pid number(9),
    PRIMARY KEY(pid)
    );
    
    CREATE TABLE transactions(
    pid number(9), cid number(9),did varchar(255),
    PRIMARY KEY(cid,did),
    FOREIGN KEY (cid) REFERENCES customer(cid),
    FOREIGN KEY (pid) REFERENCES products(pid),
    );
    
2.
    CREATE TABLE books(ISBN number(13), name varchar(255),
    PRIMARY KEY(ISBN)
    );
    
    CREATE TABLE publishers(pubName varchar(255),
    PRIMARY KEY(pubName)
    );
    
    CREATE TABLE authors(authName varchar(255),
    PRIMARY KEY(authName)
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
    year number(4) NOT NULL,
    SSN number(8),
    PRIMARY KEY(SSN,name,year),
    FOREIGN KEY(SSN) REFERENCES professor(SSN)
    );
    
    
4.