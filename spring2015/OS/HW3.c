1) Assume that we have a demand-paged memory. The
page table is held in registers. It takes 8 milliseconds to service a page fault if an
empty frame is available or if the replaced page is not modified and 20
milliseconds if the replaced page is modified. Memory-access time is 100
nanoseconds. Assume that the page to be replaced is modified 70 percent of the
time. What is the maximum acceptable page-fault rate for an effective access
time of no more than 200 nanoseconds?

8 ms =  pf for an empty frame/not dirty
20 ms =  if dirty
100 ns = memory access
page replaced 70% of time.

max acceptable pf rate <= 200 ns

where p = % page faults

(1-p)*MA  + p(.7 *(dirty) + *.3(empty/not dirty)) = 200 ns
(1 − p) ∗ 100 + 0.7 ∗ p ∗ 20000000 + 0.3 ∗ p ∗ 8000000 = 200
(14000000 + 2400000 − 100)p = 100
p = 100/(16400100) = 6.1 ∗ 10−6 = .0000061 = .00061%


2)  Assume that you are monitoring the rate at which the
pointer in the clock algorithm moves. (The pointer indicates the candidate page
for replacement.) What can you say about the system if you notice the following
behavior:
a. Pointer is moving fast.
    If the clock is moving fast then it means the 
    system is accessesing large amounts of memory. Either shared among processes
    or one processes is requesting large amounts of memory itself. 
    
    Another implication is that it also means that page faults are frequent
    if the pointer in clock has to move constantly to find new pages.
    
    Stemming from that implication, the page that clock hand is pointed to
    is being referenced often meaning it can't be replaced. The system is using 
    the memory at the same rate its requesting new memory.
    
b. Pointer is moving slow.
    
    If the clock is moving slow then smaller amounts of memory is being 
    simultaneously used or it is efficiently using it's memory.
    
    Page faults are less frequent in the system and when one does happen,
    memory requested is used for only short time before new memory is 
    being requested. Because of that the clock pointer will not move as fast 
    trying to find a non-referenced page.
    
3)

A page-replacement algorithm should minimize the
number of page faults. We can achieve this minimization by distributing heavily
used pages evenly over all of memory, rather than having them compete for a
small number of page frames. We can associate with each page frame a counter
of the number of pages associated with that frame. Then, to replace a page, we
can search for the page frame with the smallest counter.

a. Define a page-replacement algorithm using this basic idea. Specifically
address these problems:

i. What is the initial value of the counters?

0 no page is currently using the frames. 

ii. When are counters increased?

When a new page is associated with that frame.

iii. When are counters decreased?

When a page in that frame is no longer needed.(process using it exits)

iv. How is the page to be replaced selected?

The frame with least amount of page associations. In the event of a tie, pick the
one that came in first. 


b. How many page faults occur for your algorithm for the following reference
string with four page frames?

1, 2, 3, 4, 5, 3, 4, 1, 6, 7, 8, 7, 8, 9, 7, 8, 9, 5, 4, 5, 4, 2.
 
 1 1 1 1  
[1,2,3,4] (4)
 2 1 1 1
[5,2,3,4] (5)
 2 2 1 1 
[5,1,3,4] (6)
 3 2 2 2
[8,1,6,7] (9)
 3 3 2 2
[8,9,6,7] (10)
 3 3 3 3
[8,9,5,4] (12)
 4 3 3 3 
[2,9,5,4] (13) 

13 Page faults.


c. What is the minimum number of page faults for an optimal page replacement
strategy for the reference string in part b with four page frames?

[1,2,3,4] (4)
[1,5,3,4] (5)
[6,5,7,8] (8)
[9,5,7,8] (9)
[4,5,7,8] (10)
[4,5,7,2] (11)

11 page faults


4) Some systems provide file sharing by maintaining a
single copy of a file. Other systems maintain several copies, one for each of the
users sharing the file. Discuss the relative merits of each approach.

Single file:
+ Less memory consumed.   
- Harder to make changes to the file if it 
currently being read by other users.

Several copies:
+ Users are able to keep their own revisions for making changes. The changes
can later propagate towards the other copies of the file.

- Uses more memory.



5) Some file systems allow disk storage to be allocated at
different levels of granularity. For instance, a file system could allocate 4 KB of
disk space as a single 4-KB block or as eight 512-byte blocks. How could we
take advantage of this flexibility to improve performance? What modifications
would have to be made to the free-space management scheme in order to
support this feature?

When allocating a space, non even amounts of space would create internal
fragmentation. a 6kb disk space would be allocated on the old system 
as 2 4kb blocks. On the the new system it would be one 4kb block and four 512B 
blocks. Thus decreasing internal fragmentation.

THe free-space manager has to divide the blocks in the bitmap into small chucks
of 512 and group them into 4kb clusters. It also needs to know when each cluster
is being used as a sub-block in another block. It marks that cluster 
as a sub-block region open to other blocks needing it. When a sub-block is empty
it is then marked as 4kb cluster again instead of a sub-block cluster.



6) Consider a file system on a disk that has both logical
and physical block sizes of 512 bytes. Assume that the information about each
file is already in memory. For each of the three allocation strategies (contiguous,
linked, and indexed), answer these questions:


