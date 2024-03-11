
--
-- Table structure for table `task_lists`
--
CREATE TABLE IF NOT EXISTS `task_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(128) NOT NULL,
  `task_desc` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
