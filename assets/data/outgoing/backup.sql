UPDATE `admin` SET `last_login` = '2020-08-19 12:59:59', `ip_address` = '::1'
WHERE `id` = '1';
INSERT INTO `user_registration` (`uid`, `user_id`, `sponsor_id`, `username`, `f_name`, `l_name`, `email`, `password`, `phone`, `reg_ip`, `status`) VALUES ('', '1PVFBW', 'B0TASK', 'Samfield', 'Samfield', 'Bassey', 'basseysamfield@gmail.com', '359b7d4b70e42636dc6d11b88bb3c0fc', '08188631121', '::1', '1');
UPDATE `admin` SET `last_logout` = '2020-08-19 13:04:07'
WHERE `id` = '1';
UPDATE `admin` SET `last_login` = '2020-08-19 13:16:34', `ip_address` = '::1'
WHERE `id` = '1';
UPDATE `admin` SET `last_login` = '2020-08-19 14:35:02', `ip_address` = '::1'
WHERE `id` = '1';
INSERT INTO `pin` (`pin_prefix`, `pin_amount`) VALUES (NULL, 'fsdadfsd');
INSERT INTO `pin` (`pin_prefix`, `pin_amount`, `pin_code`) VALUES (NULL, 'fsdadfsd', '-694');
INSERT INTO `pin` (`pin_prefix`, `pin_amount`, `pin_code`) VALUES (NULL, 'fsdadfsd', '-400');
INSERT INTO `pin` (`pin_prefix`, `pin_amount`, `pin_code`) VALUES (NULL, '3000', '-559');
INSERT INTO `pin` (`pin_prefix`, `pin_amount`, `pin_code`) VALUES (NULL, '3000', '-629');
INSERT INTO `pin` (`pin_prefix`, `pin_amount`, `pin_code`) VALUES ('TEST', '3000', 'TEST-892');
INSERT INTO `pin` (`pin_amount`, `pin_code`) VALUES ('3000', 'TEST-180');
INSERT INTO `pin` (`pin_amount`, `pin_code`) VALUES ('6000', 'TEXT-282');
INSERT INTO `pin` (`pin_amount`, `pin_code`) VALUES ('5000', 'txt-');
INSERT INTO `pin` (`pin_amount`, `pin_code`) VALUES ('4000', 'txt--4073-3205-2607-8716');
INSERT INTO `pin` (`pin_amount`, `pin_code`) VALUES ('4000', 'TXT-6779-6907-2069-9349');
INSERT INTO `pin` (`pin_amount`, `pin_code`) VALUES ('5000', 'TXT-2630-7663-9905-1510');
UPDATE `admin` SET `last_logout` = '2020-08-20 10:56:23'
WHERE `id` IS NULL;
UPDATE `admin` SET `last_login` = '2020-08-20 19:09:21', `ip_address` = '::1'
WHERE `id` = '1';
INSERT INTO `user_registration` (`uid`, `user_id`, `sponsor_id`, `username`, `f_name`, `l_name`, `email`, `password`, `phone`, `reg_ip`, `status`) VALUES ('', 'XV54XA', 'B0TASK', 'Psalmfill', 'Ubong', 'Bassey', 'basseysamfield@gmail.com', '359b7d4b70e42636dc6d11b88bb3c0fc', '08188631121', '::1', '1');
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`) VALUES ('XV54XA', '5940', 'payeer', '60', '', '2020-08-20 20:09:41', '::1');
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`) VALUES ('XV54XA', '229.68', 'payeer', '2.32', '', '2020-08-20 20:24:25', '::1');
UPDATE `admin` SET `last_logout` = '2020-08-20 21:58:06'
WHERE `id` IS NULL;
UPDATE `admin` SET `last_login` = '2020-08-20 21:58:11', `ip_address` = '::1'
WHERE `id` = '1';
INSERT INTO `pin` (`pin_amount`, `pin_code`) VALUES ('5000', 'TXT-3966-8483-8970-1739');
UPDATE `pin` SET `is_used` = 1
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('XV54XA', '4950', 'Pin', '50', NULL, '2020-08-20 21:59:15', '::1', 1);
UPDATE `pin` SET `is_used` = 1
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('XV54XA', '4950', 'Pin', '50', NULL, '2020-08-20 22:41:22', '::1', 1);
UPDATE `pin` SET `is_used` = 1
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('XV54XA', '4950', 'Pin', '50', NULL, '2020-08-20 22:49:15', '::1', 1);
UPDATE `pin` SET `is_used` = 1, `user_id` = 'XV54XA'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('XV54XA', '990', 'Pin', '10', NULL, '2020-08-20 22:52:28', '::1', 1);
UPDATE `pin` SET `is_used` = 1, `user_id` = 'XV54XA'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('XV54XA', '990', 'Pin', '10', NULL, '2020-08-20 22:53:48', '::1', 1);
INSERT INTO `user_registration` (`uid`, `user_id`, `sponsor_id`, `username`, `f_name`, `l_name`, `email`, `password`, `phone`, `reg_ip`, `status`) VALUES ('', 'O29ICB', 'B0TASK', 'Samfield', 'Ubong', 'Bassey', 'basseysamfield@gmail.com', '359b7d4b70e42636dc6d11b88bb3c0fc', '08188631121', '::1', '1');
UPDATE `pin` SET `is_used` = 1, `user_id` = 'O29ICB'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('O29ICB', '4950', 'Pin', '50', NULL, '2020-08-20 23:02:32', '::1', 1);
UPDATE `admin` SET `last_logout` = '2020-08-21 06:39:31'
WHERE `id` IS NULL;
UPDATE `admin` SET `last_login` = '2020-08-21 06:39:37', `ip_address` = '::1'
WHERE `id` = '1';
UPDATE `pin` SET `is_used` = 1, `user_id` = 'O29ICB'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('O29ICB', '4950', 'Pin', '50', NULL, '2020-08-21 06:41:20', '::1', 1);
UPDATE `pin` SET `is_used` = 1, `user_id` = 'O29ICB'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('O29ICB', '4950', 'Pin', '50', NULL, '2020-08-21 06:50:21', '::1', 1);
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('O29ICB', NULL, NULL, NULL, 'Pin deposit', '2020-08-21 06:51:30', '::1', 1);
UPDATE `pin` SET `is_used` = 1, `user_id` = 'O29ICB'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739 ';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('O29ICB', '4950', 'Pin', '50', NULL, '2020-08-21 06:57:19', '::1', 1);
INSERT INTO `deposit` (`deposit_id`, `user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `pin_code`) VALUES (NULL, 'O29ICB', '4950', 'Pin', '50', NULL, '2020-08-21 06:57:19', '::1', 'TXT-3966-8483-8970-1739 ');
UPDATE `admin` SET `last_logout` = '2020-08-21 09:55:59'
WHERE `id` IS NULL;
UPDATE `admin` SET `last_logout` = '2020-08-21 09:55:59'
WHERE `id` IS NULL;
UPDATE `admin` SET `last_login` = '2020-08-21 09:56:06', `ip_address` = '::1'
WHERE `id` = '1';
UPDATE `pin` SET `is_used` = 1, `user_id` = 'O29ICB'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`deposit_id`, `user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `pin_code`, `status`) VALUES (NULL, 'O29ICB', '4851.495', 'Pin', '49.005', NULL, '2020-08-21 10:06:12', '::1', 'TXT-3966-8483-8970-1739', 1);
UPDATE `pin` SET `is_used` = 1, `user_id` = NULL
WHERE `pin_code` IS NULL;
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);
UPDATE `pin` SET `is_used` = 1, `user_id` = NULL
WHERE `pin_code` IS NULL;
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);
UPDATE `pin` SET `is_used` = 1, `user_id` = 'O29ICB'
WHERE `pin_code` = 'TXT-3966-8483-8970-1739';
INSERT INTO `deposit` (`user_id`, `deposit_amount`, `deposit_method`, `fees`, `comments`, `deposit_date`, `deposit_ip`, `status`) VALUES ('O29ICB', '4950', 'Pin', '50', NULL, '2020-08-21 10:10:58', '::1', 1);
INSERT INTO `transections` (`user_id`, `transection_category`, `releted_id`, `amount`, `transection_date_timestamp`, `comments`, `status`) VALUES ('O29ICB', 'deposit', 12, '4950', '2020-08-21 10:10:59', NULL, 1);
INSERT INTO `message` (`sender_id`, `receiver_id`, `subject`, `message`, `datetime`) VALUES (1, 'O29ICB', 'Deposit', 'Hi,Ubong Bassey You Deposit The Amount Is $4950', '2020-08-21 10:10:59');
