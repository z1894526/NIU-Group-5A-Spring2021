# Delete pre-existing tables
DROP TABLE Shipping_Cost;
DROP TABLE Part_Order;
DROP TABLE Order_;
DROP TABLE Customer;
DROP TABLE Inventory;

# ^ = primary key, * = foreign key
# Customer(customer_id^, first_name, last_name, email, mailing_addr)
CREATE TABLE Customer
(
	customer_id	INT NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(30),
	last_name VARCHAR(30),
	email VARCHAR(30),
	street__addr VARCHAR(30),
	city_addr VARCHAR(30),
	state_addr VARCHAR(2),
	zip_addr VARCHAR(5),

	PRIMARY KEY	(customer_id)
);
INSERT INTO Customer
	(first_name, last_name, email, street__addr, city_addr, state_addr, zip_addr)
	VALUES('Jason', 'Haut', 'z1894526@students.niu.edu', '123 Dekalb Drive', 'Dekalb', 'IL', '60115');

#Order_(order_id^, order_num, customer_id*, filled_date, ordered_date, status, weight_total, price_total)
CREATE TABLE Order_
(
	order_id INT NOT NULL AUTO_INCREMENT,
	customer_id	INT,
	filled_date DATETIME,
	ordered_date DATETIME,
	status VARCHAR(10),
	weight_total FLOAT,
	price_total FLOAT,

	PRIMARY KEY	(order_id),
	FOREIGN KEY	(customer_id) REFERENCES Customer(customer_id) 
);
INSERT INTO Order_
	(filled_date, ordered_date, status, weight_total, price_total)
	VALUES('2021-04-02 14:21:34', '2021-04-01 08:30:52', 'Orderd', '20', '80.00');

#Part_Order(part_order_id^, order_id*, part_num*, item_name, order_num, quantity)
CREATE TABLE Part_Order
(
	part_order_id INT NOT NULL AUTO_INCREMENT,
	order_id INT,
	part_num CHAR(10),
	item_name VARCHAR(30),
	quantity INT,

	PRIMARY KEY	(part_order_id),
	FOREIGN KEY	(order_id) REFERENCES Order_(order_id)
);

#Shipping_Cost(price^, order_id*, min_weight^, max_weight^)
CREATE TABLE Shipping_Cost
(
	price FLOAT NOT NULL,
	min_weight FLOAT NOT NULL,
	max_weight FLOAT NOT NULL,

	PRIMARY KEY	(price, min_weight, max_weight)
);

CREATE TABLE Inventory
(
	part_number INT,
	quantity_on_hand INT,

	PRIMARY KEY (part_number)
);

DESCRIBE Customer;
DESCRIBE Order_;
DESCRIBE Part_Order;
DESCRIBE Shipping_Cost;
DESCRIBE Inventory;
