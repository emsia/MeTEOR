-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 30, 2014 at 01:08 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `meteor`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `complete` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `type`, `region`, `province`, `city`, `complete`, `role`) VALUES
(1, 1, 'Own House', 'Central Luzon', 'BULACAN', 'SAN JOSE DEL MONTE CITY', 1, 0),
(2, 248, 'Own House', 'Central Luzon', 'BULACAN', 'SAN JOSE DEL MONTE CITY', 1, 2),
(3, 254, 'Own House', 'Central Luzon', 'AURORA', 'BALER', 1, 2),
(4, 255, 'Own House', 'Central Luzon', 'BATAAN', 'LIMAY', 1, 2),
(5, 256, 'Relative''s/Guardian''s House', 'National Capital Region', 'MANILA', 'SAN MIGUEL', 1, 2),
(6, 257, 'Own House', 'Bicol Region', 'CAMARINES NORTE', 'LABO', 1, 2),
(7, 258, 'Own House', 'Bicol Region', 'CAMARINES NORTE', 'JOSE PANGANIBAN', 1, 2),
(8, 252, 'Boarding House off Campus', 'SOCCSKSARGEN', 'SARANGANI', 'GLAN', 1, 1),
(9, 269, 'Boarding House on Campus', 'MIMAROPA', 'MARINDUQUE', 'GASAN', 1, 2),
(10, 262, 'Own House', 'National Capital Region', 'QUEZON CITY', 'DILIMAN', 1, 2),
(11, 272, 'Boarding House off Campus', 'National Capital Region', 'QUEZON CITY', 'DILIMAN', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `all_questions`
--

CREATE TABLE IF NOT EXISTS `all_questions` (
  `id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `belong` int(11) DEFAULT '0',
  `questions` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_questions`
--

INSERT INTO `all_questions` (`id`, `category_id`, `belong`, `questions`, `type`) VALUES
(1020, 20, 0, 'The trainer treats participants tactfully; does not embarrass them.', 0),
(1121, 21, 1, 'I know the basic function of computer hardware components such as: the CPU, monitor, keyboard and file storage.', 0),
(1122, 22, 1, 'I can create a new document.', 0),
(1123, 23, 1, 'I know how to use Spreadsheet application.', 0),
(1124, 24, 1, 'I can insert images into documents.', 0),
(1125, 25, 1, 'I can create a simple slideshow using a presentation application( i.e. PowerPoint, Open Office Impress).', 0),
(1126, 26, 1, 'I can locate a website given the address.', 0),
(1127, 27, 1, 'I know how to activate your student e-mail account.', 0),
(1128, 28, 1, 'What topic do you want to learn?', 1),
(2020, 20, 0, 'The objectives of the training were clearly defined.', 0),
(2121, 21, 1, 'I can find and start a program.', 0),
(2122, 22, 1, 'I can save a document.', 0),
(2123, 23, 1, 'I can use the Formula Bar to perform mathematical calculations.', 0),
(2124, 24, 1, 'I can scan images using a scanner.', 0),
(2125, 25, 1, 'I can use animation and transition tools in a presentation application.', 0),
(2126, 26, 1, 'I can use a browser''s capabilities to go back, forward, reload/refresh, print and help.', 0),
(2127, 27, 1, 'I can read email messages.', 0),
(2128, 28, 1, 'What additional training-development do you require?', 1),
(3020, 20, 0, 'The trainer uses appropriate training techniques.', 0),
(3121, 21, 1, 'I can navigate between programs.', 0),
(3122, 22, 1, 'I can cut, copy and paste a text.', 0),
(3123, 23, 1, 'I can edit and format the worksheet.', 0),
(3124, 24, 1, 'I can do basic graphic editing(i.e crop,adjust, brightness/contrast).', 0),
(3125, 25, 1, 'I can insert multimedia elements such as sound and video clips in a slideshow.', 0),
(3126, 26, 1, 'I can use a web browser to follow links to another website.', 0),
(3127, 27, 1, 'I can compose and send email messages.', 0),
(3128, 28, 1, 'What other specific comments do you have?', 1),
(4020, 20, 0, 'The trainer was able to adequately handle the exchange of ideas between and amongst training participants.', 0),
(4121, 21, 1, 'I can save files to the hard drive or removable storage, such as a CD or flash drive.', 0),
(4122, 22, 1, 'I can set font style, size and color.', 0),
(4123, 23, 1, 'I can re-size the column or row.', 0),
(4124, 24, 1, 'I can use of special graphics software(i.e Adobe Photoshop, Gimp).', 0),
(4125, 25, 1, 'I can insert hyperlinks.', 0),
(4126, 26, 1, 'I can save a website address in the bookmarks or favorites.', 0),
(4127, 27, 1, 'I can reply to an e-mail message.', 0),
(5020, 20, 0, 'I am fully satisfied with the way the training was conducted.', 0),
(5121, 21, 1, 'I can exit or quit an application.', 0),
(5122, 22, 1, 'I can utilize spell-check.', 0),
(5123, 23, 1, 'I can wrap or rotate text in a cell.', 0),
(5125, 25, 1, 'I can print handouts and notes of a slide presentation.', 0),
(5126, 26, 1, 'I can find information using a search engine such as Google or Yahoo.', 0),
(5127, 27, 1, 'I can manage your email by moving messages between folders, forwarding messages and deleting messages.', 0),
(6020, 20, 0, 'I am fully satisfied with the VENUE of the training.', 0),
(6121, 21, 1, 'I can print a document.', 0),
(6122, 22, 1, 'I can format text alignment.', 0),
(6123, 23, 1, 'I can use the built-in Function capability to create equations.', 0),
(6126, 26, 1, 'I can download and save files, such as graphics, documents, or PDF, from the Internet.', 0),
(6127, 27, 1, 'I can send attachments through email.', 0),
(7020, 20, 0, 'I am fully satisfied with the FOOD arrangements made for the training.', 0),
(7121, 21, 1, 'I can log off a computer.', 0),
(7122, 22, 1, 'I can change the line spacing in a document.', 0),
(7123, 23, 1, 'I can create charts.', 0),
(7126, 26, 1, 'I can download and install software from the Internet.', 0),
(8020, 20, 0, 'I am fully satisfied with the TRANSPORTATION arrangements made for  the training.', 0),
(8121, 21, 1, 'I can shut down a computer properly.', 0),
(8122, 22, 1, 'I set margins.', 0),
(8123, 23, 1, 'I can sort and filter information.', 0),
(8126, 26, 1, 'I can you chat using Internet messengers like Yahoo Messenger.', 0),
(9020, 20, 0, 'I am fully satisfied with the LODGING arrangements made for the training.', 0),
(9122, 22, 1, ' I can change the page orientatiobn from portrait to landscape.', 0),
(10020, 20, 0, 'Participation and interaction were encouraged during the training.', 0),
(10122, 22, 1, 'I can include page numbers.', 0),
(11020, 20, 0, 'The topics covered in the training were relevant to me and my office.', 0),
(11122, 22, 1, 'I can use headers and footers.', 0),
(12020, 20, 0, 'The training content was organized and easy to follow.', 0),
(12122, 22, 1, ' I can create a numbered or bulleted list.', 0),
(13020, 20, 0, 'The training materials distributed were helpful.', 0),
(13122, 22, 1, 'I can create a table.', 0),
(14020, 20, 0, 'The training results are essential / useful to my present and future work.', 0),
(14122, 22, 1, 'I can insert graphics, images, clip art and word art.', 0),
(15020, 20, 0, 'The trainer demonstrates thorough knowledge of the training topics.', 0),
(16020, 20, 0, 'The trainer was well prepared and organized.', 0),
(17020, 20, 0, 'The trainer speaks clearly and audibly.', 0),
(18020, 20, 0, 'What did you like most about this workshop?', 1),
(19020, 20, 0, 'What aspects of the workshop could be improved? ', 1),
(20020, 20, 0, 'Please share other comments or expand on previous responses here', 1);

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE IF NOT EXISTS `awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `award` varchar(50) NOT NULL,
  `institution` varchar(50) NOT NULL,
  `dateGive` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cancelled`
--

CREATE TABLE IF NOT EXISTS `cancelled` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `refunded` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `untag` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories_questions`
--

CREATE TABLE IF NOT EXISTS `categories_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `belong` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `categories_questions`
--

INSERT INTO `categories_questions` (`id`, `title`, `belong`) VALUES
(20, 'Questions', 0),
(21, 'basic computer operations and concepts', 1),
(22, 'word processing skills', 1),
(23, 'spreadsheet skills', 1),
(24, 'creating images', 1),
(25, 'creating slide presentation', 1),
(26, 'internet', 1),
(27, 'e-mail', 1),
(28, 'others', 1);

-- --------------------------------------------------------

--
-- Table structure for table `college_history`
--

CREATE TABLE IF NOT EXISTS `college_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `institution` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `college_history`
--

INSERT INTO `college_history` (`id`, `user_id`, `institution`, `location`, `degree`, `start`, `end`, `role`) VALUES
(2, 248, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-24', '2014-05-28', 2),
(3, 254, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-14', '2014-04-28', 2),
(4, 255, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-22', '2014-05-20', 2),
(5, 256, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-06', '2014-05-27', 2),
(6, 257, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-21', '2014-05-26', 2),
(7, 258, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-20', '2014-05-20', 2),
(8, 252, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-12', '2014-05-28', 1),
(9, 269, 'University Of The Philippines', 'Quezon City', 'BS Architecture', '2014-05-27', '2014-05-30', 2),
(10, 262, 'University Of The Philippines', 'Quezon City', 'BS Architecture', '2014-05-07', '2014-05-14', 2),
(11, 272, 'University Of The Philippines', 'Quezon City', 'BS Architecture', '2014-05-21', '2014-05-21', 2),
(28, 1, 'University Of The Philippines', 'Quezon City', 'BS Computer Science', '2014-05-25', '2014-05-31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `completed`
--

CREATE TABLE IF NOT EXISTS `completed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `last` varchar(255) DEFAULT NULL,
  `string` varchar(255) DEFAULT NULL,
  `first` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `completed`
--

INSERT INTO `completed` (`id`, `user_id`, `course_id`, `date`, `last`, `string`, `first`) VALUES
(1, 248, 4, '2014-01-08 00:00:00', 'Jan 10 2014', '8th-10th of Jan  2014', 'Jan 8 2014'),
(2, 248, 12, '2014-05-30 00:00:00', 'May 31 2014', '1st-31st of May  2014', 'May 1 2014'),
(3, 248, 18, '2014-05-30 00:00:00', 'Jun 30 2014', '1st-30th of Jun  2014', 'Jun 1 2014');

-- --------------------------------------------------------

--
-- Table structure for table `contact_emergency`
--

CREATE TABLE IF NOT EXISTS `contact_emergency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `landline` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `contact_emergency`
--

INSERT INTO `contact_emergency` (`id`, `user_id`, `relationship`, `name`, `mobile_number`, `landline`, `email`, `address`) VALUES
(1, 1, 'Sibling', 'Ethelyn Sia Mescallado', '(092)288-56703', '', 'ethelyn.mescallado@paramount.com.ph', 'paco, manila'),
(2, 248, 'Sibling', 'Everlyn Sia', '(092)288-58703', '', 'eversia@gmail.com', 'bulacan'),
(3, 254, 'Guardian', 'Ethelyn Sia Mescallado', '(092)288-56703', '', 'ethelyn.mescallado@paramount.com.ph', 'paco, manila'),
(4, 255, 'Sibling', 'Ethelyn Sia Mescallado', '(092)288-56703', '', 'ethelyn.mescallado@paramount.com.ph', 'paco, manila'),
(5, 256, 'Sibling', 'Ethelyn Sia Mescallado', '(092)288-56703', '', 'ethelyn.mescallado@paramount.com.ph', 'paco, manila'),
(6, 257, 'Guardian', 'Ethelyn Sia Mescallado', '(092)288-56703', '', 'ethelyn.mescallado@paramount.com.ph', 'paco, manila'),
(7, 258, 'Sibling', 'Ethelyn Sia Mescallado', '(092)288-56703', '', 'ethelyn.mescallado@paramount.com.ph', 'paco, manila'),
(8, 252, 'Parent', 'Ethelyn Sia Mescallado', '(092)288-56703', '', 'ethelyn.mescallado@paramount.com.ph', 'paco, manila'),
(9, 269, 'Sibling', 'Sia, Efrelyn Monesit', '(092)288-58703', '', 'ethelyn.mescallado@paramount.com.ph', 'Malate, Manila'),
(10, 262, 'Sibling', 'Sia, Efrelyn Monesit', '(092)288-58703', '', 'ethelyn.mescallado@paramount.com.ph', 'Malate, Manila'),
(11, 272, 'Parent', 'Sia, Efrelyn Monesit', '(092)288-58703', '', 'ethelyn.mescallado@paramount.com.ph', 'Malate, Manila');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `cost` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `available` int(11) NOT NULL,
  `reserved` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `venue` varchar(255) NOT NULL DEFAULT 'TBA',
  `startTime` time NOT NULL,
  `attendees` text NOT NULL,
  `food` int(100) NOT NULL,
  `landTranspo` int(255) NOT NULL,
  `airfare` int(255) NOT NULL,
  `totalexp` int(255) NOT NULL,
  `endTime` time DEFAULT NULL,
  `tempId` int(11) DEFAULT '0',
  `landRemarks` text,
  `airfareRemarks` text,
  `objectives` text,
  `foodRemarks` text,
  `accomodationRemarks` text,
  `accomodation` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `cost`, `start`, `end`, `available`, `reserved`, `paid`, `venue`, `startTime`, `attendees`, `food`, `landTranspo`, `airfare`, `totalexp`, `endTime`, `tempId`, `landRemarks`, `airfareRemarks`, `objectives`, `foodRemarks`, `accomodationRemarks`, `accomodation`) VALUES
(4, 'Learn More', 'To be more efficient.', 1000, '2014-01-01', '2014-01-07', 2, 0, 0, 'UPITDC', '06:00:00', 'VP for Academic Affairs\r\nAVP for Academic Affairs\r\neUP Project Director\r\nUniversity Registrars\r\neUP SAIS Subject Matter Experts\r\neUP SAIS Team', 283220, 30000, 72000, 385220, '06:00:00', 0, 'Itinerary: UPITDC- Subic on 06 Feb 2014\r\n      Subic- UPITDC on 08 Feb 2014 \r\n\r\n3 Units of Van Rentals (12 pax per van) \r\n@ 10,000.00 per unit X 3 Vans = Php 30,000.00 \r\n\r\nNote: Participant from different CU’s other transportation expenses such as taxi fare and bus fare going to UP ITDC will be initially shoulder by their respective offices.', 'UP Cebu: Cebu-Manila-Cebu @ 3pax * 8,000.00 = 24,000.00\r\nUP Visayas: ILO-Manila-ILO @ 3pax * 8,000.00 = 24,000.00\r\nUP Mindanao: DVO-Manila-DVO @ 3pax * 8000.00 = 24,000.00', '1. To Standardized the different traditional practices/ policies implemented.\r\n\r\n2. To Standardized the different interpretations of the existing policies in the UP code and the BOR- approved policies.', NULL, NULL, 0),
(7, 'CTC Meeting', 'Weekly meeting of the eUP Core Technical Committee', 0, '2014-01-10', '2014-01-10', 20, 0, 5, 'Conference Room', '11:00:00', '', 0, 0, 0, 0, '13:00:00', 4, NULL, NULL, NULL, NULL, NULL, 0),
(8, 'SPCMIS Conference Room Pilot 2 (CRP2)', 'SPCMIS Conference Room Pilot 2', 0, '2014-01-13', '2014-01-15', 60, 0, 26, 'UPITDC', '09:00:00', '', 0, 0, 0, 0, '17:00:00', 3, NULL, NULL, NULL, NULL, NULL, 0),
(12, 'Introduction to IT', 'sadas', 500, '2014-01-02', '2014-01-15', 5, 0, 1, 'UPITDC', '16:45:00', 'sadasd', 500, 500, 500, 1500, '16:45:00', 0, 'dsadas', 'dasdasd', 'dasdas', NULL, NULL, 0),
(13, 'Second Joint Meeting of the eUP System-Level Project Coordination Committee and the SAIS Coordination Committee ', 'Second Joint Meeting of the eUP System-Level Project Coordination Committee and the SAIS Coordination Committee ', 0, '2014-02-03', '2014-02-03', 50, 0, 0, 'UP ITDC Lecture Hall', '12:00:00', '', 0, 0, 0, 0, '16:00:00', 5, NULL, NULL, NULL, NULL, NULL, 0),
(14, 'eUP SAIS Data Dictionary Standardization workshop for University Registrars', 'To standardize OUR''s data dictionary for all UP CU''s', 0, '2014-02-06', '2014-02-08', 32, 0, 8, 'Camayan Beach Resort Subic, Zambales', '09:00:00', '', 0, 0, 0, 0, '17:00:00', 6, NULL, NULL, NULL, NULL, NULL, 0),
(15, 'eUP HRIS End User Training', 'Preparing for Go Live.', 0, '2014-05-30', '2014-05-31', 44, 0, 0, 'UP Visayas', '09:00:00', 'eUP HRIS Team\nAVPD Jaime Caro\nUP Visayas Officials\nUPV HRDO End Users', 49600, 3000, 25600, 90200, '17:00:00', 0, 'ITENERARY: UPITDC- NAIA- ILO AIRPORT- UPV ILO\n                          UPV ILO- ILO AIRPORT- NAIA- UPITDC\n\n1. Land Trasportation\n-> UPITDC-NAIA Taxi Fare  = 1000.00 Php\n->ILOILO AIRPORT-UPV ILO = 500.00 Php\n-> UPV ILO-ILO AIRPORT = 500.00 Php\n-> NAIA-UPITDC Taxi Fare = 1000.00 Php', 'Cebu Pacific Round trip fare: 6 Pax X 3,600.00 \nphp = 21,600.00 Php\nPAL Round trip fare: 1 Pax X 4,000.00 Php = 4,000.00 Php', 'The EUT will prepare intended users of HRIS from the HR Office for Go live.', 'UPV Attendees\r\n400.00 Php X 44 Pax X 2 days = 35,200.00 Php\r\n\r\neUP Team\r\n800.00 Php X 6 Pax X 3 days = 14,400.00 Php', '1,000.00 Php X 6 X PAX X 2 Nights = 12,000.00 Php', 12000),
(16, 'Data Mining', 'Mining many data', 0, '2014-05-25', '2014-05-31', 10, 0, 0, 'AS 101', '09:00:00', 'Students from UP', 5000, 3000, 0, 8000, '05:00:00', 0, 'Jeep -- ikot', 'Naglakad lang kami', 'To excavate data in places.', 'All are cheese.', 'None', 0),
(18, 'CS 199', 'Thesis', 1500, '2014-05-01', '2014-12-31', 3, 0, 1, 'DCS', '09:00:00', 'Students', 0, 0, 0, 0, '05:00:00', 0, 'KKB', 'Lakad lang.', 'To publish a paper', 'KKB', 'KKB', 0),
(19, 'Only', 'Test Only', 0, '2014-05-29', '2014-05-30', 2, 0, 0, 'DCS', '04:00:00', '', 0, 0, 0, 0, '05:00:00', 0, 'wala', 'wala', 'Basta', 'wala', 'wala', 0),
(22, 'CS 195', 'Apprenticeship', 1500, '2014-06-01', '2014-07-31', 3, 1, 0, 'DCS', '09:00:00', 'students', 1000, 2000, 0, 3000, '17:00:00', 0, 'Galing Bulacan', 'Lakad lang kami', 'To gain expereience', 'Eat all you can', 'DCS lang kami', 0);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` varchar(50) NOT NULL,
  `birth_date` varchar(25) NOT NULL,
  `birthplace` varchar(50) NOT NULL,
  `country_citizen` varchar(50) NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `birth_year` varchar(4) DEFAULT NULL,
  `birth_month` varchar(25) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `employed` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_ibfk_1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `gender`, `birth_date`, `birthplace`, `country_citizen`, `civil_status`, `birth_year`, `birth_month`, `user_id`, `employed`, `age`, `role`) VALUES
(1, 'Male', '29', 'Tondo, manila', 'Philippines', 'Single', '1992', 'October', 1, 1, 21, 0),
(2, 'Male', '29', 'tondo, manila', 'Philippines', 'Single', '1992', 'October', 248, 3, 21, 2),
(3, 'Female', '6', 'Tondo, manila', 'Philippines', 'Single', '1989', 'July', 254, 1, 24, 2),
(4, 'Female', '15', 'Tondo, manila', 'American Samoa', 'Engaged', '1979', 'March', 255, 1, 35, 2),
(5, 'Female', '7', 'Tondo, manila', 'New Zealand', 'In a Civil Union', '1978', 'September', 256, 1, 35, 2),
(6, 'Male', '17', 'Tondo, manila', 'Austria', 'In a Civil Union', '1967', 'May', 257, 1, 47, 2),
(7, 'Female', '17', 'Tondo, manila', 'Pakistan', 'In a Civil Union', '1992', 'October', 258, 1, 21, 2),
(8, 'Male', '4', 'Tondo, manila', 'Albania', 'Single', '1992', 'September', 252, 1, 21, 1),
(9, 'Male', '5', 'tondo, manila', 'Philippines', 'Single', '1961', 'August', 269, 1, 52, 2),
(10, 'Male', '17', 'tondo, manila', 'Bahamas', 'Single', '1984', 'April', 262, 1, 30, 2),
(11, 'Male', '19', 'tondo, manila', 'Philippines', 'In a Relationship', '1979', 'May', 272, 1, 35, 2);

-- --------------------------------------------------------

--
-- Table structure for table `dissolved`
--

CREATE TABLE IF NOT EXISTS `dissolved` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employment_history`
--

CREATE TABLE IF NOT EXISTS `employment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) DEFAULT '0',
  `company` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `industries` varchar(50) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `employment_history`
