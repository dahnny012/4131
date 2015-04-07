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
less than n.Write a monitor to coordinate access to the file.






