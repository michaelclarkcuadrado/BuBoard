GRANT ALL PRIVILEGES ON *.* TO 'buboard'
IDENTIFIED BY 'buboard'
WITH GRANT OPTION;
CREATE DATABASE `buboard-data`
  CHARACTER SET UTF8
  COLLATE utf8_bin;

USE `buboard-data`;
/* Create tables */
CREATE TABLE `buboard-data`.`post_categories` (
  `category_id`    INT          NOT NULL AUTO_INCREMENT,
  `category_name`  VARCHAR(255) NOT NULL,
  `category_color` CHAR(6)      NOT NULL,
  PRIMARY KEY (`category_id`)
);

CREATE TABLE `buboard-data`.`buboard_posts` (
  `post_id`             INT           NOT NULL AUTO_INCREMENT,
  `post_by_user_id`     INT           NOT NULL,
  `belongs_to_category` INT           NOT NULL,
  `post_contents`       VARCHAR(1023) NOT NULL,
  `post_title`          VARCHAR(255)  NOT NULL,
  `post_date`           DATETIME      NOT NULL,
  PRIMARY KEY (`post_id`)
);

CREATE TABLE `buboard-data`.`buboard_profiles` (
  `profile_id`                          INT          NOT NULL AUTO_INCREMENT,
  `real_name`                           VARCHAR(255) NOT NULL,
  `date_signup`                         DATETIME     NOT NULL,
  `password_hash`                       VARCHAR(255) NOT NULL,
  `email_confirmation_secret`           VARCHAR(255) NOT NULL,
  `email_address`                       VARCHAR(320) NOT NULL,
  `email_is_confirmed`                  TINYINT(1)   NOT NULL,
  `phone_confirmation_secret`           INT(11)      NOT NULL DEFAULT 0,
  `phone_number`                        VARCHAR(15)  NOT NULL DEFAULT 0,
  `phone_number_is_confirmed`           TINYINT(1)   NOT NULL DEFAULT 0,
  `profile_desc`                        VARCHAR(255) NOT NULL,
  `has_submitted_photo`                 TINYINT(1)   NOT NULL,
  `followers_posts_since_feed_pull`     INT(11)      NOT NULL DEFAULT 0,
  `power_of_two_posts_til_notification` SMALLINT     NOT NULL DEFAULT 3,
  `isAdmin`                             TINYINT(1)   NOT NULL DEFAULT 0,
  `isVerifiedAccount`                   TINYINT(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`profile_id`)
);
# I cannot for the life of me figure out how to declare a primary key and a unique key on the same query.
ALTER TABLE `buboard_profiles`
  ADD UNIQUE (`email_address`);

CREATE TABLE `buboard-data`.`profile_follows` (
  `follower_id` INT NOT NULL,
  `followee_id` INT NOT NULL,
  PRIMARY KEY (`follower_id`, `followee_id`)
);

CREATE TABLE `buboard-data`.`post_attachments` (
  `attachment_id`       INT     NOT NULL AUTO_INCREMENT,
  `belongs_to_post_id`  INT     NOT NULL,
  `post_attachment_num` TINYINT NOT NULL,
  PRIMARY KEY (`attachment_id`)
);

/* Create foreign keys between tables */

# Posts 2 categories
ALTER TABLE `buboard_posts`
  ADD CONSTRAINT `posts2categories` FOREIGN KEY (`belongs_to_category`) REFERENCES `post_categories` (`category_id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

# Follows to users
ALTER TABLE `profile_follows`
  ADD CONSTRAINT `followers2users` FOREIGN KEY (`follower_id`) REFERENCES `buboard_profiles` (`profile_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
ALTER TABLE `profile_follows`
  ADD CONSTRAINT `followed2users` FOREIGN KEY (`followee_id`) REFERENCES `buboard_profiles` (`profile_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

# Posts 2 users
ALTER TABLE `buboard_posts`
  ADD CONSTRAINT `posts2users` FOREIGN KEY (`post_by_user_id`) REFERENCES `buboard_profiles` (`profile_id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

# Attachments 2 posts
ALTER TABLE `post_attachments`
  ADD FOREIGN KEY (`belongs_to_post_id`) REFERENCES `buboard_posts` (`post_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

# Add Admin account
INSERT INTO `buboard_profiles` (`profile_id`, `real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `phone_confirmation_secret`, `phone_number`, `phone_number_is_confirmed`, `profile_desc`, `has_submitted_photo`, `followers_posts_since_feed_pull`, `power_of_two_posts_til_notification`, `isAdmin`, `isVerifiedAccount`)
VALUES ('4', 'Buboard Administration', NOW(), '$2a$10$AJiOklxbXIf3k3dM9ia3W.mIoM14E./ucrli3c8ZfgwMDq/6dKQ4.', '000000', 'buboardadmin@buboard.net', '1', '00000', '000000000', '0',
             'Official Buboard Administrator.', '0', '0', '2', '1', '1');