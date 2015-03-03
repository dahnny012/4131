/*Select Distinct S1.suppid,S2.suppid from SuppInfo S1,SuppInfo S2*/
/*Where S1.suppid != S2.suppid and S1.suppid < S2.suppid  and S1.prodid = S2.prodid;*/


/*Select S1.suppid,S2.suppid from SuppInfo S1,SuppInfo S2 Intersect */



/*Temp1
Select S1.suppid,S2.prodid From 

/*All Pairs*/
/*(Select S1.proid , S2.proid From Join SuppInfo S2 on S1.prodid = S2.prodid And S1.suppid < S2.suppid)*/

/* All difs */
/*Join SuppInfo dif on dif.prodid != S1.prodid And dif.suppid = S2.suppid;*/



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
	 
	


/* 3D */
/*Look at Customer that has only bought from that All and not from Not All*/

Select C1.name where 
(Select cid From 
/* Table of Products bought by all customers */
(Select pid 
From Buys B1
Group by B1.pid
Having Count(distinct cid) = (Select Count(cid) From Customer))
Where Not Exists 
/*Get Table of products not bought by all customers */
	(Select pid From Buys B1
	Group by B1.pid 
	Having Count(distinct cid) < (Select Count(cid) From Customer))) as allbuys,Customer C1
Where allbuys.cid = C1.cid



		

/* 4D */

Select A.name
From Actors A,Movies M,Cast C
Where M.did = (Select did from Directors where name = "Spielberg")
And C.mid = M.mid
Except
	(Where M.did != (Select did from Directors where name = "Spielberg")
	And C.mid = M.mid)
