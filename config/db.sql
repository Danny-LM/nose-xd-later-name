-- Table: users (buyers and sellers)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: products (each product has a seller)
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    seller_id INT NOT NULL, -- seller
    publication_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: categories
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

-- Intermediate Table: product_category (many-to-many relationship if desired)
CREATE TABLE product_category (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id)
);

-- Table: cart (products the user is about to purchase)
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- buyer
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: orders (a generated purchase order)
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- buyer
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'paid', 'cancelled', 'shipped', 'delivered') DEFAULT 'pending'
);

-- Table: order_details (products within an order)
CREATE TABLE order_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL
);

-- Add foreign keys
ALTER TABLE products ADD FOREIGN KEY (seller_id) REFERENCES users(user_id) ON DELETE CASCADE;
ALTER TABLE product_category ADD FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE;
ALTER TABLE product_category ADD FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE;
ALTER TABLE cart ADD FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE;
ALTER TABLE cart ADD FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE;
ALTER TABLE orders ADD FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE;
ALTER TABLE order_details ADD FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE;
ALTER TABLE order_details ADD FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE;

-- Initial inserts
INSERT INTO users (name, email, password, phone, address) VALUES
('Juan Perez', 'juan@example.com', '123456', '5551234567', 'Evergreen Ave 123'),
('Ana Lopez', 'ana@example.com', 'abcdef', '5559876543', 'Moon St 456');

INSERT INTO categories (category_name) VALUES ('Electronics'), ('Apparel'), ('Home');

INSERT INTO products (product_name, description, price, stock, seller_id) VALUES
('Bluetooth Headphones', 'Noise-cancelling headphones.', 599.99, 20, 1),
('White T-Shirt', 'Basic cotton t-shirt.', 149.50, 100, 2);

INSERT INTO product_category (product_id, category_id) VALUES
(1, 1), (2, 2);

INSERT INTO cart (user_id, product_id, quantity) VALUES
(2, 1, 1), (2, 2, 2);

INSERT INTO orders (user_id, total, status) VALUES (2, 898.99, 'paid');

INSERT INTO order_details (order_id, product_id, quantity, unit_price) VALUES
(1, 1, 1, 599.99),
(1, 2, 2, 149.50);

-- =========================================
-- Change 2025-06-04
-- Added audience and category catalog tables
-- Modified the products table to add foreign keys to catalogs
-- =========================================

-- =========================================
-- ALTER PRODUCTS TABLE
-- =========================================
ALTER TABLE products 
ADD audience_id INT,
ADD discount INT,
ADD new_category_id INT,
ADD advertising BOOLEAN DEFAULT FALSE;

-- =========================================
-- CREATE AUDIENCES CATALOG
-- =========================================
CREATE TABLE audiences (
    audience_id INT AUTO_INCREMENT PRIMARY KEY,
    audience_name VARCHAR(50) NOT NULL
);

INSERT INTO audiences (audience_name) VALUES 
('Child'), 
('Teenager'), 
('Adult');

-- =========================================
-- INSERT NEW CATEGORIES
-- =========================================
CREATE TABLE new_categories (
    new_category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

INSERT INTO new_categories (category_name) VALUES 
('Toys'), 
('Books'), 
('Accessories');

-- =========================================
-- FOREIGN KEYS
-- =========================================
ALTER TABLE products 
ADD FOREIGN KEY (audience_id) REFERENCES audiences(audience_id) ON DELETE SET NULL,
ADD FOREIGN KEY (new_category_id) REFERENCES new_categories(new_category_id) ON DELETE SET NULL;
