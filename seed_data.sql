-- Use the shopping_cart database
USE shopping_cart;

-- Insert customers
INSERT INTO users (username, role) VALUES ('Jane', 'customer');
INSERT INTO users (username, role) VALUES ('John', 'customer');


-- Insert products
INSERT INTO products (name, description, price, stock_quantity) VALUES
                                                                    ('Apple', 'A crisp and juicy red apple, perfect for a healthy snack.', 1.50, 100),
                                                                    ('Banana', 'A ripe, sweet banana full of potassium and energy.', 0.99, 120),
                                                                    ('Cherry', 'A small, sweet, and tangy cherry bursting with flavor.', 3.99, 80),
                                                                    ('Date', 'A chewy and naturally sweet date, rich in fiber.', 2.50, 60),
                                                                    ('Elderberry', 'A tart elderberry, often used in syrups and jams.', 4.50, 30),
                                                                    ('Fig', 'A fresh, soft fig with a sweet and rich taste.', 2.99, 50),
                                                                    ('Grape', 'A bunch of seedless grapes, perfect for snacking.', 2.99, 100),
                                                                    ('Honeydew Melon', 'A refreshing and juicy honeydew melon.', 3.50, 40),
                                                                    ('Indian Fig', 'A sweet and unique cactus fruit, also known as prickly pear.', 2.20, 30),
                                                                    ('Jackfruit', 'A large and sweet jackfruit, perfect for exotic dishes.', 5.99, 10);