--

INSERT INTO `employment_history` (`id`, `user_id`, `type`, `company`, `designation`, `start`, `end`, `industries`, `role`) VALUES
(2, 254, 0, 'UPITDC', 'Entry/Junior Level', '2014-05-06', '2014-05-19', 'Information Technology', 2),
(3, 255, 0, 'UPITDC', 'Lead Level', '2014-05-20', '2014-05-27', 'Information Technology', 2),
(4, 256, 0, 'UPITDC', 'Lead Level', '2014-05-13', '2014-05-28', 'Engineering', 2),
(5, 257, 0, 'UPITDC', 'Lead Level', '2014-05-20', '2014-05-26', 'Food and Related Products', 2),
(6, 258, 0, 'UPITDC', 'Lead Level', '2014-05-28', '2014-05-29', 'Food and Related Products', 2),
(7, 252, 0, 'UPITDC', 'Intermediate Level', '2014-05-27', '2014-05-27', 'Import and Export', 1),
(8, 269, 0, 'PLDT', 'Intermediate Level', '2014-05-01', '2014-12-04', 'Consultancy Services', 2),
(9, 262, 0, 'SMART', 'Entry/Junior Level', '2014-05-27', '2014-05-22', 'Consultancy Services', 2),
(10, 272, 0, 'GLOBE', 'Intermediate Level', '2014-05-29', '2014-05-23', 'Information Technology', 2),
(28, 1, 0, 'UPITDC', 'Entry/Junior Level', '2014-05-26', '2014-05-31', 'Information Technology', 0);

