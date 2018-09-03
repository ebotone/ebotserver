SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


DROP TABLE IF EXISTS `@@name_table_users@@`;
CREATE TABLE `@@name_table_users@@` (
  `id` int(11) NOT NULL,
  `chat_id` varchar(15) NOT NULL,
  `vk_id` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `language_code` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `nikname` varchar(50) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `remind` varchar(20) NOT NULL,
  `lng` varchar(3) NOT NULL,
  `datetime` datetime NOT NULL,
  `sid` varchar(32) NOT NULL,
  `field_1` varchar(500) NOT NULL,
  `field_2` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `@@name_table_users@@`
  ADD UNIQUE KEY `id` (`id`);


ALTER TABLE `@@name_table_users@@`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

DROP TABLE IF EXISTS `@@name_table_logs@@`;
CREATE TABLE `@@name_table_logs@@` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `chat_id` varchar(20) NOT NULL,
  `notice` text NOT NULL,
  `log_file` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `@@name_table_logs@@`
  ADD UNIQUE KEY `id` (`id`);
  
ALTER TABLE `@@name_table_logs@@`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
  
  
  
  
  
  
  
  
  
DROP TABLE IF EXISTS `@@name_table_group_questions@@`;
CREATE TABLE `@@name_table_group_questions@@` (
  `id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `php_start` varchar(1000) NOT NULL,
  `php_end` varchar(1000) NOT NULL,
  `sps` text NOT NULL,
  `gname` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;  

ALTER TABLE `@@name_table_group_questions@@`
  ADD UNIQUE KEY `id` (`id`);
  
ALTER TABLE `@@name_table_group_questions@@`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
  
DROP TABLE IF EXISTS `@@name_table_questions@@`;
CREATE TABLE `@@name_table_questions@@` (
  `id` int(11) NOT NULL,
  `group_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `field` varchar(50) NOT NULL,
  `_type` varchar(20) NOT NULL,
  `number` int(10) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `@@name_table_questions@@`
  ADD UNIQUE KEY `id` (`id`);
  
ALTER TABLE `@@name_table_questions@@`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;  

DROP TABLE IF EXISTS `@@name_table_act_questions@@`;
CREATE TABLE `@@name_table_act_questions@@` (
  `id` int(11) NOT NULL,
  `chat_id` varchar(20) NOT NULL,
  `group_id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

ALTER TABLE `@@name_table_act_questions@@`
  ADD UNIQUE KEY `id` (`id`);
  
ALTER TABLE `@@name_table_act_questions@@`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;  
  
  
COMMIT;  