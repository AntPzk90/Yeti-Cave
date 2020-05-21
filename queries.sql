INSERT INTO categories(title_category, symbol)
VALUES
('Доски и лыжи','boards'),
('Крепления','attachment'),
('Ботинки','boots'),
('Одежда','clothing'),
('Инструменты','tools'),
('Разное','other');

INSERT INTO users(email, name_user, pass, contacts, id_lot, id_bid)
VALUES
('alexey@gmail.com', 'Alex', '1234', '+380987776644', 1, 1),
('anatolii@gmail.com', 'Anatolii', '1234', '+380987776655', 2, 2),
('vlad@gmail.com', 'Vlad', '1234', '+380987776655', 3, 3);

INSERT INTO lots (title_lot, dscr, img_path, start_price, price_lot, step, dt_fin, id_user, id_winner, id_category)
VALUES
('2014 Rossignol District Snowboard', 'some text 1', 'img/lot-1.jpg', '10999', '11999', 1000 ,'2020-06-11', 1, 3, 1),
('DC Ply Mens 2016/2017 Snowboard', 'some text 2', 'img/lot-2.jpg', '15999', '16999', 1000,'2020-06-10', 1, 3, 1),
('Крепления Union Contact Pro 2015 года размер L/XL', 'some text 3', 'img/lot-3.jpg', '8000', '8800', 800,'2020-06-09', 1, 3, 2),
('Ботинки для сноуборда DC Mutiny Charocal', 'some text 4', 'img/lot-4.jpg', '10999', '11799', 800, '2020-06-08', 2, 3, 3),
('Куртка для сноуборда DC Mutiny Charocal', 'some text 5', 'img/lot-5.jpg', '7500', '8000', 500, '2020-06-07', 2, 3, 4),
('Маска Oakley Canopy', 'some text 6', 'img/lot-6.jpg', '5400', '5900', 500, '2020-06-06', 3, 3, 6);

INSERT INTO bids(price_bid, id_lot, id_user)
VALUES
(15000, 1, 3),
(16000, 1, 2),
(17000, 1, 3),
(18000, 1, 2);

SELECT title_category FROM categories;

SELECT title_lot, start_price, img_path, price_lot, id_category, dt_fin FROM lots WHERE
dt_fin < '2020-06-11 00:00:00';

SELECT *  FROM lots l
JOIN categories c
ON l.id_category = c.id;

UPDATE lots SET title = '2014 Rossignol District Snowboard updated' WHERE id = 1;

SELECT * FROM bids WHERE id_lot = 1 ORDER BY dt_add ASC
