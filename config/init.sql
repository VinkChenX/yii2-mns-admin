CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `password_hash` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `auth_key` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Auth Key',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_name` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `mns_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '创建用户ID',
  `component_id` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '使用组件ID',
  `name` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '名称',
  `description` text NOT NULL COMMENT '描述',
  `delay_seconds` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '延迟时间（秒）',
  `maximum_message_size` int(11) unsigned NOT NULL COMMENT '消息体最大长度（1024 ~ 65536Byte）',
  `message_retention_period` int(11) unsigned NOT NULL COMMENT '消息最长保留时间（60 ~ 1296000秒）',
  `visibility_timeout` int(11) unsigned NOT NULL COMMENT '消息被receive后的隐藏时长（1 ~ 43200秒）',
  `logging_enabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用日志',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_name` (`name`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

CREATE TABLE `mns_topic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `component_id` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '组件ID',
  `name` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '名称',
  `description` text NOT NULL COMMENT '描述',
  `maximum_message_size` int(11) unsigned NOT NULL COMMENT '消息体的最大长度（1024 ~ 65536Byte）',
  `logging_enabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启日志',
  `active_subscription_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '已激活订阅数量',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_name` (`name`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

CREATE TABLE `mns_topic_subscription` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '名称',
  `topic_id` int(11) unsigned NOT NULL COMMENT '主题ID',
  `description` text NOT NULL COMMENT '描述',
  `endpoint` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '终端',
  `notify_strategy` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '消息推送出现错误时的重试策略',
  `notify_content_format` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '消息格式',
  `filter_tag` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '过滤标签',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_topicid_name` (`topic_id`,`name`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
