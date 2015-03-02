/* Csci 4707 Homework 2 Script */
-- Author: Christopher Jonathan

-- Part D Number 1

/* SuppInfo Table */

create table SuppInfo (
	suppid integer,
	prodid integer,
	primary key(suppid, prodid));

insert into SuppInfo values (1, 1);
insert into SuppInfo values (1, 2);
insert into SuppInfo values (2, 1);
insert into SuppInfo values (3, 1);
insert into SuppInfo values (4, 1);
insert into SuppInfo values (4, 2);
insert into SuppInfo values (5, 1);
insert into SuppInfo values (5, 2);
insert into SuppInfo values (5, 3);
	
/* Purchases Table */

create table Purchases (
	purchaseid integer,
	custid integer,
	prodid integer,
	purchaseMethod integer,
	primary key(purchaseid));
	
insert into Purchases values (1, 1, 1, 1);
insert into Purchases values (2, 1, 1, 2);
insert into Purchases values (3, 1, 1, 3);
insert into Purchases values (4, 2, 1, 1);
insert into Purchases values (5, 2, 1, 3);
insert into Purchases values (6, 3, 1, 1);
insert into Purchases values (7, 3, 1, 2);
insert into Purchases values (8, 4, 1, 1);
	
/* 
Problem D1a Expected Output

1,4 or 4,1
2,3 or 3,2

Problem D1b Expected Output

2
3

*/