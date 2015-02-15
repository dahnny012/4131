1.What is the purpose of interrupts? What are the
differences between a trap and an interrupt? Can traps be generated intentionally
by a user program? If so, for what purpose?

An interrupt is when the operating system generates a signal
that the OS may choose to handle.Like IO , events , and errors.

A Trap is a subset of interrupts and its purpose is to signal 
divide by zero or invalid memory access.

A user can signal a trap by dividing by zero or trying to access
a null pointer.

A user may choose to wrap a potential trap into a try catch block
because they want the program to handle it and not terminate the process.


// This might need refactoring
2. Why is the separation of mechanism and policy
desirable?

Seperating mechanism and policy allows for more configurations. In the context
of microkernels since most of the policies is left to the user to implement,
if the policies and mechanisms were tightly coupled it would not be easy to
implement. The designer of the kernel can't account for every single policy 
combination with the mechanisms

// Probably needs refactoring
3. What are the advantages of using loadable kernel
modules?

It would allow for a smaller footprint when running the system.
The system could only load what was needed and unload when the module
is no longer being used to free memory/cpu processing time.

It also allows the designer to extend new features to the kernel.
Like supporting new devices 


4. Explain the role of the init process on UNIX and Linux
systems in regards to process termination.

When a process terminates and it has children that it did not terminate,
the init process inherits them as "Orphans".
// What then?

// Needs refactoring
5.  Can a multithreaded solution using multiple user-level
threads achieve better performance on a multiprocessor system than on a single
processor system? Explain.

On a single processor, the threads are running one at a time. It gives us
the illusion of parrelism. On a multiple processor system , the system 
can run each thread on a different processor achieving parrelism instead
switching threads one at a time.



6. Consider the following code segment:
pid_t pid;
pid = fork();
    // P-C1 Child
    if (pid == 0) { /* child process */
        // P-C1-C2
        fork();
            // P-C1-T
            // P-C1-C2-T
        thread create( . . .);
    }
    // P-C1-C3
    // P-C1-C2-C4
fork();
    // P-C5

a. How many unique processes are created?
5 Children are created
b. How many unique threads are created?
2 threads are created


// Refactor some more
7. : A variation of the round-robin scheduler is the
regressive round-robin scheduler. This scheduler assigns each process a time
quantum and a priority. The initial value of a time quantum is 50
milliseconds.However, every time a process has been allocated the CPU and
uses its entire time quantum (does not block for I/O), 10 milliseconds is added to
its time quantum, and its priority level is boosted. (The time quantum for a
process can be increased to a maximum of 100 milliseconds.) When a process
blocks before using its entire time quantum, its time quantum is reduced by 5
milliseconds, but its priority remains the same. What type of process (CPU-bound
or I/O-bound) does the regressive round-robin scheduler favor? Explain.

Regressive round robin favors CPU-Bound processes because it elevates their priority 
and also gives them more of the time quantum. This algorithm tries to optimize on the
the fact that blocking io processes do not need as much cpu computation because they 
are waiting on IO. 

8. ---> Drawing


// Refactor on b.
9. Consider a variant of the RR scheduling algorithm
where the entries in the ready queue are pointers to the PCBs.
a. What would be the effect of putting two pointers to the same process in the
ready queue?

Whatever they are pointing to will run twice.

b. What would be two major advantages and disadvantages of this scheme?

+
1. Allows to do more advance scheduling , like based on priority we can 
push duplicate pointers into the queue.

2. Easier to store pointers than PCB blocks in memory
pointers are static length , PCB's are variable length

-
1. More overall memory used due to duplicate pointers
2. More overall loading,  we load a pointer,and then the PCB

c. How would you modify the basic RR algorithm to achieve the same effect
without the duplicate pointers?

If we want to implement it where a process gets ran twice , we can
just allow it a bigger time quantum.



// Might need a refactor.
10. Consider a preemptive priority scheduling algorithm
based on dynamically changing priorities. Larger priority numbers imply higher
priority. When a process is waiting for the CPU (in the ready queue, but not
running), its priority changes at a rate α; when it is running, its priority changes at
a rate β. All processes are given a priority of 0 when they enter the ready queue.
The parameters α and β can be set to give many different scheduling algorithms.


When a process is waiting for the CPU: a rate α
When a process is running: a rate β

a. What is the algorithm that results from β > α > 0?
First in first out.

b. What is the algorithm that results from α < β < 0?

Shortest jobs will likely finish first.