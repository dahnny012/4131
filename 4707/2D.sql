/* 1A */

Select S1.suppid,S2.suppid
From SuppInfo S1,SuppInfo S2
Where S1.prodid = S2.prodid and S1.suppid < S2.suppid
Minus (Select S3.suppid,S4.suppid
  From SuppInfo S3,SuppInfo S4
  Where S3.prodid != S4.prodid
);

/* 1B */
Select Distinct custid
From (Select P1.custid
	From Purchases P1,Purchases P2
		Where P1.custid = P2.custid and P1.purchaseMethod != P2.purchaseMethod)
Where custid Not In
	(Select P1.custid
	From Purchases P1,Purchases P2,Purchases P3
	Where P1.custid = P2.custid and P2.custid = P3.custid  
	and P1.purchaseMethod != P2.purchaseMethod 
	and  P1.purchaseMethod != P3.purchaseMethod
	and P2.purchaseMethod != P3.purchaseMethod);
	 
	
	
/*2D*/
Select Distinct S1.barId,S2.barId
From Serves S1,Serves S2
Where S1.beerId = S2.beerId and S1.barId < S2.barId
and (S1.barId,S2.barId) not in (Select S3.barId,S4.barId
  From Serves S3,Serves S4
  Where S3.beerId != S4.beerId);

/* 3D */
Select C1.cname From
/* Get Cids where they dont exist there */
	(Select B1.cid
	From Buys B1
	Where Not Exists
/*Get customers who did not buy products bought by all customers */
	(Select B2.cid ,Count(distinct B2.cid) as cCount
	From Buys B2
	Group by B2.cid
	Having Count(distinct B2.cid) < (Select Count(cid) From Customer))) allbuys,Customer C1
	Where allBuys.cid = C1.cid; 


/* 4D */

Select A.name
From Actors A,Movies M,Cast C
Where M.did in (Select did from Directors where name = 'Spielberg')
And C.mid = M.mid and A.aid = C.aid
Minus
	(Select A.Name From Actors A,Movies M,Cast C 
	Where M.did Not in (Select did from Directors where name = 'Spielberg')
	And C.mid = M.mid and A.aid = C.aid);
