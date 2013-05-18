-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 18, 2013 at 07:17 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tscp_blank`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_calls`
--

CREATE TABLE IF NOT EXISTS `active_calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `call_sid` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `available_agents`
--

CREATE TABLE IF NOT EXISTS `available_agents` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(60) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `last_online` datetime NOT NULL,
  `last_picked_call` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `calls_on_hold`
--

CREATE TABLE IF NOT EXISTS `calls_on_hold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `agent_name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `incoming_calls`
--

CREATE TABLE IF NOT EXISTS `incoming_calls` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `call_from` varchar(100) NOT NULL,
  `call_to` varchar(100) NOT NULL,
  `call_sid` varchar(255) NOT NULL,
  `recording_url` varchar(200) NOT NULL,
  `call_duration` smallint(6) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `has_to_sync` tinyint(1) NOT NULL DEFAULT '0',
  `is_sync` tinyint(1) NOT NULL DEFAULT '0',
  `current_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`call_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `language_details`
--

CREATE TABLE IF NOT EXISTS `language_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `position_id` int(10) NOT NULL,
  `value` text NOT NULL,
  `title_type` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `language_master`
--

CREATE TABLE IF NOT EXISTS `language_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(200) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `page_name` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(200) NOT NULL,
  `level` smallint(2) NOT NULL DEFAULT '1',
  `parent_page_id` smallint(2) NOT NULL,
  `tab_order` tinyint(4) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `description`, `page_name`, `is_active`, `title`, `level`, `parent_page_id`, `tab_order`) VALUES
(1, 'Main Home Page', 'home.php', 1, 'Home', 0, 0, 0),
(2, 'Manage Users', 'manage_users.php', 1, 'User Management', 1, 0, 1),
(11, 'Application Settings', 'settings.php', 1, 'Settings', 1, 0, 4),
(15, 'Page Master', 'manage_pages.php', 1, 'Page Master', 2, 2, 1),
(16, 'Add Page', 'add_new_page.php', 1, 'Add Page', 3, 15, 1),
(17, 'Group Master', 'manage_groups.php', 1, 'Group Master', 2, 2, 2),
(18, 'Add Group', 'add_new_group.php', 1, 'Add Group', 3, 17, 1),
(19, 'User Master', 'manage_users.php', 1, 'User Master', 2, 2, 3),
(20, 'Add User', 'add_new_user.php', 1, 'Add User', 3, 19, 1),
(26, 'Call Platform', 'call_platform.php', 1, 'Call Platfrom', 1, 0, 2),
(28, '001', 'Michael', 0, 'Franchise 001', 1, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers`
--

