


#Overview of Query Evaluation

    Query plan:
        Tree of relational algegra operators
        With choice of algorithm for each operator.
    
    Example:
        What are the names of sailors who have reserved boat 103?
            What are the operators
            
        SELECT  S.name    
        FROM     Sailors S, Reserves R
        WHERE   S.sid=R.sid AND R.bid=103
        

#Continued

    Two main issues in query optimizaion:
        For a given query, what plans are condisdered?
            Algorithm to search plan sapce for cheapest plan.
            
        How is the cost of a plan estimated?
        
    Ideally: Want to find best plan.
        Practically: Avoid worst plans!
        
    Each operator is typically implemented using a `pull` interface:
        When an operator is pulled for the next output tuples
        it pulls on its inputs and computes them.
    
    
#Some Common Techniques

    Algorithms for evaluation relational operators:
        Indexing: 
            Can use WHERE conditions to retrieve tuples.
        
        Iteration: 
            Sometimes, faster to scan all tuples even if there is 
            an index. (And sometimes, we can scan the data entries
            in an index instead of the table itself.)
            
        Partitioning:
            By using sorting or hashing, we can partition the
            input and replace an expensive operation by similar 
            operations on small inputs.
            
#Statistics and Catalogs

    Need information about the relations and indexes
    Catalogs typically contain at least:
        
        # tubles (NTuples) and # pages (NPages) for each relation.

        # distinct key values (NKeys) and NPages for each index.
        
        Index height, low/high key values Low/High for each tree index.
        

#Using an Index for Selections

    Cost depends on #qualifying tuples and clustering.
        Cost of finding qualifying data entries plus cost
        of retrieving records.
        
#Projection
    
    Project is:
        1) Dropping unwanted cols.
        2) Removing duplicates.
        
    Expensive part is removing duplicates
    
    If no dupe elimination is needed,
    iterate over table whose key contains all the 
    projection fields.
    
    
#Projection with duplicate elimination

    Sorting Approach:
        sort <sid,bid> and remove duplicates.
        
    Hashing Approach:
        Hash on <sid,bid> to create partitions.
        Load partitions into memory one at a time,
        build in-memory hash structure, and eliminate duplicates.
        
    Index with both R.sid,R.bid in the search key,
    may be cheaper to sort data entries.
        
        
#Join 
    
    Common and most expensive operator.


#Join: Index Nested Loops

    If there is an index on the join column of one
    relation (say S), can make it the inner and exploit index.
    
#Examples of Index Nested Loops

    Hash Index on both.
    
    Page size = 80/tuples S , 100 tuples R
    
    Cardinality of Sailors = 40,000 -> 500 pages
    Cardinality of Reserves = 100,000 -> 1000 pages
    
    Hash-index on sid of Sailors(as inner):
    
        Scan Reserves: 1000 page IOs 100*1000
        
        For each Reserves:
            1000 + 100,000 * 2.2 = 221,000 IOs
            
    Hash-index on sid of Reserves(as inner):
        
        Scan Sailors: 500 pages IOs, 80*500
        
        500 + 40,000 * 3.7 = 148,500 IOs
        
    
#Join: Sort-Merge (R><S)

    Sort on the join column.
    
    Sorting:
        takes two passes, for each pass, we need to 
        scan (read and write) each data record:
            Cost for sorting Reserves: 2 * 2 * 1000 = 4000
            
    Merging needs only one global pass over the two
        tables with read only
            Merging cost = 1000 + 500
            
    Total cost = 4000 + 2000 + 1500  = 7500
        
        
#Highlights of System R Optimizizer

    Impact:
        Most Widely used currently; works well for < 10 joins
        
    Cost Estimation:
        
        Uses stats in catalog.
        considers CPU+IO costs
        
    Plan Space: Too large, must be pruned
        Only the space of left deep plans is considered
            Left-deep plans allow output to be pipelined.
        
        Cartesian products avoided.
        
        
#Relational Operations

    
    Selection:
    
        No Index,  Unsorted Data
            Most selective access path is "file scan"
            O(M)
            
        No Index, Sorted Data
            Most selective access path is "binary search".
            O(log2M) + # pages
            
        Clustered B+ tree:
            2-3 IOs to find start record  + # matching pages.
            
        Unclustered 
            2-3 IOs... Every single match 
        
        Clustered Hash Index:
        
            1-2 IOs + matching pages
        
        Unclustered Hash Index:
            
            1-2 IOs + matching tuples.
            

        
            
        
        
        
        