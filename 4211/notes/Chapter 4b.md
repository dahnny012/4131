#Network Layer: Part B

## Basic Routing Principles and Routing Algorithms
- Link State vs Distance Vector

## Routing in the Internet

- Intra-AS vs Inter AS routing
- Intra-AS: RIP and OSPF
- Inter-AS: BGP and Policy Routing

##Broadcast and Multicast Routing


#Routing and Forwarding:
##Logical View of a router

	1st Layer:
		Routing information
			Routing agent --> updates
				Routing table
	2nd Layer:
		Input Links 
			--> look up forwarding table
				---> gets up update from routing table(1st layer)
			
			Switching Fabric | Data Plane
				Output link
		
