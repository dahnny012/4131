Recovery Manager --> Atomicity and Durability


When to resume from?

Xact commit --- Alive ---- Xact End

Reasons to not flush when commit
  users cant reuse the buffer
  performance cost of having to do io all the damn time
  
page force vs log force,
    log force is small , page can contain a lot of records
    log file force is a service to the community, everyone has to do it anyway
    
    page force is a bad thing to others
    you are hurting others.
    Instead of doing good for the community you are hurting others.
    
    