CREATE TABLE IF NOT EXISTS `phone_numbers` (
  `ph_id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `is_active` smallint(2) NOT NULL,
  `text_message` varchar(500) NOT NULL,
  PRIMARY KEY (`ph_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `salesforce_contacts`
--

CREATE TABLE IF NOT EXISTS `salesforce_contacts` (
  `Id` varchar(30) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `LastName` varchar(200) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `LeadSource` varchar(40) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `MobilePhone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salesforce_leads`
--

CREATE TABLE IF NOT EXISTS `salesforce_leads` (
  `Id` varchar(40) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `LeadSource` varchar(40) DEFAULT NULL,
  `FirstName` varchar(40) DEFAULT NULL,
  `LastName` varchar(40) DEFAULT NULL,
  `Rating` varchar(40) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(200) NOT NULL,
  `config_value` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `config_name`, `config_value`, `is_active`) VALUES
(1, 'twilio_sid', 'ACd4423401eb4a46b6ac290198c8b76e84', 1),
(2, 'twilio_auth_token', '67995a2618e468e5a79a48ab26f65493', 1),
(3, 'twilio_app_sid', 'AP6cc5d20dee99d08223d37c37efe23b39', 1),
(4, 'salesforce_uname', 'mfalgares%40gaminride.com', 1),
(5, 'salesforce_pass', 'lr567plus', 1),
(6, 'salesforce_security_token', '2quqDNrMkgDJEISGKIAVdRUhK', 1),
(7, 'salesforce_client_id', '3MVG9Km_cBLhsuPxxFVA4bEVHEkA_1LZgsdDmvpQwTO8Wp1gFqQFESnPmu8RNKlDi8MAcPgD4MmZokKNB.69V', 1),
(8, 'salesforce_client_secret', '8119236351955255622', 1),
(9, 'salesforce_current_access_token', '00D50000000JKHe!AR8AQCuikNQ9cG7v10PVeO6WGJDHOXGg7oF.nRKtJBbM9dic1tLqfbS08VwQVJWsGK_TrfnbbShaE.Wd1LszTochW2.PSfR2', 0),
(10, 'salesforce_current_instance_url', 'https://na3.salesforce.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `twilio_debug`
--

CREATE TABLE IF NOT EXISTS `twilio_debug` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `time_stamp` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group` int(10) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_password` text NOT NULL,
  `name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `preferred_language` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_group`, `user_name`, `user_password`, `name`, `user_email`, `user_phone`, `is_active`, `preferred_language`) VALUES
(1, 1, 'developer', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Super Admin', 'admin@satnyx.com', '90990090909', 1, 2),
(2, 1, 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'Admin Test User', 'admin@satnyx.com', '90990090909', 1, 1),
(3, 5, 'satnyx_user', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Test User', 'admin@satnyx.com', '90990090909', 1, 2),
(4, 5, 'new', 'e67a40509ebbff2dda3af742d2bf838fb49e5c61', 'new One', 'admin@satnyx.com', '90990090909', 1, 1),
(5, 5, 'test_user3', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Any one', 'admin@satnyx.com', '90990090909', 1, 1),
(6, 7, 'twi_tester', '62c06f95ab88437f76a74242c225b47173ba6727', 'Tester', 'twi@twillio.com', '1234567890', 1, 1),
(7, 6, 'directorlive', '79e73eae497736fdfa8a7729d7b5fe8e06cddf12', 'Michael Falgares', 'mfalgares@gaminride.com', '7327794415', 1, 1),
(8, 6, 'agent1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Agent Smith', 'agent@satnyx.com', '456123789', 1, 1),
(9, 6, 'agent2', '658fa37d9da4a5369378256364d24ec858f349e3', 'Agent 2', 'agent@site.com', '1234567890', 1, 1),
(10, 6, 'mfalgares', '79e73eae497736fdfa8a7729d7b5fe8e06cddf12', 'Michael', 'mfalgares@me.com', '7327794415', 1, 1),
(11, 6, 'acaldwell', 'f4c980f9daaafcbd15e804d6c2d075f5843b21c1', 'Adrianne Caldwell', 'acaldwell@gaminride.com', '7329875255', 1, 1),
(12, 6, 'mpondaco', 'f4c980f9daaafcbd15e804d6c2d075f5843b21c1', 'Marcie Pondaco', 'mpondaco@gaminride.com', '7329875254', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_crud_permissions`
--

CREATE TABLE IF NOT EXISTS `user_crud_permissions` (
  `crud_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `create` tinyint(1) NOT NULL DEFAULT '0',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `update` tinyint(1) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`crud_permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `comments` text NOT NULL,
  `landing_page` varchar(200) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`group_id`, `group_name`, `is_active`, `comments`, `landing_page`) VALUES
(1, 'Users', 1, 'Group of Admins', '2'),
(5, 'New Group', 1, 'my new group', '2'),
(6, 'Agent', 1, 'Agent Group', '26'),
(7, 'Twillio Testers', 1, 'This group has only twillio permissions.', '26');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE IF NOT EXISTS `user_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`permission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`permission_id`, `group_id`, `page_id`, `is_active`) VALUES
(1, 1, 1, 1),
(45, 1, 11, 1),
(44, 1, 20, 1),
(43, 1, 19, 1),
(42, 1, 18, 1),
(41, 1, 17, 1),
(40, 1, 16, 1),
(39, 1, 15, 1),
(38, 1, 2, 1),
(37, 1, 1, 1),
(29, 5, 1, 1),
(52, 5, 19, 1),
(51, 5, 18, 1),
(50, 5, 17, 1),
(49, 5, 16, 1),
(48, 5, 15, 1),
(47, 5, 2, 1),
(46, 5, 1, 1),
(53, 5, 20, 1),
(54, 5, 24, 0),
(55, 5, 25, 0),
(56, 6, 1, 1),
(71, 6, 1, 1),
(69, 6, 1, 1),
(65, 1, 26, 1),
(66, 7, 1, 1),
(67, 7, 26, 1),
(68, 7, 11, 1),
(73, 6, 1, 1),
(75, 6, 1, 1),
(76, 6, 26, 1),
(77, 1, 28, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions_on_group`
--

CREATE TABLE IF NOT EXISTS `user_permissions_on_group` (
  `user_permissions_on_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `permissioned_group_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_permissions_on_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `user_permissions_on_group`
--

INSERT INTO `user_permissions_on_group` (`user_permissions_on_group_id`, `group_id`, `permissioned_group_id`, `is_active`) VALUES
(6, 1, 5, 1),
(5, 1, 1, 1),
(7, 5, 5, 1),
(8, 1, 6, 1),
(11, 1, 7, 1),
(12, 7, 7, 1),
(13, 7, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vardump`
--

CREATE TABLE IF NOT EXISTS `vardump` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `dump` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
