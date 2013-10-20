
"""
FILE: skeleton_parser.py
------------------
Author: Garrett Schlesinger (gschles@cs.stanford.edu)
Author: Chenyu Yang (chenyuy@stanford.edu)
Modified: 10/13/2012

Skeleton parser for cs145 programming project 1. Has useful imports and
functions for parsing, including:

1) Directory handling -- the parser takes a list of eBay xml files
and opens each file inside of a loop. You just need to fill in the rest.
2) Dollar value conversions -- the xml files store dollar value amounts in 
a string like $3,453.23 -- we provide a function to convert it to a string
like XXXXX.xx.
3) Date/time conversions -- the xml files store dates/ times in the form 
Mon-DD-YY HH:MM:SS -- we wrote a function (transformDttm) that converts to the
for YYYY-MM-DD HH:MM:SS, which will sort chronologically in SQL.
4) A function to get the #PCDATA of a given element (returns the empty string
if the element is not of #PCDATA type)
5) A function to get the #PCDATA of the first subelement of a given element with
a given tagname. (returns the empty string if the element doesn't exist or 
is not of #PCDATA type)
6) A function to get all elements of a specific tag name that are children of a
given element
7) A function to get only the first such child

Your job is to implement the parseXml function, which is invoked on each file by
the main function. We create the dom for you; the rest is up to you! Get familiar 
with the functions at http://docs.python.org/library/xml.dom.minidom.html and 
http://docs.python.org/library/xml.dom.html

Happy parsing!
"""

import sys
from xml.dom.minidom import parse
from re import sub

columnSeparator = "<>"

# Dictionary of months used for date transformation
MONTHS = {'Jan':'01','Feb':'02','Mar':'03','Apr':'04','May':'05','Jun':'06',\
                'Jul':'07','Aug':'08','Sep':'09','Oct':'10','Nov':'11','Dec':'12'}


"""
Returns true if a file ends in .xml
"""
def isXml(f):
    return len(f) > 4 and f[-4:] == '.xml'

"""
Non-recursive (NR) version of dom.getElementsByTagName(...)
"""
def getElementsByTagNameNR(elem, tagName):
    elements = []
    children = elem.childNodes
    for child in children:
        if child.nodeType == child.ELEMENT_NODE and child.tagName == tagName:
            elements.append(child)
    return elements

"""
Returns the first subelement of elem matching the given tagName,
or null if one does not exist.
"""
def getElementByTagNameNR(elem, tagName):
    children = elem.childNodes
    for child in children:
        if child.nodeType == child.ELEMENT_NODE and child.tagName == tagName:
            return child
    return None

"""
Parses out the PCData of an xml element
"""
def pcdata(elem):
        return elem.toxml().replace('<'+elem.tagName+'>','').replace('</'+elem.tagName+'>','').replace('<'+elem.tagName+'/>','')

"""
Return the text associated with the given element (which must have type
#PCDATA) as child, or "" if it contains no text.
"""
def getElementText(elem):
    if len(elem.childNodes) == 1:
        return pcdata(elem) 
    return ''

"""
Returns the text (#PCDATA) associated with the first subelement X of e
with the given tagName. If no such X exists or X contains no text, "" is
returned.
"""
def getElementTextByTagNameNR(elem, tagName):
    curElem = getElementByTagNameNR(elem, tagName)
    if curElem != None:
        return pcdata(curElem)
    return ''

"""
Converts month to a number, e.g. 'Dec' to '12'
"""
def transformMonth(mon):
    if mon in MONTHS:
        return MONTHS[mon] 
    else:
        return mon

"""
Transforms a timestamp from Mon-DD-YY HH:MM:SS to YYYY-MM-DD HH:MM:SS
"""
def transformDttm(dttm):
    dttm = dttm.strip().split(' ')
    dt = dttm[0].split('-')
    date = '20' + dt[2] + '-'
    date += transformMonth(dt[0]) + '-' + dt[1]
    return date + ' ' + dttm[1]

"""
Transform a dollar value amount from a string like $3,453.23 to XXXXX.xx
"""

def transformDollar(money):
    if money == None or len(money) == 0:
        return money
    return sub(r'[^\d.]', '', money)

"""
Parses a single xml file. Currently, there's a loop that shows how to parse
item elements. Your job is to mirror this functionality to create all of the necessary SQL tables
"""
def parseXml(f, parse_fn):
    dom = parse(f) # creates a dom object for the supplied xml file
    rows = parse_fn(dom)
    
    for row in rows:
	for i in range(len(row)):
		sys.stdout.write(row[i].strip())
		
		if i<len(row) - 1:
			sys.stdout.write(columnSeparator)
	
	sys.stdout.write("\n")


