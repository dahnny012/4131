Danh Nguyen
4460226


Question 1 (20 points): 

The first known correct software solution to the criticalsection
problem for two processes was developed by Dekker. The two
processes, P0 and P1, share the following variables:


boolean flag[2]; /* initially false */
int turn;


The structure of process Pi (i == 0 or 1) is shown in Figure 5.21 (in the textbook);
the other process is Pj (j == 1 or 0). Prove that the algorithm satisfies all three
requirements for the critical-section problem.



Answer:

The critical section problem has to prove three things.

Mutual Exclusion
Progress
and Bounded Waiting


Dekkler's algorithm:
P1:
do {
    flag[i] = true;
    
    while (flag[j]) {
        if (turn == j) {
            flag[i] = false;
            while (turn == j); 
            /* do nothing */
            flag[i] = true;
        }
    }
    
    /* critical section */
    turn = j;
    flag[i] = false;
    /* remainder section */
} while (true);


P2:
do {
    flag[j] = true;
    while (flag[i]) {
        if (turn == i) {
            flag[j] = false;
            while (turn == i); 
            /* do nothing */
            flag[j] = true;
        }
    }
    
    /* critical section */
    turn = i;
    flag[j] = false;
    /* remainder section */
} while (true);

Since a process will keep busy waiting until
its flags are triggered, this shows mutual exclusion because
a process can only access the critical section when 
another proccess has finished executing on it. The only time
"turn" is turned on for one process is when another one has
exited the critical section.

This shows progress because if P1 finishes or exits in the remainder section
P2 can still run indefinitely. To enter the remainder section P1 has to flip it's 
flag to false so P2 can skip the while loop even though it is not P2's turn.

And finally this solves starvation because it also allows processes to share 
as P2 can't be repeatedly scheduled if P1 is still running.

/* Needs some more detail */




Question 2 (20 points): 
Consider how to implement a mutex lock using an
atomic hardware instruction. Assume that the following structure defining the
mutex lock is available:

    typedef struct {
    int available;
    } lock;

where (available == 0) indicates the lock is available; a value of 1 indicates the
lock is unavailable. Using this struct, illustrate how the following functions may be
implemented using the test and set() and compare and swap() instructions.

• void acquire(lock *mutex)
• void release(lock *mutex)

Be sure to include any initialization that may be necessary.


Assuming testAndSet and compareAndSwap is implemented like this.

int testAndSet(int *target){
    int ret = *target;
    *target = 1;
    return ret;
}


int compare_and_swap(int* reg, int oldval, int newval)
{
  int old_reg_val = *reg;
  if (old_reg_val == oldval)
     *reg = newval;
  return old_reg_val;
}

void acquire(lock *mutex){
    while(testAndSet(&(mutex->available)))
    // Wait till its true
}


void release(lock mutex){
    compare_and_swap(&(mutex->available),1,0);
}
\


Question 3:

#define MAX_PROCESSES 255
int number_of_processes = 0;
/* the implementation of fork() calls this function */
int allocate_process() {
    int new_pid;
    if (number_of_processes == MAX_PROCESSES)
        return -1;
    else {
        /* allocate necessary process resources */
        ++number_of_processes;
        return new_pid;
    }
}

/* the implementation of exit() calls this function */
void release_process() {
/* release process resources */
    --number_of_processes;
}

Consider the code example for allocating and releasing
processes shown in Figure 5.23 (in the textbook).
a. Identify the race condition(s).

    1. The changing and comparison of number_of_processes
    is not atomic so therefore allocate_process() could be called
    twice and if (++number_of_processes) is interupted because it is a multi step
    instruction then the proper value wont be saved.
    
    2. The first problem applies to (--number_of_processes) as well.
    
    3. Because of the incrementing of number_of_processes is not atomic
    it is entirely possible we can make more than 255 if at 254 a process is 
    interrupted before it can finish the (++number_of_processes) instruction.
    Then in the comparison it will still see 254 and continue to the else. From
    there it would be entirely possible to have 256 processes.


b. Assume you have a mutex lock named mutex with the operations acquire()
and release(). Indicate where the locking needs to be placed to prevent the race
condition(s).

#define MAX_PROCESSES 255
int number_of_processes = 0;
/* the implementation of fork() calls this function */
int allocate_process() {
    int new_pid;
    acquire();
    if (number_of_processes == MAX_PROCESSES){
        release();
        return -1;
    }
    else {
        /* allocate necessary process resources */
        acquire()
        ++number_of_processes;
        release();
        return new_pid;
    }
}

/* the implementation of exit() calls this function */
void release_process() {
/* release process resources */
    acquire();
    --number_of_processes;
    release();
}


c. Could we replace the integer variable
int number_of_processes = 0
with the atomic integer
atomic_t number_of_processes = 0
to prevent the race condition(s)?

No two proccesses calling number_of_processes at the same time
at number_of_processes = 254 will cause it to become 256. Because
they will both skip the comparison and both increment the atomic int.



Question 4 (20 points):

A file is to be shared among different processes, each
of which has a unique number. The file can be accessed simultaneously by
several processes, subject to the following constraint: The sum of all unique
numbers associated with all the processes currently accessing the file must be
less than n.

Write a monitor to coordinate access to the file.

typedef struct{
    Mutex CounterLock;
    int counter;
} Lock;

typedef struct{
    Lock fileLocks[x];
    FILE* files[x];
} Monitor;

// Could be abused by processes and keep subscribing to dominate a file.
// Im willing to accept that exploit.