-- --------------------------------------------------------

--
-- Table structure for table `forsending`
--

CREATE TABLE IF NOT EXISTS `forsending` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dateToday` datetime NOT NULL,
  `tempId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forSending_ibfk_1` (`user_id`),
  KEY `forSending_ibfk_2` (`tempId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `landline`
--

CREATE TABLE IF NOT EXISTS `landline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `landline`
--

INSERT INTO `landline` (`id`, `user_id`, `number`) VALUES
(2, 248, ''),
(3, 254, ''),
(4, 255, ''),
(5, 256, ''),
(6, 257, ''),
(7, 258, ''),
(8, 252, ''),
(9, 269, ''),
(10, 262, ''),
(11, 272, ''),
(28, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE IF NOT EXISTS `managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `user_id`, `status`) VALUES
(1, 249, 1),
(2, 250, 1),
(3, 251, 1),
(4, 252, 1),
(5, 314, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mobilenumbers`
--

CREATE TABLE IF NOT EXISTS `mobilenumbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `mobilenumbers`
--

INSERT INTO `mobilenumbers` (`id`, `user_id`, `number`) VALUES
(2, 248, '(091)646-32369'),
(3, 254, '(091)646-32369'),
(4, 255, '(091)646-32369'),
(5, 256, '(091)646-32369'),
(6, 257, '(091)646-32369'),
(7, 258, '(091)646-32369'),
(8, 252, '(091)646-32369'),
(9, 269, '(093)586-40084'),
(10, 262, '(093)586-40084'),
(11, 272, '(093)586-40084'),
(28, 1, '(093)586-40084');

-- --------------------------------------------------------

--
-- Table structure for table `origsurvey`
--

CREATE TABLE IF NOT EXISTS `origsurvey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `todate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `10122_id` int(11) NOT NULL,
  `11122_id` int(11) NOT NULL,
  `1122_id` int(11) NOT NULL,
  `12122_id` int(11) NOT NULL,
  `13122_id` int(11) NOT NULL,
  `14122_id` int(11) NOT NULL,
  `2122_id` int(11) NOT NULL,
  `3122_id` int(11) NOT NULL,
  `4122_id` int(11) NOT NULL,
  `5122_id` int(11) NOT NULL,
  `6122_id` int(11) NOT NULL,
  `7122_id` int(11) NOT NULL,
  `8122_id` int(11) NOT NULL,
  `9122_id` int(11) NOT NULL,
  `1123_id` int(11) NOT NULL,
  `2123_id` int(11) NOT NULL,
  `3123_id` int(11) NOT NULL,
  `4123_id` int(11) NOT NULL,
  `5123_id` int(11) NOT NULL,
  `6123_id` int(11) NOT NULL,
  `7123_id` int(11) NOT NULL,
  `8123_id` int(11) NOT NULL,
  `1124_id` int(11) NOT NULL,
  `2124_id` int(11) NOT NULL,
  `3124_id` int(11) NOT NULL,
  `4124_id` int(11) NOT NULL,
  `1125_id` int(11) NOT NULL,
  `2125_id` int(11) NOT NULL,
  `3125_id` int(11) NOT NULL,
  `4125_id` int(11) NOT NULL,
  `5125_id` int(11) NOT NULL,
  `1126_id` int(11) NOT NULL,
  `2126_id` int(11) NOT NULL,
  `3126_id` int(11) NOT NULL,
  `4126_id` int(11) NOT NULL,
  `5126_id` int(11) NOT NULL,
  `6126_id` int(11) NOT NULL,
  `7126_id` int(11) NOT NULL,
  `8126_id` int(11) NOT NULL,
  `1127_id` int(11) NOT NULL,
  `2127_id` int(11) NOT NULL,
  `3127_id` int(11) NOT NULL,
  `4127_id` int(11) NOT NULL,
  `5127_id` int(11) NOT NULL,
  `6127_id` int(11) NOT NULL,
  `1128_id` varchar(255) NOT NULL,
  `2128_id` varchar(255) NOT NULL,
  `3128_id` varchar(255) NOT NULL,
  `1121_id` int(11) NOT NULL,
  `2121_id` int(11) NOT NULL,
  `3121_id` int(11) NOT NULL,
  `4121_id` int(11) NOT NULL,
  `5121_id` int(11) NOT NULL,
  `6121_id` int(11) NOT NULL,
  `7121_id` int(11) NOT NULL,
  `8121_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `origsurvey`
--

INSERT INTO `origsurvey` (`id`, `userid`, `course_id`, `todate`, `10122_id`, `11122_id`, `1122_id`, `12122_id`, `13122_id`, `14122_id`, `2122_id`, `3122_id`, `4122_id`, `5122_id`, `6122_id`, `7122_id`, `8122_id`, `9122_id`, `1123_id`, `2123_id`, `3123_id`, `4123_id`, `5123_id`, `6123_id`, `7123_id`, `8123_id`, `1124_id`, `2124_id`, `3124_id`, `4124_id`, `1125_id`, `2125_id`, `3125_id`, `4125_id`, `5125_id`, `1126_id`, `2126_id`, `3126_id`, `4126_id`, `5126_id`, `6126_id`, `7126_id`, `8126_id`, `1127_id`, `2127_id`, `3127_id`, `4127_id`, `5127_id`, `6127_id`, `1128_id`, `2128_id`, `3128_id`, `1121_id`, `2121_id`, `3121_id`, `4121_id`, `5121_id`, `6121_id`, `7121_id`, `8121_id`) VALUES
(3, 249, 12, '2014-05-19 07:05:42', 3, 4, 2, 4, 2, 2, 4, 4, 4, 2, 1, 2, 2, 2, 2, 2, 4, 3, 4, 2, 1, 4, 1, 4, 1, 4, 2, 2, 2, 3, 2, 4, 4, 1, 2, 4, 2, 2, 3, 3, 2, 4, 4, 2, 4, 'Superb', 'galing', 'saludo', 2, 4, 2, 2, 3, 3, 1, 4),
(5, 248, 12, '2014-05-30 05:49:57', 4, 3, 3, 4, 3, 4, 4, 3, 4, 3, 4, 3, 4, 3, 3, 4, 3, 4, 3, 4, 4, 4, 4, 3, 2, 1, 1, 2, 3, 4, 4, 3, 3, 2, 1, 2, 3, 4, 4, 4, 3, 2, 1, 1, 2, 'Natutunan ko na lahat so far', 'Wala naman.', 'Hmmmm, i guess i said it all.', 4, 4, 4, 3, 4, 4, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `ornumber` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `amount`, `remarks`, `ornumber`, `user_id`, `course_id`, `date`) VALUES
(1, 500, NULL, 8, 248, 12, '2014-01-09 00:00:00'),
(4, 0, 'free', 0, 253, 7, '2014-01-09 11:42:02'),
(5, 0, 'free', 0, 254, 7, '2014-01-09 13:03:25'),
(6, 0, 'free', 0, 255, 7, '2014-01-09 13:30:48'),
(7, 0, 'free', 0, 256, 7, '2014-01-09 14:10:34'),
(8, 0, NULL, 0, 251, 7, '2014-01-09 00:00:00'),
(14, 0, 'free', 0, 259, 8, '2014-01-13 12:00:16'),
(19, 0, 'free', 0, 261, 8, '2014-01-13 13:25:14'),
(21, 0, 'free', 0, 270, 8, '2014-01-13 13:25:32'),
(22, 0, 'free', 0, 265, 8, '2014-01-13 13:25:50'),
(25, 0, 'free', 0, 263, 8, '2014-01-13 13:27:20'),
(26, 0, 'free', 0, 274, 8, '2014-01-13 13:29:28'),
(28, 0, 'free', 0, 278, 8, '2014-01-13 13:32:41'),
(29, 0, 'free', 0, 269, 8, '2014-01-13 13:33:33'),
(31, 0, 'free', 0, 281, 8, '2014-01-13 13:36:22'),
(32, 0, 'free', 0, 279, 8, '2014-01-13 13:36:27'),
(33, 0, 'free', 0, 275, 8, '2014-01-13 13:38:41'),
(34, 0, 'free', 0, 276, 8, '2014-01-13 13:42:02'),
(35, 0, 'free', 0, 271, 8, '2014-01-13 13:43:29'),
(36, 0, 'free', 0, 283, 8, '2014-01-13 13:51:04'),
(38, 0, 'free', 0, 282, 8, '2014-01-13 14:00:20'),
(39, 0, 'free', 0, 284, 8, '2014-01-13 14:09:06'),
(40, 0, 'free', 0, 267, 8, '2014-01-13 15:41:54'),
(45, 0, 'free', 0, 266, 8, '2014-01-13 15:46:48'),
(46, 0, 'free', 0, 287, 8, '2014-01-13 15:52:48'),
(47, 0, 'free', 0, 288, 8, '2014-01-13 22:28:13'),
(48, 0, 'free', 0, 289, 8, '2014-01-14 06:51:23'),
(49, 0, 'free', 0, 273, 8, '2014-01-14 08:31:12'),
(50, 0, 'free', 0, 262, 8, '2014-01-14 09:04:40'),
(51, 0, 'free', 0, 260, 8, '2014-01-14 09:16:24'),
(54, 0, 'free', 0, 290, 8, '2014-01-15 09:13:17'),
(58, 0, 'free', 0, 291, 8, '2014-01-16 10:33:38'),
(59, 0, 'free', 0, 249, 14, '2014-02-03 11:41:17'),
(60, 0, 'free', 0, 293, 14, '2014-02-03 11:45:50'),
(61, 0, 'free', 0, 294, 14, '2014-02-03 11:58:46'),
(62, 0, 'free', 0, 251, 14, '2014-02-03 13:03:58'),
(63, 0, 'free', 0, 296, 14, '2014-02-03 13:04:17'),
(64, 0, 'free', 0, 254, 14, '2014-02-03 13:05:04'),
(65, 0, 'free', 0, 255, 14, '2014-02-03 13:05:48'),
(66, 0, 'free', 0, 295, 14, '2014-02-03 15:58:58'),
(67, 0, 'free', 0, 297, 13, '2014-02-03 16:09:52'),
(68, 0, 'free', 0, 255, 13, '2014-02-03 16:28:24'),
(69, 0, 'free', 0, 298, 13, '2014-02-03 16:31:59'),
(70, 0, 'free', 0, 300, 13, '2014-02-03 21:01:01'),
(71, 0, 'free', 0, 301, 13, '2014-02-03 22:45:05'),
(72, 0, 'free', 0, 302, 14, '2014-02-03 23:40:14'),
(73, 0, 'free', 0, 303, 14, '2014-02-04 09:22:42'),
(74, 0, 'free', 0, 305, 14, '2014-02-04 13:43:29'),
(75, 0, 'free', 0, 306, 13, '2014-02-04 14:32:29'),
(76, 0, 'free', 0, 258, 14, '2014-02-05 21:00:09'),
(77, 0, 'free', 0, 307, 14, '2014-02-05 21:11:47'),
(78, 0, 'free', 0, 308, 13, '2014-02-07 09:50:01'),
(79, 1500, '', 13123, 248, 18, '2014-05-28 18:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `pending`
--

CREATE TABLE IF NOT EXISTS `pending` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `course_id` int(50) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `name`, `count`) VALUES
(8, '2014-02-07empty.png', 1),
(11, '2014-05-172014-01-092013-07-10coa_signature.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `provincial_addresses`
--

CREATE TABLE IF NOT EXISTS `provincial_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recentactivities`
--

CREATE TABLE IF NOT EXISTS `recentactivities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(20) NOT NULL,
  `course` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `recentactivities`
--

INSERT INTO `recentactivities` (`id`, `desc`, `course`, `date`, `status`) VALUES
(1, 'ADD', '38', '2013-11-13 17:41:17', 2),
(2, 'DELETE', '3', '2014-01-07 17:19:16', 2),
(3, 'ADD', '4', '2014-01-08 15:18:59', 2),
(4, 'ADD', '5', '2014-01-08 18:58:23', 2),
(5, 'ADD', '6', '2014-01-08 19:46:41', 2),
(6, 'ADD', '9', '2014-01-09 18:03:22', 2),
(7, 'ADD', '10', '2014-01-10 16:36:26', 2),
(8, 'ADD', '11', '2014-01-10 16:37:09', 2),
(9, 'ADD', '12', '2014-01-10 16:44:22', 2),
(10, 'ADD', '15', '2014-05-14 14:11:17', 2),
(11, 'ADD', '16', '2014-05-27 15:55:54', 2),
(12, 'DELETE', '18', '2014-05-28 16:50:47', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reserved`
--

CREATE TABLE IF NOT EXISTS `reserved` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `reserved`
--

INSERT INTO `reserved` (`id`, `user_id`, `course_id`, `date`) VALUES
(6, 248, 22, '2014-05-30 15:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expired` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions_ios`
--

CREATE TABLE IF NOT EXISTS `sessions_ios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `signature`
--

CREATE TABLE IF NOT EXISTS `signature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `enddate` date NOT NULL,
  `startdate` date NOT NULL,
  `photo_id2` int(11) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `name1` varchar(255) DEFAULT NULL,
  `position1` varchar(255) DEFAULT NULL,
  `name2` varchar(255) DEFAULT NULL,
  `position2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `photo_id` (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `signature`
--

INSERT INTO `signature` (`id`, `course_id`, `photo_id`, `enddate`, `startdate`, `photo_id2`, `type`, `name1`, `position1`, `name2`, `position2`) VALUES
(8, 13, 8, '2014-02-07', '2014-02-07', 0, 'Attendance', 'Dr. Jaime D.L. Caro', 'Asst. Vice President for Development, UP System and eUP Project Director', '', ''),
(11, 12, 11, '2014-05-17', '2014-05-12', 0, 'Attendance', 'Sia, Efrelyn Monesit', 'CEO', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `certOk` int(11) NOT NULL,
  `counted` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  `todate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `1020_id` int(11) NOT NULL,
  `2020_id` int(11) NOT NULL,
  `3020_id` int(11) NOT NULL,
  `4020_id` int(11) NOT NULL,
  `5020_id` int(11) NOT NULL,
  `6020_id` int(11) NOT NULL,
  `7020_id` int(11) NOT NULL,
  `8020_id` int(11) NOT NULL,
  `9020_id` int(11) NOT NULL,
  `10020_id` int(11) NOT NULL,
  `11020_id` int(11) NOT NULL,
  `12020_id` int(11) NOT NULL,
  `13020_id` int(11) NOT NULL,
  `14020_id` int(11) NOT NULL,
  `15020_id` int(11) NOT NULL,
  `16020_id` int(11) NOT NULL,
  `17020_id` int(11) NOT NULL,
  `18020_id` varchar(255) NOT NULL,
  `19020_id` varchar(255) NOT NULL,
  `20020_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`id`, `userid`, `course_id`, `total`, `certOk`, `counted`, `permission`, `todate`, `1020_id`, `2020_id`, `3020_id`, `4020_id`, `5020_id`, `6020_id`, `7020_id`, `8020_id`, `9020_id`, `10020_id`, `11020_id`, `12020_id`, `13020_id`, `14020_id`, `15020_id`, `16020_id`, `17020_id`, `18020_id`, `19020_id`, `20020_id`) VALUES
(1, 248, 12, 36, 0, 1, 0, '2014-05-30 05:10:36', 1, 2, 1, 2, 1, 2, 2, 2, 1, 2, 3, 4, 3, 3, 3, 2, 2, 'Everything!', 'Wala na i guess.', 'Great!');

-- --------------------------------------------------------

--
-- Table structure for table `temp_courses`
--

CREATE TABLE IF NOT EXISTS `temp_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `venue` varchar(255) NOT NULL DEFAULT 'TBA',
  `startTime` time NOT NULL,
  `count` int(11) NOT NULL,
  `endTime` time DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `approved` int(11) DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `facilitator` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_courses_ibfk_1` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `temp_courses`
--

INSERT INTO `temp_courses` (`id`, `name`, `sender`, `cost`, `start`, `end`, `venue`, `startTime`, `count`, `endTime`, `code`, `approved`, `description`, `department`, `facilitator`, `email`) VALUES
(3, 'SPCMIS Conference Room Pilot 2 (CRP2)', 'Lemuel Catalogo', 0, '2014-01-13', '2014-01-15', 'UPITDC', '09:00:00', 60, '17:00:00', '4oNnv8R4k2owHSDRtwOYMuJcG', 1, 'SPCMIS Conference Room Pilot 2', 'SPCMIS', NULL, 'lbcatalogo@ittc.up.edu.ph'),
(4, 'CTC Meeting', 'Carlos N. Forteza', 0, '2014-01-10', '2014-01-10', 'Conference Room', '11:00:00', 20, '13:00:00', 'iPxDGTAQUuex22gErIxrBFH6U', 1, 'Weekly meeting of the eUP Core Technical Committee', 'eUP', NULL, 'cnforteza@ittc.up.edu.ph'),
(5, 'Second Joint Meeting of the eUP System-Level Project Coordination Committee and the SAIS Coordination Committee ', 'Lemuel Catalogo', 0, '2014-02-03', '2014-02-03', 'UP ITDC Lecture Hall', '12:00:00', 50, '16:00:00', 'RlVjdNu8dtnGilEfPqzu3kqMY', 1, 'Second Joint Meeting of the eUP System-Level Project Coordination Committee and the SAIS Coordination Committee ', 'eUP System-Level', NULL, 'lbcatalogo@ittc.up.edu.ph'),
(6, 'eUP SAIS Data Dictionary Standardization workshop for University Registrars', 'Kenneth Isaac dela Cruz', 0, '2014-02-06', '2014-02-08', 'Camayan Beach Resort Subic, Zambales', '09:00:00', 40, '17:00:00', 'J1TEfe0qsAHURjQt0Qgu8cOq3', 1, 'To standardize OUR''s data dictionary for all UP CU''s', 'eUP SAIS', NULL, 'ksdelacruz2@up.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(128) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=316 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `role`, `salt`, `verified`, `slug`, `middlename`) VALUES
(1, 'meteor.upitdc@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'UpItdc', 'Admin', 0, '', 1, 'GQ3U4JT8Tl5jMofHMTz9GzEu7', 'EUP'),
(98, 'managerone@mail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Master', 'Manager', 1, '', 1, '121654hfg1h2g1h', NULL),
(248, 'esia.rizal@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Efren Ver', 'Sia', 2, '', 1, 'jbvWLIuELVjeMpJnzjgvtJseh', 'Monesit'),
(249, 'kscruz@ittc.up.edu.ph', '6b18bc13b3936a27eb26a414870eca6e412115eb', 'Kenneth Isaac', 'Dela Cruz', 1, '', 1, 'HtyKZ8Pawm4SZoEt1BzvK2ie7', NULL),
(250, 'lbcatalogo@ittc.up.edu.ph', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Lemuel', 'Catalogo', 1, '', 1, 'sefwer87465fdas', NULL),
(251, 'cnforteza@ittc.up.edu.ph', 'c4cdaf9bafa9b0b4dc4087ff7189fdb0dbafc6a6', 'Carlos', 'Forteza', 0, '', 1, '56sdf465sd4fdsferw687', NULL),
(252, 'efren.aldave@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Efren', 'Sia', 1, '', 1, 'fdfw987r56wefSDad', 'Aldave'),
(253, 'rmpancho@ittc.up.edu.ph', '6ca933944c990f70b33e7432077fc34f1e24b9ea', 'Richmon', 'Pancho', 2, '', 1, 'NLBIwLwEjMpIH9RzC5EVij5NI', NULL),
(254, 'hssalapare@ittc.up.edu.ph', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Hernando', 'Salapare', 2, '', 1, 'vrcDLmcbZTdpRYLqgggO1LIA2', 'Ewan'),
(255, 'crpasco@ittc.up.edu.ph', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Cherie Anne', 'Pasco', 2, '', 1, 'v6M87Y30o6PFpvCMBRn3hUc2y', 'Ewan'),
(256, 'jcamua@ittc.up.edu.ph', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'JUVY', 'CAMUA', 2, '', 1, '6MP9zscXDRvANfJE5uCPTjdOK', 'Ewan'),
(257, 'vpteodosio@up.edu.ph', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Vincent', 'Teodosio', 2, '', 1, '4x4iUANomAULmpp7MBBLfLZLg', 'Ewan'),
(258, 'rcsolamo@up.edu.ph', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Ma. Rowena', 'Solamo', 2, '', 1, 'Fg1LbFsjlit5udL19DHDiAr2p', 'Ewan'),
(259, 'Gengrmerc@yahoo.com', '87053ce147649d913e40cb9cd049b562bced4a27', 'Genoveva', 'Mercado', 2, '', 1, 'YTk4NNsbEJVvbfINdq0gA2LGx', NULL),
(260, 'rtsuyat@gmail.com', 'fbdb2f50fe1c44bf04f34db68e5b2091e348c43a', 'Rodolfo', 'Suyat', 2, '', 1, 'uqoWLSVnzjbeAfJlkQfGwpmLU', NULL),
(261, 'jbagsic@gmail.com', 'cf8c972ceaf4c0b9f185f1880be5030215bc5571', 'James Benedict', 'Bagsic', 2, '', 1, 'iQ6GllH3jL6SkJOCWBxTVL7WE', NULL),
(262, 'sammyniev@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Samuel', 'Nievales', 2, '', 1, 'R9337dSr41kshDq7iFZVF6ZKX', 'Aldave'),
(263, 'amalia.perez@upou.edu.ph', '9fe9b90d693506d87e660ffa9aac0ee6c5118ab6', 'Perez', 'Amalia', 2, '', 1, 'Aln7JOnsaw4kQvA2pcJD9Nmg4', NULL),
(264, 'agperez_upou@yahoo.com', 'd053051f9fa00a4df16d55e3a356829790c64e27', 'Amalia', 'Perez', 2, '', 0, 'WVWZSsRi6RlZ7p0n3MbTUrICk', NULL),
(265, 'ruby_allado@yahoo.com', '3ce69380e8f936c32f0549b1198eb21cca3754f5', 'Ruby', 'Allado', 2, '', 1, 'HA72r1J93QgISg5XrnxCvZLS4', NULL),
(266, 'reynaldolaysico@yahoo.com', '17074388a8496716b262cc5598d7a3b00b94ae9f', 'reynaldo', 'laysico', 2, '', 1, 'BaXUvqxk3qcnsx4o5EVmfDfxg', NULL),
(267, 'minacreyes@yahoo.com', '696b18afe8865081603d372e643c9b1f849754da', 'Romina', 'Reyes', 2, '', 1, '0lEbv1B7q8qiSTqjYsqzTGNQ5', NULL),
(268, 'pura.amoloza@upou.edu.ph', '9ceab1febd414b7fc5d4ca07f487f33d07b23dba', 'Pura', 'Amoloza', 2, '', 0, '88N0J4MgRA38SqU5OepzuYXUo', NULL),
(269, 'uplb.bacsecretariat@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Gercy Love', 'Juanillas', 2, '', 1, '9akAe9nimeCzBxWmgfRe7BA5o', 'Ewan'),
(270, 'supply_property@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Gorgonio', 'Nunal III', 2, '', 1, 'GzNgRqXYhGvaEVMShqUYP8eTM', NULL),
(271, 'rodel_monta@yahoo.com', '0c60c97a22f055e8c4799381303010df3891148e', 'rodel', 'montanano', 2, '', 1, 'nlURaiWhBMFDS0iHlTehil5ee', NULL),
(272, 'rossalbertgonzales@ymail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Albert', 'Gonzales', 2, '', 1, 'aEpA8iUNJIXbuQG1qgnFXeaFZ', 'Martinez'),
(273, 'jkeangrif@yahoo.com', '183d688aeacf1e4de331e9155ba53f3f9718089d', 'Venus', 'Claveria', 2, '', 1, 'CjQBxP2z8mcYQZ7FAp3Ik5YhF', NULL),
(274, 'jb.punzalan@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'jaybee', 'punzalan', 2, '', 1, 'D2eBQfnXWO6Xcqwka0RJTPhdb', NULL),
(275, 'janet_galamgam@yahoo.com', '43a5a5767a683e2e46435811c6601da8fccdc377', 'Janet', 'Catangcatang', 2, '', 1, 'BTVWbcDhcMzUXpBDN5dG9czx3', NULL),
(276, 'remumay@yahoo.com', '8d513a3bcd59a153cbec3c799a1636386cbc15b3', 'rommel', 'medina', 2, '', 1, '71O82478OmyUswu3D6qcV116p', NULL),
(277, 'lea_spmo@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'lea', 'gonzales', 2, '', 1, '00yPPSy8nN0hVWBwXudLKRRgy', NULL),
(278, 'bcmevangelista@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'bennie', 'evangelista', 2, '', 1, 'MCLbxHWuVlnAJZTUgJwdeE7YR', NULL),
(279, 'jaycees2@yahoo.com', '9901b288a9f659e2ec344c1d549d24503c8c5607', 'juliet', 'gayas', 2, '', 1, 'Nw1K2KQZn6pXoGzjYbNFjiM3v', NULL),
(280, 'cluesebio@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Cristina', 'Eusebio', 2, '', 0, 'TKmpwlzeKoaXmuMqY7kCBzKMt', NULL),
(281, 'stineli_m@yahoo.com.sg', '2c4c3f003c5394f2ba6041c491a3ff2a22e173d5', 'MA. STINELI', 'MAGDADARO', 2, '', 1, 'tRPyWwBjU3tIFEXgHovzeZFvL', NULL),
(282, 'pgh_purchasing@yahoo.com', 'c95bd005a1261b6643bf60c3e3f3ffaac5217020', 'Fenie', 'Sinarao', 2, '', 1, 'eiQGQW5QnoFsa3ZrHyBTidlJ8', NULL),
(283, 'clueusebio@yahoo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Cristina', 'Eusebio', 2, '', 1, 'fgMLA9fEOmHafggwKQKoDenck', NULL),
(284, 'Antonio_beconado@yahoo.com', '424894614e3f74a53d92d33db149320b5e858ab0', 'Antonio Jr.', 'Beconado M', 2, '', 1, 'IHgOUyUwtShM5Ehtr65XdwPwQ', NULL),
(285, 'mariel_dimaano@yahoo.com', 'c9904d5ab9931e0f29f721aa0754effc77b66196', 'Mariella', 'Dizon', 2, '', 1, 'xafZrjpJSdvXoEuNOxSrx7yHA', NULL),
(286, 'aurora_verdejo@yahoo.com', 'be6cee3dcc12c59e3dc34001e7232b51e7330de0', 'Nancy', 'Lugtu', 2, '', 0, 'zJCY2xA9yqHsxMAcRZNXlHauK', NULL),
(287, 'erz_117027@yahoo.com', '12b1dbb3fcd8929e2a8344eeea10f0baca1213e0', 'Erwin', 'Dando', 2, '', 1, 'XgbcepmSqrDwqbaGfkJPtif5P', NULL),
(288, 'isagani_bagus@yahoo.com', 'bd7832b1bce2a9aecf05718b4fab87d384df5fb4', 'Isagani', 'Bagus', 2, '', 1, 'TkviYOQyTo4ACoogMgV1PALem', NULL),
(289, 'sasantos@post.upm.edu.ph', '81cd1035e9610df04ce0b9a47f2054f67c279f5f', 'solita ', 'santos', 2, '', 1, 'R4HIgfVIE6T5UDekczLYLUiOR', NULL),
(290, 'taarroco@up.edu.ph', 'b6c3dfac31ee5534ee0d0e8344f0af5ff0bae4d5', 'teresa', 'arroco', 2, '', 1, 'FNAm8MRty6BXQ8WiRioaxKemw', NULL),
(291, 'joelllobit@yahoo.com', '9cbcd952e4af66c8d062c72fca57a9a24f0bf83d', 'joel', 'llobit', 2, '', 1, '8wnqn96wmjjdCEx4tPGdjsqPX', NULL),
(292, 'tonyblackrocks@gmail.com', '305cfe6e6277aa7020978ac06a2d304a7332011d', 'Test', 'Test', 2, '', 0, 'f718b4549d7ec6bace67f1e542e313f6effd2db5', NULL),
(293, 'szcortejos@ittc.up.edu.ph', '5c342f23b1efbb60ba244a5b605a5393b7899c56', 'Sarah Grace', 'Cortejos', 2, '', 1, '2p2SOL6HEy4PkMDnwjLmhspT5', NULL),
(294, 'registrar_uplb@yahoo.com', '5339f63741f76b57dd192f00649b44cf7aede0df', 'Ma. Arabella Caridad', 'Ricarte', 2, '', 1, 'l6bOFXZnznAxPilFID4jZfvB6', NULL),
(295, 'jrrafanan@upb.edu.ph', '0313a9f806f0a1703c72b20e714100038c4336e3', 'JOCELYN', 'RAFANAN', 2, '', 1, 'puI03SVWRPcsOQ8ZVaIuOSlnR', NULL),
(296, 'jacob.obinguar@up.edu.ph', 'af900abb8fb144c7aca421cd786b11810c2127f1', 'JACOB', 'OBINGUAR', 2, '', 1, 'EQnkWpAKCOU3PB5zufTWC52a5', NULL),
(297, 'jennylyn.llamas@gmail.com', '1719a6d595827a04ca11ec9d89ec1e460280021f', 'Jennylyn Teodora', 'Baluyot', 2, '', 1, 'jZy8RzvYBpAFNV8oeKCHsVdv2', NULL),
(298, 'anamaria.alarilla@gmail.com', '9215ba191a6de9ea8979bd47f06700c3a3d0e0fc', 'ana maria', 'alarilla', 2, '', 1, 'FJmun9smFlGGMpuKZQnxh15kc', NULL),
(299, 'mgc405@yahoo.com', '1d02684da8258eaa2740ad075d8dc3550852a4bb', 'Myrna', 'Carandang', 2, '', 0, '9Rxw4JSBoiaPINNh5uybfZfhY', NULL),
(300, 'rina@post.upm.edu.ph', '3a5c0806ce29c2464801167542ca82924a4f5e87', 'Lorina', 'Tolentino Alcid', 2, '', 1, '7OOUdXRrS75RGkawsIQtsQt3w', NULL),
(301, 'wvalangui@gmail.com', 'eb02b0c3729282d99ee3b4decb96aa0070580da5', 'Willy V.', 'Alangui', 2, '', 1, '2cfdjTYXgnIkfpYxwvioOMLqc', NULL),
(302, 'btrmortel@upm.edu.ph', 'd3b6e75e2f7ca29c6b7851ed44a18ddf8e479deb', 'Buenalyn Teresita', 'Ramos-Mortel', 2, '', 1, 'KmhhbInCLLmEcJQyI4So4FHMP', NULL),
(303, 'jmmapalo@upb.edu.ph', '0aa69e071dac12e02864f58a2e10678aee2fee54', 'jay', 'mapalo', 2, '', 1, 'blRhdOnRVQTrlSZaw7Dobkof9', NULL),
(304, 'our@upmin.edu.ph', 'a6c61b35094e635a3ce10375744211c20c0bb4ad', 'UP Mindanao', 'Office of the University Registrar', 2, '', 0, 'PVzBmRRrPPY5m4f1lBiBYNyiC', NULL),
(305, 'josego75115@gmail.com', '8dd68b7f42086716a98985473f9e09794e01c906', 'Jose', 'Go', 2, '', 1, 'FiuuAbX1Kjmih2E9hkkzoF1BL', NULL),
(306, 'mjdeluna@post.upm.edu.ph', '0510d07adb61c9361f3cad5ba657304b77fba90c', 'Marie Josephine', 'De Luna', 2, '', 1, '6SptFPBYtFUCgKN931L6sHMDS', NULL),
(307, 'records@upou.edu.ph', '11184cc70c51e2d8b4177ecdd2f81494c0730a30', 'Rhodora', 'Pamulaklakin', 2, '', 1, 'R2N13n5jclVYz9mxyrfHClo4O', NULL),
(308, 'jessicakcarino@gmail.com', '54ac27b445b73c5a5c44cfdb097305c2b16855ad', 'Jessica', 'Carino', 2, '', 1, 'oWqDSPDKgr1d9Cbk9oQ3yF0Y7', NULL),
(309, 'clramos@upsitf.org', 'f26b85802a61c49cde714733944a206422d298e0', 'Cha', 'Ramos', 2, '', 1, '1DCT4fcEqU4qtrj7J1buCaglG', NULL),
(310, 'paulopaje@gmail.com', 'a66c3c33580b15c33315abe1bb9a2aa39171948b', 'Paulo Noel G', 'Paje', 2, '', 1, 'oXp4Fb72z6MJNSNBClU4BRVUj', NULL),
(314, 'evsia@ittc.up.edu.ph', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Efrelyn', 'Sia', 1, '', 1, 'Zx6cVRf7eX8xVkprFuGuyCbfY', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `all_questions`
--
ALTER TABLE `all_questions`
  ADD CONSTRAINT `all_questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories_questions` (`id`);

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cancelled`
--
ALTER TABLE `cancelled`
  ADD CONSTRAINT `cancelled_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cancelled_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `college_history`
--
ALTER TABLE `college_history`
  ADD CONSTRAINT `college_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `completed`
--
ALTER TABLE `completed`
  ADD CONSTRAINT `completed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `completed_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `contact_emergency`
--
ALTER TABLE `contact_emergency`
  ADD CONSTRAINT `contact_emergency_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dissolved`
--
ALTER TABLE `dissolved`
  ADD CONSTRAINT `dissolved_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `dissolved_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `employment_history`
--
ALTER TABLE `employment_history`
  ADD CONSTRAINT `employment_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `forsending`
--
ALTER TABLE `forsending`
  ADD CONSTRAINT `forSending_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `forSending_ibfk_2` FOREIGN KEY (`tempId`) REFERENCES `temp_courses` (`id`);

--
-- Constraints for table `landline`
--
ALTER TABLE `landline`
  ADD CONSTRAINT `landline_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `managers`
--
ALTER TABLE `managers`
  ADD CONSTRAINT `managers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mobilenumbers`
--
ALTER TABLE `mobilenumbers`
  ADD CONSTRAINT `mobilenumbers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `provincial_addresses`
--
ALTER TABLE `provincial_addresses`
  ADD CONSTRAINT `provincial_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reserved`
--
ALTER TABLE `reserved`
  ADD CONSTRAINT `reserved_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reserved_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `signature`
--
ALTER TABLE `signature`
  ADD CONSTRAINT `signature_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `signature_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `picture` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
