#Network layer


#What Does Network Layer Do?

	End-to-end deliver packet from sending recieving hosts,
	"hop-by-hop" through network.

	Comparison vs other layers:
		-Transport: Between  two end hosts.
		-Data link layer: over a physical link connecting multiple hosts.

	Transport segement from sender to rcving host.
	
	Sending side encapsulates segments into datagrams
	
	On rcving side, delivers segments to transport layer.
	
	network layer protocols in every host, router
	
	Router examines header fields in all ip datagrams
	passing through it.
	


#Network Layer Functions

	Addressing
		- Globally unique address for each routable device
			Logical address, unlike MAC address (as you'll see later)
		- Assigned by network operator
			Need to map to MAC address
		
	Routing: building a "map" of network
		- Which path to use to forward packets from src to dest.
	
	Forwarding: delivery of packets hop by hop
		- From input port to appropriate output port in a router
		
		- Routing and forwarding depend on network service 
		- models: datagram vs virtual circuit.
		
		
#Two Key Network-Layer Functions

	Forwarding:
		move packets from router's input to appopriate
		route output.
		
	Routing:
		Determine route taken by packets from source to dest.
		
	Analogy:
		routing --> process of planning tip from src-dest.
		
		forwarding --> process of getting through single interchange
		
		
#IP Addressing: Basics 


#IP Addressing: Network vs Host

	Two-level hierarchy
		- Network = High order bits
		- Host = low order bits
		
	What is a network?
	
		- device interfaces with same network part of IP address
		
		- can physically reach each other without intervening router
		
#Classless Addressing: CIDR

	CIDR: Classless InterDomain Routing
		- Network potion of address is of arbitrary length
		
		- Addresses allocated in contigous blocks
			- number of addresses assigned always power of 2
			
		- Address format: a.b.c.d/x
			- x is number of bits in network portion of address
			

#DHCP: Dynamic Host Configuration Protocol

	Goal: allow host to dynamically obtain its IP address 
	from network server when it joins network.
	
		Can renew its lease on current addr
		Alows reuse of addrs
		Support for mobile users 
		
	DHCP overview:
		- host broadcasts "DHCP discover" msg
		- DHCP server responds with "DHCP offer"
		- host requests IP address: "DHCP request" msg
		- DHCP server sends address: "DHCP ack" msg

#Interplay between routing and  forwarding

	Routing algorithm
		Local forwarding table
			header|output link
			
#Network Service Model

	Q:  What service model for "channel"
	transportin packes from sender to reciever?
	
		- guaranteed bandwidth?
		- preservaton of inter-packet timing?
		- loss-free delivery ?
		- in-order delivery?
		- congestion feedback to sender?
		
#Cont

	Example services for individual datagrams:
		
		-guaranteed delivery
		-guaranteed delivery with < 0 ms delay
		
	Example services for a flow of datagrams:
		
		-in-order datagram deivery
		-guaranteed miniumum bandwdth to flow.
		-restrictions on changes in inter-packet spacing
		
	 
#Network Layer Connection vs Connectionless Service

	 datagram network provides network-layer connectionless service.
	 
	 VC network provides network-layer connection service
	 
	 analogous to transprot-layer services, but:
	 	- service: h2h
		- no choice: network provides one or the other
		- implementaton: in network core
		
	network vs transport layer connection service:
		network: between two hosts, in case of VCs, also involve
		intervening routers
		
		transport: between two processes

	
#Virtual Circuit vs Datagram

	Objective of both: mvoe packets through routers from source 
	to destination
	
	Datagram Model:
		- Routing: determine next hop to each destination.
		- Forwarding: destinaton address in packet header, used 
		at each hop to ook up for next hop
			- routes may change during "session"
		
		- analog: driving, asking directions at every as station, or
		based on te road signs at every turn.
	
	Virtual Circuit Model:
		Routing: determine a path from source to each destination
		
		"Call" Set-up: fixed path("virutal circuit") set up at "call"
		setup time, remains fixed thru "call"
		
		Data Forwarding: each packet carries "tag" or "label"(VCI)
		which determines next hop.
		
		routers maintain "per-call" state.
		
#Virtual Circuits
	
	"source-to-dest path behaves much like telephone circuit"(over packet network)
		- peformance-wise
		- network actions aong source-to-dest path
		
	- call setup/teardown for each ca before data can flow
		- need special conrol protocol: "signaling"
		- every router on source-des path maintains "state" 
		(VCI translation table) for each call
		
	- link,router resources (bandwidth,buffers) may be reserved and allocated
	to each VC.
			- to et "circuit-like" performance
			
	- Compare w/ transport-layer "connection": only involves two
	end systems, no fixed path, can't reserve bandwidth!
	
	
#VC Implementation

	a VC consists of 
		1. path from source to destination
		2. VC numbers, one number for each link along path
		3. entries in forwarding ables n rotuers along path
	
	packet beloning to VC carries VC number (rather than dest address)
	
	VC number can be changes on each link.
		- New VC number comes from forwarding table
		

#VC Translation/Forwarding Table



#Virtual Circuit Setup/Teardown

	Call Set-up:
		- Source: select a path from source to destination
			Use routing table(Which provides a "map of network"
		
		- Source: send VC setup request control("signaling") packet
			- Specify path for the call, and also the (initial) oupu VCI
			
			- perhaps also resources to be reserved, if supported
			
		- Each router along the path:
			- Determine output port and choose a local oupu VCI for the cal
				need to ensue that no two distinct VCs leaving the same output
				port have the same VCI!
				
			- Update VCI translation table("forwarding table")
				add an entry, establishing an mapping between incoming VCI
				& port no. and outgoing VCI & port no. for the call.
				
	Cal Tear-Down: similar, but remove entry instead
	
	
#Datagram Networks: the Internet Model

	No call setup at network layer
	
	routers: no state about end-to-end connections
		- no network-level concept of "connection"
		
	packets forwarded using destination host address
		- packets between same source-dest pair may take
		different paths, when intermediate routes change
		
#IP Datagram Forwarding Model

	IP datagram:
		[misc fields][source IP addr][dest IP addr][data]
		
	Datagram remains unchanged, as it travels src to dest
	
	
#IP Forwarding: Destination in Same Net
	
	[misc fields][223.1.1.1][223.1.1.3][data]
	
	Starting at A, send IP datagram addressed to B:
		- look up net. address of B in forwardin table
		
		- Find B is on same net. as A
	
		- link layer will send datagam directly to B inside
		link-layer frame
	
		- B and A are directly connected
		
#IP Forwarding: Destination in Diff. Net

	[misc fields][223.1.1.1][223.1.2.3][data]
	
	Starting at A, dest. E:
		- look up network address of E in forwarding table
		
		- E on diferent network
			- A,E not direct
			
		- routing table: next hop router to E is 223.1.1.4
		
		- Link layer sends datagram to router 223.1.1.4 inside link-layer frame
		
		- datagram arives at 223.1.1.4
		
#Continued
		
	Arriving at 223.1.1.4 destined for 223.1.2.2
	
		- Look up network address of E in router's forwarding table
		 
		- E on same network as router's interface 223.1.2.9
		 	- router, E directly attached	 
		
		- Link layer sends datagram to 223.1.2.2 inside link-layer
		frame via interface 223.1.2.9
		
		- datagram arrives at 223.1.2.2!!! (hooray)
				
#Virtual Circuit vs. Datagram 

	Objective of both: move packets throuh routers from source to destination.
	
	Datagram Model:
		- Routing: determine next hop to each destination a prior.
		
		- Forwarding: destination address in packet header, used at each hop
		to look up for next hop
			- routes may change during "session"
			
		- analogy:	driving, asking directions at every gas station, or based
		on the road signs at every turn
		
	Virtual Circuit Model:
		- Routing: determine a path from source t oeach destination
		
		- "Call" Set-up: fixed path ("virtual circuit") set up at "call" 
		set up time, remains fixed thru "call"
		
		- Data Forwarding: each packet carries "tag" or "label"
		(virtual circuit id, VCI), which determines next hop
		
		- Routers maintain "per-call" state
		
	
		
	
#Datagram or VC: Why?

Internet:
	data exchange among computers 
		-"elastic" service, no strict timing req
	
	"smart" end systems(computers)
		- can adapt, perform control,error recovery
		- simple inside network, complexity at "edge"
		
	many link types 
		- different characteristics
		- uniform service difficult	
		
ATM:
	evolved from telephony
	
	human conversation:
		- strict timing, reliability
		requirements
		
		- need for guranteed service
		
	"dumb" end systems
		- telephones
		- complexity inside network
		
MPLS (layer 2.5)

	Evolve from ATM
		- traffice engineering, fast path restoration
		
		
#IP Forwarding and IP/ICMP protocol
## In the Network Layer

Routing protocols:
	Path selection
	RIP,OSPF,BGP
	
	Interacts with Routing Table

IP Protocol:
	Addressing conventions
	
	packet handling conventions
	
	
ICMP protocol:
	Error reporting
	
	router "signaling"
	
	
#IP Datagram Format

version | head len | type of service | length
	length is total datagram length (16 bit max)
16 bit identifier | flgs | fragment offset
	All used for fragmentation/reassembly
time to live | upper layer | Internet checksum
	time to live = max number of remaining hops
	upplayer = upper later protocol to deliver payload to	
32 bit IP Src
32 bit IP Dest
Options
data

How much overhead with TCP?
	20 bytes TCP
	20 bytes IP
	= 40 bytes + app layer overhead.
	
#IP Fragmentation and Reassembly: Why

Network links have MTU --> largest possible link-level frame
	-  Different link types, differenet MTUS
	
Large IP datagram divided within net
	- One datagram becomes several datagrams
	- "reassembled" only at final destination
	- IP header bits used to identify, order related fragments
	
#IP Fragmentation and Reassembly: How

An IP datagram is chopped by a router into smaller pieces if 
	- datagram size is greater than network MTU
	- Don't fragment option is not set
	
Each datagram has unique datagram identification
	- Generated by source hosts
	- All fragments of a packet carry orginal datagram id
	
All fragments except the last have more flag set
	- Fragment offset and Length fields are modified appropriately
	
Fragments of Ip packet can be further fragmented by other
routers along the way  to destination !

Reassembly only done at destination host(why?)
	- Use IP datgram id, fragment offset, fragment flags.Length
	- A timer is set when first fragment is recieved (why?)
	
#Router Architecture Overview

Two key router functions:
	run routing algorithms/protocol(RIP,OSPF,BGP)
	forwarding datagrams from incoming to outgoing link
	
#Input Port Functions
	
Decentralized switching:
	given datagram dest., lookup ouput port
	using forwarding table in input port memory
	
	Goal: complete input port processign at 'line speed'
	
	queuing: if datagrams arrive faster than forwarding
	rate into switch fabric. 
	
##Input port 
Line Termination -> Data link Processing -> Lookup Forwarding


#Output Ports

## Diagram
	queuing/buffer manager -> data link processing -> line termination ->

Buffering 
	required when datagrams arrive from fabric 
	faster than the  transmission rate
	
Scheduling Discipline
	chooses among queued datagrams from transmission
	
	
	