FILE* subscribe(pid_t pid,int index){
    // Pretend user already knows the index number
    Lock fileLock = Monitor->fileLocks[index];
    acquire(&fileLock->lock);
    if((fileLock->counter + pid) < N){
        fileLock->counter += pid
        release(&fileLock->lock);
        return Monitor->files[file];
    }
    else{
        // Could busy wait but ill let the user decide what to do.
        release(&fileLock->lock);
        return NULL;
    }
}
/* 
   Potentially could be a abused by a process
   so it must prove that it has the file
*/
void unsubscribe(pid_t pid,int index,FILE* file){
    if(file != Monitor->files[index])
        return;
    Lock fileLock = Monitor->fileLocks[file];
    acquire(&fileLock->lock);
    fileLock->counter -= pid
    release(&fileLock->lock)
}


Question 5 (10 points):

Assume a multithreaded application uses only reader—writer locks for synchronization. 
Applying the four necessary conditions for deadlock, 
is deadlock still possible if multiple reader—writer locks are used?

Conditions for Deadlock:

Mutual Exclusion
Hold and wait
No Preemption
Circular Wait

Assumptions:
A writer can only access when no readers.
No readers can read when writer is writing.
Writer will magically release the lock if it segfaults while it has the lock.

The application will still experiance a deadlock because it 
satisfies all four of the conditions. 
    1) Either the readers or writer have mutual access
    to lock. So if a writer never releases the lock due to 
    some sort of error then all processes access the file are
    deadlocked.
    
    2) A thread is able to hold multiple reader/writer locks.
    If a thread has a writer lock but needs to write to another
    variable then it is possible it become deadlocked because
    processes are able to possess multiple locks.
    
    3) Only the holders of the resource lock can release. So if 
    the holder magically errors out. There is nothing the system
    can do.
    
    4) Similar to 2) where a thread waiting to write, that is
    waiting to read ... etc.
    



Question 6 (10 points): 

A single-lane bridge connects the two Vermont villages
of North Tunbridge and South Tunbridge. Farmers in the two villages use this
bridge to deliver their produce to the neighboring town. The bridge can become
deadlocked if both a northbound and a southbound farmer get on the bridge at
the same time (Vermont farmers are stubborn and are unable to back up). Using
semaphores, design an algorithm that prevents deadlock. Initially, do not be
concerned about starvation (the situation in which northbound farmers prevent
southbound farmers from using the bridge, and vice versa).


Semaphore okToCross = init(1);


/* This implentation doesnt support a north person crossing
    while a north person is in the middle of crossing.
    But this makes it more fair for the other side.
*/
cross(){
    wait(okToCross);
    // Cross
    signal(okToCross);
}

Question 7.

Most systems allow a program to allocate more memory
to its address space during execution. Allocation of data in the heap segments of
programs is an example of such allocated memory. What is required to support
dynamic memory allocation in the following schemes?
    a. Contiguous memory allocation
        - The system needs to decide how much heap space it allows
        the user to add. Then when it allocates initial program space
        it can add N empty contigous blocks of memory.
        
        - If the system wants to support unlimited heap space. 
        It needs to move the process to a new location when it exceeds 
        it's inital allowed space.
        
        
    b. Pure segmentation
        If inital memory block is filled , the system
        needs to move the segment to where a new location.
    c. Pure paging
        Moving is not required , system just needs to allocate additional pages.
        
Question 8.

The BTV operating system has a 21-bit virtual address,
yet on certain embedded devices, it has only a 16-bit physical address. It also
has a 2-KB page size. How many entries are there in each of the following?


a. A conventional, single-level page table
2^21(process size)/2^11(page size) = 2^10 or 1Kb


b. An inverted page table

2^16(process size)/2^11 = 2^5 or 32 bytes


Question 9.

Consider a paging system with the page table stored in memory.

    a. If a memory reference takes 50 nanoseconds, how long does a paged memory
    reference take?
    
    Access page table, then reference it.
    100 nanoseconds.
    
    b. If we add TLBs, and 75 percent of all page-table references are found in the
    TLBs, what is the effective memory reference time? (Assume that finding a pagetable
    entry in the TLBs takes 2 nanoseconds, if the entry is present.)
    
    
    (.75)*50 + 100*(.25) + 2 = 64.5
    

Question 10.
Consider the Intel address-translation scheme shown in Figure 8.22 (in the textbook).

a. Describe all the steps taken by the Intel Pentium in translating a logical
address into a physical address.

The segment register points to the appropriate entry in the LDT or GDT. The
base and limit information about the segment in question is used to generate
a linear address. First, the limit is used to check for address validity. If the
address is not valid, a memory fault is generated, resulting in a trap to the
operating system. If it is valid, then the value of the offset is added to the value
of the base, resulting in a 32-bit linear address (from the book).

From the linear address we take the 1st 10 bits as the outer page. From the outer page table
we take the next 10 bits in the linear address to locate the inner page table. The last 
12 bits refer to the offset in the inner page to where the page is located. This would 
be the physical address.

-- Taken from the book.

b. What are the advantages to the operating system of hardware that provides
such complicated memory translation?

The advantages of having such a complicated memory translation in
hardware is that it would be more efficient. The hardware designer can
make specific design choices that would speed up this process.CounterLock

Another advantage would be that it reduces the complexity of the OS/kernel. 
By seperating the process from the kernel it makes it less complicated because
now its just a layer of hardware that manages memory instead of half software
half hardware. 

c. Are there any disadvantages to this address-translation system? If so, what
are they? If not, why is this scheme not used by every manufacturer?

There is a lot of indirection that needs to happen to locate the physical memory.
And each page fault is costly because of this.

Also it is not portable and is only specific to the pentium archeticture. From
A OS developers point of view not all computers have pentiums so you might 
have to write two seperate versions. From a cpu manufacturer point of view
not all OSs use the same address translation system.
