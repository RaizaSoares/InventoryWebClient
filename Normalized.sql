USE db_7505038_s20;
   
CREATE TABLE Customer
(
CustomerID INT PRIMARY KEY,
FirstName nvarchar(50) NOT NULL,
LastName nvarchar(50) NOT NULL
);

CREATE TABLE Sale
(
SalesOrderID INT PRIMARY KEY,
status tinyint NOT NULL,
CustomerID INT NOT NULL,
TotalDue decimal(19,4) NOT NULL,
OrderDate datetime NOT NULL,
FOREIGN KEY (CustomerID) REFERENCES Customer (CustomerID)
);
CREATE TABLE Product
(
ProductID int PRIMARY KEY,
ProductName nvarchar(50) NOT NULL,
ListPrice decimal(19,4) NOT NULL
);
CREATE TABLE Orders
(
SalesOrderID INT NOT NULL,
SalesOrderDetailID INT NOT NULL,
ProductID INT NOT NULL,
OrderQty INT NOT NULL,
FOREIGN KEY (SalesOrderID) REFERENCES Sale (SalesOrderID),
FOREIGN KEY (ProductID) REFERENCES Product (ProductID),
Primary Key (SalesOrderID, SalesOrderDetailID, ProductID)
);

CREATE TABLE Inventory
(
ProductID int NOT NULL,
LocationID smallint NOT NULL,
FOREIGN KEY (ProductID) REFERENCES Product (ProductID),
Primary Key (ProductID, LocationID),
Quantity smallint NOT NULL
);
INSERT into db_7505038_s20.Customer(CustomerID, FirstName, LastName)
SELECT DISTINCT CustomerID, FirstName, LastName
FROM Legacy_Store_DB.Customer;

INSERT into db_7505038_s20.Sale(SalesOrderID, status, CustomerID, TotalDue, OrderDate)
SELECT DISTINCT SalesOrderID, Status, CustomerID, TotalDue, OrderDate
FROM Legacy_Store_DB.Orders;

INSERT into db_7505038_s20.Product(ProductID, ProductName, ListPrice)
SELECT DISTINCT ProductID, ProductName, ListPrice
FROM Legacy_Store_DB.Orders;

INSERT into db_7505038_s20.Orders(SalesOrderID, SalesOrderDetailID, ProductID, OrderQty)
SELECT DISTINCT SalesOrderID, SalesOrderDetailID, ProductID, OrderQty
FROM Legacy_Store_DB.Orders;

INSERT into db_7505038_s20.Inventory(ProductID, LocationID, Quantity)
SELECT DISTINCT ProductID, LocationID, Quantity
FROM Legacy_Store_DB.Inventory;


