USE `buboard-data`;

INSERT INTO `buboard_profiles` (`profile_id`, `real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`) VALUES ('1', 'Willy Wonka', '2017-10-03 00:00:00', 'fake hash lol', 'fsadfasdf', 'freewilly87@chocolate.com', '1', 'I liek chocolate', '1');
INSERT INTO `buboard_profiles` (`profile_id`, `real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`) VALUES ('2', 'Optimus Prime', '2017-10-02 00:00:00', 'fake hash lol', 'fsadfasdf', 'example@example.com', '1', 'This is a fake profile', '1');
INSERT INTO `buboard_profiles` (`profile_id`, `real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`) VALUES ('3', 'Snoop Dogg', '2017-10-01 00:00:00', 'fake hash lol', 'fsadfasdf', 'dfasdf@google.com', '1', 'This profile has no description.', '1');

INSERT INTO `post_categories` (`category_id`, `category_name`, `category_color`) VALUES ('1', 'Events', 'FFA500');
INSERT INTO `post_categories` (`category_id`, `category_name`, `category_color`) VALUES ('2', 'Announcements', '7FFF00');

INSERT INTO `buboard_posts` (`post_id`, `post_by_user_id`, `belongs_to_category`, `post_contents`, `post_title`, `post_date`) VALUES (NULL, '3', '2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 'Example post!!!!', '2017-10-04 13:15:29');
INSERT INTO `buboard_posts` (`post_id`, `post_by_user_id`, `belongs_to_category`, `post_contents`, `post_title`, `post_date`) VALUES (NULL, '2', '1', 'This is a long text post about things and stuff. Many things are said here, regarding several other things. Sometimes, this text has substance. Some other times, like this one, they do not.', 'How do I use buboard?', '2017-10-01 14:28:29');
INSERT INTO `buboard_posts` (`post_id`, `post_by_user_id`, `belongs_to_category`, `post_contents`, `post_title`, `post_date`) VALUES (NULL, '1', '2', 'What even is a buboard? or is it booboard? ', 'Recent Announcements', '2017-10-24 19:28:35');
INSERT INTO `buboard_posts` (`post_id`, `post_by_user_id`, `belongs_to_category`, `post_contents`, `post_title`, `post_date`) VALUES (NULL, '3', '2', 'Please... I\'m so lonely. I haven\'t seen other people in a solid week. ', 'Anyone wanna grab coffee?', '2017-08-09 21:31:29');

INSERT INTO `post_attachments` (`attachment_id`, `belongs_to_post_id`, `post_attachment_num`) VALUES (NULL, '3', '1'), (NULL, '4', '1'), (NULL, '4', '1')
