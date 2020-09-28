CREATE TABLE `history` (
 `history_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `create_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `details` (
 `details_id` int(11) NOT NULL AUTO_INCREMENT,
 `history_id` int(11) NOT NULL,
 `item_id` int(11) NOT NULL,
 `price` int(11) NOT NULL,
 `amount` int(11) NOT NULL,
 PRIMARY KEY (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8