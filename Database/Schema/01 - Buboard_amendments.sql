USE `buboard-data`;

/* BEGIN CHANGES Feb 14th*/

ALTER TABLE `buboard_profiles` CHANGE `email_address` `email_address` VARCHAR(320) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `buboard_profiles` ADD INDEX( `real_name`), ADD INDEX(`profile_desc`);

/* END CHANGES Feb 14th*/