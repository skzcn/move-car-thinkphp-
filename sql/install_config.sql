CREATE TABLE IF NOT EXISTS `system_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text,
  `config_group` varchar(20) DEFAULT 'basic',
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `system_config` (`name`, `value`, `config_group`, `title`) VALUES
('site_title', '我的网站', 'basic', '网站标题'),
('smtp_host', 'smtp.qq.com', 'email', 'SMTP服务器'),
('smtp_port', '465', 'email', 'SMTP端口'),
('smtp_user', '', 'email', 'SMTP用户名'),
('smtp_pass', '', 'email', 'SMTP密码'),
('smtp_from', '', 'email', '发件人邮箱');
