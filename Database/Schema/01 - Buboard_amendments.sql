USE `buboard-data`;

/* BEGIN CHANGES Feb 14th*/

ALTER TABLE `buboard_profiles`
  CHANGE `email_address` `email_address` VARCHAR(320) CHARACTER SET utf8
COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `buboard_profiles`
  ADD INDEX (`real_name`),
  ADD INDEX (`profile_desc`);

/* END CHANGES Feb 14th*/

/* BEGIN CHANGES MARCH 14*/

CREATE TABLE `buboard-data`.`buboard_outgoing_messages_log` (
  `text_id`      INT          NOT NULL AUTO_INCREMENT,
  `user_id`      INT          NOT NULL,
  `timestamp`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `number`       VARCHAR(255) NOT NULL,
  `message_text` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`text_id`)
)
  ENGINE = InnoDB;

ALTER TABLE `buboard_outgoing_messages_log`
  ADD FOREIGN KEY (`user_id`) REFERENCES `buboard_profiles` (`profile_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

ALTER TABLE `buboard_profiles`
  ADD `follower_texts_enabled` BOOLEAN NOT NULL
  AFTER `phone_number_is_confirmed`,
  ADD `unread_texts_enabled` BOOLEAN NOT NULL
  AFTER `follower_texts_enabled`;

ALTER TABLE `buboard_profiles`
  ADD `phone_confirmation_text_sent` BOOLEAN NOT NULL
  AFTER `phone_number_is_confirmed`;

ALTER TABLE `buboard_profiles`
  CHANGE `profile_id` `profile_id` INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE `date_signup` `date_signup` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CHANGE `email_is_confirmed` `email_is_confirmed` TINYINT(1) NOT NULL DEFAULT '0',
  CHANGE `phone_confirmation_text_sent` `phone_confirmation_text_sent` TINYINT(1) NOT NULL DEFAULT '0',
  CHANGE `follower_texts_enabled` `follower_texts_enabled` TINYINT(1) NOT NULL DEFAULT '0',
  CHANGE `unread_texts_enabled` `unread_texts_enabled` TINYINT(1) NOT NULL DEFAULT '0',
  CHANGE `profile_desc` `profile_desc` VARCHAR(255) CHARACTER SET utf8
COLLATE utf8_bin NOT NULL DEFAULT '',
  CHANGE `has_submitted_photo` `has_submitted_photo` TINYINT(1) NOT NULL DEFAULT '0';
/* END CHANGES MARCH !4 */