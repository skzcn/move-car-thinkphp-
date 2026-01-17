ALTER TABLE `users` ADD COLUMN `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '邮箱' AFTER `mobile`;
