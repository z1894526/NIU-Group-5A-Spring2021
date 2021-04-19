# Delete pre-existing tables
DROP TABLE Shipping_Cost;
DROP TABLE Part_Order;
DROP TABLE Order_;
DROP TABLE Customer;

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
	weight_total FLOAT(6,2),
	price_total FLOAT(8,2),

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
	bracket_id INT NOT NULL AUTO_INCREMENT,
	price FLOAT(8,2) NOT NULL,
	min_weight FLOAT(4,2) NOT NULL,
	max_weight FLOAT(4,2) NOT NULL,

	PRIMARY KEY	(bracket_id)
);

DESCRIBE Customer;
DESCRIBE Order_;
DESCRIBE Part_Order;
DESCRIBE Shipping_Cost;