a. How is the logical-to-physical address mapping accomplished in this system?
(For the indexed allocation, assume that a file is always less than 512 blocks
long.)

Contiguous. 
    Divide the logical address by 512 to get the quotient and remainder.
    Add the quotient to logical address to obtain the physical block number. 
    the remainder is the displacement into that block. 
    
Linked.
      Divide the logical address by 511 to get a quotient and remainder.
      Using the quotient run through the linked list where it is quotient + 1
      blocks. The remainder + 1 is the offset in to the last physical 
      block.
      
Indexed.
    Divide the logical address by 512 to get a quotient and remainder.
    The quotient is the index block. Access the index block and the remainder
    is the offset into the index block , mapping to the physical block.
    

b. If we are currently at logical block 10 (the last block accessed was block 10)
and want to access logical block 4, how many physical blocks must be read from
the disk?

Contiguous

1 , There is direct access.

Linked

4 , Follow blocks 1,2,3 to lead to 4. 

Indexed
        
2, one index block , one data block



7)

Consider a file system that uses inodes to represent files.
Disk blocks are 8 KB in size, and a pointer to a disk block requires 4 bytes. This
file system has 12 direct disk blocks, as well as single, double, and triple indirect
disk blocks. What is the maximum size of a file that can be stored in this file
system?


Direct Blocks.
12 * 8KB 

Single Indirect:
8KB/4 = 2KB data block of pointers to disk blocks.
->2KB * 8 

Double Indirect
Each 2KB pointer points to another 2KB pointer block.
->2KB^2 * 8 


Triple Indirect
2KB^4 * 8 


Direct + Single + Double + Triple = 64.03 TB



8)
Suppose that a disk drive has 5000 cylinders,
numbered 0 to 4999. The drive is currently serving a request at cylinder 2150,
and the previous request was at cylinder 1805. The queue of pending requests,
in FIFO order, is: 2069, 1212, 2296, 2800, 544, 1618, 356, 1523, 4965, 3681
Starting from the current head position, what is the total distance (in cylinders)
that the disk arm moves to satisfy all the pending requests for each of the
following disk-scheduling algorithms?
a. FCFS
b. SSTF
c. SCAN
d. LOOK
e. C-SCAN
f. C-LOOK


FCFS:
abs(2150 - 2069)= 81
    2069 - 1212= 857
    1212 - 2296 = 1084
    2296 - 2800 = 504
    2800 - 544 = 2256
    544 - 1618 = 1074
    1618 - 356 = 1262
    356 - 1523 = 1167
    1523 - 4965 = 3442
    4965 - 3691 = 1274
    
Total = 10241 



SSTF:
abs(2150 - 2069) = 81
    2069 - 2296 = 227
    2296 - 2800 = 504
    2800 - 3681 = 881
    3681 - 4965 = 1284
    4965 - 1618 = 3247
    1618 - 1523 = 95
    1523 - 1212 = 311
    1212 - 544 = 668
    544 - 356 = 188
    
Total = 7486
    
SCAN:
abs(2150 - 2296) = 146
    2296 - 2800 = 504
    2800 - 3681 = 881
    3681 - 5000 = 1319
    5000 - 2069 = 2931
    2069 - 1618 = 451
    1618 - 1523 = 95
    1523 - 1212 = 311
    1212 - 544 = 668
    544 - 356 = 188
    
Total = 7494

LOOK:
abs(2150 - 2296) = 146
    2296 - 2800 = 504
    2800 - 3681 = 881
    3681 - 4965 = 1319
    4965 - 2069 = 1284
    2069 - 1618 = 451
    1618 - 1523 = 95
    1523 - 1212 = 311
    1212 - 544 = 668
    544 - 356 = 188
    
Total = 7459
    

C-SCAN:
abs(2150 - 2296) = 146
    2296 - 2800 = 504
    2800 - 3681 = 881
    3681 - 4965 = 1319
    4965 - 5000 = 35
    5000 - 0 = 5000
    0 - 356 = 356
    356 - 544 = 188
    544 - 1212 = 668
    1212 - 1523 = 311
    1523 - 1618 = 95
    1618 - 2069 = 451

Total = 9954
    
C-LOOK:
abs(2150 - 2296) = 146
    2296 - 2800 = 504
    2800 - 3681 = 881
    3681 - 4965 = 1319
    4965 - 356 = 4609
    356 - 544 = 188
    544 - 1212 = 668 
    1212 - 1523 = 311
    1523 - 1618 = 95
    1618 - 2069 = 451

Total = 9563


   
9) Describe some advantages and disadvantages of using
SSDs as a caching tier and as a disk-drive replacement compared with using
only magnetic disks.

+ Faster Reads and Writes due to not being limited to using a read/write
head.
- Less Memory because overall, $/GB more expensive.
- SSDs deterioate faster when being used to write because
of block wearing down.

10) Discuss the relative advantages and disadvantages of
sector sparing and sector slipping

Sector sparing can cause an extra head switch, which would result in extra
latency for some requests. 
Sector slipping has lessens this impact , but when the sector needs to remap
it can require the reading and writing of an entire track’s worth of
data to slip the sectors past the corrupted sector.
