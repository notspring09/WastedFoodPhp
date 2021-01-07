SELECT `product`.`id` AS `product_id`,`seller_id`, `product`.`name` AS `product_name`,`product`.`image` AS `product_image`, `start_time`, `end_time`, `original_price`,`sell_price`, `original_quantity`, `remain_quantity`,`product`.`description` AS `product_description`,`sell_date`,`status`,`shippable`, `account_id`, `currents`.`name` AS `seller_name`, `currents`.`image` AS `seller_image`, `address`,`latitude`,`longitude`,`currents`.`description` AS `seller_description`, `firebase_UID`,`rating`, distance FROM `product` JOIN ( SELECT `account_id`, `name`, `image`,`address`,`latitude`,`longitude`,`description`, `firebase_UID`,`rating`, distance FROM ( SELECT `account_id`, `name`, `image`,`address`,`latitude`,`longitude`,`description`, `firebase_UID`, `rating`, ( ( ( acos( sin(( 21.01324833333333 * pi() / 180)) * sin(( `latitude` * pi() / 180)) + cos(( 21.01324833333333* pi() /180 )) * cos(( `latitude` * pi() / 180)) * cos((( 105.52706333333332 - `longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance FROM `seller` JOIN `account` ON `account`.`id` = `seller`.`account_id`) markers ) currents ON currents.`account_id` = `product`.`seller_id` WHERE DATE(`sell_date`) = CURRENT_DATE AND `remain_quantity` > 0 AND TIME(`start_time`) >= '11:00:00' AND TIME(`end_time`) <= '22:00:00' AND `product`.`sell_price` / `product`.`original_price` * 100 < 90 ;