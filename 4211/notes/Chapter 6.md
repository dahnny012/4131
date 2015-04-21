#What Does data link layer do?

    Data link layer has responsibility of transferring frames
    from one node to adjacentn over a link a single link
    
    
#Data link layer functions

    Framing:
        Sender (transmitter):
            encapsulte datagram into frame,
            adding header...etc.
            
        Reciever:
            detect beginning of frames, recieve frame
            strips header..etc
            
    Link Access (Media Access Control):
        Determines whether its okay to transmit over the link:
            important when link shared by many nodes.
                also an issue over half-duplex pt2pt link
                    why?:
                        /* TODO */
                        
            Media Access Control --> MAC
        
        Physical addresses identify sender/reciever on a link.
            particularly important when link shared by many nodes,
            while over point-to-point link, not necessary
                why?
            
            physical addresses often referred to as "MAC" addresses
                different from ip addresses which are (logical and global)
        
#Other data link layer functions

    Error Detection
        errors caused by noise , signal attentuation
        sender computes checksum, attaches to frame.
        reciever detects presence of errros by verfifying "checksum"
            drops corrupted frame, may ask sender to another.
        Commonly used "checksum" , CRC
        
    Reliable Delivery between adj nodes(optional)
        Using GBN Or SR 
            seldom used on low bit error link.
            wireless links: high error rates
            Q: Why both link-level and e-e reliability
            
    Error Correction (optional):
        recv identifies and corrects bit errors 
        without resorting to retransmitssion, using 
        forward error correction.
        
    Flow Control (Optional):
        negotiating transmission rates between two nodes
        
        
#Adapters Communicating

    Sender:
        Encapsulates datagram
        Adds error check buts
        flow control...
    
    Recv:
        looks for errors,flow control..etc
        extracts datagram and passes it node.
        
    
    data link & physical layer are closely coupled.
    
    
    
#Error Detection
    
    Added after after every 7-8 bits.

    parity bit = parity of # of 1 bits.
    
    A cross product of all bits should result 
    in correct parity.
        
#Internet Checksum

    Goal:
        detect "errors" flipped bits in transmitted 
        segment note used at transport layer only.
        
        Sender:
            Treat segment contents as sequence of 16-bit 
            ints.
            
            checksum:
                addition (1's complement sum) of segment contents
        
            sender puts checksum value into UDP checksum field.
            
        Reciever:
            Compute checksum of recieved segment
            
            check if computed checksum equals
            checksum field value:
            
                no - error detected
                yes - no error detected
                
#Checksumming: Cyclic Redudancy Check

    view data bits, D as a binary number
    
    Choose r+1 bit patttern (generator), Goal
    
    goal: choose r CRC bits, R such that
        <D,R> exactly divsible by G (modulo 2)
        Recv knows G, divides <D,R> by G. 
            If non-zero remainder: error detected.
        can detect all burst errors less than r+1 bits
        
    [D:data bits to be sent][R: CRC bits] bit pattern
    
    D*2^r XOR R ---> 0
    R = remainder[D*2^r/G]
        
        
        
#Multiple Access Links and LANs

    Two types of "links"
        pt2pt, e.g.,
            - PPP for dial-up access, or over optical fibers
            
        broadcast(shared wire or medium), e.g.
            traditional Ethernet
            
            802.11 wireless LAN

#LAN: Issues & Technologies

    Issues:
        addressing: physical (or MAC) addresses
        media access control (MAC) for broadcast LANs
        expand LANs: connect multiple LAN segments
            hubs,bridges,(layer-2) switches (we'll explain difference later)
    
    Various Commonly used LAN technologies
        
        
#MAC (Physical, or LAN) Addresses

    Used to get frames from one interface to another physically-
    connected interface (same physical network, i.e., p2p or LAN)
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        
        
        
        
        
        
        
        
        