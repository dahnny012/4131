/*Select Distinct S1.suppid,S2.suppid from SuppInfo S1,SuppInfo S2*/
/*Where S1.suppid != S2.suppid and S1.suppid < S2.suppid  and S1.prodid = S2.prodid;*/


Select S1.suppid,S2.suppid
from SuppInfo S1,SuppInfo S2
Intersect
Select S1.suppid,S2.suppid
 From SuppInfo S1
Join SuppInfo S2 on S1.prodid = S2.prodid
 And S1.suppid < S2.suppid
Join SuppInfo dif on dif.prodid != S1.prodid
 And dif.suppid = S2.suppid;

