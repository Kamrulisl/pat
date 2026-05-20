CREATE DATABASE IF NOT EXISTS PetSelling CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE PetSelling;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Messages;
DROP TABLE IF EXISTS Reviews;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Pets;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20),
    city VARCHAR(80),
    profile_picture VARCHAR(255),
    role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Pets (
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    category_id INT NOT NULL,
    pet_name VARCHAR(100) NOT NULL,
    breed VARCHAR(100),
    age INT DEFAULT 0,
    gender ENUM('male', 'female') NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    pet_image VARCHAR(255),
    status ENUM('available', 'sold', 'pending') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id) ON DELETE CASCADE
);

CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    pet_id INT NOT NULL,
    order_status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (pet_id) REFERENCES Pets(pet_id) ON DELETE CASCADE
);

CREATE TABLE Reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    seller_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE Messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

INSERT INTO Categories (category_name, description) VALUES
('Dog', 'Friendly dogs and puppies'),
('Cat', 'Cats and kittens'),
('Bird', 'Pet birds'),
('Rabbit', 'Rabbits and small pets'),
('Fish', 'Aquarium fish');

-- Default password for all seed accounts is: 123456
INSERT INTO Users (username, email, password_hash, full_name, phone_number, city, profile_picture, role) VALUES
('admin', 'admin@petpals.com', 'e10adc3949ba59abbe56e057f20f883e', 'PetPals Admin', '01700000000', 'Dhaka', 'admin.jpg', 'admin'),
('seller', 'seller@petpals.com', 'e10adc3949ba59abbe56e057f20f883e', 'Demo Seller', '01800000000', 'Dhaka', NULL, 'seller'),
('buyer', 'buyer@petpals.com', 'e10adc3949ba59abbe56e057f20f883e', 'Demo Buyer', '01900000000', 'Dhaka', NULL, 'buyer');

INSERT INTO Pets (seller_id, category_id, pet_name, breed, age, gender, price, description, pet_image, status) VALUES
(1, 1, 'Admin Special Puppy', 'Labrador', 6, 'female', 300.00, 'Admin listed sample product for buyer testing.', NULL, 'available'),
(2, 1, 'Max', 'Golden Retriever', 8, 'male', 350.00, 'Healthy, vaccinated and friendly puppy.', NULL, 'available'),
(2, 2, 'Milo', 'Persian', 5, 'male', 220.00, 'Calm kitten, litter trained and playful.', NULL, 'available'),
(2, 3, 'Rio', 'Budgerigar', 3, 'male', 45.00, 'Colorful bird with starter cage and food.', NULL, 'available'),
(2, 4, 'Snow', 'Mini Lop', 4, 'female', 80.00, 'Soft white rabbit with starter food pack.', NULL, 'available'),
(2, 5, 'Goldie Pack', 'Goldfish', 2, 'female', 25.00, 'Small aquarium fish pack for beginners.', NULL, 'available');
