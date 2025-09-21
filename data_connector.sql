-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 04:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_connector`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personal`
--

CREATE TABLE `tbl_personal` (
  `id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `sex` varchar(10) NOT NULL,
  `civil_status` varchar(20) NOT NULL,
  `civil_other` varchar(50) DEFAULT NULL,
  `tax_identification_number` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `Bldg_Name` varchar(100) DEFAULT NULL,
  `House_Lot_Bl_No` varchar(100) DEFAULT NULL,
  `Street_name` varchar(100) DEFAULT NULL,
  `subdivision` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `RM_FLR_Unit_No` varchar(100) DEFAULT NULL,
  `house_no` varchar(100) DEFAULT NULL,
  `house_street` varchar(100) DEFAULT NULL,
  `house_subdivision` varchar(100) DEFAULT NULL,
  `house_barangay` varchar(100) DEFAULT NULL,
  `house_city` varchar(100) DEFAULT NULL,
  `house_province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `house_zip_code` varchar(10) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone_number` varchar(15) DEFAULT NULL,
  `Father_last_name` varchar(50) DEFAULT NULL,
  `Father_first_name` varchar(50) DEFAULT NULL,
  `Father_middle_initial` char(1) DEFAULT NULL,
  `Mother_last_name` varchar(50) DEFAULT NULL,
  `Mother_first_name` varchar(50) DEFAULT NULL,
  `Mother_middle_initial` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_personal`
--

INSERT INTO `tbl_personal` (`id`, `last_name`, `first_name`, `middle_initial`, `date_of_birth`, `sex`, `civil_status`, `civil_other`, `tax_identification_number`, `nationality`, `religion`, `Bldg_Name`, `House_Lot_Bl_No`, `Street_name`, `subdivision`, `barangay`, `city`, `province`, `zip`, `RM_FLR_Unit_No`, `house_no`, `house_street`, `house_subdivision`, `house_barangay`, `house_city`, `house_province`, `country`, `house_zip_code`, `mobile_number`, `email`, `telephone_number`, `Father_last_name`, `Father_first_name`, `Father_middle_initial`, `Mother_last_name`, `Mother_first_name`, `Mother_middle_initial`) VALUES
(2, 'a', 'a', 'a', '2003-01-17', 'Female', 'Others', 'a', '1', 'a', '1', '1', 'Quia dolore placeat', 'Fallon Frederick', 'Et eos laboris corpo', 'Iusto in nobis moles', 'a', 'a', '1', 'Porro nostrud repreh', 'Quia dolore placeat', 'Est labore sint vo', '1', '1', 'z', 'z', 'Zimbabwe', '1', '1', 'maefloralivio@gmail.com', '12', 'a', 'a', 'a', 'a', 'a', 'a'),
(3, 'Reynolds', 'Walter', 'R', '2003-11-27', 'Female', 'Single', '', '11', 'Consequuntur molliti', 'In ut in et quae non', 'In ut in et quae non', 'Quasi id voluptas i', 'Donovan Odom', 'At ea illum rerum f', 'Ullamco enim anim ve', 'Doloremque obcaecati', 'Quia distinctio In', '17207', 'Aliquam alias conseq', 'Quasi id voluptas i', 'Recusandae Ut exped', 'Quia facilis aliquid', 'Quia facilis aliquid', 'Quae et qui eius off', 'Fugiat pariatur Dol', 'Zimbabwe', '91299', '564', 'fyhycujy@mailinator.com', '+1 (422) 451-42', 'Ferguson', 'Sawyer', 'S', 'Baldwin', 'Ahmed', 'U'),
(4, 'Salas', 'Angela', 'D', '1973-09-05', 'Female', 'Legally Separated', '', '48', 'Obcaecati magni omni', 'Ipsum aut eligendi a', 'Ipsum aut eligendi a', 'Voluptas eos nisi eu', 'Phyllis Carson', 'Commodo amet minima', 'Cupiditate qui expli', 'Tempor voluptate qui', 'Ut tempor incididunt', '74429', 'Id nihil duis volupt', 'Voluptas eos nisi eu', 'Minus sequi aut offi', 'Non incidunt et vel', 'Non incidunt et vel', 'Exercitation volupta', 'Suscipit quia molest', 'Canada', '76852', '218', 'duwa@mailinator.com', '+1 (672) 666-13', 'Downs', 'Ulysses', 'L', 'Webb', 'Hiram', 'C'),
(5, 'Velasquez', 'Logan', 'B', '2003-07-29', 'Female', 'Widowed', '', '351', 'Proident doloremque', 'Ut ipsum veritatis', 'Ut ipsum veritatis', 'In distinctio Nobis', 'Brian Haley', 'Placeat voluptas do', 'Aute non expedita et', 'Sit duis porro eum q', 'Culpa et consequatu', '16098', 'Minima exercitation', 'In distinctio Nobis', 'Sunt a velit sed qu', 'Sint officia nobis v', 'Sint officia nobis v', 'Eius itaque recusand', 'Ut voluptate dolorem', 'Zimbabwe', '42217', '576', 'liqyj@mailinator.com', '+1 (939) 497-89', 'Hughes', 'Elaine', 'V', 'Watts', 'Alea', 'V'),
(16, 'Summers', 'Yen', 'V', '1980-01-25', 'Female', 'Legally Separated', '', '848', 'Voluptas aut quibusd', 'Voluptas qui sed ips', 'Voluptas qui sed ips', 'Distinctio Quisquam', 'Taylor Howell', 'Ab ducimus aut id r', 'Est magni nisi sint', 'Officia perspiciatis', 'Nobis corrupti aliq', '90288', 'Elit sint rerum si', 'Distinctio Quisquam', 'Aliqua Ab error neq', 'Ea quia illo repudia', 'Ea quia illo repudia', 'A nostrud unde ut ut', 'Ad accusamus volupta', 'Zimbabwe', '12160', '105', 'gelupozuh@mailinator.com', '111', 'Solomon', 'Shelly', 'A', 'Shields', 'Andrew', 'Q'),
(24, 'Pacheco', 'Keith', 'C', '1988-06-20', 'Female', 'Legally Separated', '', '549', 'Consequuntur cupidit', 'Tempora et minus qui', 'Tempora et minus qui', 'Aut et mollitia fugi', 'Kamal Patrick', 'Officia in id iure', 'Ad proident sit al', 'Autem et nesciunt s', 'Atque eaque ea ipsa', '67822', 'Ab aut saepe sunt op', 'Aut et mollitia fugi', 'Adipisci velit simi', 'Et omnis aperiam ex', 'Et omnis aperiam ex', 'Vel repudiandae corp', 'At aut consequat Re', 'Zimbabwe', '46070', '289', 'sodag@mailinator.com', '+1 (863) 563-95', 'Clemons', 'Malcolm', 'D', 'Robertson', 'Iola', 'N'),
(25, 'Patrick', 'Guy', 'E', '2003-08-12', 'Male', 'Others', 'aa', '577', 'Repellendus Lorem d', 'Deleniti deserunt es', 'Deleniti deserunt es', 'Sunt vero consequunt', 'Shelby Fowler', 'Quos animi exercita', 'Ipsam possimus cumq', 'Amet esse in impedi', 'Culpa consequatur', '29062', 'Et asperiores labori', 'Sunt vero consequunt', 'Est iste consequatur', 'In corporis laboris', 'In corporis laboris', 'Omnis dolor suscipit', 'Magni magna dolores', 'Zimbabwe', '96449', '456', 'xivodiryh@mailinator.com', '+1 (446) 995-68', 'Sears', 'Lillian', 'A', 'Butler', 'Leah', 'F'),
(26, 'Velazquez', 'Clayton', 'V', '2005-07-14', 'Male', 'Legally Separated', '', '414', 'Sed voluptatem aliqu', 'Eveniet sed eum hic', 'Iris Harrell', 'Et voluptatem corru', 'Colby Leon', 'Dolorem exercitation', 'Nihil dolor irure sa', 'Cupidatat sit culpa ', 'Minim veritatis duis', '32650', 'Quas veniam delenit', 'Consectetur delectu', 'Ea dignissimos et fu', 'Exercitation reicien', 'Aspernatur sed minus', 'Dolorem obcaecati om', 'Architecto rerum eos', 'Palau', '47163', '571', 'feju@mailinator.com', '+1 (289) 125-47', 'Harris', 'Lilah', 'E', 'Macdonald', 'Tamekah', 'U'),
(27, 'Mathews', 'Thomas', 'I', '1994-03-11', 'Male', 'Widowed', '', '804', 'Aut totam asperiores', 'Iusto Nam voluptas q', 'Quail Conrad', 'Velit ex quaerat cor', 'Leonard Duffy', 'Sed quam esse ipsum', 'Error neque similiqu', 'Non quia ipsam assum', 'Iusto aut velit qui ', '39857', 'Ut quia in neque des', 'Est est laboriosam', 'Alias sed est nihil ', 'Quod ea dolore cum q', 'Cupiditate qui iure ', 'Reprehenderit pariat', 'Placeat pariatur E', 'United Kingdom', '56541', '164', 'zodehunu@mailinator.com', '+1 (568) 615-12', 'Mejia', 'Alexis', 'I', 'Barlow', 'Grady', 'D'),
(28, 'Cervantes', 'Anika', 'Q', '1997-10-07', 'Female', 'Others', 'Test', '823', 'Incididunt aliquid d', 'Ut vel rem cillum fu', 'Shelley Middleton', 'Ut qui impedit tota', 'Dale Clemons', 'Anim inventore anim ', 'Non ipsa ab eveniet', 'At aut error anim ex', 'Proident aut illum', '36664', 'Quas consequatur Ex', 'Consequatur nisi qui', 'Voluptatibus quaerat', 'Id a maxime quidem a', 'Voluptate amet aut ', 'Voluptatem sint seq', 'Dolores nesciunt sa', 'Angola', '40910', '459', 'xukemu@mailinator.com', '+1 (296) 419-74', 'Rodriquez', 'Jared', 'E', 'Benton', 'Jaden', 'I'),
(29, 'Sharpe', 'Sebastian', 'S', '2003-06-11', 'Female', 'Legally Separated', '', '167', 'Voluptatem nostrum f', 'Iusto incidunt quis', 'Yolanda Gilmore', 'Ut voluptate cum eaq', 'Adena Chase', 'Consequatur corrupti', 'Vitae cumque ex dolo', 'Repellendus Modi qu', 'Aperiam rerum aperia', '62288', 'Sed dignissimos fugi', 'Ipsa odit nobis acc', 'Sit ut adipisci del', 'Ex nemo aut cillum a', 'Nihil corporis conse', 'Debitis est asperior', 'Maxime dolores cupid', 'Madagascar', '53296', '740', 'gexalylyqy@mailinator.com', '+1 (179) 814-42', 'Compton', 'Mia', 'A', 'Cabrera', 'Brandon', 'O'),
(32, 'Jefferson', 'Joshua', 'V', '2004-02-12', 'Male', 'Others', 'Quis debitis volupta', '666', 'Consequuntur non mol', 'Possimus corrupti', 'Dolan Cooke', 'Veniam non quidem i', 'Rogan Frost', 'Elit harum est quis', 'Voluptate corrupti', 'Voluptas ex sint qui', 'Et nesciunt in dign', '42567', 'Deserunt et quam occ', 'Similique vero paria', 'Sapiente culpa moll', 'Voluptate do sunt qu', 'Eum suscipit qui rei', 'In quae excepturi vo', 'Irure odit magni qui', 'Cabo Verde', '47079', '99', 'xyqytiteb@mailinator.com', '+1 (549) 111-74', 'Hawkins', 'Neve', 'F', 'Mckinney', 'Xandra', 'P'),
(34, 'Barker', 'Dora', 'S', '2003-05-24', 'Female', 'Single', '', '911', 'Quasi voluptas modi', 'Do ex molestiae dolo', 'Do ex molestiae dolo', 'Culpa voluptas dolo', 'Candice Barber', 'Quisquam soluta ulla', 'At sequi aute sed na', 'Do quia possimus co', 'Officia est similiq', '38689', 'Ad iusto eu aliquam', 'Culpa voluptas dolo', 'Laboriosam commodi', 'Iusto voluptatum aut', 'Iusto voluptatum aut', 'Nisi sed quis quia t', 'Aut qui voluptate te', 'Zimbabwe', '35967', '604', 'jitenulal@mailinator.com', '+1 (726) 527-25', 'Franklin', 'Prescott', 'M', 'Ruiz', 'Nigel', 'R'),
(35, 'Barnett', 'Xena', 'E', '2000-05-05', 'Male', 'Single', '', '323', 'aa', 'Consequat In error', '11', 'Officia eiusmod dolo', 'Zephr Reid', 'Lorem duis dolor neq', 'Dolor quia eos perf', 'Voluptate et magni c', 'Mollitia pariatur E', '21765', 'Veniam et voluptati', 'Officia eiusmod dolo', 'Expedita est volupt', 'Voluptate qui id rem', 'Voluptate qui id rem', 'Deserunt omnis at no', 'Non expedita culpa', 'Zimbabwe', '16931', '733', 'basoqawox@mailinator.com', '+1 (156) 882-96', 'Wooten', 'Fallon', 'A', 'Hendrix', 'Holmes', 'A'),
(37, 'Santana', 'Leah', 'R', '2003-05-24', 'Female', 'Widowed', '', '418', 'Corporis expedita qu', 'Est qui maxime nihi', 'Stella Boyd', 'Saepe et officia mol', 'Yuli Terry', 'Ut sint proident fu', 'Nesciunt eaque cons', 'Qui iste commodi Nam', 'Doloremque neque min', '80971', 'Accusamus voluptatem', 'Ea quod aspernatur c', 'Sed excepteur except', 'Pariatur Distinctio', 'Amet ut rerum recus', 'Vitae nulla quisquam', 'Ullam ex voluptatum ', 'Iraq', '21559', '290', 'gujanafox@mailinator.com', '+1 (436) 666-41', 'Mckenzie', 'Demetria', 'Q', 'Ramos', 'Ivor', 'D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_personal`
--
ALTER TABLE `tbl_personal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_personal`
--
ALTER TABLE `tbl_personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
