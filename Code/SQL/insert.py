# Reading an excel file using Python 
import xlrd 
import random
from datetime import datetime, timedelta

min_year=2016
max_year=2018

start = datetime(min_year, 1, 1, 00, 00, 00)
years = max_year - min_year+1
end = start + timedelta(days=365 * years)


#done

# or a function
def gen_datetime(min_year=2016, max_year=2018):
    # generate a datetime in format yyyy-mm-dd hh:mm:ss.000000
    start = datetime(min_year, 1, 1, 00, 00, 00)
    years = max_year - min_year + 1
    end = start + timedelta(days=365 * years)
    return start + (end - start) * random.random()
  
# Give the location of the file 
loc = ("order_details.xlsx") 
  
# To open Workbook 
wb = xlrd.open_workbook(loc) 
sheet = wb.sheet_by_index(0) 
  
# For row 0 and column 0 
#print(sheet.cell_value(0, 0))
#insert into Users values('Customer','password','c');

#print("insert into customer values(",int(r[0]),", ","'",a[0:10],"'",", ","'",r[2],"'",", ","'",r[3],"'",", ",int(r[4]),", ","'",r[5],"'",", ",int(r[6]),", ","'",r[7],"'",", ","'",r[8],"'",", ","'",r[9],"'",", ","'",r[10],"'",", ","'",r[11],"'",", ","'",r[12],"'",", ","'",int(r[13]),"'",", ",int(r[14]),");",sep="")
#print("insert into shippers values(",int(r[0]),", ","'",r[1],"'",", ",int(r[2]),");",sep="")
#print("insert into suppliers values(",int(r[0]),", ","'",r[1],"'",", ",r[2],", ","'",r[3],"'",", ","'",r[4],"'",", ","'",r[5],"'",", ","'",r[6],"'",", ",int(r[7]),", ","'",r[8],"'",", ","'",r[9],"'",", ","'",r[10],"'",", ","'",r[11],"'",", ","'",int(r[12]),"'",", ",int(r[13]),");",sep="")
#print("insert into category values(",int(r[0]),", ","'",r[1],"'",", ","'",r[2],"'",");",sep="")
#print("insert into products values(",int(r[0]),", ","'",r[1],"'",", ",r[2],", ",int(r[3]),", ",int(r[4]),", ","'",r[5],"'",", ","'",r[6],"'",", ",int(r[7]),", ",int(r[8]),", ",int(r[9]),", ",int(r[10]),", ",int(r[11]),", ","'",r[12],"'",", ","'",r[13],"'",");",sep="")
#print("insert into orders values(",int(r[0]),", ","'",r[1],"'",", ",int(r[2]),", ",int(r[3]),", ","'",r[4],"'",", ","'",r[5],"'",", ",int(r[6]),", ","'",r[7],"'",", ","'",r[8],"'",");",sep="")
#print("insert into payment values(",int(r[0]),", ","'",r[1],"'",");",sep="")
#print("insert into order_details values(",int(r[0]),", ","'",r[1],"'",", ","'",r[2],"'",", ",int(r[3]),", ",0,", ",int(r[5]),", ",r[6],", ","'",r[7],"'",", ","'",r[8],"'",");",sep="")

# ,"','",r[]    ,",",r[]
n = sheet.nrows
for i in range(1,n):
    r = sheet.row_values(i)
    random_date = start + (end - start) * random.random()
    a = str(random_date)
    #r[1] = a[0:10]
    print("insert into order_details values(",int(r[0]),", ","'",r[1],"'",", ","'",r[2],"'",", ",int(r[3]),", ",0,", ",int(r[5]),", ",r[6],", ","'",r[7],"'",", ","'",r[8],"'",");",sep="")


    