"""
TO DO: traverse the dom tree to extract information for your SQL tables
"""

# Parse the sellers and bidders to return users
def parseUsers(dom):		
	items = dom.getElementsByTagName("Item")
	users = []

	for item in items:
		seller = item.getElementsByTagName("Seller")[0]
		props = []
		props.append(seller.attributes["UserID"].value)
		location = pcdata(getElementByTagNameNR(item, "Location"))
		country = pcdata(getElementByTagNameNR(item, "Country"))	
		props.append(location)
		props.append(country)
		props.append(seller.attributes["Rating"].value)
		#print props
		users.append(props)

	for item in items:
		bidsElement = item.getElementsByTagName("Bids")[0]
		bids = bidsElement.getElementsByTagName("Bid")

		for bid in bids:
			props = []
			bidder = bid.getElementsByTagName("Bidder")[0]
			props.append(bidder.attributes["UserID"].value)

			location = NULLValue;
			country = NULLValue;

			try:
				location = pcdata(bid.getElementsByTagName("Location")[0])
			except: 
				pass

			try:
				country = pcdata(bid.getElementsByTagName("Country")[0])
			except:
				pass

			props.append(location)
			props.append(country)
			props.append(bidder.attributes["Rating"].value)
			#print "bidder", props
			users.append(props)

	return users

# Parse the items
def parseItems(dom):
	itemElements = dom.getElementsByTagName("Item")
	items = []

	for itemElement in itemElements:
		props = []
		props.append(itemElement.attributes["ItemID"].value)
		props.append(pcdata(itemElement.getElementsByTagName("Name")[0]))
		props.append(pcdata(itemElement.getElementsByTagName("Currently")[0]))
		props.append(pcdata(itemElement.getElementsByTagName("Number_of_Bids")[0]))
		props.append(transformDollar(pcdata(itemElement.getElementsByTagName("First_Bid")[0])))
		
		buy_price = NULLValue

		try:
			buy_price = transformDollar(pcdata(itemElement.getElementsByTagName("Buy_Price")[0]))
		except:
			pass

		props.append(buy_price)

		seller  = itemElement.getElementsByTagName("Seller")[0]
		props.append(seller.attributes["UserID"].value)
	
		props.append(transformDttm(pcdata(itemElement.getElementsByTagName("Started")[0])))
		props.append(transformDttm(pcdata(itemElement.getElementsByTagName("Ends")[0])))
		props.append(pcdata(itemElement.getElementsByTagName("Description")[0]))
		items.append(props)
		
	return items

def parseBids(dom):
	itemElements = dom.getElementsByTagName("Item")
	bids = []
	
	for itemElement in itemElements:
		bidsElement = itemElement.getElementsByTagName("Bids")[0]
		bidElements = bidsElement.getElementsByTagName("Bid")

		for bidElement in bidElements:
			props = []
			bidder = bidElement.getElementsByTagName("Bidder")[0]
			props.append(bidder.attributes["UserID"].value)
			props.append(itemElement.attributes["ItemID"].value)
			props.append(transformDttm(pcdata(bidElement.getElementsByTagName("Time")[0])))
			props.append(transformDollar(pcdata(bidElement.getElementsByTagName("Amount")[0])))

			bids.append(props)
	return bids

def parseItemCategories(dom):
	itemElements = dom.getElementsByTagName("Item")
	itemCategories = []

	for itemElement in itemElements:
		categories = itemElement.getElementsByTagName("Category")
		
		for category in categories:	
			props = []
			props.append(itemElement.attributes["ItemID"].value)
			props.append(pcdata(category))
			itemCategories.append(props)

	return itemCategories

UserRelation = "User"
ItemRelation = "Item"
BidRelation = "Bid"
ItemCategoryRelation = "ItemCategory"
NULLValue = "NULL"

relations = {UserRelation : parseUsers, ItemRelation : parseItems, BidRelation : parseBids, ItemCategoryRelation : parseItemCategories}
class_prefix = "-class"

"""
Loops through each xml files provided on the command line and passes each file
to the parser
"""
def main(argv):
    class_index = -1

    try:
     	class_index = argv.index(class_prefix);
    except:
	pass

    if len(argv) < 4 or class_index == -1:
        print >> sys.stderr, 'Usage: python parser.py <path to xml files> -class <class>'
        sys.exit(1)

    parse_fn = relations[argv[class_index+1]]

    # loops over all .xml files in the argument
    for f in argv[1:]:
        if isXml(f):
            parseXml(f, parse_fn)
            #print "Success parsing " + f

if __name__ == '__main__':
    main(sys.argv)
