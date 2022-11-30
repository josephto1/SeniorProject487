from pip._vendor import requests
from bs4 import BeautifulSoup, NavigableString
import re
import mysql.connector

#connect to db
mydb = mysql.connector.connect(
    host="localhost",
    user="jato",
    password="cheese7100",
    database="printers"
)

mycursor = mydb.cursor()

#find webpage to scrape
URL = "https://turing.cs.olemiss.edu/~jato/weir209Printer.html"
page = requests.get(URL)

soup = BeautifulSoup(page.content, "html.parser")

#extract all blank entries
for match in soup.find_all('div', id=re.compile("msg1001")):
    match.extract()

for empty in soup.find_all('div', id=re.compile("msg-97")):
    empty.insert(0, NavigableString("No Description"))

currentcycle = soup.find(id="itm-9057")

cyclenumber = currentcycle.find("div", class_="hpDataItemValue")

cyclecount = cyclenumber.text.strip()

print(cyclecount)

cyclelist = []

cyclelist.append(cyclecount)

mycursor.execute('DELETE FROM printer2supplies')

sql = "INSERT INTO printer2supplies (cycles) VALUES (%s)"
val = (cyclelist)
mycursor.execute(sql, val)

#find the correct table we want to scrape
results = soup.find(id="page-9445")

#find all td inside the table
printer_elements = results.find_all("td", class_="hpTableCell")

#create a list to store the values of the table
printerList = []

#loop through all the elements we want to add to the db
for printer_element in printer_elements:
    #find the text inside each cell
    first_element = printer_element.find("div", class_="hpPageText")
    # if the cell is empty extract from the page
    try:
        if len(first_element.get_text(strip=True)) == 0:
            first_element.extract()
        #if it is not empty add it to the list
        else:
            listItem = first_element.text.strip()
            print(first_element.text.strip())
            printerList.append(listItem)
    except AttributeError:
        pass
    

print(printerList)


# divide list into sublists of 7 because each entry has 7 items
def divide_chunks(l, n):

    # looping till length l
    for i in range(0, len(l), n):
        yield l[i:i + n]

n = 7

x = list(divide_chunks(printerList, n))
print(x)

mycursor.execute('DELETE FROM printer2')

#insert values into db
mycursor.executemany('''INSERT INTO printer2 (number, date, time, cycles, event, firmware, description)
                      VALUES (%s, %s, %s, %s, %s, %s, %s)''', x)

# commit to db
mydb.commit()


URL = "https://turing.cs.olemiss.edu/~jato/weir209InkLevel.html"
page = requests.get(URL)

soup = BeautifulSoup(page.content, "html.parser")

item = soup.find("div", class_="hpGasGaugeBlock")


print(item.text.strip())

ink = str(item.text.strip())

inky = re.findall(r'\d+', ink)

print(inky)

del inky[-1]

print(inky)


suppliesList = []

suppliesList.append(cyclecount)

suppliesList.append(inky)


print(suppliesList)


sql = "INSERT INTO printer2supplies (ink) VALUES (%s)"
val = (inky)
mycursor.execute(sql, val)

# commit to db
mydb.commit()