-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 02:11 AM
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
-- Database: `ejusticesys`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_sessions`
--

CREATE TABLE `active_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `last_activity_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int(11) NOT NULL,
  `municipality_id` int(11) NOT NULL,
  `barangay_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `municipality_id`, `barangay_name`) VALUES
(1, 1, 'Sample Barangay'),
(74, 41, 'San Vicente'),
(76, 42, 'Batong Malake'),
(78, 48, 'IV-A'),
(92, 54, 'Poblacion(Alaminos)'),
(93, 44, 'Poblacion(San Pedro)'),
(94, 47, 'Tagumpay'),
(95, 42, 'Anos'),
(96, 45, 'Bagong Kalsada');

-- --------------------------------------------------------

--
-- Table structure for table `case_progress`
--

CREATE TABLE `case_progress` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `current_hearing` varchar(255) NOT NULL,
  `latest_hearing` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_progress`
--

INSERT INTO `case_progress` (`id`, `complaint_id`, `current_hearing`, `latest_hearing`) VALUES
(65, 103, '1th', ''),
(67, 105, '1th', ''),
(69, 107, '1th', ''),
(70, 108, '1th', ''),
(71, 109, '1th', ''),
(73, 111, '1th', ''),
(74, 112, '1th', ''),
(75, 113, '1th', ''),
(76, 114, '1th', ''),
(77, 115, '1th', ''),
(78, 116, '1th', ''),
(81, 119, '1th', ''),
(82, 120, '1th', ''),
(83, 121, '1th', ''),
(84, 122, '1th', ''),
(85, 123, '1th', ''),
(86, 124, '1th', ''),
(87, 125, '1th', ''),
(88, 126, '1th', ''),
(89, 127, '1th', ''),
(90, 128, '1th', ''),
(91, 129, '1th', ''),
(92, 130, '1th', ''),
(93, 131, '1th', ''),
(94, 132, '1th', '4th'),
(95, 133, '1th', ''),
(96, 134, '1th', ''),
(97, 135, '1th', '13th'),
(98, 136, '1th', ''),
(99, 137, '1th', ''),
(100, 138, '1th', ''),
(101, 139, '1th', ''),
(102, 140, '1th', ''),
(103, 141, '1th', ''),
(104, 142, '1th', ''),
(105, 143, '1th', ''),
(106, 144, '1th', ''),
(107, 145, '1th', ''),
(108, 146, '1th', ''),
(109, 147, '1th', ''),
(110, 148, '1th', ''),
(111, 149, '1th', ''),
(112, 150, '1th', ''),
(113, 151, '1th', ''),
(114, 152, '1th', ''),
(115, 153, '1th', ''),
(116, 154, '1th', ''),
(117, 155, '1th', ''),
(118, 156, '1th', ''),
(119, 157, '1th', ''),
(120, 158, '1th', ''),
(121, 159, '1th', ''),
(122, 160, '1th', ''),
(123, 161, '1th', ''),
(124, 162, '1th', ''),
(125, 163, '1th', ''),
(126, 164, '1th', '4th'),
(127, 165, '1th', ''),
(128, 166, '1th', ''),
(129, 167, '1th', ''),
(130, 168, '1th', ''),
(131, 169, '1th', ''),
(132, 170, '1th', ''),
(133, 171, '1th', ''),
(134, 172, '1th', ''),
(135, 173, '1th', ''),
(136, 174, '1th', ''),
(137, 175, '1th', ''),
(138, 176, '1th', ''),
(139, 177, '1th', ''),
(140, 178, '1th', ''),
(141, 179, '1th', ''),
(142, 180, '1th', ''),
(143, 181, '1th', ''),
(144, 182, '1th', ''),
(145, 183, '1th', ''),
(146, 184, '1th', ''),
(147, 185, '1th', ''),
(148, 186, '1th', ''),
(149, 187, '1th', ''),
(150, 188, '1th', ''),
(151, 189, '1th', ''),
(152, 190, '1th', ''),
(153, 191, '1th', ''),
(154, 192, '0', ''),
(155, 193, '0', ''),
(156, 194, '0', ''),
(157, 195, '1th', ''),
(158, 196, '1th', ''),
(159, 197, '0', ''),
(160, 198, '1th', ''),
(161, 199, '6th', '6th'),
(162, 200, '2th', ''),
(163, 201, '1th', ''),
(164, 202, '1th', ''),
(165, 203, '1th', ''),
(166, 204, '1th', ''),
(167, 205, '1th', ''),
(168, 206, '1th', ''),
(169, 207, '1th', ''),
(170, 208, '1th', ''),
(171, 209, '1th', ''),
(172, 210, '0', ''),
(173, 211, '2th', ''),
(174, 212, '1th', ''),
(175, 213, '0', ''),
(176, 214, '1th', ''),
(177, 215, '0', ''),
(178, 216, '0', ''),
(179, 217, '0', ''),
(180, 218, '0', ''),
(181, 219, '0', ''),
(182, 220, '0', ''),
(183, 221, '0', ''),
(184, 222, '1th', ''),
(185, 223, '0', ''),
(187, 225, '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BarangayID` int(11) DEFAULT NULL,
  `CNum` varchar(50) DEFAULT NULL,
  `CAddress` varchar(255) DEFAULT NULL,
  `RAddress` varchar(255) DEFAULT NULL,
  `Mdate` date DEFAULT NULL,
  `RDate` date DEFAULT NULL,
  `CNames` varchar(255) DEFAULT NULL,
  `RspndtNames` varchar(255) DEFAULT NULL,
  `CDesc` varchar(255) DEFAULT NULL,
  `Petition` varchar(255) DEFAULT NULL,
  `ForTitle` varchar(255) DEFAULT NULL,
  `Pangkat` varchar(255) DEFAULT NULL,
  `CType` varchar(50) DEFAULT NULL,
  `CStatus` varchar(50) DEFAULT NULL,
  `CMethod` varchar(50) DEFAULT NULL,
  `IsArchived` tinyint(1) DEFAULT 0,
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `UserID`, `BarangayID`, `CNum`, `CAddress`, `RAddress`, `Mdate`, `RDate`, `CNames`, `RspndtNames`, `CDesc`, `Petition`, `ForTitle`, `Pangkat`, `CType`, `CStatus`, `CMethod`, `IsArchived`, `seen`) VALUES
(103, 109, 74, '001-227-0124', NULL, NULL, '2024-01-05', '2024-01-10', 'Aileen Bagui', 'Chloe Joy Baris', ' Hindi pag babayad ng utang', ' Gusto ko po makausap ang aking inirereklamopara malaman ko kung papano sya makakabayad ng nahiram nyang pera', 'collectionofmoney', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(105, 110, 76, '2024-2-11', NULL, NULL, '2024-03-10', '2024-01-23', 'Anabel Aquino', 'Cristina M. Talamo', 'Ako po si Anabel Aquino na inirereklamo si Cristina M. Talamo ng hindi pagbabayad ng utang.', 'Mabayaran niya ang kanyang utang', 'HindiPagbabayadSaUtang', '', 'Others', 'Settled', 'Mediation', 0, 0),
(107, 110, 76, '2024-1-01', '12746 O.B. Purok 1, Mayondon Los BaÃ±os, Laguna', 'O.B. Purok 1, Batong Malake, Los BaÃ±os, Laguna', '2023-12-26', '2023-12-26', 'Gerald Allan Raminto, Gernaldo V. Raminto, Gerardo V. Raminto', 'Jayvee Belencio', ' Ako si Gernaldo V. Raminto natungo sa tanggapan ng Barangay Batong Malake upang ireklamo si Jayvee Belencio dahil sa pagpukpok niya ng bangko sa ulo ng kapatid ko na si Gerald Allan Raminto noong December 25, 2023 mga bandang 1:30 ng umaga. Ang Kapatid k', ' Gusto namin siya makaharap sa tanggapan ng Barangay Batong Malake upang mapagusapan ang nangyaring insidente at sagutin niya ang gastusin sa ospital ng aking kapatid.', 'PinukpokNgBangkoSaUlo', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(108, 110, 76, '2024-1-02', 'Sitio Villegas, Batong Malake, Los BaÃ±os, Laguna', 'Sitio Villegas, Batong Malake, Los BaÃ±os, Laguna', '2023-12-30', '2023-12-30', 'Carlo De Gula Maligalig', 'Nadie Casipong', ' Mga bandang 9:00 ng gabi, December 29, 2023 pumunta ako sa covered court para hanapin ang aking anak, hindi ko alam na party pala at nayakad ako ng isang tauhan at napaupo sa kanilang inuman. Mga bandang 1:30 am ay pinalo ako sa ulo ng bote at hinataw ng', ' Gusto ko na magharap kami sa tanggapan ng Barangay upang pagusapan at sagutin ni Nadie Casipong ang aking magagastos sa aking pag-papagamot.', 'PaghatawNgBoteSaUlo', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(109, 110, 76, '2024-1-03', '0601 Dangka St., Ilaya Bayog, Los BaÃ±os, Laguna', 'Western Union, National Highway, Batong Malake, Los BaÃ±os, Laguna', '2024-01-08', '2024-01-08', 'Leonardo Tamisin Jr.', ' Jose Xavier B. Gonzales, Shirley Bartilez', ' Ako si Leonardo Tamisin Jr. nagtungo sa tanggapan ng Barangay Batong Malake, Los Baï¿½os, Laguna. Nais ko ireklamo ang empleyado ng Western Union dahil sa pekeng pera na naibigay sa akin nung ako ay kumuha ng ayuda para sa Farmers. P5,000.00 ang nareceiv', ' Nais ko siya makaharap sa tanggapan ng Barangay upang makipglinawan sa aking reklamo.', 'PagkuhaNgP5000AyudaParaSaFarmersNaMayNahalongP1000NaPeke', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(111, 110, 76, '2023-1-02', 'Jamila Apartment, Emerald St., Batong Malake, Los Baños, Laguna', 'Sitio Villegas, Batong Malake, Los Baños, Laguna', '2024-03-23', '2023-01-08', 'Patrick John M. Chui', 'Raymond Mahipos / Darwin Mahipos', 'Ako po ay inaya na makipagsuntukan ni Raymond Mahipos bandang 12:00 am ng gabi ng Enero 8, 2023, kasama niya si Darwin Mahipos at mayroon pang isang hindi kilalang lalake na may hawak na patalim. Ako po ay nabugbog at napuruhan ang ulo.', 'Gusto ko siyang makausap upang mapag-usapan ang nangyaring pambubugbog sa akin at siya ay mapanagot.', 'Pambubugbog at Akmang Pananaksak', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(112, 110, 76, '2023-1-03', '8800 Gazal Compound, Batong Malake, Los Baños, Laguna', 'Gazal Compound, Batong Malake, Los Baños, Laguna', '2024-03-23', '2023-01-16', 'Gloria G. De Peralta', 'Mark Anthony G. Melchor', 'Si Mark Anthony Melchor ay nagwala dahil lang sa nakasara ang aming gate sa compound, dahil dito kung ano-ano ang sinabi niya sa akin na masasakit na salita.', 'Dahil dito gusto ko siyang makaharap upang magpaliwanag sya kung bakit ako sinabihan ng mga masasakit na salita.', 'Pagwawala dahil sa nakasarang gate', '', 'Others', 'Settled', 'Mediation', 0, 0),
(113, 110, 76, '2023-1-04', 'Sitio Riverside, Batong Malake, Los Baños, Laguna', 'Sitio Riverside, Batong Malake, Los Baños, Laguna', '2024-03-23', '2023-01-18', 'Helen P. Garbanzos', 'Roberto Monterey', 'Nagpunta ako dito upang ipatala si Roberto Monterey dahil pinapahiya niya ako at minumura kahit saan niya ako makita dahil ako ay may utang sa kanya.', 'Gusto ko siyang makausap upang makipaglinawan sa maayos kong pagbabayad at matigil ang pagpapahiya at pagmumura niya sa akin.', 'Panghihiya dahil sa Utang', '', 'Others', 'Settled', 'Mediation', 0, 0),
(114, 110, 76, '2023-1-05', 'Sitio Riverside, Batong Malake, Los Baños, Laguna', 'Sitio Riverside, Batong Malake, Los Baños, Laguna', '2024-03-23', '2023-01-18', 'Arrabelle S. Marcos', 'Helen P. Garbanzos', 'SI Helen Garbanzos ay may utang sa akin na halagang Php10,300.00 noon pang taong 2019. Hanggang ngayon ay di pa rin nya ito binabayaran.', 'Dahilan, kaya gusto ko siyang makausap para makipaglinawan kung kailan niya ako mababayaran.', 'Perang Hiniram na hindi Ibinalik', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(115, 110, 76, '2023-1-06', 'Sitio Riverside, Batong Malake, Los Baños, Laguna', 'Sitio Riverside, Batong Malake, Los Baños, Laguna', '2024-03-24', '2023-01-18', 'Arlene P. Miranda', 'Helen Garbanzos', 'Kaninang umaga, kami ay nagkaroon ng pagtatalo ni Helen Garbanzos na aking kapitbahay dahil ipinagkakalat niya na ako ay pokpok.', 'Dahil dito, gusto ko siyang makaharap at mag paliwanag siya sa akin kung bakit niya ipinagkakalat na pokpok ako.', 'Pagkakalat ng Tsismis', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(116, 110, 76, '2023-1-07', 'Danka, Barangay Bayog, Los Baños, Laguna', 'Jamboree Site, Batong Malake, Los Baños, Laguna', '2024-03-24', '2023-01-23', 'Ronald Tayson / Beverly Garcia', 'Anthony Galla', 'Habang kami ay pauwi na at nakasakay sa aming motor, nagulat kami nang may mabilis na bumangga sa amin mula sa likuran, dahilan upang kami ay tumilapon pati na rin ang aming bitbit. Nangyari ito ngayong araw at kami ay nagpatingin sa center bago pumunta d', 'Guto ko siyang makausap, upang mapagusapan ang nangyari sa amin.', 'Aksidenteng Banggaan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(119, 110, 76, '2023-3-14', 'Grove St., Barangay Batong Malake, Los Baños, Laguna', '10528 Grove St., Barangay Batong Malake, Los Baños, Laguna', '2023-03-06', '2023-03-06', 'Bryan Morales', 'Cynthia O. Labita', 'Kahapon March 5, 2023, Bandang 9:00 am, si Cynthia Labita ay kung ano ano ang masasamang isinisigaw sa labas ng aming bahay, nag eeskandalo siya at kami ang pinupuntirya niya sinasabihan ko siya na tumigil ngunit tuloy parin siya sa pageeskandalo.', 'Dahil dito, ako po ay lumapit sa inyong tanggapan upang makausap at maipatawag siya.', 'Pag E-eskandalo', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(120, 110, 76, '2023-1-01', '175 Silangan, Barangay Bayog, Los Baños, Laguna', 'Lopez Avenue, Batong Malake, Los Baños, Laguna', '2024-03-25', '2023-01-02', 'Joey D. Mercado', 'Maria Cristina Macario', 'Ang aming inuupahang tindahan ay nabangga ni Maria Cristina Macario. Dahilan para ito ay masira at maperwisyo ang aming mga tinitindang pangkabuhayan. Kami ay sarado mula nang nangyari ang insidente hanggang sa mga oras na ito.', 'Hinihiling namin na panagutan ni Maria Cristina Macario ang aming daily income at kasama na rin ang mga pasweldo namin sa aming manggagawa. simula ng nangyari ang insidente hanggang sa ngayon kami at sarado.', 'Nabanggang Tindahan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(121, 110, 76, '2023-2-08', '10633 Mint St., Demarces Subd., Batong Malake, Los Baños, Laguna', 'Demarces Subd., Batong Malake, Los Baños, Laguna', '2024-03-25', '2023-01-30', 'Gabby Jesena Lazaro', 'Obet Polintan & Grace Polintan', 'During the recent survey of Bagnes Surveying Office, the surveyor confirmed that their property took advantage of our adjoining property and built their residence as an extension of our building property. This is negligence on their part of civil code of ', 'I want to talk to them so that they know my concern.', 'Restaurant Enhancement of their Residential to our Space Property', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(122, 110, 76, '2023-2-09', '9064 Collado Apt., Batong Malake, Los Baños, Laguna', 'Collado Apt., Batong Malake, Laguna', '2024-03-25', '2023-02-05', 'Erlinda N. Collado ', 'Leni Anilao', 'Inirereklamo ko si Leni Anilao sa hindi niya Pagbabayad ng bill ng tubig, Meralco Bill at renta sa bahay simula noong May 2021 hanggang November 2022.', 'Dahil dito, gusto ko siyang ipatawag at makaharap upang mapag-usapan ang kanyang mga utang.', 'Hindi Pagbabayad sa Renta ng Bahay at Bill ng Tubig at Kuryente', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(123, 110, 76, '2023-02-10', 'Mayondon, Los Baños, Laguna', 'UP Los Baños, Laguna', '2023-02-10', '2023-10-02', 'Michael Nicole Ocon', 'Bryan V. Patio', 'Kaugnay ng insidente sa Tresto Bar noong February 1, 2023 na itinala sa incident report ng batong Malake, ako ay dumulog sa inyong tanggapan upang  pormal na maghain ng reklamo kay Bryan Patio na nanakit sakin habang kami ay nagkakasiyahan sa kanyang pana', 'Gusto siyang ipatawag upang papanagutin sa kanyang ginawa sakin.', 'Pananakit', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(124, 110, 76, '2023-02-11', 'Sta. Mesa, Calamba City', 'Lopez Avenue, Batong Malake, Los Baños, Laguna', '2024-03-25', '2023-11-02', 'Marilyn S. Moniejo', 'Rizalito Revilleza', 'Ako ay nagtungo sa Barangay Batong Malake upang humingi ng tulong upang maiharap si Rizalito Revilleza tungkol sa pamamahala sa Cartas Apt., ayon sa kanya sya  na daw  ang mamahala. Kung itoy totoo nakahanda akong iturn over sa kanya lahat ng matiwasay an', 'Gusto ko siya makausap upang malinawan ang usaping ito.', 'Usapin tungkol sa pamamahala sa carta\'s apartment', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(125, 110, 76, '2023-03-12', '10582 Batong Malake, Los Baños, Laguna', '10108 Batong Malake, Los Baños, Laguna', '2024-03-25', '2023-04-03', 'Cynthia Labita', 'Randy Punzalan', 'Noong March 03, 2023, tumaya si Randy Punzalan sa STL sa akin ng 19x13. Bago ito  isulat, tinanong ko pa siya kung 19x13 at sya ay tumango at umalis na. Noong lumabas ang 9x30 pinagpipilitnan na 9x30 daw ang kanyang tinayaan. kaya minabuti kong pumunta sa', 'Gusto ko siyang makaharap para pakipaglinawan', 'Pakikipaglinawan tungkol sa tumama sa STL', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(126, 110, 76, '2023-03-13', '10108 Batong Malake, Los Baños, Laguna', '10528 Batong Malake, Los Baños, Laguna', '2024-03-25', '2023-03-13', 'Randy Punzalan', 'Cynthia Labita', 'Ako ay tumaya kay Cynthia Labita sa STL kahapon March 3, 2023, bandang 4:40 ng hapon. ang aking taya ay 9x30 pero ang inilagay nya ay 19x13. Noong tumama ang 9x30 wala daw akong taya dahil 19x13 pala ang inilagay niya.', 'Dahilan kaya ako\'y nagtungo na sa barangay Batong Malake upang kami ay magharap upang mapag usapan ang usaping ito.', 'Pakikipaglinawan tungkol sa tumama sa STL', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(127, 110, 76, '2023-03-15', 'Grove, Batong Malake, Los Baños, Laguna ', 'Grove, Batong Malake, Los Baños, Laguna ', '2024-03-25', '2023-03-06', 'Bryan Morales & Grace Morales', 'Careene Del Rosario', 'Irereklamo namin si Careen Del Rosario dahil ayaw nya kami tigilan sa pagkakalat ng kung anu anong maling kwento sa amin. Kinompronta ko na sya tungkol dito ngunit sya pa ang galit. Pati ang aming personal na away mag-asawa ay vinivideo nya at ginagamit p', 'Gusto ko itong matuldukan, kaya naman ay humingi na nang tulong sa tanggapan para mayroong mamagitan sa amin.', 'Paninirang puri ng paulit-ulit', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(128, 110, 76, '2023-03-16', 'Grove, Batong Malake, Los Baños, Laguna ', 'Grove, Batong Malake, Los Baños, Laguna ', '2024-03-25', '2023-03-07', 'Cynthia Labita & Careen Del Rosario', 'Bryan Morales', 'Noong March 5, 2023, kami ay sinigaw sigawan ni Bryan Morales. Hind kami makalaban sa kanya dahil lalaki sya. Ibinalibag din niya ang kanilang pinto ng pagkalakas lakas. Hindi lang ito unang beses nangyari ito, paulit ulit niya kami pinopurwisyo.', 'Dahil dito kami ay dumulog sa inyong tanggapan upang siya ay maipatawag at makausap ng may nanamagitan.', 'Paninigaw', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(129, 110, 76, '2023-03-17', '9255 San Antonio, Los Baï¿½os, Laguna', '10189 Batong Malake, Los Baï¿½os, Laguna', '2024-04-17', '2023-03-09', 'Rowena ValeÃ±a`', 'Maria Teresa Clemeno', 'Ako ay may utang kay Maria Teresa Clemeno ng halagang Php 30, 000 at andami kong naririnig na masasamang salita na sinasabi niya sa ibang tao. Pati ang iba kong utang sa iba sinasama pa sa usapin.', 'Gusto ko siyang makausap tungkol sa mga masamang salita na sinasabi nya.', 'Paninirang puri dahil sa utang', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(130, 110, 76, '2023-03-18', 'Batong Malake, Los Baños, Laguna', 'AD Tech (Contractor)', '2024-03-25', '2023-11-03', 'Marvin Justin V. Gonzales & Mark Jonas V. Gonzales', 'Joseph Siryan', 'Biyernes ng umaga Feb. 17, 2023, may nakita akong white spots sa kotse, nagpaCarwash ako ng mga 11:30am. Hindi natanggal ang mga spots sa harap, gilid at bintana ng sasakyan', 'Dahil dito gusto kong makausapang management ng Robinsons Town Mall Los Baños, dahil sila ang building na nagpipintura. Gustokong makipaglinawan dahil sa nangyari sa kotse.', 'Tulo ng pintura sa kotse', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(131, 110, 76, '2023-03-19', 'Batong Malake, Los Baños, Laguna', 'Batong Malake, Los Baños, Laguna', '2024-03-25', '2023-03-11', 'Leodencio Liag & Lawrence Liag', 'Leticia Garcia', 'Nagpunta kami dito upang pag usapan ang paghahati ng property sa Liag Compound, UPLB, Batong Malake. Bago namin ilapit ang usaping ito sa inyong tanggapan ay sumangayos sina Leticia Garcia.', 'Gusto namin dito sa Barangay Batong Malake Pag usapan ang paghahati ng property para mayroong mamagitan sa amin.', 'Paghahati ng Property', '', 'Others', 'Settled', 'Conciliation', 0, 0),
(132, 110, 76, '2023-03-20', 'Batong Malake, Los Baños, Laguna', 'Batong Malake, Los Baños, Laguna', '2024-03-25', '2023-03-13', 'Aniflor Minorca & Mylene Jimenez', 'Rojane E. Gatchalian', 'Si Rojane Gatchalian ay may utang sa akin noong taong 2020. Noong una nakakapagbayad naman siya ng maayos ngunit noong huli ay hindi na sya sa amin nagrereply, hindi rin siya nasagot sa tawag may balanse pa sya Php1,500.00', 'Nais namin siyang ipatawag para magkaroon ng linaw kung kailan nya mababayaran ang kanyang balanse.', 'Perang hinihiram na hindi binabayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(133, 110, 76, '2023-4-24', 'SITIO PAGKAKAISA, BARANGAY BATPNG MALAKE, LOS BAÑOS, LAGUNA', 'Collado Compound, Barangay Batong Malake, Los Baños Laguna', '2023-04-01', '2023-04-13', 'REMELLAS P. VENERAYON', 'Daryl L. Biag', 'Bandang 9:00am, ako ay pauwi na galing palengke, dumaan ako sa Collado Compd. dahil ito ay shortcut pauwi sa bahay. naglalakd ako ng bigla ako suntukin ni Daryl Biag. Ako ay natumba nung tatayo ako ay dun na ako gumanti. Hanggang sa inawat na kami. Ako ay', 'Dahil dito gusto ko siyang makaharap at pananagutin sa ginawa niya sa akin.', 'Panununtok sa hindi malaman na dahilan', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(134, 110, 76, '03-2023-21', 'Taal ST. Barangay Batong Malake, Los Baños, Laguna ', ' SITIO PAGKAKAISA, BARANGAY BATONG MALAKE, LOS BAÑOS, LAGUNA', '2023-03-21', '2023-03-21', 'Mylene V. Jimenez  /  Aniflor C. MInorca', 'Mary jane M. Gatchalian', 'Si Mary jane Gatchalian ay mayroong hiniram na pera sa amin na nagkakahalaga ng Php 5,000, ngunit hindi na nya kami binayaran ang oerang hinram nya ay noon  pang taon  6, 2020', 'Dumulong na kami dito sa inyong tanggapan upang maipatawag at makausap namin siya tugkol sa kanyang perang hiniram.', 'Perang hiniram na hindi binayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(135, 115, 1, '01-000-0424', 'Masili ', 'Masili', '2024-09-17', '2024-04-01', 'Jayson Cuason', 'Popoy Kaloy', 'Nagkasinitan sa basketball kaya nagkasuntukan', 'Ipagamot at magbayad sa pinsala', 'Nagkasuntukan', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(136, 110, 76, '03-2023-22', 'Sitio Riverside Barangay Batong Malake, Los Baños, Laguna', 'Sitio Riverside Barangay Batong Malake, Los Baños, Laguna', '2023-03-20', '2023-03-20', 'Richard Eduarte  / Frederick Gavanes /  Benjie De Leon /  Gemilliano Ramos Sr.  / Rodrigo Gavanes', 'Orlando Macam', 'Si Orlando Macam ay inerereklamo namin dahil kami ay pinagbabantaan na oras na kami daw ay makita, Kami daw ay papatayin nya. Nagagalit Sya Dahil Hindi Sya napayag sa oras ng bukas at sara ng gate ng UPLB. Kaya sya ay laging nagwawala', 'Dahilan para kami ay pumunta dito sa barangay upang sya ay makaharap at makausap.', 'Paulit ulit na pagwawala at pagbabanta', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(137, 110, 76, '03-2023-23', 'Jamboree site, Batong Malake, Los Baños, Laguna.', 'Jamboree site, Batong Malake, Los Baños, Laguna.', '2023-03-31', '2023-03-31', 'Zenaida M. Cabonce', 'Rhodora P. Talagtag', 'Inirereklamo ko si Rhodora Talagtag sa Kadahilanang sobra na po ang paninira sa akin sa SNSJ groupchat na nababasa ng lahat ng ebidensya nito ay mga screenshots na pinagsasabi nya sa aming groupchat.', 'Dahil dito, Nais ko pong makausap at makaharap si Rhodora dahil sa ginagawa nyang pagkakalat ng tsimis.', 'paninira at pagkakalat ng tsismis', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(138, 110, 76, '04-2023-25', 'Lot 4 Blk 2. Bay Gardens Subdivision, Bay Laguna,', '9001, Batong Malake, Los Baños, Laguna.', '2023-04-23', '2023-04-23', 'Anna T. Mendoza', 'Gino B. Villegas', 'Si Gino Villegas ay Humiram sakin ng PhP. 9,000 noong March 15 2023 at nangakong ibabalik sa katapusan ng March. Noong dumating ang March 31, Humingi po sya ng Palugit na isang Linggo. Pumayag ako Ngunit Dumating ang araw na sinabi nya  hindi pa rin sya n', 'Ako po ay Dumulog sa tanggapan nyo upang sya ay makausap, Para malaman kung bakit hindi na sya nasagot', 'hiniram na pera na hindi ibinalik', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(139, 110, 76, '04-2023-26', 'Bangkal Ext. San Antonio. LBL', 'Sierra Madre st., Batong Malake,', '2023-04-23', '2023-04-23', 'Priyashanta Nuñez', 'Louis Leaño', 'Nagtungo Ako sa Barangay upang ipatalq ang insidenteng nangyari sa akin na ako ay hinaras ni Louis Leaños. Dati ko syang boyfriend at boss din at the same time. Gustp ko na pong matigil ang panghaharas nya sa akin', 'Dahil dito gusto ko syang makausap at makaharap upang matigil na ang panghaharas nya sa akin.', 'Pang haharas', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(140, 110, 76, '2023-5-27', '10804 Sitio Riverside, B.Malake LBL', 'Sitio Riverside, B.Malake LBL', '2023-05-01', '2023-05-01', 'Arabelle S. Marcos ', 'Jenelyn Geronda / Loid Castillo', 'Sina Jenelyn Geronda at Loid Castillo ay nagkaroon ng utang sa akin noong October 30, 2022 ng halagang PhP 12,100 at hanggang ngayon ay hindi pa din nag babayad', 'Dahil dito Dumulog ako sa tanggapan ng Batong Malake upang sila ay maipatawag at magkalinawan kung kailan sila mag babayad.', 'Perang hiniram na hindi ibinalik', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(141, 110, 76, '2023-5-28', 'Calamba Laguna.', 'Market site, Barangay Batong Malake.', '2023-05-07', '2023-05-07', 'Rico L. Monreal', 'Genesis K. Pajo', 'Ako si Rico Monreal na Taga Calamba Laguna ako po ay nagpunta dito sa Brgy. Batong Malake upang isumbong si Genesis Pajo dahil sa Pagbabanta nya sa akin', 'Gusto ko syang ipatawag upang pag pagpaliwanagin kung bakit ako pinagbabantaan.', 'pagbabanta', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(142, 110, 76, '2023-5-29', 'Mary mount, Brgy Anos', 'Market site, Barangay Batong Malake.', '2023-05-09', '2023-05-09', 'Joshua Manggale/Rene Recto', 'Hanna Patricia Galag/Bryle Jhoben Lacbay Lynon Legisma/Timsanates/ Jamir Sombillo', 'Ang aming motor ay nagkaroon ng damage dahil sa isang rumble ng mga grupo ng aming inerereklamo', 'Gusto ko silang makausap upang mapagusapan ang naging damage ng aking motor', 'Nasirang motor dahil sa Away', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(143, 110, 76, '2023-5-30', 'Calauan Laguna', '9238, Barangay Batong Malake.', '2023-05-22', '2023-05-22', 'Rizamae Aguilar', 'Anjo Dela Paz', 'Si Anjo Dela Paz ay pagkakautang sa akin ng PhP 7,000 nais ko syang makaharap at makausap', 'Gusto ko syang maipatawag upang malinawan kung kailan ako babayaran', 'Hiniram na pera na hndi ibinalik', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(144, 110, 76, '2023-5-31', 'Sitio Maligaya, San Antonio Los Baños Laguna', 'Grove st, Barangay Batong Malake.', '2023-05-29', '2023-05-29', 'Carlo Alah', 'Michael Veron', 'Ako si Carlo Alah na taga Sitio Maligaya Barangay San Antonio. Nagtungo ako sa Brgy. Batong Malake, Hingil sa pananakit at panununtok sa akin ni Michael Veron ny, Taga Grove Batong Malake , Sa nangyaring ito ako ay nagpamedical may mga resetang gamot', 'Gusto ko syang makausap upang siya ay panagutin sa kanyang ginawa sa akin', 'Pananakit / Panununtok', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(145, 110, 76, '2023-6-32', '11456 Jamboree site L.B.L.', '10955 kanluran st. UPLB los Baños Laguna', '2023-05-31', '2023-05-31', 'Delia Domdom Tamayo', 'Bianca Alinq P. Saguin', 'Nagtungo ako sa Barangay Batong Malake, Upang Ireklamo si Bianca Saguin, Dahil sa aksidenteng nangyari sa akin', 'Nais kong makaharap si Bianca Saguin upang makausap sya dahil sa aksidente', 'Pakikipag linawan tungkol sa nangyaring Aksidente', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(146, 110, 76, '2023-6-33', 'Anos, Los Baños Laguna', 'Kanluran RD, UPLB Barangay Batong Malake Los Baños ', '2023-06-05', '2023-06-05', 'Ronaldo A. Banaticla', 'Jaime S. Reyes', 'Dumulog ako dito sa barangay Batong malake, Dahil Ako ay hinamon ng suntukan at tinakot ni Jaime Reyes', 'Dahil dito, Gusto ko syang makausap upang ipaliwanag nya kung bakit sya nagagalit sa akin', 'Paghahamon ng suntukan at pananakot', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(147, 110, 76, '2023-6-34', 'Blk.2 Lot 17 Mangga st.  Barangay san antonio Los Baños Laguna.', '10455 Grove st. Lopez Ave Batong malake', '2023-06-05', '2023-06-05', 'Edna N. Vacarizas ', 'Miguel Tecson', 'Si Mr. Miguel Tecson ay aming Boarder Ngunit ayaw na namin sya Irenew at magpatuloy pa sa pag upa sa amin', 'Nais namin sya makausap upang mapayapa syang umalis sa aming Boarding House', 'Mapayapang pagpapaalis sa aming tenant', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(148, 110, 76, '2023-6-35', 'Marymount Brgy. Anos LBL', 'Riverside. Lopez Ave Batong malake', '2023-06-06', '2023-06-06', 'Monina Gazelle Charina B./Carandang, Juan Miguel', 'Ryan Consibido', 'Mga 6:00 pm nakita ko si Ryan Consibido na nasa lobby ng Physci BLDG. Lumapit po sya sa amin. Hinarangan ko po sya at sinabing wag lumapit sinapak po nya ako sa ulo sya po ay tumakbo at sinundan namin nakita po namin  sya sa parking sa aming kotse sinaksa', 'Dahil dito gusto ko syang ipatawag upang makausap at pananagutin sa mga ginawa nya', 'Pananakit at Pambubutas ng kotse', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(149, 110, 76, '2023-6-36', '5123 Pulo, Cabuyao, Laguna', 'Purok 8, Forestry', '2023-06-09', '2023-06-09', 'Meliza R. Santos', 'Jefferson T. Salac', 'Si Jefferson T. Salac ay may pagkakautang sa akin halagang PhP 7,000 hanggang sa ngayon ay hindi pa rin nya ako binabayaran', 'Dahil dito gusto ko syang makaharap upang pag-usqpan kung kailan nya ako babayaran', 'Pakikipag linawan tungkol sa nahiram na  Pera', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(150, 110, 76, '2023-6-37', 'Jamboree site.', 'Jamboree site', '2023-06-19', '2023-06-19', 'Kreslelyn Narvaez', 'Jennifer Gonzales', 'Bandang alas 8:00 pm June 19 2023 Pumasok si Jennifer sa kwarto naming mag asawa at kung anu ano sinabe tungkol sa akin, Around 10pm June 19 nag away po kaming mag asawa at nakialam sya kung anu ano ang sinabe at sinigawan ako sinampal nya ako ng ilang be', 'Gusto ko syang makausap para matigil na ang ginagawa nya sakin', 'Pagsasabi ng masamang salita at pananakit', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(151, 110, 76, '2023-6-38', '9064 Batong Malake', '9060 Batong Malake', '2023-06-21', '2023-06-21', 'Adora Collado', 'Marcial Mupal', 'June 13 ng gabi may inuman sa tindahan nya sinabihan ko sya na hinaan ang videoke at sigawan nila dahil may mga bata at student. Bigla syang sumigaw at nag wala nagmura lumabas sa bahay at nag sisigaw kung anu ano ang sinasbae halos lumuea ang mata sa gal', 'Dahilan nito gusto na namin sya paalisin sa inuupahan upang hindi na maulit ang ganun pangyayare', 'Pag- iingay at Pagwawala', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(152, 110, 76, '2023-7-40', 'Riverside, Batong Malake, LBL', 'Riverside.Batong Malake.', '2023-07-05', '2023-07-05', 'Rebecca G. Licaros ', 'Arlene Perez / Aljur Q. Garbanzos', 'Si Arlene Perez ay kumuha sa akin ng bigas na nagkakahalaga ng PhP 1,200 noong nakaraan May 11, 2023 ngunit hanggang  ngayon ay hindi na nya ito binabayaran ang itinuturo nyang mag babayad ay ang kanyang kinakasamang si aljur Garbanzos', 'Dahil dito Gusto ko  silang makausap at malinawan kung kailan nila ako babayaran', 'Hindi binayaran na bigas', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(153, 110, 76, '2023-7-41', '9797 Jade st.  Batong Malake', 'Revilleza Compound Batong Malake', '2023-07-10', '2023-07-10', 'Aida Biglete ', 'Untoy Patoc', 'Ako ay nagpagawa ng elektrikpan kay untoy patoc ako ay nagbigay ng PhP 1,000 para sa pyesa kasama na rin ang Repair Ngunit hindi nya ako binalikab', 'Gusto ko syang makaharap at maibalik sa akin ang electrikpan na maayos at gumagana ', 'Pakikipaglinawan Tungkol sa Pinagawang ELectric Fan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(154, 110, 76, '2023-7-42', '716 Purok 7   Brgy. Malinta Los Baños', 'Sitio Pagkakaisa Batong Malake', '2023-07-11', '2023-07-11', 'Nestor Monte Castro Frondoso', 'Marjorie Joy Eroles', 'Si Joy Eroles ay  utang sa akin Halagang PhP 4,300 ngunit mula ng humiram sya sa akin ay hindi na sya nag babayad', 'Gusto ko syang makausap para malaman kung kailan sya mag babayad sa akin', 'Perang Hiniram na hindi Binayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(155, 110, 76, '2023-7-39', 'Blk. 3 lot 2 Everlasting St. TS. Las Piñas  city', '9304 -B Mt. Taal St. Umali subd. Barang Batong Malake.', '2023-07-03', '2023-07-03', 'Russel Sabandal', 'Cesar Grajo', 'Ako po ay nagrereklamo ako ay nag rent kay Mr. Grajo nagpa reserve ako noon June 5, 2023 Nag Txt sya na due date ko daw po na hindi pa po ako nakakalipat ang usapan ay ibibigay ko ang 1month sa down payment pag ako ay nakalipat na.', 'Dahil dito gusto ko syang makaharap upang makipaglinawan may Mr. Gajo', 'Pakikipaglinawan Tungkol sa Reservation Fee ng Apartment', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(156, 110, 76, '2023-7-43', 'Bagong Kalsada', 'Jamboree site', '2023-07-11', '2023-07-11', 'Christian N. Navarez/kreslelyn N. Navarez', 'Marina Gonzales', 'Si Marina Gonzales ay binili ang aming Tricycle ngunit may balanse pa itong PhP 5.000 Hanggang ngayon ay hindi pa nya ito nababayaran', 'Nais ko syang makausap upang ako ay kanyang bayaran', 'Usapin tungkol sa Tricycle na ibinenta', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(157, 110, 76, '2023-7-44', 'Faculty village Batong Malake', 'Faculty Village Batong Malake', '2023-07-17', '2023-07-17', 'Armain Doñasales / Patricia Marie Villacetan', 'Ritchee Yee', 'Si Ritchee Yee ay ilang beses na naming sinasabihan na wag mag park sa tapat ng aming bahay dahil ito ay gagamitin na namin kagabi, Nilagyan na namin ito ng no parking na sign ngunit pag uwi namin ito ay sira sira na pati na rin ang aming nga halaman', 'Gusto namin sya makausap at pagpaliwanagin tungkol sa kanyang ginawa', 'Pakikipaglinawan Tungkol sa Parking at Paninira ng SIgnage at Halaman', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(158, 110, 76, '2023-7-45', 'Brgy. Putho Tuntungin Los Baños ', 'Lopez Ave. Brgy Batong Malake ', '2023-07-19', '2023-07-19', 'Isidra Concepcion', 'Maria Belen Quizon', 'Si Maria Belen Quizon ay may pagkakautang sa akin hanggang ngayon ay hindi pa nya ako Binabayaran', 'Gusto ko sya makausap para makipagpalinawan sa kanya kung kailan nya ako babayaran', 'Perang Hiniram na Hindi Binayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(159, 110, 76, '2023-8-46', 'Riverside Batong Malake ', 'Riverside Batong Malake ', '2023-08-02', '2023-08-02', 'Rebecca Licaros ', 'Helen Garbansos', 'Si Helen Garbansos ay may pagkakautang sa akin nang  Nagkakahalagang Php 2,533 Hanggang Ngayon ay di pa nya binabayaran', 'Gusto ko syang makausap upang malaman kung kailan nya ako babayaran', 'Perang hiniram na Hindi Binayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(160, 110, 76, '2023-8-47', ' Batong Malake , Los Baños Laguna', '10809 Sitio Riverside Batong Malake ', '2023-08-07', '2023-08-07', 'Roland E. Martinez /Maria Clarissa M. Adovas ', 'Jovelyn O. Corda ', ' Nagtungo ako dito sa Barangay Batong Malake Upang humingi ng tulong na makausap si Jovelyn Corda dahil ang aming Dinadaanan patungo sa bahay namin ay pag aari nya ngunit ito ay babakuran nya', 'Dahilan nito ay wala kaming madadaanan kaya gusto ko sya makausap Upang makiusap na baka kami ay mabigyan nya ng kahit kapirasong madadaanan', 'Pakikipag linawan Tungkol sa Itinayong bakod', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(161, 110, 76, '2023-8-48', ' 10809 Sitio Riverside Batong Malake ', ' Batong Malake ', '2023-08-07', '2023-08-07', 'Jovelyn O. Corda', 'Roland E. Martinez / Maria Clarissa', 'Sina Roland Martinez at Maria Clarissa Adouas ay aking inirereklamo dahil sa pagsisiga nila at ang isa pa ay ang kanilang mga aso', 'Gusto ko silang makaharap upang makipaglinawan', 'Pakikipaglinawan tungkol sa aso at uso ng siga', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(162, 110, 76, '2023-8-49', 'Purok 6 Riverside Batong Malake ', 'Riverside  Batong Malake ', '2023-08-09', '2023-08-09', 'Arlene P. Miranda', 'Angelo Garbansos ', 'Si Angelo Garbansos ay nagbanta noong linggo ng gabi August 6, 2023 Hindi na daw bale na makulong sya bastaapatay lang daw ako Hindi ako makauwi sa amin dahil sa pag babanta nya noong uns ako ay minumura lang  nya hanggang sa sya ay nag wala na', 'Dahil dito gusto ko siyang kausapin na itigil na ang ginagawa nya sa akin', 'Pagbabanta', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(163, 110, 76, '2023-8-50', 'Batong Malake', 'Batong Malake', '2023-08-13', '2023-08-13', 'Jessica Caraga', 'Verminda Santos', 'Ako ay nagpunta dito sa Barangay Batong Malake upang Ireklamo si Verminda Santos Dahil sa parking ng kanyang mga Customer', 'Dahil dito gusto ko siyang makausap upang ang parking namin ay hindi na magamit ng kanilang Customer.', 'Usapin tungkol sa Parking', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(164, 110, 76, '2023-9-51', '9172  sitio pagkakaisa  Brgy, Batong Malake', '9172 sitio pagkakaisa ', '2023-08-30', '2023-08-30', 'Reinna M. Salazar', 'Mary Jean Poche/Daria Casale', 'Nag punta ako dito sa brgy upang ipaalam ang hindi pagbabayad ng renta at hindi pagbabayad ng mga bills ni Mary Jean Poche at Daria Casale', 'Dahil dito, Gusto ko sila makausap para maisettle and mga bayarin nila', 'pagpapaalis sa apartment sa maayos na paraan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(165, 110, 76, '2023-9-52', 'Umali subdivision barangay batong malake ', 'Umali subdivision barangay batong malake ', '2023-09-03', '2023-09-03', 'Abigail Mendoza ', 'Carla delos santos ', 'Ako si abigail Mendoza , nagtungo ako dito sa Brgy, upang ireklamo si carla delos santos dahil sa mali nyang kinikwento sa aming mga kapitbahay.', 'Gusto ko siyang makaharap, para itigil na nya ang mga maling kinikwento nya sa mga kapitbahay.', 'Pagkalat ng tsismis', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(166, 110, 76, '2023-9-53', 'Diamong Ext., Batong malake ', 'Sitio Sipit Barangay Batong malake', '2023-09-10', '2023-09-10', 'Ayo Beth D. Pena / Beth Dumagat / Anne D. Vallejera / Lorna Escobin / Andres Dumagat', 'Carlos Aquino / Dexter Cabahuy', 'Si carlos Aquini at Dexter Cabahug ay gustoilong makausap tungkol sa basura ng sitio sipit Homeowners, Ang barusahan kasi nila ay nasa gilid ngaming bahay ito ay nagdudulot ng mabahong amoy.', 'Dahil dito gusto namin makausap sila para magawaan ng paraan at maging maayos ang basurahan.', 'Pakikipaglinawan Tungkol sa Basura', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(167, 110, 76, '2023-9-55', 'BRGY. bayog Los baños, Laguna', 'Sitio Pagkakaisa, Batong Malake Los Baños, Laguna ', '2023-09-18', '2023-09-18', 'Joshua Angeles / Mary grace Vargas ', 'Jed Jordan Oca / Bernalyn Oca ', 'Ako si Joshua Angeles taga BRGY. Bayog ,nagkakaroon ng aksidenteng Banggaan ,at ako po ay handang makipag- usap sa kanila.', 'dahil sa aksidenteng nangyari gusto kong makaharap sila at makausap.', 'Aksidenteng Banggaan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(168, 110, 76, '2023-9-56', 'OB Purok , Barangay Batong malake ', 'OB Purok , Barangay Batong malake', '2023-09-23', '2023-09-23', 'Mark Toledo ', 'Kieser Maranan ', 'Ako si Mark Toledo , ako ay pinagbabantaan ni kieser Maranan pinagbabantaan nya ako sa hindi ko malaman na dahilan.', 'Gusto ko siyang makausap para malaman ang dahilan kung bakit nya ako pinagbabantaan.', 'Pagbabanta', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(169, 110, 76, '2023-9-57', 'El Danda ST. Barangay Batong Malake ', 'El Danda ST. Barangay Batong Malake', '2023-09-25', '2023-09-25', 'Rolando Manaig ', 'Kenneth Villegas ', 'Ako si Roalando Manaig ako ay taga El Danda Batong Malake, Ako ay sinuntok ni Kenneth Villegas.', 'Dahil dito gusto ko syang ipatawag at makausap.', 'Panununtok', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(170, 110, 76, '2023-10-59	', 'Batong Malake L.B.L.', 'Batong Malake L.B.L.', '2023-10-01', '2023-10-01', 'Rolando Aguirre ', 'Bessi Alforja', 'Si Bessie Alforja ay mayroong pagkakautang sa akin sya ay may balance pa sa akin hanggang ngayon ay hindi pa rin nya ako binabayaran', 'Gusto ko syang makausap upang pag usapan ang kanyang balance', 'Perang hiniram na hindi Binayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(171, 110, 76, '2023-10-60', 'Batong Malake L.B.L', 'FO Santos Batong Malake L.B.L.', '2023-10-01', '2023-10-01', ' Amador  A Cube ', 'Alvin Jocson Cube', 'Si Alvin Jocson Cube ay aking inerereklamo dahil ginamit nya ang pangalan ko sa pagkakabit ng internet.', 'Gusto ko syang makaharap at makausap kung bakit nya ginamit ang pangalan ko.', 'Paggamit ng pangalan sa pagkakabit ng internet', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(172, 110, 76, '2023-10-61', '9588 Sitio sipit Batong Malake L.B.L.', '34 Revilleza CompoundBatong Malake L.B.L.', '2023-10-03', '2023-10-03', 'Violeta A. Casubha', 'Christopher N. Escobin ', 'Si Mr, Christopher Escobin ay umupa sa akin Ngunit nung sya ay umalis Mayroon syang utility bills na hindi nabayaran', 'Gusto ko na ipatawag sya upang pag usapan ang naiwan utang sa mga bills.', 'Pakikipaglinawan sa renta at kontrata', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(173, 110, 76, '2023-10-62	', '9635 Taal Extension Batong Malake L.B.L.', 'Batong Malake L.B.L.', '2023-10-03', '2023-10-03', 'Ma. Laarni Ocampo /Alliyah Louise C. Ocampo / Ericson Salcedo ', 'Alfred Lorenze Ocampo /Giohsua Opulencia/ James Ashley Quinta/ Adrian Llagas', 'Si Alfred Ocampo at ang kanyang mga kaibigan ay bisita ng aking anak, Nang biglang si Alfred ay pang nagwawala na at inaaway ako pati ang aking kinakasama dahilan ng kaguluhan sa party ng aking anak.', 'Dahil dito gusto kong magpaliwanag si Alfred at ang kaniyang mga kaibigan kung bakit nagkaroon ng kaguluhan.', 'Panggulo Pananakit at Pagbabanta', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(174, 110, 76, '2023-10-63', 'Ilag Compound Batong Malake L.B.L.', 'Ilag CompoundBatong Malake L.B.L.', '2023-10-08', '2023-10-08', 'Kyla mae P. Simbajon/Gayle Therese L. Parco/Ma. Jillian L. Parco/Carla S. Redondo', 'Letticia Garcia/Virgilia Conception/ Amilene Pua ', 'Nais naming mabawi ang aming deposit na nagkakahalaga ng Php 8,000 kay Virgilia  Conception dahil yung property ay naibenta na pala', 'Dahil dito gusto naming syang ipatawag upang makaharap at makausap', 'Pag bawi  sa deposit ng apartment', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(175, 110, 76, '2023-10-64', 'Sitio Riverside Batong Malake L.B.L.', 'Sitio Riverside Batong Malake L.B.L.', '2023-10-10', '2023-10-10', 'Irene p. Saguin', 'Arlene Garbanzos ', 'Ako ay bumili ng washing machine kay Arlene Garbanzos at ako ay nakabayad ng buo ngunit gusto nya tong kunin bawiin noong ako ay hindi pumayag dahil gusto kong ibalik din nya ang bayad ko ay sinabihan nya ako ng Burikat', 'Gusto kong linawin ang sinabi nya gusto ko syang makaharap', 'Pakikipaglinaw tungkol sa washing machine', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(176, 110, 76, '2023-10-65', '11145 Angeles AT, Mayondon', 'Bangkal Ext. Batong Malake L.B.L.', '2023-10-10', '2023-10-10', 'Micah M. Santos', 'Sarah Himongala ', 'Si Sarah Himongala ay nagkakalat ng maling impormasyon ako daw ay hatid sundo sa bahay ni John  Michael Mahipos at ito ay ikinagalit ng aking asawa', 'Gusto kong makaharap at makausap si Sarah upang makipaglinawan', 'Pagkakalat ng maling impormasyon', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(177, 110, 76, '2023-10-66	', '158 Barangay Malinta LBL', 'Batong Malake L.B.L.', '2023-10-10', '2023-10-10', 'John Carlo T. Laurel', 'Jomari P. Mula Cruz 	', 'Ako si John Carlo T. Laurel, nagtungo ako dito sa brgy. Upang ipatala ang nangyari sa aking sasakyan nagasgasan ito ni Jomari P. Mula Cruz gusto ko sana sya makausap', 'Gusto ko makaharap upang pagusapan ang nagasgasan kong sasakyan.', 'Nasagasaan na sasakyan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(178, 110, 76, '2023-10-67', '#57 Dona Aurora Up campus Batong Malake L.B.L.', 'Demarces subd.  Batong Malake L.B.L.', '2023-10-17', '2023-10-17', 'Rydz R Rivera', 'Dennis A.Servañez ', 'Ako si Rydz Rivera taga 57 Doña aurora UPLB. Ako po ay naaksidente sa daan ni dennis Servañez taga demarces subd.	', 'Dahil dito gusto ko syang makausap dahil sa nangyaring aksidente', 'Aksidente sa daan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(179, 110, 76, '2023-10-68', 'Purok 6 Tuntungin Putho', '10336 lopez ave. Batong Malake L.B.L.', '2023-10-16', '2023-10-16', 'Rubylyn B. Pelagio', 'Einnor Lait ', 'Si Einnor A. Lait ay aking tauhan na taga 10336 Batong Malake Los Baños Laguna ako ay nawalan ng pera sa kaha s halagang 42,000', 'Gusto kong makaharap sa Einor upang makipaglinawan tungkol sa nawawalang pera sa kaha', 'Nawawalang pera sa kaha', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(180, 110, 76, '2023-10-69', 'Malinta Los Baños Laguna', 'Nuñez Compound Batong Malake L.B.L.', '2023-10-20', '2023-10-20', 'Elizamae C. Peligrina/ Prince Bary Peligrina', '	Alvin Montecillio', 'Ako si Elizamae Pelegria nanay ni Prince barry Peligrina ay nagpunta sa brgy hingil sa referee na si Alvin Montecillo Nuñez cmpd. Ayon sa aking anak ay inaabangan nito at pinagsisigawan.', 'Gusto ko makaharap ang referee na si Alvin Montecillo upang ipaliwanag nya bakit nya sinisigawan ang anak ko .', 'Pagaabang at pagtataas ng boses', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(181, 110, 76, '2023-11-70', 'Sitio Villegas  Batong Malake L.B.L.', 'Bungalo F. Dona Aurora UPLB Batong Malake L.B.L.', '2023-11-05', '2023-11-05', 'Rolando Maat', 'Monica Saez ', 'Ang aking motor N Maxiss, Matt black ay naatrasan at natumba ito ay nagkaroon ng mga gasgas at ito ay naatrasan ng kotse na minamaneho ng anak ni allen peter saez	', 'Gusto ko silang makausap upang maipaayos ang aking motor', 'Nasaging motor', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(182, 110, 76, '2023-11-71	', 'Purok 1 OB  Batong Malake L.B.L.', 'Purok 1 OB Batong Malake L.B.L.', '2024-04-02', '2023-11-07', 'Leni Reyes', 'Narciso Manigbas  ', 'Ako si Leni Reyes taga OB purok 1 batong malake ay hindi na matiis ang aso ni Narciso manigbas na taga OB purok 1 dahil sa paghahalukay ng basura ng aso nya at ito ay nagdudulot ng kalat s aming property at dahil dito ako ay pinagmumura nya at pinag banta', 'Gusto ko po syang makausap upang magpaliwanag bakit nya ako pinagmumura at pinagbantaan.', 'Pag mumura at pag babanta', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(183, 110, 76, ' 2023-11-72', '9010 Sitio Ulik Mabcanc Calauan', '11451 kanluran st. UPCO Batong Malake L.B.L.', '2023-11-13', '2023-11-13', 'Steven L. Ballesteros ', 'Abigail M. Natanauan', 'Si Abigail Natanauan ay may pagkakautang sakin sa halagang 4,307 Hanggang ngayon hindi pa sya nagbabayad', 'Dahil dito gusto ko sya makausap at makaharap', 'Peran hiniram na Hindi Binayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(184, 110, 76, '2023-11-73', '9324 Lopez Ave.  Batong Malake L.B.L.', 'Manzano Apartments Batong Malake L.B.L.', '2023-11-14', '2023-11-14', 'Ingrid Bianca Manzano/Doris Manzano', 'Rene Paul Manzano ', 'Ako si Ingrid Bianca Manzano at Doris Manzano ay nagpunta sa Brgy upang ipaalam ang nangyari sa aming bakuran ang malimit na pagkakalat ng gamit sa sakop ng aming pwesto nagkakalat at palagi ang pang hahamit ni Rene Paul Manzano', 'Gusto naming syang makaharap at makausap para matigil na ang pagkakalat nito', 'Panghahamit', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(185, 110, 76, '2023-11-74', 'Manzano Apartments Batong Malake L.B.L.', '9324 Lopez Ave.  Batong Malake L.B.L.', '2023-11-14', '2023-11-14', 'Rene Paul Manzano', 'Ingrid Bianca Manzano/Doris Manzano/Marica Manzano/John Derry Manzano', 'Ako po si Rene Paul Manzano nagtungo ako dito sa brgy upang ipaalam ang pagbabanta paninirang puri nila Doris,Ingrid,Monica,John Deryl Manzano pati narin ang panlalait at pagsasalita ng hindi maganda sa akin at trespassing', 'Gusto ko silang makausap at makaharap upang ipaliwanag nila ang kanilang ginawa sa akin', 'Pagbabanta/paninirang puri/   pisikal na pananakit / verbal abuse at trespassing', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(186, 110, 76, '2023-11-75', '10813 sitio riverside.  Batong Malake L.B.L.', 'Sitio riverside  Batong Malake L.B.L.', '2023-11-19', '2023-11-19', 'Jenelyn Mayores Geronda', 'Romulo Dacuya ', 'Ang akin pamangkin ay nakagat ng aso nila Romulo Dacuya at ito ay pinadaka sa albularyo ngunit sabi ng albularyo ay dapat maturukan ang bata ngunit hanggang ngayon ay hindi nakikipag usap ang may ari ng aso', 'Gusto ko siyang makausap upang mapagusapan ang pag babayad sa gastos sap pag papaturok.', 'Nakagat ng aso ng kapitbahay', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(187, 110, 76, '2023-11-76', 'Sn. Antonio Los Baños Laguna', 'Sitio Villegas Batong Malake L.B.L.', '2023-11-21', '2023-11-21', 'Jayson S. Verdana', 'Bonifacio A. Igot Jr/Mariecris Plaza', 'Si Bonifacio Igot dahil sya ay may kulang pa sa akin na nagkakahalaga ng Php 40,550 hanggang ngayon hindi pa sya nakikipagugnayan', 'Dahil dito gusto ko syang makausap upang malaman kung kalian nya ako babayaran.', 'Hiniram nap era na hindi binayaran', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(188, 110, 76, '2023-12-77', '9929 katinglad st. villegas  Batong Malake L.B.L.', '0313 katinglad st. villegas  Batong Malake L.B.L.', '2023-12-03', '2023-12-03', 'Lizbeth T. Gonzales/Marianne M. Villanueva', 'Jerome S. Dela Cruz', 'Kami si Marianne Villanueva at Lizbeth Gonzales inerereklamo naming si Dela Cruz dahil sa pambabastos nya sa aming mga larawan ng walang paalam', 'Dahil dito gusto naming makausap si Jerome Dela Cruz upang pagpaliwanagin kung bakit binastos ang aming larawan', 'Pang aasar at Panghahamit', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(189, 110, 76, '2023-12-79', 'Enzos ramen Ruby ST. Batong Malake L.B.L.', 'Lopez Ave. Batong Malake L.B.L.', '2023-12-24', '2023-12-24', 'Emanuel G. Reyes', 'Christopher N. Escobin', 'Gusto kong ireport ang nagyari sa aking sasakyan kahapon nasagi ito ni Karyl Cabonce sya ay walang lisensya sya ay tauhan ni Christoper Escobin nagkaroon ng damage ang akin sasakyan', 'Gusto kong mabayaran nila ang gastos sa pagpapaayos ng aking sasakyan. Dahil hindi lahat ng gastos ay covered ng insurance', 'Sagian ng Sasakyan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(190, 110, 76, '2023-12-80', 'UPCO. Batong Malake L.B.L.', '3196 Batong Malake L.B.L.', '2023-12-26', '2023-12-26', 'Andrew Esguerra', '	Jerick B. Eusebio', 'Si Jerick Eusebio ay inerereklamo ko siya ay may utang sa akin nagkakahalaga ng Php 1,000 hanggang ngayon ay hindi nya pa ako binabayaran.', 'Gusto ko syang makaharap upang ako ay kanyang mabayaran.', 'Pakikipaglinawan tungkol sa perang hiniram', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(191, 115, 1, '02-000-0424', 'tadlac', 'tadlac', '2024-04-15', '0000-00-00', 'Angel May L. De Guzman', 'Gina Gomez', 'Isang taon na hindi nakakapagbayad sa napagusapan na utang. Noong January 2023 nangutang siya ng limang libo sa akin, ipinangako niya na sa isang linggo pagkarating ng sahpd ng asawa ay magbabayad siya. Subalit ngayon ay taong 2024 na perohindi parin siya', 'magbayad ng utang ayon sa napagkasunduang araw. ', 'Tumults and other disturbances of public order; Tumltuous disturbances or interruption liable to cause disturbance (Art. 153)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(192, 115, 1, '03-000-0424', 'tadlac', 'tadlac', '2024-04-11', '0000-00-00', 'Erning Diamonddd', 'Popoy Kaloy', 'Isang taon na hindi nakakapagbayad sa napagusapan na utang. Noong January 2023 nangutang siya ng limang libo sa akin, ipinangako niya na sa isang linggo pagkarating ng sahpd ng asawa ay magbabayad siya. Subalit ngayon ay taong 2024 na perohindi parin siya', 'magbayad ng utang ayon sa napagkasunduang araw, nais kong singilin na may dagdag na tub si Mang Erning sapagkat ang due ng kanyang utang ay lagpas lagpas sa napagkasunduang araw. Ang napagkasunduan na bayad ay 15k ngunit nais ko siyang tubuan pa ng 10k pa', 'Unlawful use of means of publication and unlawful utterances (Art. 154)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(193, 115, 1, '03-000-0424', 'tadlac', 'tadlac', '2024-04-11', '0000-00-00', 'Erning Diamonddd', 'Popoy Kaloy', 'Isang taon na hindi nakakapagbayad sa napagusapan na utang. Noong January 2023 nangutang siya ng limang libo sa akin, ipinangako niya na sa isang linggo pagkarating ng sahpd ng asawa ay magbabayad siya. Subalit ngayon ay taong 2024 na perohindi parin siya', 'magbayad ng utang ayon sa napagkasunduang araw, nais kong singilin na may dagdag na tub si Mang Erning sapagkat ang due ng kanyang utang ay lagpas lagpas sa napagkasunduang araw. Ang napagkasunduan na bayad ay 15k ngunit nais ko siyang tubuan pa ng 10k pa', 'Unlawful use of means of publication and unlawful utterances (Art. 154)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(194, 115, 1, '03-001-0424', 'Masili ', 'Masili', '2024-08-11', '0000-00-00', 'Angel May L. De Guzman', 'Aaron Banaag', 'Isang taon na hindi nakakapagbayad sa napagusapan na utang. Noong January 2023 nangutang siya ng limang libo sa akin, ipinangako niya na sa isang linggo pagkarating ng sahpd ng asawa ay magbabayad siya. Subalit ngayon ay taong 2024 na perohindi parin siya', 'magbayad ng utang ayon sa napagkasunduang araw', 'Alarms and Scandals (Art.155)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(195, 110, 76, '2023-9-58', 'Umali subdivision barangay batong malake ', 'Sitio Villegas, Batong malake Los Baños , Laguna ', '2023-09-27', '2023-09-27', 'Jayous Neil Tabaquero/ Fe P. Sangre', 'Anthony D. Tagana ', 'Kami si Jayous Neil Tabaguero at Fe P. Sangre , Kami ay dumulog dito sa BRGY upang ireport ang aming nasangkutang aksidente ni MR. Anthony Tagana.', 'Dahil dito gsto ko syang makaharap at makausap upang mapagusapan ang nangyaring aksidente.', 'Aksidenteng Banggaan', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(196, 110, 76, '2023-9-54', '10012 Halcon St. Barangay Batong malake', 'JP Heritage Dormitory , Kitanlad St. Barangay Batong malake ', '2023-09-13', '2023-09-13', 'Yoshiki R. Daranciang ', 'Rose Isip', 'SI Rose Isip ay aking Ininireklamo  dahil sa hindi nya pagtupad sa usapan na ibalik ang downpayment at deposito sakin.', 'Gusto ko syang ipatawag upang makausap at maibalik ang akin pera.', 'Pagbawi sa Deposito at upa sa apartment', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(197, 115, 1, '04-023-0424', 'Purok 6A Bambang Los Banos Laguna', 'Purok 4 Libis Lalakay Los Banos Laguna', '2024-08-16', '2024-04-05', 'Glenndel Paccial', 'Kyle Pamplona', 'I wish to complain about ____ (name of product or service, with serial number or account number) that I purchased on ____ (date and location of transaction). I am complaining because ____ (the reason you are dissatisfied). To resolve this problem I would ', 'A complaint letter format will typically begin with the sender\'s details, followed by stating who it\'s addressed to, the date, and then the letter itself. The opening paragraph should state your reason for writing, and the meat of the text will go into de', 'Alarms and Scandals (Art.155)', '', 'Civil', 'Settled', 'Mediation', 1, 0),
(198, 115, 1, '03-000-0424', 'Masili ', 'tadlac', '2024-09-17', NULL, 'Sarah', 'Popoy Kaloyube', 'Isang taon na hindi nakakapagbayad sa napagusapan na utang. Noong January 2023 nangutang siya ng limang libo sa akin, ipinangako niya na sa isang linggo pagkarating ng sahpd ng asawa ay magbabayad siya. Subalit ngayon ay taong 2024 na perohindi parin siya', 'magbayad ng utang ayon sa napagkasunduang araw. ', 'Unlawful use of means of publication and unlawful utterances (Art. 154)', '', 'Civil', 'Unsettled', 'Pending', 1, 0);
INSERT INTO `complaints` (`id`, `UserID`, `BarangayID`, `CNum`, `CAddress`, `RAddress`, `Mdate`, `RDate`, `CNames`, `RspndtNames`, `CDesc`, `Petition`, `ForTitle`, `Pangkat`, `CType`, `CStatus`, `CMethod`, `IsArchived`, `seen`) VALUES
(199, 110, 76, '2023-12-78', '2479 Tuntungin Putho, Los BaÃ±os, Laguna', 'Ruby St., Umali Subd., Batong Malake, Los BaÃ±os, Laguna', '2023-12-03', '2023-12-03', 'Erlinda M. Obrince', 'Michael Nicdao, Carla NIcdao', 'Gusto kong makausap sina Michael Nicdao at Carla Nicdao upang ipaalis ang kanilang PVC na inilagay sa aking kanal na ipinagawa. Ito ay kanilang inilagay ng walang paalam.', 'Gusto ko silang makausap para itanong bakit hindi sila nagpaalam sa akin bago nila ilagay ang PVC.', 'Pakikipaglinawan Tungkol sa Kanal', NULL, 'Civil', 'Unsettled', 'Pending', 0, 0),
(200, 115, 1, '04-000-0424', 'tadlac', 'Masili', '2024-08-22', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam orci risus, tincidunt nec felis nec, finibus dapibus augue. Cras id luctus neque. In hac habitasse platea dictumst. Duis convallis ex non lacus facilisis pulvinar. Vivamus tristique risus at', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam orci risus, tincidunt nec felis nec, finibus dapibus augue. Cras id luctus neque. In hac habitasse platea dictumst. Duis convallis ex non lacus facilisis pulvinar. Vivamus tristique risus at', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam orci risus, tincidunt nec felis nec, finibus dapibus augue. Cras id luctus neque. In hac habitasse platea dictumst. Duis convallis ex non lacus facilisis pulvinar. Vivamus tristique risus at', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam orci risus, tincidunt nec felis nec, finibus dapibus augue. Cras id luctus neque. In hac habitasse platea dictumst. Duis convallis ex non lacus facilisis pulvinar. Vivamus tristique risus at', 'Alarms and Scandals (Art.155)', '', 'Civil', 'Unsettled', 'Pending', 1, 0),
(201, 110, 76, '2024-1-04', '9178 El Danda, Batong Malake, Los BaÃ±os, Laguna', 'El Danda, Batong Malake, Los BaÃ±os, Laguna', '2024-04-17', '2024-01-15', 'Melinda Villarmino', 'Raquel Cabrera Flores, Monica Agtuca Mendoza', 'Ako ay nagtungo sa tanggapan ng Barangay Batong Malake upang ireklamo sina Raquel Cabrera Flores at Monica Agtuca Mendoza dahil sa pagmumura sa akin kanina January 14, 2024, 7:50 ng umaga at paulit-ulit na pagpaparinig sa akin tuwing dadaan ako sa kanila.', 'Gusto ko sila makausap sa barangay upang matigil na ang ginawa nila sa akin.', 'Pagmumura at Pagpaparinig ng Paulit-ulit', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(202, 110, 76, '2024-1-05', '9172 El Danda, Barangay Batong Malake, Los BaÃ±os, Laguna', '9178 El Danda, Batong Malake, Los BaÃ±os, Laguna', '2024-04-17', '2023-01-16', 'Monica A. Mendoza', 'Melinda Garcia Villarmino', 'Ako si Monica A. Mendoza nagtungo sa tanggapan ng Barangay Batong Malake, Los BaÃ±os, Laguna upang ireklamo si Melinda Garcia Villarmino dahil sa pagpapalayas niya sa amin at pamimilit ng pagpapalabas ng Titulo, wala kaming titulo kundi kontrata ang hawak', 'Ang nais namin ay makausap sila at magbigay sila ng patunay na sa kanila ang lupa na inuupahan namin.', 'Pagpapalayas at Pamimilit na Pagpapalabas ng Titulo', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(203, 110, 76, '2024-1-06', '10329 Ruby St., Los BaÃ±os Subd., Batong Malake, Los BaÃ±os, Laguna', 'Batong Malake, Los BaÃ±os, Laguna', '2024-04-17', '2024-01-16', 'Maharlinda S. Asuncion', 'Marlene C. Francia', 'Ako po si Ginang Maharlinda S. Asuncion may-ari ng tuta na si Marta breed pure Chihuahua. Namatay noong January 12, 2024. Sa kadahilanan na kinagat ng aso nina Ginang Marlene Francia sa tapat ng bahay nila noong nabuksan ang gate nila. Kinagat sa ulo at t', 'Gusto ko makaharap ang may-ari ng aso na pumatay kay marta para panagutan yung action at responsibility bilang may ari ng aso na pumatay.', 'Asong Pinatay ng Aso ng Kapit-bahay', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(204, 110, 76, '2024-1-07', 'Barangay Bayog, Los BaÃ±os, Laguna', 'Batong Malake, Los BaÃ±os, Laguna', '2024-04-17', '2024-01-23', 'Rommel Alvarado', 'Harvard Hernani', 'Nagtungo po ako sa tanggapang ng Barangay Batong Malake para ireklamo ang aking contractor na si Harvard Hernani sa hindi pagbabayad sa nagawa naming trabaho.', 'Nais namin siya makausap sa barangay upang makipaglinawan at mabayaran ang ginawa naming proyekto.', 'Hindi Pagbabayad sa Nagawang Kontrata o Proyekto', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(205, 110, 76, '2024-2-08', '6728 Bangkal St., San Antonio, Los BaÃ±os, Laguna', '9624 Taal Ext., Batong Malake, Los BaÃ±os, Laguna', '2024-01-29', '2024-01-29', 'Mario M. De Guia', 'Jayson S. Estiva', 'Ako si Mario M. De Guia na inirereklamo si Jayson S. Estiva dahil sa pagkakabangga niya sa akin kaninang umaga habang tumatawid ako sa pedestrian lane sa tapat ng Jolibee crossing.', 'Gusto ko na mapag-usapan namin ito sa tanggapan ng Barangay Batong Malake upang tulungan niya ako sa gastusin ng aking pagpapagamot.', 'Pagkakabangga', '', 'Criminal', 'Settled', 'Mediation', 0, 0),
(206, 110, 76, '2024-2-09', 'Mt. Data St., Batong Malake, Los BaÃ±os, Laguna', '10109 Sierra Madre Batong Malake, Los BaÃ±os, Laguna', '2024-02-04', '2024-02-04', 'Amparo Magbanua', 'Mel Tejada', 'Ako ay nagtungo sa tanggapan ng Barangay Batong Malake upang ireklamo si Mel Tejada dahil sa pagbibintang sa akin na hindi daw sa akin ang tuwalyang naiwan ko at mga panty.', 'Gusto ko siyang makaharap sa Barangay upang makipaglinawan at malinis ang aking pangalan.', 'Pakikipaglinawan tungkol sa Nawawalang Gamit', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(207, 110, 76, '2024-2-10', 'Barangay Anos, Los BaÃ±os, Laguna', 'LB Square, Batong Malake, Los BaÃ±os, Laguna', '2024-02-10', '2024-02-10', 'Mary Rose L. Alumbro & Ogie Alumbro Y Delas Armas', 'Jenirey S. Olmidillo', 'Gusto namin ireklamo si Jemrey S. Olmidillo dahil sa kanyang pagkakalat ng maling inpormasyon tungkol sa amin.', 'Nais namin siyang makaharap sa barangay upang matigil na ang kanyang paninira.', 'Pagkakalat ng Maling Inpormasyon', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(208, 110, 76, '2024-2-12', '9407 Lopez Ave., Los BaÃ±os, Laguna', '9407 Lopez Ave., Los BaÃ±os, Laguna', '2024-02-10', '2024-02-10', 'Ronoel P. Revilleza & Emma O. Revilleza', 'Grace Sityar & Sandy Capili', 'Ako si Emma Revilleza ay nagtungo sa tanggapan ng Barangay Batong Malake upang makausap sina Sandy Capili at Grace Sityar. Sila ay mga caretaker ng rental unit na pagmamay-ari ng aking asawa at kanyang mga kapatid. ', 'Nasa ibang bansa ang mga kapatid ng asawa ko kaya nais namin makipaglinawan sa mga caretaker tungkol sa renta at amilyar.', 'Pakikipaglinawan tungkol sa Amilyar at Renta', NULL, 'Civil', 'Unsettled', 'Pending', 0, 0),
(209, 110, 76, '2024-2-13', 'Lungsod ng Makati', '8724 Junction St., Batong Malake, Los BaÃ±os, Laguna', '2024-02-12', '2024-02-12', 'Jenny Carreon', 'Ramonato Carreon', 'Nasi ko po ireklamo si Ramonato Carreon dail gusto ko na maging legal ang aming usapan tungkol sa pagtira at pag-alis niya sa bahay ng aking tatay.', 'Nais ko siya makaharap sa barangay upang makipaglinawan at legal ang aming usapan.', 'Pakikipaglinawan sa Upa ng Bahay', NULL, 'Civil', 'Unsettled', 'Pending', 0, 0),
(210, 110, 76, '01-03-0424', 'Sitio Riverside, Batong Malake, Los BaÃ±os, Laguna', 'Sitio Riverside, Batong Malake, Los BaÃ±os, Laguna', '2024-02-12', '2024-02-12', 'Helen Garbanzos Padilla', 'Antonio Garbanzos Padilla', 'Ako si Helen G. Padilla nagpunta sa tanggapan ng Barangay Batong Malake upang ireklamo ang aking kapatid na si Antonio G. Padilla dahil sa kanyang pagwawala kahapon, February 11, 2024, 5:30 ng hapon dahil siya ay lasing. Ako ay inaway niya at gusto akong ', 'Gusto ko pong makaharap siya sa barangay upang makausap siya at mapalitan ang mga nasira niyang upuan at para hindi na maulit ang pagwawala niya.', 'Pagwawala at Paninira ng Gamit', NULL, 'Civil', 'Unsettled', 'Pending', 0, 0),
(211, 110, 76, '2024-2-14', 'Sitio Riverside, Batong Malake, Los BaÃ±os, Laguna', 'Sitio Riverside, Batong Malake, Los BaÃ±os, Laguna', '2024-02-12', '2024-02-12', 'Helen Garbanzos Padilla', 'Antonio Garbanzos Padilla', 'Ako si Helen G. Padilla nagpunta sa tanggapan ng Barangay Batong Malake upang ireklamo ang aking kapatid na si Antonio G. Padilla dahil sa kanyang pagwawala kahapon, February 11, 2024, 5:30 ng hapon dahil siya ay lasing. Ako ay inaway niya at gusto akong ', 'Gusto ko pong makaharap siya sa barangay upang makausap siya at mapalitan ang mga nasira niyang upuan at para hindi na maulit ang pagwawala niya.', 'Pagwawala at Paninira ng Gamit', NULL, 'Civil', 'Unsettled', 'Pending', 0, 0),
(212, 115, 1, '01-000-0824', 'SI', 'SI', '2024-09-17', '2024-08-11', 'escanor', 'netoy', 'nag banatan', 'dk alam', 'Alarms and Scandals (Art.155)', '', 'Civil', 'Settled', 'Arbitration', 1, 0),
(213, 115, 1, '02-000-0824', 'SI', 'SI', '2024-09-17', '2024-08-11', 'manolo', 'mike', 'away sa lupa', 'wala ', 'Removal, sale or pledge of mortgaged property (Art. 319)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(214, 115, 1, '02-000-0824', 'san isidro', 'san isidro', '2024-09-17', '2024-08-20', 'arin', 'jomel', 'bentahan ng tanso', 'none', 'Light coercions and unjust taxation (Art. 287)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(215, 115, 1, '02-000-0824', 'sies', 'sies', '2024-09-17', '2024-08-19', 'manolo', 'bigote', 'away sa lupa', 'dk alam', 'Unlawful use of means of publication and unlawful utterances (Art. 154)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(216, 125, 79, '01-000-0824', 'san isidro', 'san isidro', '2024-08-28', '2024-08-28', 'escanor', 'jomel', 'bentahan ng tanso', 'none', 'Alarms and Scandals (Art.155)', '', 'Civil', 'Unsettled', 'Pending', 0, 0),
(217, 125, 79, '02-000-0824', 'san isidro', 'san isidro', '2024-08-28', '2024-08-28', 'person1', 'person2', 'nag abando', 'none', 'Abandoning a minor (Art. 276)', '', 'Criminal', 'Unsettled', 'Pending', 0, 0),
(218, 125, 79, '02-000-0824', 'san isidro', 'san isidro', '2024-08-28', '2024-08-28', 'manolo', 'michael', 'sa kuryente', 'none', 'Malubhang pamimilit (Art. 286)', NULL, 'Civil', 'Unsettled', 'Pending', 1, 0),
(219, 125, 79, '02-000-0824', 'san isidro', 'san isidro', '2024-08-28', '2024-08-28', 'fgdfg', 'fdg', 'nag abando', 'none', 'Unlawful use of means of publication and unlawful utterances (Art. 154)', '', 'Civil', 'Unsettled', 'Pending', 1, 0),
(220, 134, 92, '01-000-0924', 'san isidro', 'san isidro', '2024-09-26', '2024-09-05', 'dsfsdf', 'trert', 'rtertt', 'retergfdf', 'Unlawful use of means of publication and unlawful utterances (Art. 154)', '', 'Civil', 'Unsettled', 'Pending', 0, 1),
(221, 134, 92, '02-000-0924', 'gdfgdg', 'tyutyu', '2024-09-26', '2024-09-05', 'yutyu', 'ytutyu', 'fghjfgh', 'ret', 'tatgalog', '', 'Civil', 'Unsettled', 'Pending', 0, 1),
(222, 135, 93, '01-000-0924', 'fg', 'dfg', '2024-09-25', '2024-09-13', 'dgfhfdg', 'fgdgf', 'fdgdfg', 'dfgdfg', 'Swindling a minor (Art. 317)', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(223, 115, 1, '01-000-0924', 'erter', 'ert', '2024-09-18', '2024-09-18', 'rtert', 'ertert', 'retet', 'ertert', 'Sample tagalog1', '', 'Civil', 'Settled', 'Mediation', 0, 0),
(225, 134, 92, '03-000-0924', 'dfgdf', 'dfg', '2024-09-26', '2024-09-26', 'fgfdg', 'fdgdfg', 'dfg', 'dfg', 'Sample tagalog3', NULL, 'Civil', 'Unsettled', 'Pending', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hearings`
--

CREATE TABLE `hearings` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `hearing_number` varchar(255) NOT NULL,
  `form_used` varchar(50) NOT NULL,
  `made_date` date DEFAULT NULL,
  `received_date` date NOT NULL,
  `appear_date` timestamp NULL DEFAULT NULL,
  `resp_date` date DEFAULT NULL,
  `scenario` int(11) DEFAULT NULL,
  `scenario_info` text DEFAULT NULL,
  `officer` varchar(50) NOT NULL,
  `settlement` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `subpoena` text DEFAULT NULL,
  `fraud_check` tinyint(1) DEFAULT 0,
  `fraud_text` text DEFAULT NULL,
  `violence_check` tinyint(1) DEFAULT 0,
  `violence_text` text DEFAULT NULL,
  `intimidation_check` tinyint(1) DEFAULT 0,
  `intimidation_text` text DEFAULT NULL,
  `fourth_check` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hearings`
--

INSERT INTO `hearings` (`id`, `complaint_id`, `hearing_number`, `form_used`, `made_date`, `received_date`, `appear_date`, `resp_date`, `scenario`, `scenario_info`, `officer`, `settlement`, `created`, `subpoena`, `fraud_check`, `fraud_text`, `violence_check`, `violence_text`, `intimidation_check`, `intimidation_text`, `fourth_check`) VALUES
(285, 103, '1th', '7', '2024-03-11', '2024-03-11', NULL, NULL, NULL, NULL, '', NULL, '2024-03-11 02:54:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(287, 103, '1th', '8', '2023-01-01', '2023-01-01', '2023-01-04 10:00:00', NULL, NULL, NULL, '', NULL, '2024-03-11 02:55:43', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(288, 105, '1th', '7', '2024-01-23', '2024-01-23', NULL, NULL, NULL, NULL, '', NULL, '2024-03-11 02:55:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(289, 103, '1th', '9', '2024-01-03', '2023-01-03', '2024-01-04 10:00:00', '2024-01-03', NULL, NULL, 'DR. APOLINARIO ALZONA', NULL, '2024-03-11 03:00:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(290, 103, '1th', '16', '2024-01-04', '0000-00-00', NULL, NULL, NULL, NULL, '', 'nagka sundo ang magkabilang panig at ito ay nakatala sa Lupon Kasunduan Book', '2024-03-11 03:03:35', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(291, 105, '1th', '8', '2024-01-24', '2024-01-24', '2024-01-26 14:00:00', NULL, NULL, NULL, '', NULL, '2024-03-11 03:04:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(292, 105, '1th', '9', '2024-01-24', '2024-01-24', '2024-01-26 14:00:00', '2024-01-24', NULL, NULL, 'Ronnie', NULL, '2024-03-11 03:13:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(293, 105, '2th', '16', '2023-02-13', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang dalawang panig na huhulugan ni Cristina Talamo ang balanse na P2,000.00 \r\n2. Huhulugan ni Cristina ng P200.00 weekly\r\n3. Dadalhin niya sa Barangay Batong Malake ang hulog tuwing linggo ng umaga at ito ay kukunin ni Anabel sa Barangay\r\n4.', '2024-03-11 03:18:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(295, 107, '1th', '7', '2023-12-26', '2023-12-26', NULL, NULL, NULL, NULL, '', NULL, '2024-03-13 02:05:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(296, 107, '1th', '8', '2023-12-26', '2023-12-26', '2023-12-27 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-13 02:08:10', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(297, 108, '1th', '7', '2023-12-30', '2023-12-30', NULL, NULL, NULL, NULL, '', NULL, '2024-03-13 05:38:56', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(298, 108, '1th', '8', '2024-01-04', '2024-01-04', '2024-01-05 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-13 05:48:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(299, 108, '1th', '9', '2024-01-05', '2024-01-05', '2024-01-05 18:00:00', '2024-01-05', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-13 05:55:04', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(300, 108, '1th', '16', '2024-01-05', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Napagkasunduan ng dalawang panig na babayaran ni Nadie Casipong ang mga sumusunod na gastos ni Mr. Carlo Maligalig; \r\n7 Days Absent: 5,250.00\r\nLPA Bay District:  1,300.00\r\nX-RAY: 250.00\r\nER FEE: 1,000.00\r\nLPH BAY DISTRICT: 68.00\r\nTOTAL: 7,868.00\r\n\r\n2. ', '2024-03-13 06:03:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(301, 109, '1th', '7', '2024-01-04', '2024-01-04', NULL, NULL, NULL, NULL, '', NULL, '2024-03-13 07:08:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(302, 109, '1th', '8', '2024-01-08', '2024-01-08', '2024-01-11 14:00:00', NULL, NULL, NULL, '', NULL, '2024-03-13 07:09:53', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(303, 109, '1th', '9', '2024-01-08', '2024-01-08', '2024-01-11 14:00:00', '2024-01-08', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-13 07:11:12', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(304, 109, '1th', '16', '2024-01-11', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang dalawang panig. Humingi ng tawad si Ms. Shirley kay Mr. Leonardo dahil sa naidulot na kahihiyan sa kanya sa waltermart. Sa araw ng Martes, January 16, 2024 papalitan ni Ma\'am Shirley ang pekeng pera na P1,000.00 na natanggap ni Sir Leonardo', '2024-03-13 07:16:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(307, 111, '1th', '7', '2023-01-08', '2023-01-08', NULL, NULL, NULL, NULL, '', NULL, '2024-03-24 02:55:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(308, 111, '1th', '8', '2023-01-08', '2023-01-08', '2023-01-11 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-24 02:56:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(309, 111, '1th', '16', '2023-01-11', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Tinanggap ng magkabilang panig ang kanilang mga kamalian.\r\n2. Kapwa handang makipag-ayos at tapusin ang alitang ito.\r\n3. Magbabayad ng PhP926.00 sa enero 14 via G-Cash ni Raymond Mahipos kay Patrick John bilang danyos sa pagpapatingin at sa gamot.', '2024-03-24 03:09:37', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(310, 112, '1th', '7', '2023-01-16', '2023-01-16', NULL, NULL, NULL, NULL, '', NULL, '2024-03-24 03:19:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(311, 112, '1th', '8', '2023-01-16', '2023-01-16', '2023-01-18 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-24 03:20:28', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(312, 112, '1th', '16', '2023-01-18', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkapaliwanagan sina Gng. Peralta at si Mark Anthony sa nangyari sa pagitan nila.\r\n2. Inamin ni Mark Anthony na maling mali ang mga nasabi niya kay Gng. Gloria na masakit na salita at pinagsisisihan nya lahat dahil dala lang ito ng kanilang problema s', '2024-03-24 03:26:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(313, 113, '1th', '7', '2023-01-18', '2023-01-18', NULL, NULL, NULL, NULL, '', NULL, '2024-03-24 06:06:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(314, 113, '1th', '8', '2023-01-18', '2023-01-18', '2023-01-20 18:08:00', NULL, NULL, NULL, '', NULL, '2024-03-24 06:09:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(315, 113, '1th', '16', '2023-01-20', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Inamin ni Mr. Roberto ang panghihiya kay Gng. Helen dahil sa sobrang tagal na ng utang ng huli sa una.\r\n2. Nangako si Gng. Helen na huhulugan niya ng PhP 200.00 kada linggo si G. Roberto tuwing sabado hanggang matapos ang utang.\r\n3. Di na mauulit ang p', '2024-03-24 06:14:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(316, 114, '1th', '7', '2023-01-18', '2023-01-18', NULL, NULL, NULL, NULL, '', NULL, '2024-03-24 06:29:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(317, 114, '1th', '8', '2023-01-18', '2023-01-18', '2023-01-20 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-24 06:30:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(318, 114, '1th', '16', '2023-01-20', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nangako si Gng. Helen na huhulugan kada linggo, araw ng sabado. 28 ng Enero 2023 ng halagang PhP 200.00 hanggang matapos ang utang na may kabuuang halagang PhP10,300.00\r\n2. Dadalahin sa bahay nina Ms. Arrabelle ang bayad at di liliban.\r\n3. Kung hindi m', '2024-03-24 06:39:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(319, 115, '1th', '7', '2023-01-18', '2023-01-18', NULL, NULL, NULL, NULL, '', NULL, '2024-03-24 07:54:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(320, 115, '1th', '8', '2023-01-18', '2023-01-18', '2023-01-20 06:00:00', NULL, NULL, NULL, '', NULL, '2024-03-24 07:58:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(321, 115, '1th', '16', '2023-01-20', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Humingi ng dispensa at nagkapaliwanagan ang magkabilang panig.\r\n2. Nangako ang bawat isa na hindi lilikha pa ng issue na pagmumulan ng di pagkakaunawaan sa pagitan nila sa kapatid at pamangkin ni Gng. Helen at sa katayuan ni Ms. Arlene.\r\n3. Ihihinto an', '2024-03-24 08:03:13', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(322, 116, '1th', '7', '2023-01-23', '2023-01-23', NULL, NULL, NULL, NULL, '', NULL, '2024-03-24 08:13:13', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(323, 116, '1th', '8', '2023-01-23', '2023-01-23', '2023-01-26 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-24 08:14:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(324, 116, '1th', '16', '2023-01-26', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang magkabilang panig na magbabayad si Anthony Garcia ng halagang walong libong piso (PhP8,000.00) na may kalakip na resibo. Ito ay babayaran ng hulugan at ngayon ay magbibigay na si Mr. Galla ng tatlong libong piso (PhP3,000.00). Ang kulang', '2024-03-24 08:18:52', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(329, 119, '1th', '7', '2023-03-06', '2023-03-06', NULL, NULL, NULL, NULL, '', NULL, '2024-03-25 02:53:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(330, 119, '1th', '8', '2023-03-07', '2023-03-07', '2023-03-08 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-25 02:55:46', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(331, 119, '1th', '9', '2023-03-06', '2023-03-06', '2023-03-08 18:00:00', '2023-03-06', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 03:03:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(332, 119, '1th', '16', '2023-03-08', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Aalisin ni Ms. Careene Del Rosario yung mga basura na nakatambak at upuan na nakaharang sa daanan at hindi na maglalagay ng anumang basura o harang sa daan.\r\n2. Kung may problema ang bawat isa ay mauusap ng maayos\r\n3. Hindi na magpopost si Careen Del R', '2024-03-25 03:09:42', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(333, 120, '1th', '7', '2023-01-02', '2023-01-02', NULL, NULL, NULL, NULL, '', NULL, '2024-03-25 07:33:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(334, 120, '1th', '8', '2023-01-02', '2023-01-02', '2023-01-05 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-25 07:34:12', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(335, 120, '1th', '9', '2023-01-02', '2023-01-02', '2023-01-05 18:00:00', '2023-01-02', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 07:35:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(336, 120, '1th', '16', '2023-01-05', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Matapos naipa-repair nina Mr. & Mrs. Macario ang nabanggang tindahan na nagkakahalagang PhP 34,000.00 ay binayaran din nila ang mag-asawang Joey & Shayne Mercado ng halagang PhP 20,000.00 para sa kanilang mga tauhan at kita sa panahong ipinagawa ang na', '2024-03-25 07:41:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(337, 111, '1th', '9', '2023-01-08', '2023-01-08', '2023-01-11 18:00:00', '2023-01-08', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 07:44:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(338, 112, '1th', '9', '2023-01-16', '2023-01-16', '2023-01-18 18:00:00', '2023-01-16', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 07:47:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(339, 113, '1th', '9', '2023-01-18', '2023-01-18', '2023-01-20 18:00:00', '2023-01-18', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 07:49:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(340, 114, '1th', '9', '2023-01-18', '2023-01-18', '2023-01-20 18:00:00', '2023-01-18', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 07:52:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(341, 115, '1th', '9', '2023-01-18', '2023-01-18', '2023-01-20 18:00:00', '2023-01-18', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 07:54:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(342, 116, '1th', '9', '2023-01-18', '2023-01-18', '2023-01-26 18:00:00', '2023-01-18', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 07:56:27', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(343, 121, '1th', '7', '2023-01-30', '2023-01-30', NULL, NULL, NULL, NULL, '', NULL, '2024-03-25 08:12:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(344, 121, '1th', '8', '2023-02-08', '2023-02-08', '2023-02-10 14:00:00', NULL, NULL, NULL, '', NULL, '2024-03-25 08:13:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(345, 121, '1th', '9', '2023-02-08', '2023-02-08', '2023-02-10 14:00:00', '2023-02-08', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 08:16:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(346, 121, '1th', '16', '2023-02-10', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang dalawang partido na magbayad ng renta kay Mrs. Lazaro sa lumang sukat ng pinauupahang lugar sa halagang PhP23,450.00 per month sa loob ng anim na buwan mula January - June 2023 na nagkakahalagang total na PhP 187,600.00 including advance', '2024-03-25 08:22:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(347, 122, '1th', '7', '2023-02-05', '2023-02-05', NULL, NULL, NULL, NULL, '', NULL, '2024-03-25 23:47:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(348, 122, '1th', '8', '2023-02-08', '2023-02-08', '2023-02-15 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-25 23:48:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(349, 122, '1th', '9', '2023-02-09', '2023-02-09', '2023-02-15 18:00:00', '2023-02-09', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-25 23:50:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(350, 122, '1th', '16', '2023-02-15', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig na babayaran ni Lenie ang utang nya na may kabuang halaga na  Php 45,000 sa loob ng 28 months (Php 1,500.00 per month), buwan hanggang sa matapos mabayaran ang utang.\r\n\r\nbreakdown: \r\nRental (Apartment)- Php 36,000.00\r\nMera', '2024-03-26 00:01:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(351, 123, '0', '16', '2023-02-17', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang kabuang halaga na Php 14,654.8 na nagastos sa pagpapagamot ni Mr. Ocon ay hahatiin sa tatlong beses na pagbabayad ni Mr. Patio na magsisimula sa February 28, 2023, March 15, 2023. Ito ay nagkakahalaga ng Php5,218.26 kada bayad.\r\nPag-uusapin sa susunod', '2024-03-26 00:25:03', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(352, 123, '1th', '16', '2023-02-17', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang kabuang halaha na Php 15,654.8 na nagastos sa pagpapagamot no Mr. Ocon ay hahatiin sa tatlong beses na pagbabayad ni Mr. Patio na magsisimula sa February 28, 2023, March 15, 2023. Ito ay nagkakahalaga ng Php 5,218.26 kada bayad.\r\nPag uusapin sa susuno', '2024-03-26 00:28:53', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(353, 123, '1th', '7', '2023-02-10', '2023-02-10', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 00:29:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(354, 123, '1th', '8', '2023-02-10', '2023-02-10', '2023-02-12 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 00:30:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(355, 123, '1th', '9', '2023-02-12', '2023-02-10', '2023-02-12 18:00:00', '2023-02-10', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 00:36:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(356, 124, '1th', '16', '2023-02-21', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Mr. Rizalito Revilleza satified the request of Ms. Marilyn Montejo to permit the authenticated copy of SPA indicating that he is the assigned new manager of Cartas Apt. managed by Ms. Montejo.\r\nMs. Marilyn Montejo upon communicating w/Ms. Jennifer Buenave', '2024-03-26 01:02:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(357, 124, '1th', '8', '2023-02-14', '2023-02-14', '2023-02-21 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 01:04:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(358, 124, '1th', '9', '2023-02-14', '2023-02-14', '2023-02-21 18:00:00', '2023-02-14', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 01:05:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(359, 124, '1th', '7', '2023-02-11', '2023-02-11', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 01:06:36', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(360, 125, '1th', '7', '2023-02-04', '2023-02-04', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 01:14:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(361, 125, '1th', '8', '2023-03-04', '2023-03-04', '2023-03-05 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 01:14:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(362, 125, '1th', '9', '2023-03-04', '2023-03-04', '2023-03-05 18:00:00', '2023-03-04', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 01:15:37', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(363, 126, '0', '16', '2023-03-05', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Pumayag si Ms. Cynthia Labita na magbabayad ng kalahati sa tumama sa STL na may halagang Php12,000.00 sa April 24, 2023. Ang bayaran ay magaganap dito sa tanggapan ng Batong Malake', '2024-03-26 01:33:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(364, 126, '1th', '16', '2023-03-05', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Pumayag si Cynthia Labita na magbabayad ng kalahati sa tumama sa STL na may halagang Php12,000.00 sa April 24, 2023. Ang bayaran ay magaganap sa tanggapan ng Batong Malake.', '2024-03-26 01:34:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(365, 126, '1th', '7', '2023-03-04', '2023-03-04', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 01:34:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(366, 126, '1th', '8', '2023-03-04', '2023-03-04', '2023-03-05 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 01:35:35', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(367, 126, '1th', '9', '2023-03-04', '2023-03-04', '2023-03-05 18:00:00', '2023-03-04', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 01:36:45', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(368, 127, '1th', '16', '2023-03-08', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Aalisin ni Ms. Careene Del Rosario yung mga basura na nakatambak at upuan na nakaharang sa daanan at hindi na maglalagay ng anumang basura o  harang sa daan.\r\nKung may problema ang bawat isa ay mag uusap ng maayos.\r\nHindi na magpo-post si Careen Del Rosar', '2024-03-26 01:52:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(369, 127, '1th', '7', '2023-03-06', '2023-03-06', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 01:53:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(370, 127, '1th', '8', '2023-03-06', '2023-03-06', '2023-03-08 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 01:53:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(371, 127, '1th', '9', '2023-03-06', '2023-03-06', '2023-03-08 18:00:00', '2023-03-06', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 01:54:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(372, 128, '1th', '16', '2023-03-08', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Aalisin ni Ms. Careene Del Rosario yung mga basura na nakatambak at upuan na nakaharang sa daanan at hindi na maglalagay ng anumang basura o harang sa daan.\r\n2. Kung may problema ang bawat isa ay mauusap ng maayos\r\n3. Hindi na magpopost si Careen Del R', '2024-03-26 02:03:37', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(373, 128, '1th', '7', '2023-03-07', '2023-03-07', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 02:04:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(374, 128, '1th', '8', '2023-03-07', '2023-03-07', '2023-03-08 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 02:04:37', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(375, 128, '1th', '9', '2023-03-07', '2023-03-07', '2023-03-08 18:00:00', '2023-03-07', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 02:05:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(376, 129, '1th', '16', '2023-03-10', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Magbibigay si Ms. Rowena Valeña ng Php 3,000.00 ngayong araw kay Ms. Maria Teresa Clemeno. Ang Php 22,000.00 na balanse ay babayaran nya ngayong darating na April 15, 2023.', '2024-03-26 02:12:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(377, 129, '1th', '7', '2023-03-09', '2023-03-09', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 02:16:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(378, 129, '1th', '8', '2023-03-09', '2023-03-09', '2023-03-09 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 02:16:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(379, 129, '1th', '9', '2023-03-09', '2023-03-09', '2023-03-10 18:00:00', '2023-03-09', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 02:17:27', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(380, 130, '1th', '16', '2023-03-13', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Lahat ng magagastos at nagastos ng magkapatid na Marvin at Mark Gonzales ay sasagutin ng AD Tech para sa rebuffing ng kanilang kotse na atlis at vios.\r\nAng lahat ng resibo ng nagastos nila ay ipapasa Barangay para ibigay sa AD Tech.\r\nDito na nagtatapos an', '2024-03-26 02:26:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(381, 130, '1th', '7', '2023-03-11', '2023-03-11', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 02:27:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(382, 130, '1th', '8', '2023-03-11', '2023-03-11', '2023-03-13 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 02:28:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(383, 130, '1th', '9', '2023-03-11', '2023-03-11', '2023-03-13 18:00:00', '2023-03-11', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 02:29:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(384, 131, '1th', '16', '2023-07-28', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang magkabilang partido ay nagkasundo na magbibigay ng palugit sa pagpapatupad ng mga kasunduan. Ang palugit sa mga pagpapatupad ang mga sumusunod.\r\nItem 1- na ang Ekstratura ang lilisanin at gigibain ni Mrs. Garcia hanggang Dec. 2023 at hindi na bibigyan', '2024-03-26 02:37:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(385, 131, '1th', '7', '2023-03-11', '2023-03-11', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 02:38:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(386, 131, '1th', '8', '2023-03-11', '2023-03-11', '2023-03-12 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 02:38:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(387, 131, '1th', '9', '2023-03-11', '2023-03-11', '2023-03-12 18:00:00', '2023-03-11', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 02:42:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(388, 131, '2th', '8', '2023-03-13', '2023-03-13', '2023-03-15 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 02:48:07', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(389, 131, '2th', '9', '2023-03-13', '2023-03-13', '2023-03-15 18:00:00', '2023-03-13', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 02:49:07', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(390, 131, '3th', '9', '2023-03-16', '2023-03-16', '2023-03-16 18:00:00', '2023-03-16', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 02:50:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(391, 131, '3th', '16', '2023-07-28', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang magkabilang partido ay nagkasundo na magbibigay ng palugit sa pagpapatupad ng mga kasunduan. Ang palugit sa mga pagpapatupad ang mga sumusunod.\r\nItem 1- na ang Ekstratura ang lilisanin at gigibain ni Mrs. Garcia hanggang Dec. 2023 at hindi na bibigyan', '2024-03-26 02:51:02', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(392, 131, '3th', '10', '2023-03-27', '2023-03-27', '2023-07-28 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 02:51:48', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(393, 131, '3th', '11', NULL, '2023-03-27', NULL, NULL, NULL, 'Myrna Servañez', 'Myrna Servañez', NULL, '2024-03-26 02:54:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(394, 131, '3th', '11', NULL, '2023-03-27', NULL, NULL, NULL, 'Fernando Paras Jr.', 'Fernando Paras Jr.', NULL, '2024-03-26 02:55:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(395, 131, '3th', '12', '2024-03-26', '2023-03-27', '2024-07-28 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 02:59:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(396, 132, '0', '8', '2023-03-13', '2023-03-13', '2023-03-13 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 03:08:04', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(397, 132, '1th', '7', '2023-03-13', '2023-03-13', NULL, NULL, NULL, NULL, '', NULL, '2024-03-26 03:08:52', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(398, 132, '1th', '8', '2023-03-13', '2023-03-13', '2023-03-15 18:00:00', NULL, NULL, NULL, '', NULL, '2024-03-26 03:09:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(399, 132, '1th', '9', '2023-03-13', '2023-03-13', '2023-03-15 18:00:00', '2023-03-13', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-03-26 03:10:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(400, 132, '1th', '16', '2023-03-15', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nangako si Rojane Gatchalian kina Aniflor Minorca & Mylene Jimenez na babayaran nya ang halagang Php 1,500.00 sa darating na ika-23 ng Marso 2023.\r\nNagkasundo silang magbabayaran sa tindahan ni Ms. Mylene Jimenez sa lugar ng kanyang business sa Grove, Bat', '2024-03-26 03:13:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(401, 133, '1th', '7', '2023-04-13', '2023-04-13', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 00:45:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(402, 133, '1th', '8', '2023-04-13', '2023-04-13', '2023-04-14 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 00:47:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(403, 133, '1th', '9', '2023-04-13', '2023-04-13', '2023-04-14 06:00:00', '2023-04-13', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 00:49:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(404, 133, '1th', '16', '2023-04-14', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Babayaran ni G. Daryl Biag si G. Venerayon sa halaga ng pagpapagamot, pamasahe, at araw na hindi nakapagtrabahaho na may kabuuang PhP5,000.00.\r\n2. Ang unag bayad ay sa April 25, 2023, Huwebes PhP2,500.00 at ang pangalawang bayad ay sa Mayo 20, 2023, Sa', '2024-04-01 00:53:36', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(405, 134, '1th', '7', '2023-03-16', '2024-04-01', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 01:38:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(406, 134, '1th', '8', '2023-03-16', '2023-03-16', '2023-03-17 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 01:42:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(407, 134, '1th', '9', '2023-03-16', '2023-03-16', '2023-03-17 18:00:00', '2023-03-16', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 01:44:43', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(408, 134, '1th', '16', '2023-03-17', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Ang natitirang pagkakautang ni Gng. Gatchalian kina Aniflor Minorca at Mtlene V. Jimenez na nagkakahalagang Php 5,900 ay babayaran sa mga sumusunod na petsa at halaga.\r\nMarso 20,2023 - Php 1,000\r\nApril 20,2023 -  Php 2,000\r\nMayo 20,2023 - Php 2,000\r\nHu', '2024-04-01 01:51:48', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(409, 136, '1th', '7', '2023-03-20', '2023-03-20', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 02:09:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(410, 136, '1th', '8', '2023-03-20', '2023-03-20', '2023-03-24 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 02:11:02', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(411, 136, '1th', '9', '2023-03-20', '2023-03-20', '2023-03-24 18:00:00', '2023-03-20', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 02:12:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(412, 136, '1th', '16', '2023-03-24', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Humingi ng tawad si Orlando Macam sa mga nagawa tulad ng pagwawqlq at pagbabanta. At wag ng mauulit pa ang pangyayari\r\n\r\n2. Babawiin ni Orlando ang pag babanta\r\n\r\n3. at personal na hihingi ng paumanhin ang magkabilang panig ay magkasundo ayon sa napag ', '2024-04-01 02:14:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(413, 137, '1th', '7', '2023-03-31', '2023-03-31', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 02:22:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(414, 137, '1th', '8', '2023-03-31', '2023-03-31', '2023-04-04 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 02:23:24', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(415, 137, '1th', '9', '2023-03-31', '2023-03-31', '2023-04-04 18:00:00', '2023-03-31', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 02:26:02', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(416, 137, '1th', '16', '2023-04-04', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang magkabilang panig at nagkaroon ng pag aayos humingi mg paumanhin si Ms. Rhodora P. Talagtag kay Ms. Zenaida M. Cabonce At nangako na tatapusin na ang anumang issue sa pagitan nilang dalawa', '2024-04-01 02:27:22', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(417, 138, '1th', '7', '2023-04-23', '2023-04-23', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 02:34:14', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(418, 138, '1th', '8', '2023-04-23', '2024-04-23', '2023-04-25 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 02:35:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(419, 138, '1th', '9', '2023-04-23', '2023-04-23', '2023-04-23 18:00:00', '2023-04-23', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 02:37:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(420, 138, '1th', '16', '2023-04-25', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Babayaran ni Gino Villegas ang Halagang PhP 9,000 sa katapusan  ng May 2023.\r\n\r\n2. Dito na nagtatapos ang usaping ito.', '2024-04-01 02:38:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(421, 139, '1th', '7', '2023-04-23', '2023-04-23', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 02:43:37', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(422, 139, '1th', '8', '2023-04-23', '2023-04-23', '2023-04-26 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 02:44:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(423, 139, '1th', '9', '2023-04-23', '2023-04-23', '2023-04-26 18:00:00', '2023-04-23', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 02:46:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(424, 139, '1th', '16', '2023-04-26', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. That Yet, Both parties have agreed to have no more communication with one another that would create misunderstanding (Personal confrontation), Txt sms, Facebook , Instagram, E-mail and Other form of social media platform\r\n\r\n2. Both parties agreed that ', '2024-04-01 02:47:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(425, 140, '1th', '7', '2023-05-01', '2023-05-01', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 02:53:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(426, 140, '1th', '8', '2023-05-01', '2023-05-01', '2023-05-03 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 02:54:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(427, 140, '1th', '9', '2023-05-01', '2023-05-01', '2023-05-03 18:00:00', '2023-05-01', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 02:56:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(428, 140, '1th', '16', '2023-05-03', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang magkabilang panig na babayaran ng respondent sa halagang 3hundred kada Linggo.\r\n\r\n2. Gayumpaman, babayaran ng respondent sa loob ng 38 weeks sa kabuuan ng 11,400 sa huli ng kabayaranan ay 4 hundred ang hulog. kung makakakuwag ang respond', '2024-04-01 02:56:52', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(429, 141, '1th', '7', '2023-05-07', '2023-05-07', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 03:01:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(430, 141, '1th', '8', '2023-05-07', '2023-05-07', '2023-05-09 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 03:03:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(431, 141, '1th', '9', '2023-05-07', '2023-05-07', '2023-05-09 18:00:00', '2023-05-07', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 03:05:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(432, 141, '1th', '16', '2023-05-09', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Humingi ng tawad si Mr. Genesis K. Pajo kay Mr. Rico L. Monreal at nangakong hindi mauulit ang pag babanta\r\n\r\n2. Tinanggap ni Mr. Rico L. Moreal Ang paghingi ng tawad ni Mr. Genesis K. Pajo.\r\n3. Dito Na natapos ang usaping Ito.', '2024-04-01 03:05:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(433, 142, '1th', '7', '2023-05-09', '2023-05-09', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 03:13:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(434, 142, '1th', '8', '2023-05-09', '2023-05-09', '2023-05-11 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 03:14:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(435, 142, '1th', '9', '2023-05-09', '2023-05-09', '2023-05-11 18:00:00', '2023-05-09', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 03:15:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(436, 142, '1th', '16', '2023-05-11', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagbayad si Mr. Sombillo ng hanggang ng halagang PhP 2,000 Kay Mr. Manggale bilang bayad sa danyos sa nasirang motor.\r\n2. Dito Na natapos ang usaping Ito.', '2024-04-01 03:16:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(437, 143, '1th', '7', '2023-05-22', '2023-05-22', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 03:22:22', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(438, 143, '1th', '8', '2023-05-22', '2023-05-22', '2023-05-24 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 03:23:28', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(439, 143, '1th', '9', '2023-05-22', '2023-05-22', '2023-05-24 18:00:00', '2023-05-22', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 03:25:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(440, 143, '1th', '16', '2023-04-24', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nangako si Mr. Anjo Dela Paz na ibabalik ang halagang 7,000 sa darating na may 31, 2023.\r\n2. Dito Na natapos ang usaping Ito.', '2024-04-01 03:25:40', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(441, 144, '1th', '7', '2023-05-29', '2023-05-29', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 04:18:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(442, 144, '1th', '8', '2023-05-29', '2023-05-29', '2023-05-31 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 04:19:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(443, 144, '1th', '9', '2023-05-29', '2023-05-29', '2023-05-31 18:00:00', '2023-05-29', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 04:22:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(444, 144, '1th', '16', '2023-05-31', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Inamin ni Michael ang nangyaring panununtok at humingi ng dispensa.\r\n2. Babayran nya ang nagastos ni Carlo sa pagpapagamot at ang mga araw na hindi naipasok ni carlo sa trabaho 3 araw ng nagastos: PhP 300. ER fee, Medico legal Fee at certif. Fee\r\n790. ', '2024-04-01 04:23:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(445, 145, '1th', '7', '2023-05-31', '2023-05-31', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 04:41:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(446, 145, '1th', '8', '2023-05-31', '2023-05-31', '2023-06-02 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 04:42:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(447, 145, '1th', '9', '2024-05-31', '2023-05-31', '2023-06-02 18:01:00', '2023-05-31', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 04:44:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(448, 145, '1th', '16', '2024-06-02', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang bawat panig ay nagkasundo sa mga sumusunod\r\n1. Na mabibigay ng halagang 30,000 si Ms. Saguin para sa financial assistance kay Delia D. Tamayo. (Nagbigay ang halaga mismong pagdinig)\r\n2. Na ang kasunduang ito ay igagalang ng bawat panig bilang pag tata', '2024-04-01 04:45:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(449, 146, '1th', '7', '2023-06-05', '2023-06-05', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 04:50:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(450, 146, '1th', '8', '2023-06-05', '2023-06-05', '2023-06-07 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 04:51:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(451, 146, '1th', '9', '2023-06-05', '2023-06-05', '2023-06-07 18:00:00', '2023-06-05', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 04:52:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(452, 146, '1th', '16', '2023-06-07', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nangako si Jaime S. Reyes na hindi na mauulit ang paghahamon nya ng suntukan at pananakot. sa huli, Sa huli nagpatawarqn at nangakong ibabalik nila ang dati nilang samahan', '2024-04-01 04:53:14', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(453, 147, '1th', '7', '2023-06-05', '2023-06-05', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 04:59:27', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(454, 147, '1th', '8', '2023-06-05', '2023-06-05', '2023-06-07 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 05:00:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(455, 147, '1th', '9', '2023-06-05', '2023-06-05', '2023-06-07 18:00:00', '2023-06-05', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 05:04:41', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(456, 147, '1th', '16', '2023-06-07', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig na mapayapang lilisanin ni Mr. Miguel Tecson ang apartment na pagmamay-ari ni Ms. Edna Vacarizas.', '2024-04-01 05:05:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(457, 148, '1th', '7', '2023-06-06', '2023-06-06', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 05:09:48', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(458, 148, '1th', '8', '2023-06-06', '2023-06-06', '2023-06-09 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 05:10:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(459, 148, '1th', '9', '2023-06-06', '2023-06-06', '2023-06-09 18:00:00', '2023-06-06', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 05:11:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(460, 148, '1th', '16', '2023-06-09', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. napagkasunduan na ako si Ryan Consibido ay kaharap ang nagsusumbong na personal na humihingi na kapatawaran sa ginawa ko. Kasama dito na sa ikaw - 16 ng hunyo, 2023 ay babayaran sa kakila ang halagang PhP 11,500,00 Danyos sa kotse - 6,500 danyos sa bin', '2024-04-01 05:12:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(461, 149, '1th', '7', '2023-06-09', '2023-06-09', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 05:17:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(462, 149, '1th', '8', '2023-06-09', '2023-06-09', '2023-06-11 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 05:18:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(463, 149, '1th', '9', '2023-06-09', '2023-06-09', '2023-06-11 18:00:00', '2023-06-09', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 05:20:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(464, 149, '1th', '16', '2023-06-11', '0000-00-00', NULL, NULL, NULL, NULL, '', 'nagkasundo ang magkabilang panig na ang kabuuang halaga na babayaran ni Mr. Jefferson T. Salac Kay Meliza R. Santos ay PhP 7,000 ang halagang PhP 7,000 ay ibibigay ni Mr. Salac kay Ms . Santos ngayong araw.', '2024-04-01 05:21:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(465, 150, '1th', '7', '2023-06-19', '2023-06-19', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 05:26:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(466, 150, '1th', '8', '2023-06-19', '2023-06-19', '2023-06-21 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 05:26:36', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(467, 150, '1th', '9', '2023-06-19', '2023-06-19', '2023-06-21 18:00:00', '2023-06-19', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 05:28:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(468, 150, '1th', '16', '2023-06-21', '0000-00-00', NULL, NULL, NULL, NULL, '', 'ang bawat panig ay nagkasundo sa mga sumusunod:\r\n1. Humingi ng tawad si Jennifer kay Kresielyn dahil sa pananampal at mga nasabing masasakit na salita at ito naman ay tinanggap ni kresielyn\r\n\r\n2. Tutulong si Jennifer upang kausapin ang mga kamag anak nya ', '2024-04-01 05:28:55', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(469, 151, '1th', '7', '2023-06-21', '2023-06-21', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 05:33:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(470, 151, '1th', '8', '2023-06-21', '2023-06-21', '2023-06-23 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 05:34:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(471, 151, '1th', '9', '2023-06-21', '2023-06-21', '2023-06-23 18:00:00', '2023-06-21', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 05:35:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(472, 151, '1th', '16', '2023-06-23', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Aalis si Marcial Mupal sa inuupahan studio type sa pag aari ng Collado family sa loob ng tatlong buwan mula ngayon.\r\n2. Nagkasundo ang magkabilang panig na hindi na sila magpakailanman/ huwag na mag pansinan.\r\nDito na nag tatapos ang kasong ito', '2024-04-01 05:36:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(473, 152, '1th', '7', '2023-07-05', '2023-07-05', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 05:46:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(474, 152, '1th', '8', '2023-07-05', '2023-07-05', '2023-07-07 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 05:47:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(475, 152, '1th', '9', '2023-07-05', '2023-07-05', '2023-07-07 18:00:00', '2023-07-05', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 05:49:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(476, 152, '1th', '16', '2023-07-07', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Inamin ni Aljur ang pagkakautang na bigas sa halagang PhP 1, 200,00 \r\n2. Nangako si Aljur na babayaran ang buong halaga sa Hulyo 15 2023 dito sa baranagay\r\n\r\n3. Tutuparin ni Aljur ang pangakong pag babayad ng PhP 1,200\r\n4. Dito na nag tatapos ang usapa', '2024-04-01 05:49:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(477, 153, '1th', '7', '2023-07-10', '2023-07-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 05:56:06', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(478, 153, '1th', '8', '2023-07-10', '2023-07-10', '2023-07-12 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 05:57:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(479, 153, '1th', '9', '2023-07-10', '2023-07-10', '2023-07-12 18:00:00', '2023-07-10', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 05:58:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(480, 153, '1th', '16', '2023-07-12', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Ang electricfan na dalawa ay dadalhin dito sa tanggapan ng barangay Batong malake upang matiyak na ito ay maayos ang pag kakagawa \r\n\r\n2. Ito ay dadalhin ni Mr. Rogelio R. Patoc bukas , July 13 2023 ng 10:00 AM qt ibibigay kay ms Aida A. Biglete matapos', '2024-04-01 05:59:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(481, 154, '1th', '7', '2023-07-11', '2023-07-11', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 06:06:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(482, 154, '1th', '8', '2023-07-11', '2023-07-11', '2023-07-12 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 06:07:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(483, 154, '1th', '9', '2023-07-11', '2023-07-11', '2023-07-12 18:00:00', '2023-07-11', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 06:09:14', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(484, 154, '1th', '16', '2023-07-12', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Ang magkqbilang panig ay nagkasundo sa  sumusunod schedule of payment ang kabuuang utang ni Joy Eroles ay PhP 4,300\r\n\r\n\r\n2.  Schedule of payment are as follows \r\nJuly 16-5 hundred\r\n        23-5hundred\r\n        31-5hundred\r\nAug 06-5hundred\r\n        13-5', '2024-04-01 06:10:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(485, 155, '1th', '7', '2023-07-03', '2023-07-03', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 06:58:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(486, 155, '1th', '8', '2023-07-03', '2023-07-03', '2023-07-06 15:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 06:59:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(487, 155, '1th', '9', '2023-07-03', '2023-07-03', '2024-04-06 15:00:00', '2023-07-03', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:00:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(488, 155, '1th', '16', '2023-07-06', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Ibabalik ni Mr. Grajo ang halagang 3,500.00 kay Ms. Sabandal bilang reservation fee kalhati ng binigay nyang PhP 7,500.\r\n2. Dito na nag tatapos ang usaping  ito', '2024-04-01 07:01:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(489, 156, '1th', '7', '2023-07-11', '2023-07-11', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 07:05:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(490, 156, '1th', '8', '2023-07-11', '2023-07-11', '2023-07-13 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 07:06:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(491, 156, '1th', '9', '2023-07-11', '2023-07-11', '2023-07-13 18:00:00', '2023-07-11', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:07:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(492, 156, '1th', '16', '2023-07-13', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Si Marina N. Gonzales ay magbibigay ng PhP 5,000 ngayong araw, July 13, 2023 Bilang huling Bayad sa tricycle na kanyang binili kina kreslelyn N. Navarez at Christian N. Navarez matapos syang magbigay ng Php 25,000 noong taong 2022.\r\n2. Dito na matatapo', '2024-04-01 07:08:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(493, 157, '1th', '7', '2023-07-17', '2023-07-17', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 07:13:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(494, 157, '1th', '8', '2023-07-17', '2023-07-17', '2023-07-19 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 07:14:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(495, 157, '1th', '9', '2023-07-17', '2023-07-17', '2023-07-19 18:00:00', '2023-07-17', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:15:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(496, 157, '1th', '16', '2023-07-19', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Na ang respondents ay hindi na maaaring mag parking sa tapat na unit ng mga complainants \r\n\r\n2. Maari lamang mag parking sa pag kakataon na may occasion ang respondents subalit may pagpayag sa mga complainants \r\n\r\n3.nagkasundo na walang sasabihin di ka', '2024-04-01 07:16:03', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(497, 158, '1th', '7', '2023-07-19', '2023-07-19', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 07:20:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(498, 158, '1th', '8', '2023-07-19', '2023-07-19', '2023-07-21 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 07:21:27', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(499, 158, '1th', '9', '2023-07-19', '2023-07-19', '2023-07-21 18:00:00', '2023-07-19', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:22:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(500, 158, '1th', '16', '2023-07-21', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Na magbabayad ang respondent sa aug 12 sa halagang Php 2,500 at aug 22 sa halagang Php 2,500 bilang kabuuan na kabayaran sa halagang Php 5,000 na pagkaka utang \r\n\r\n2. Dadalhin ng respondent ang bayad sa Barangay Batong malake kung sino man hindi pagsun', '2024-04-01 07:23:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(501, 159, '1th', '7', '2023-08-02', '2023-08-02', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 07:27:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(502, 159, '1th', '8', '2023-08-02', '2023-08-02', '2023-08-04 10:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 07:28:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(503, 159, '1th', '9', '2023-08-02', '2023-08-02', '2023-08-04 10:00:00', '2023-08-02', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:29:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(504, 159, '1th', '16', '2023-08-04', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Maghuhulog si Helen Garbanzos ng Halagang Php 1,500 kada sabado na magsisimula sa august 12, 2023 Hanggang Mabayaran niya ang Kabuuang halaga Php 2,533,00 Kay Rebecca Licaros', '2024-04-01 07:29:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(505, 160, '1th', '7', '2023-08-07', '2023-08-07', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 07:40:55', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(506, 160, '1th', '8', '2023-08-07', '2023-08-07', '2023-08-09 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 07:41:45', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(507, 160, '1th', '9', '2023-08-07', '2023-08-07', '2023-08-09 18:00:00', '2023-08-07', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:42:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(508, 160, '1th', '16', '2023-08-09', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo sina Mr. Martinez at Mrs . Corda tungkol sa itinayong bakod na magsasarq sa bakuran nila Mr. Martinez para makulong ang kanilang mga aso at para mabigyan din ng panibagong daraanan sina Mrs. Corda sila ay nagkasundo na ang lapad ng bagong daan ', '2024-04-01 07:43:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(509, 161, '1th', '7', '2023-08-07', '2023-08-07', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 07:48:43', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(510, 161, '1th', '8', '2023-08-07', '2023-08-07', '2023-08-09 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 07:49:40', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(511, 161, '1th', '9', '2023-08-07', '2023-08-07', '2023-08-09 18:00:00', '2023-08-07', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:50:46', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(512, 161, '1th', '16', '2023-08-09', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Matapos makipaglinawan ang isat isa sa mga isyu tungkol sa aso at usok ng siga sila ay nagkasundo sa mga sumusunod \r\nuna,itatami o ikakadena ang lahat ng aso at di dapat makarating sa bakuran nila Mrs Corda .\r\nPangalwa sa pagkat labag sa batas ang pag sis', '2024-04-01 07:51:32', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(513, 162, '1th', '7', '2023-08-09', '2023-08-09', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 07:56:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(514, 162, '1th', '8', '2023-08-09', '2023-08-09', '2023-08-11 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 07:57:14', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(515, 162, '1th', '9', '2023-08-09', '2023-08-09', '2023-08-11 18:00:00', '2023-08-09', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 07:58:42', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(516, 162, '1th', '16', '2023-08-11', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Iiwasan ang pagbabanta kay Arlene at nangako na Hindi na mauulit ang nasabing Pangyayari na Ginawa ni Angelo.\r\n\r\n2. Kakausapin ni Angelo  ang asawa nya upang ipaliwanag ang naging reaksyon ni Arlene at Pag sasabihan na itigil ang pag bebentang kay arle', '2024-04-01 07:59:22', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(517, 163, '1th', '7', '2023-08-13', '2023-09-13', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 08:08:52', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(518, 163, '1th', '8', '2023-08-13', '2023-08-13', '2023-08-15 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 08:09:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(519, 163, '1th', '9', '2023-08-13', '2023-08-13', '2023-08-15 18:00:00', '2023-08-13', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 08:10:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(520, 163, '1th', '16', '2023-08-15', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang Magkabilang Panig na hindi na magpapark ang mga customer ni Ms. Santos sa parking lot ni Ms. Caraga\r\n\r\n2. Tatanungin ni Ms. Santos ang kanilang Customer kung may kotse at iadvise na hindi na sila puwedeng mag park sa Parking ni Ms. Carag', '2024-04-01 08:11:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(521, 164, '0', '16', '2023-08-30', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Hindi na babayaran nila Ms, Casale ang upa nila sa apartment para sa buwan na ito ngunit sila ay mananatili na lamang on/before september 10 2023\r\n\r\n2. ang mga maiiwan na bills ay babayaran nila bago sila umalis  sa apartment sa september 10, 2023', '2024-04-01 08:26:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0);
INSERT INTO `hearings` (`id`, `complaint_id`, `hearing_number`, `form_used`, `made_date`, `received_date`, `appear_date`, `resp_date`, `scenario`, `scenario_info`, `officer`, `settlement`, `created`, `subpoena`, `fraud_check`, `fraud_text`, `violence_check`, `violence_text`, `intimidation_check`, `intimidation_text`, `fourth_check`) VALUES
(522, 164, '1th', '7', '2023-08-30', '2023-08-30', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 08:29:10', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(523, 164, '1th', '8', '2023-08-30', '2023-08-30', '2023-09-01 15:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 08:30:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(524, 164, '1th', '9', '2023-08-30', '2023-08-30', '2023-09-01 15:00:00', '2023-08-30', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 08:31:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(525, 164, '1th', '16', '2023-09-01', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Hindi na babayaran nila Ms. Casale ang upa nila sa apartment para sa buwan na ito ngunit sila ay mananatili na lamang on/before september 10 2023\r\n\r\n2. ang mga maiiwan na bills ay babayaran nila bago umalis ng apartment sa september 10 2023 ', '2024-04-01 08:37:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(526, 165, '1th', '7', '2023-09-03', '2023-09-03', NULL, NULL, NULL, NULL, '', NULL, '2024-04-01 08:41:48', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(527, 165, '1th', '8', '2023-09-03', '2023-09-03', '2023-09-05 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-01 08:42:42', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(528, 165, '1th', '9', '2023-09-03', '2023-09-03', '2023-09-05 18:00:00', '2023-09-03', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-01 08:43:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(529, 165, '1th', '16', '2023-09-05', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nangako si Ms. Abigail Mendoza na lilinawin ang mga naikwento niyang mali sa kanilang mga kapitbahay sa muli, nagkapatawaran ang magkabilang panig.', '2024-04-01 08:44:24', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(530, 135, '1th', '7', '2024-04-02', '2024-04-12', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 01:02:24', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(531, 166, '1th', '7', '2023-09-10', '2023-09-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 01:31:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(532, 166, '1th', '8', '2023-09-10', '2023-09-10', '2023-09-12 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 01:32:53', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(533, 166, '1th', '9', '2023-09-10', '2023-09-10', '2023-09-12 18:00:00', '2024-04-02', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 01:41:22', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(534, 166, '1th', '16', '2023-09-12', '0000-00-00', NULL, NULL, NULL, NULL, '', '1.	nag Barangay Batong malake sa pamumuno ni chairman Ian N. Kalaw ay hahanap ng tamang lugar kung saan maaaring ilagay ang metal garbage bin na walang maaapektuhan na sinuman.\r\n2.	Pansamantala, ang kanilang mga basura ay ilalagay muna sa nasabing metal g', '2024-04-02 01:45:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(535, 167, '1th', '7', '2023-09-18', '2023-09-18', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 02:00:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(536, 167, '1th', '8', '2023-09-18', '2023-09-18', '2023-09-20 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 02:02:10', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(537, 167, '1th', '9', '2023-09-18', '2023-09-18', '2023-09-20 18:00:00', '2023-09-18', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 02:04:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(538, 167, '1th', '16', '2023-09-20', '0000-00-00', NULL, NULL, NULL, NULL, '', '1.	nagkaroon ng anghaharap ang magkabilang panig tungkol sa aksidenteng banggaan sa naganap noong september 16,2023.\r\n2.	ang magkabilang panig ay nagkapatawaran at inintindi nila ang sitwasyon ng bawat isa.', '2024-04-02 02:05:36', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(539, 168, '1th', '7', '2023-09-23', '2023-09-23', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 02:12:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(540, 168, '1th', '8', '2023-09-23', '2023-09-23', '2023-09-25 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 02:14:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(541, 168, '1th', '9', '2023-09-23', '2023-09-23', '2023-09-25 18:00:00', '2023-09-23', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 02:16:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(542, 168, '1th', '16', '2023-09-25', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Inamin ni MR. Kieser Maranan ang kanyang ginawang pagbabanta kay MR. Mark Toledo at nangakong hindi na ito mauulit sa huli ang magkabilang panig ay nagkapatawaran.', '2024-04-02 02:17:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(543, 169, '1th', '7', '2023-09-25', '2023-09-25', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 02:30:10', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(544, 169, '1th', '8', '2023-09-25', '2023-09-25', '2023-09-27 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 02:31:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(545, 169, '1th', '9', '2023-09-25', '2023-09-25', '2023-09-27 18:00:00', '2023-09-25', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 02:33:07', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(546, 169, '1th', '16', '2023-09-27', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang magkabilang panig ay nagkapatawaran matapos humingi ng tawad sa isa’t isa. Nangako si MR. Kenneth Villegas na hindi na mauulit ang pannununtok o anumang pananakit.', '2024-04-02 02:33:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(547, 170, '1th', '7', '2023-10-01', '2023-10-01', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 02:48:07', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(548, 170, '1th', '8', '2023-10-01', '2023-10-01', '2023-10-04 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 02:49:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(549, 170, '1th', '9', '2023-10-01', '2023-10-01', '2023-09-04 18:00:00', '2023-10-01', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 02:50:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(550, 170, '1th', '16', '2023-10-04', '0000-00-00', NULL, NULL, NULL, NULL, '', 'The remaining balance of 29,500 pesos that Ms, Bessie owe Mr, Aguirre will be paid monthly via Gcash Ms Alforja promise to pay monthly a minimum of 2,000 pesos monthly without any missing payments.', '2024-04-02 02:53:13', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(551, 171, '1th', '7', '2023-10-01', '2023-10-01', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 02:58:35', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(552, 171, '1th', '8', '2023-10-01', '2023-10-01', '2023-10-04 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 02:59:37', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(553, 171, '1th', '9', '2023-10-01', '2023-10-01', '2023-10-04 18:00:00', '2023-10-01', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 03:00:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(554, 171, '1th', '16', '2023-10-04', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Both parties agreed that Mr, Alvin Jocson Cube will settle the overdue account of globe internet in the amount Php 8,936,64 on or before end of the October 2023.', '2024-04-02 03:02:02', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(555, 172, '1th', '7', '2023-10-03', '2023-10-03', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 03:05:53', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(556, 172, '1th', '8', '2023-10-03', '2023-10-03', '2023-10-06 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 03:07:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(557, 172, '1th', '9', '2023-10-03', '2023-10-03', '2023-10-06 18:00:00', '2023-10-03', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 03:08:32', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(558, 172, '1th', '16', '2023-10-06', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Mr, Christopher  Escobin will settle all utilities bills pertaining to the rented facility he will pay Php 6, 125 for the month of novermber and December proof of payment  of utility bills will be forwarded to Ms. Casubha and payments for November and Dec', '2024-04-02 03:09:35', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(559, 173, '1th', '7', '2023-10-03', '2023-10-03', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 03:21:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(560, 173, '1th', '8', '2023-10-03', '2023-10-03', '2023-10-06 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 03:22:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(561, 173, '1th', '9', '2023-10-03', '2023-10-03', '2023-10-06 18:00:00', '2023-10-03', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 03:23:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(562, 173, '1th', '16', '2023-10-06', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Mr, Alfred Ocampo will apologize through facebook to the friends of Ms, Alliyah Ocampo regarding the incident during her birthday\r\nAlso Mr, Alfred , Mr, Quiña, Mr, Llgas promise not to be involved in any attempt or cause harm to Ms. Laarni, Ms. Alliyah an', '2024-04-02 03:24:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(563, 174, '1th', '7', '2023-10-08', '2023-10-08', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 03:29:55', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(564, 174, '1th', '8', '2023-10-08', '2023-10-08', '2024-10-11 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 03:31:06', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(565, 174, '1th', '9', '2023-10-08', '2023-10-08', '2023-10-11 18:00:00', '2023-10-08', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 03:32:47', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(566, 174, '1th', '16', '2023-10-11', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo and dalawang panig na ibalik ang deposit (Php 8,000) upang mailagay naman sa lilipatan nilang apartment nagbayad si Letticia Garcia ng Php 8,000 pesos matapos ang di pagkakaunawaan tungkol sa deposits.', '2024-04-02 03:34:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(567, 175, '1th', '7', '2023-10-10', '2023-10-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 03:38:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(568, 175, '1th', '8', '2023-10-10', '2023-10-10', '2023-10-13 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 03:39:22', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(569, 175, '1th', '9', '2023-10-10', '2023-10-10', '2023-10-13 18:00:00', '2023-10-10', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 03:40:37', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(570, 175, '1th', '16', '2023-10-13', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig na tutubusin ni Arlene and dryer ng washing machine na iki nya kay Irene sa sabado, Uktobre 21, 2023 pagdating ng asawa nya galling sa trabaho sa Cavite.', '2024-04-02 03:41:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(571, 176, '1th', '7', '2023-10-10', '2023-10-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 03:45:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(572, 176, '1th', '8', '2023-10-10', '2023-10-10', '2023-10-13 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 03:46:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(573, 176, '1th', '9', '2023-10-10', '2023-10-10', '2023-10-13 18:00:00', '2023-10-10', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 03:47:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(574, 176, '1th', '16', '2023-10-13', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig na kausapin ni Sarah ang mister (ka live-in) ni Micah upang magpaliwanag tungkol sa maling impormasyon na nakarating sa kanya.', '2024-04-02 03:48:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(575, 177, '1th', '7', '2023-10-10', '2023-10-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 04:31:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(576, 177, '1th', '8', '2023-10-10', '2023-10-10', '2023-10-13 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 04:32:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(577, 177, '1th', '9', '2023-10-10', '2023-10-10', '2023-10-13 18:00:00', '2023-10-10', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 04:34:13', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(578, 177, '1th', '16', '2023-10-13', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig na babayaran ni Mr. Mula Cruz si Mr Laurel  ng halagang 2,000 pesos sa November 5, 2023 dito natatapos ang usapang ito.', '2024-04-02 04:34:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(579, 178, '1th', '7', '2023-10-17', '2023-10-17', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 04:39:47', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(580, 178, '1th', '8', '2023-10-17', '2023-10-17', '2023-10-19 14:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 04:41:06', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(581, 178, '1th', '9', '2023-10-17', '2023-10-17', '2023-10-19 14:00:00', '2023-10-17', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 04:42:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(582, 178, '1th', '16', '2023-10-19', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig sa halagang Php 10,000 ang kalhati nito Php 5,000 ay babayaran ni Mr. Servanez ngayong araw, October 11 2023 ang kalhati naman ay babayaran sa October 30 2023 dito na natatapos ang usaping ito.', '2024-04-02 04:42:36', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(583, 179, '1th', '7', '2023-10-16', '2023-10-16', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 04:47:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(584, 179, '1th', '8', '2023-10-16', '2023-10-16', '2023-10-20 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 04:49:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(585, 179, '1th', '9', '2023-10-16', '2023-10-16', '2023-10-20 18:00:00', '2023-10-16', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 04:50:22', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(586, 179, '1th', '16', '2023-10-20', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Magbabayad si Mr. Einnor A Lait ng Php 14,000 kada buwan s loob ng tatlong buwan hanggang makumpleto niya ang kabuuang halaga ng Php 42,000 na halaga ng perang Nawala dito na natapos ang usaping ito.', '2024-04-02 04:51:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(587, 180, '1th', '7', '2023-10-20', '2023-10-20', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 04:59:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(588, 180, '1th', '8', '2023-10-20', '2023-10-20', '2023-10-23 14:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 05:00:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(589, 180, '1th', '9', '2023-10-20', '2023-10-20', '2023-10-23 14:00:00', '2023-10-20', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 05:02:12', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(590, 180, '1th', '16', '2023-10-23', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang magkabilang panig ay nagkaroon ng paliwanagan at sa huli ya nanghingi ng paumanhin sa isat isa nangako naman si Mr.Montecillo na ang pangyayaring iyon ay hindi na mauulit.', '2024-04-02 05:04:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(591, 181, '1th', '7', '2023-11-05', '2023-11-05', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 05:09:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(592, 181, '1th', '8', '2023-11-05', '2023-11-05', '2023-11-08 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 05:10:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(593, 181, '1th', '9', '2023-11-05', '2023-11-05', '2023-11-08 18:00:00', '2023-11-05', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 05:11:45', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(594, 181, '1th', '16', '2023-11-08', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ms. Monica Saez will pay the damage to the motorcycle at Mr. Rolando it is agreed upon that 2,000 pesos will cover all the damages and that no other payments would be made the payment Mr. Maat will no longer be able to ask for additional payment for other', '2024-04-02 05:12:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(595, 182, '1th', '7', '2023-11-07', '2023-11-07', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 05:23:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(596, 182, '1th', '8', '2023-11-07', '2023-11-07', '2023-11-10 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 05:24:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(597, 182, '1th', '9', '2023-11-07', '2023-11-07', '2023-11-10 18:00:00', '2023-11-07', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 05:25:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(598, 182, '1th', '16', '2023-11-10', '0000-00-00', NULL, NULL, NULL, NULL, '', '1.  Mr. manigbas will be responsible pet owner and would keep his dog on a leash to prevent trash and dog from spreading in the reyes property\r\n2. Mr Manigbas will not participate in quarrels at his lang lady and the reyes will not curse or threat the rey', '2024-04-02 05:25:55', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(599, 183, '1th', '7', '2023-11-13', '2023-11-13', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 05:29:53', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(600, 183, '1th', '8', '2023-11-13', '2023-11-13', '2023-11-16 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 05:31:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(601, 183, '1th', '9', '2023-11-13', '2023-11-13', '2023-11-16 18:00:00', '2023-11-13', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 05:32:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(602, 183, '1th', '16', '2023-11-16', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang halagang Php 4,307 ay babayran ni Ms. Natanauan kar Mr. Ballesteros ngayong araw November 16,2023 bilang huling bayad nya sa hiniram nilang pera. Dito na natatapos ang usapang ito.', '2024-04-02 05:32:55', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(603, 184, '1th', '7', '2023-11-14', '2023-11-14', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 05:38:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(604, 184, '1th', '8', '2023-11-14', '2023-11-14', '2023-11-17 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 05:38:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(605, 184, '1th', '9', '2023-11-14', '2023-11-14', '2023-11-17 18:00:00', '2023-11-14', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 05:39:46', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(606, 184, '1th', '16', '2023-11-17', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. aalisin ang daan sa gilid ng daan at aalisin din ang anumang gamit sa hindi nila sakop na pwesto\r\n2. maglalagay ng basurahan sina Mr. Rene paul Manzano para maiwasan ang pagtatapon ng basura kung saan.\r\n3. Hindi na sila gagawa ng anumang bagay na ika- ', '2024-04-02 05:40:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(607, 185, '1th', '7', '2023-11-14', '2023-11-14', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 05:45:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(608, 185, '1th', '8', '2023-11-14', '2023-11-14', '2023-11-17 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 05:46:13', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(609, 185, '1th', '9', '2023-11-14', '2023-11-14', '2023-11-17 18:00:00', '2023-11-14', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 05:47:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(610, 185, '1th', '16', '2023-11-17', '0000-00-00', NULL, NULL, NULL, NULL, '', '1.  aalisin ang mga yero sa gilid ng daan at aalisin din ang anumang gamit sa hindi nila sakop na puwesto \r\n2. maglalagay ng basurahan sina Mr. Rene paul Manzano para maiwasan ang pagtatapon ng basura kung saan.\r\n3. Hindi na sila gagawa ng anumang bagay n', '2024-04-02 05:48:36', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(611, 186, '1th', '7', '2023-11-19', '2023-11-19', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 05:54:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(612, 186, '1th', '8', '2023-11-19', '2023-11-19', '2023-11-22 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 05:55:03', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(613, 186, '1th', '9', '2023-11-19', '2023-11-19', '2023-11-22 18:00:00', '2023-11-19', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 05:56:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(614, 186, '1th', '16', '2023-11-22', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Babayaran ni Romulo ang nagastos sa pagpapaturok Php 1,000.00 (anti rabies) kay Volma eins (anak ni willie panghuli ni sa linggo ) Nov. 26 Jenelyn na nakagat ng alagang aso mi Romulo \r\n2. Nakausap sina Romulo na huwag ng maglalaro sina John eins sa har', '2024-04-02 05:57:35', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(615, 187, '1th', '7', '2023-11-21', '2023-11-21', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 06:01:07', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(616, 187, '1th', '8', '2023-11-21', '2023-11-21', '2023-11-24 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 06:02:04', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(617, 187, '1th', '9', '2023-11-21', '2023-11-21', '2023-11-24 18:00:00', '2023-11-21', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 06:02:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(618, 187, '1th', '16', '2023-11-24', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig na babayaran munan ni Bonifacio si Jayson huling hiniram na Php 5,000 (emergency ) ito ay Disyembre mula 8, 2023(Friday) at tuwing biyernes sa halagang Php 1,250.00 (4 fridays)', '2024-04-02 06:03:32', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(619, 188, '1th', '7', '2023-12-03', '2023-12-03', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 06:06:56', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(620, 188, '1th', '8', '2023-12-03', '2023-12-03', '2023-12-06 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 06:07:52', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(621, 189, '1th', '7', '2023-12-24', '2023-12-24', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 06:13:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(622, 189, '1th', '8', '2023-12-24', '2023-12-24', '2023-12-27 14:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 06:14:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(623, 189, '1th', '9', '2023-12-24', '2023-12-24', '2023-12-27 14:00:00', '2023-12-24', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 06:15:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(624, 189, '1th', '16', '2023-12-27', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Napagkasunduan ng dalwang panig na kung magkano ang magiging computation na gagastusin sa pagpapaayos ng sasakyan ni Emmanuel G. Reyes ay babayaran ni Christopher N. Escobin ipapacompute ang damage sa Toyota Calamba\r\nAng pangyayaring sagian ng sasakyan ay', '2024-04-02 06:16:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(625, 190, '1th', '7', '2023-12-26', '2023-12-26', NULL, NULL, NULL, NULL, '', NULL, '2024-04-02 06:20:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(626, 190, '1th', '8', '2023-12-26', '2023-12-26', '2023-12-29 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-02 06:20:41', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(627, 190, '1th', '9', '2023-12-26', '2023-12-26', '2023-12-29 18:00:00', '2023-12-26', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 06:21:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(628, 190, '1th', '16', '2023-12-29', '0000-00-00', NULL, NULL, NULL, NULL, '', '1.  nagkasundo ang magkabilang panig na ang kabuuang Php 1,000 ay babayaran ni Jerick Eusebio Ngayong Darating na January 5, 2024\r\n2. Dito na nagtatapos ang usapang ito.', '2024-04-02 06:22:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(629, 188, '1th', '9', '2023-12-03', '2023-12-03', '2023-12-06 18:00:00', '2023-12-03', NULL, NULL, 'Ronaldo P. Zalameda', NULL, '2024-04-02 06:50:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(630, 188, '1th', '16', '2023-12-06', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Matapos magkapaliwanagan ang bawat isa nagkasundo sila na tapusin na ang isyung ito sa barangay na may kaakibat na obligasyon si Jerome ayon sa mga sumusunod:\r\n1. Humingi sya ng paumanhin kin Ms. Marianne at Ms. Lizbeth na nagawang mag post ng mga picture', '2024-04-02 06:58:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(631, 125, '1th', '16', '2023-03-05', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Pumayag si Ms, Cynthia Labita na Magbayad ng kalhati sa tumama sa STL na may halagang Php 12,000 sa april 24 2023. Ang bayaran ay magaganap dito sa tanggapan ng Batong Malake', '2024-04-03 02:27:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(632, 195, '1th', '7', '2023-09-27', '2023-09-27', NULL, NULL, NULL, NULL, '', NULL, '2024-04-03 03:11:04', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(633, 195, '1th', '8', '2023-09-27', '2023-09-27', '2023-09-29 14:00:00', NULL, NULL, NULL, '', NULL, '2024-04-03 03:11:47', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(634, 195, '1th', '9', '2023-09-27', '2023-09-27', '2023-09-29 14:00:00', '2023-09-27', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-03 03:12:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(635, 195, '1th', '16', '2023-09-29', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang magkabilang panig na mag babayad si Mr. Anthony D. Tagana ng Halagang Php 5,000 bilang bayad sa damage ng kaniyang pagkakabangga sa sasakyan nila MR. Jayous Neil Tabaquero at Fe P. Sangre .', '2024-04-03 03:15:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(636, 196, '1th', '7', '2023-09-13', '2023-09-13', NULL, NULL, NULL, NULL, '', NULL, '2024-04-03 05:59:45', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(637, 196, '1th', '8', '2023-09-13', '2023-09-13', '2023-09-15 18:00:00', NULL, NULL, NULL, '', NULL, '2024-04-03 06:00:48', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(638, 196, '1th', '9', '2023-09-13', '2023-09-13', '2023-09-15 18:00:00', '2023-09-13', NULL, NULL, 'RONALDO P. ZALAMEDA', NULL, '2024-04-03 06:01:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(639, 196, '1th', '16', '2023-09-15', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Remaining  deposit of MR. Daranciang amounting to six thousand ( Php 6,000) Peso will be returned by Ms. Isip.', '2024-04-03 06:03:06', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(640, 107, '1th', '9', '2023-12-26', '2023-12-26', '2023-12-28 01:00:00', '2023-12-26', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-12 03:27:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(641, 107, '2th', '8', '2023-12-29', '2023-12-29', '2024-01-04 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-12 03:30:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(642, 107, '2th', '9', '2023-12-29', '2023-12-29', '2024-01-04 01:00:00', '2023-12-29', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-12 03:34:12', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(644, 107, '2th', '16', '2024-01-03', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Babayaran ang halagang Php10,000.00 mula kay Javee Belencio, babayaran kay Gerald Allan Raminto sa sumusunod na paraan:\r\nJanuary 10, 2024 - Magbabayad sa halagang Php2,500.00\r\nJanuary 25, 2024 - Magbabayad sa halagang Php2,500.00\r\nFebruary 10, 2024 - M', '2024-04-12 06:17:03', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(645, 191, '1th', '8', '2024-04-13', '2024-04-13', '2024-04-13 16:10:00', NULL, NULL, NULL, '', NULL, '2024-04-15 01:10:13', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(646, 191, '2th', '8', '2024-04-12', '2024-04-12', '2024-04-12 16:10:00', NULL, NULL, NULL, '', NULL, '2024-04-15 01:10:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(647, 191, '1th', '8', '2024-04-12', '2024-04-12', '2024-04-12 19:59:00', NULL, NULL, NULL, '', NULL, '2024-04-15 01:42:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(648, 191, '1th', '10', '2024-04-12', '2024-04-12', '2024-04-12 16:47:00', NULL, NULL, NULL, '', NULL, '2024-04-15 01:50:41', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(649, 191, '1th', '8', '2024-04-12', '2024-04-12', '2024-04-12 19:59:00', NULL, NULL, NULL, '', NULL, '2024-04-15 01:54:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(650, 191, '1th', '8', '2024-04-12', '2024-04-12', '2024-04-12 19:59:00', NULL, NULL, NULL, '', NULL, '2024-04-15 01:55:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(651, 191, '1th', '16', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, '', 'sdfjuytsd12', '2024-04-15 02:30:33', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(653, 198, '0', '16', '2024-04-18', '0000-00-00', NULL, NULL, NULL, NULL, '', 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respond', '2024-04-15 02:50:13', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(654, 191, '1th', '16', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, '', 'fffffffffffffffffffffffffffffffff', '2024-04-15 02:55:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(655, 191, '1th', '16', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, '', 'fweefffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', '2024-04-15 02:56:28', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(656, 191, '1th', '16', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, '', 'fweefffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', '2024-04-15 02:57:55', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(657, 198, '0', '8', '2024-04-12', '2024-04-15', '2024-04-12 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-15 12:02:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(658, 198, '0', '8', '2024-04-11', '2024-04-12', '2024-04-01 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-15 12:02:43', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(659, 198, '0', '16', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, '', '1212', '2024-04-15 12:02:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(660, 198, '0', '16', '2033-02-04', '0000-00-00', NULL, NULL, NULL, NULL, '', '22', '2024-04-15 12:03:02', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(661, 198, '0', '22', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, 'Popoy Kaloyube', 'eeeeeeeeeeeeeeeeeee', '2024-04-15 12:18:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(662, 198, '0', '21', '2024-04-13', '2024-04-12', NULL, NULL, NULL, NULL, 'Sarah', '4124212', '2024-04-15 12:20:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(663, 198, '1th', '7', '2024-04-15', '2024-04-15', NULL, NULL, NULL, NULL, '', NULL, '2024-04-15 12:43:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(664, 198, '1th', '7', '2024-04-24', '2024-04-12', NULL, NULL, NULL, NULL, '', NULL, '2024-04-15 12:43:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(665, 198, '1th', '7', '2024-04-24', '2024-04-12', NULL, NULL, NULL, NULL, '', NULL, '2024-04-15 12:53:56', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(666, 198, '1th', '7', '2024-04-15', '2024-04-15', NULL, NULL, NULL, NULL, '', NULL, '2024-04-15 12:53:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(667, 198, '1th', '7', '2024-04-15', '2024-04-15', NULL, NULL, NULL, NULL, '', NULL, '2024-04-15 12:53:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(668, 198, '1th', '7', '2024-04-15', '2024-04-15', NULL, NULL, NULL, NULL, '', NULL, '2024-04-15 12:53:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(669, 199, '1th', '7', '2023-12-03', '2023-12-03', NULL, NULL, NULL, NULL, '', NULL, '2024-04-16 01:15:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(670, 199, '1th', '8', '2023-12-03', '2023-12-03', '2023-12-06 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-16 01:17:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(671, 199, '1th', '9', '2023-12-03', '2023-12-03', '2023-12-06 21:00:00', '2023-12-03', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-16 01:19:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(672, 199, '2th', '8', '2023-12-07', '2023-12-07', '2023-12-10 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-16 01:34:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(673, 199, '2th', '9', '2023-12-07', '2023-12-07', '2023-12-10 21:00:00', '2023-12-07', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-16 01:35:35', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(674, 199, '3th', '8', '2023-12-11', '2023-12-11', '2023-12-13 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-16 01:36:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(675, 199, '3th', '9', '2023-12-11', '2023-12-11', '2023-12-13 21:00:00', '2023-12-11', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-16 01:37:59', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(676, 199, '4th', '8', '2023-12-14', '2023-12-14', '2023-12-15 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-16 05:56:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(677, 199, '4th', '9', '2023-12-14', '2023-12-14', '2023-12-15 21:00:00', '2023-12-14', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-16 05:58:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(678, 199, '5th', '8', '2023-12-18', '2023-12-18', '2023-12-21 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-16 06:00:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(679, 199, '5th', '9', '2023-12-18', '2023-12-18', '2023-12-21 21:00:00', '2023-12-18', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-16 06:01:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(680, 199, '6th', '10', '2023-12-21', '2023-12-21', '2023-12-23 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-16 06:13:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(681, 199, '6th', '12', '2023-12-21', '2023-12-21', '2023-12-23 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-16 06:21:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(682, 199, '6th', '16', '2023-12-23', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang magkabilang panig sa rekomendasyon ng Municipal Engineering Office na maglalagay sina Michael Nicdao at Carla Nicdao ng sariling overflow connection underground. Sila ay magbabayad ng halagang Php5,000.00 kay Ms. Obrince.\r\n2. Ito ay kail', '2024-04-16 06:24:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(683, 198, '1th', '16', '2024-04-25', '0000-00-00', NULL, NULL, NULL, NULL, '', 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respond', '2024-04-17 03:07:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(684, 200, '0', '16', '2024-04-03', '0000-00-00', NULL, NULL, NULL, NULL, '', 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respond', '2024-04-17 03:53:54', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(685, 200, '0', '16', '2024-04-24', '0000-00-00', NULL, NULL, NULL, NULL, '', 'wwwwwww', '2024-04-17 04:06:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(686, 200, '0', '24', NULL, '2024-04-12', '2024-04-11 18:11:00', NULL, NULL, NULL, 'April 17, 2024', '1111111', '2024-04-17 04:48:23', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(687, 200, '0', '25', '2024-04-12', '2024-04-11', NULL, NULL, NULL, 'Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here.Enter text here', 'Ryan Cayabyab', 'Carl Janzell Oropesa', '2024-04-17 04:55:58', '12,122 pesos', 0, NULL, 0, NULL, 0, NULL, 0),
(688, 200, '0', '16', '2024-04-04', '0000-00-00', NULL, NULL, NULL, NULL, '', 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:', '2024-04-17 05:03:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(689, 201, '1th', '7', '2024-01-15', '2024-01-15', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 05:20:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(690, 201, '1th', '8', '2024-01-15', '2024-01-15', '2024-01-18 01:20:00', NULL, NULL, NULL, '', NULL, '2024-04-17 05:21:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(691, 201, '1th', '9', '2024-01-15', '2024-01-15', '2024-01-18 01:00:00', '2024-01-15', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-17 05:22:10', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(692, 201, '1th', '16', '2024-01-17', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Hindi na magkakaroon ng pagpaparinigan na kung anumang masakit na mga pananalita at pagsasabihan din ang kanilang Family Members upang magkaroon ng katahimikan at kaayusan sa kanilang komunidad na tinitirahan.\r\nHindi na rin ipinagpapatuloy ang reklamo kay Raquel Percha Cabrera use name is reflected in the Complainant as \"Raquel Cabrera Flores\"', '2024-04-17 05:26:45', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(693, 202, '1th', '7', '2024-01-16', '2024-01-16', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 05:56:06', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(694, 202, '1th', '8', '2024-01-16', '2024-01-16', '2024-01-20 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:00:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(695, 202, '1th', '9', '2024-01-16', '2024-01-16', '2024-01-20 01:00:00', '2024-01-16', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-17 06:02:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(696, 200, '0', '16', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, '', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA VVVVVVVVVVVVVVVVVVV CCCCCCCCCCCCCCCCCCCCCCCCC', '2024-04-17 06:04:28', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(697, 202, '1th', '16', '2024-01-19', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Ang respondent ay hindi pinapalayas ang complainant dahil ang complainant ay may karapatan din tumira sa property na kinatatayuan nito. Bilang pagkakasundo, commitment ng bawat partido na hindi na magpapalitan ng kung anumang masasakit na mga pananalita.', '2024-04-17 06:09:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(698, 200, '1th', '20', '2024-04-02', '0000-00-00', NULL, NULL, NULL, NULL, 'Aanrjea', 'AAWj', '2024-04-17 06:22:25', NULL, 1, NULL, 0, 'jjkj', 0, 'jjj', 0),
(699, 203, '0', '7', '2024-01-16', '2024-01-16', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 06:35:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(700, 203, '0', '8', '2024-01-16', '2024-01-16', '2024-01-20 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:36:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(701, 203, '0', '9', '2024-01-16', '2024-01-16', '2024-01-20 01:00:00', '2024-01-16', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-17 06:37:04', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(702, 203, '0', '16', '2024-01-19', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Respondent will pay the complainant with the amount of Five Thousand Pesos to be paid as follows:\r\nJanuary 31, 2024 - PhP1,000.00\r\nFebruary 7, 2024 - PhP1,000.00\r\nFebruary 14, 2024 - PhP1,000.00\r\nFebruary 21, 2024 - PhP1,000.00\r\nFebruary 28, 2024 - Php1,000.00\r\nPayments will give and receive here at Barangay and in front of Barangay Secretary.', '2024-04-17 06:43:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(703, 203, '1th', '7', '2024-01-16', '2024-01-16', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 06:46:03', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(704, 203, '1th', '8', '2024-01-16', '2024-01-16', '2024-01-20 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:46:38', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(705, 200, '2th', '9', '2022-02-01', '2024-04-01', '2021-01-01 18:11:00', '2024-04-03', 1, '', 'Kisha', NULL, '2024-04-17 06:50:40', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(706, 203, '1th', '9', '2024-01-16', '2024-01-16', '2024-01-20 01:00:00', '2024-01-16', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-17 06:51:48', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(707, 200, '2th', '7', '2024-04-17', '2024-04-17', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 06:53:47', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(708, 200, '2th', '7', '2024-04-17', '2024-04-17', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 06:53:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(709, 200, '2th', '8', '2024-04-12', '2024-04-13', '2024-04-01 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:54:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(710, 200, '2th', '8', '2024-04-12', '2024-04-13', '2024-04-01 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:54:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(711, 200, '2th', '8', '2024-04-12', '2024-04-13', '2024-04-01 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:54:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(712, 200, '2th', '9', '2024-04-01', '2024-04-12', '2024-04-12 18:11:00', '2024-04-03', 3, '', 'IAN NORA KALAW', NULL, '2024-04-17 06:56:20', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(713, 200, '2th', '9', '2024-04-01', '2024-04-12', '2024-04-12 18:11:00', '2024-04-03', 3, '', 'IAN NORA KALAW', NULL, '2024-04-17 06:56:24', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(714, 203, '1th', '16', '2024-01-19', '0000-00-00', NULL, NULL, NULL, NULL, '', 'The respondent will pay the complainant for the total amount of Php5,000.00, to be paid for the following schedule:\r\nJanuary 31, 2024 - Php1,000.00\r\nFebruary 7, 2024 - Php1,000.00\r\nFebruary 14, 2024 - Php1,000.00\r\nFebruary 21, 2024 - Php1,000.00\r\nFebruary 28, 2024 - Php1,000.00\r\nPayments will give and receive here at Barangay and in front of Barangay Secretary.', '2024-04-17 06:56:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(715, 200, '2th', '10', '2024-04-01', '2024-04-03', '2024-04-02 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:57:27', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(716, 200, '2th', '10', '2024-04-01', '2024-04-03', '2024-04-02 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:57:32', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(717, 200, '2th', '11', NULL, '2024-02-14', NULL, NULL, NULL, 'Prince Salazar', 'Carl Oropesa', NULL, '2024-04-17 06:57:50', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(718, 200, '2th', '11', NULL, '2024-02-14', NULL, NULL, NULL, 'Prince Salazar', 'Carl Oropesa', NULL, '2024-04-17 06:57:56', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(719, 200, '2th', '12', '2024-04-01', '2024-04-01', '2024-04-02 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:58:11', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(720, 200, '2th', '12', '2024-04-01', '2024-04-01', '2024-04-02 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:58:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(721, 200, '2th', '12', '2024-04-01', '2024-04-01', '2024-04-02 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:58:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(722, 200, '2th', '12', '2024-04-01', '2024-04-01', '2024-04-02 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 06:58:16', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(723, 204, '1th', '7', '2024-01-23', '2024-01-23', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 07:16:41', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(724, 204, '1th', '8', '2024-01-24', '2024-01-24', '2024-01-26 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-17 07:17:24', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(725, 204, '1th', '9', '2024-01-24', '2024-01-24', '2024-01-26 21:00:00', '2024-01-24', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-17 07:18:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(726, 204, '1th', '16', '2024-01-26', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang dalawang panig na ang PhP40,000.00 ay gawin na lamang na PhP30,000.00 at ibawas ang paunang bayad na Php9,000.00. Kaya ang babayaran ni Harvard Hernani ay ang balanse na PhP21,000.00 upang maayos na ang usapin na ito. Ito ay patunay na Fully paid na si Harvard Hernani kay Rommel Alvarado at sila ay nagbayaran sa tanggapan ng Barangay Batong Malake, Los BaÃ±os, Laguna.', '2024-04-17 07:41:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(727, 200, '2th', '16', '2024-04-24', '0000-00-00', NULL, NULL, NULL, NULL, '', 'and bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\nmadami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami \r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\nmadami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami \r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\n\r\nand bind ourselves to comply honestly and faithfully with the above terms of settlement.\r\nmadami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami madami \r\n', '2024-04-17 08:18:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(728, 200, '2th', '16', '2024-04-11', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, Hello madami, ', '2024-04-17 08:20:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(729, 135, '1th', '8', '2024-04-01', '2024-04-21', '2021-01-11 08:00:00', NULL, NULL, NULL, '', NULL, '2024-04-17 08:26:14', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(730, 135, '1th', '9', '2024-04-12', '2024-04-12', '2012-04-12 18:11:00', '2024-04-11', 1, '', 'IAN NORA KALAW', NULL, '2024-04-17 08:27:32', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(731, 135, '1th', '10', '2024-04-01', '2024-04-01', '2024-04-11 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 08:28:18', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(732, 135, '1th', '11', NULL, '2024-04-01', NULL, NULL, NULL, 'Mary Grace Bautista', 'Prince Salazar', NULL, '2024-04-17 08:28:42', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(733, 135, '1th', '12', '2024-04-01', '2024-04-01', '2024-01-01 18:11:00', NULL, NULL, NULL, '', NULL, '2024-04-17 08:29:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(734, 135, '1th', '13', '2024-04-01', '0000-00-00', '2024-04-01 18:11:00', NULL, NULL, 'aaaaaaaaaaaa', 'bbbbbbbbbbbb', 'ccccccccccc', '2024-04-17 08:30:37', 'ddddddddddd', 0, NULL, 0, NULL, 0, NULL, 0),
(735, 135, '1th', '14', '2024-04-12', '0000-00-00', NULL, NULL, NULL, NULL, '', NULL, '2024-04-17 08:31:07', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(736, 135, '1th', '15', NULL, '2024-04-21', NULL, NULL, NULL, 'Phil Bojo Repotente', 'Angel May DeGuzman', 'IAN NORA KALAW', '2024-04-17 08:32:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0);
INSERT INTO `hearings` (`id`, `complaint_id`, `hearing_number`, `form_used`, `made_date`, `received_date`, `appear_date`, `resp_date`, `scenario`, `scenario_info`, `officer`, `settlement`, `created`, `subpoena`, `fraud_check`, `fraud_text`, `violence_check`, `violence_text`, `intimidation_check`, `intimidation_text`, `fourth_check`) VALUES
(737, 135, '1th', '16', '2024-04-05', '0000-00-00', NULL, NULL, NULL, NULL, '', 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:\r\n\r\nWe, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:', '2024-04-17 08:33:12', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(738, 135, '1th', '17', '2024-04-13', '2024-04-15', NULL, '2024-04-14', NULL, NULL, '', NULL, '2024-04-17 08:34:15', NULL, 1, 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:', 1, 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows: We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:', 1, 'We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:', 0),
(739, 135, '1th', '18', '2024-04-13', '2024-04-14', '2024-04-11 18:11:00', '2024-04-12', NULL, NULL, '', NULL, '2024-04-17 08:34:58', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(740, 135, '1th', '19', '2024-04-14', '2024-04-15', '2024-04-11 18:12:00', '2024-04-13', NULL, NULL, '', NULL, '2024-04-17 08:35:57', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(741, 135, '1th', '20', '2024-04-11', '0000-00-00', NULL, NULL, NULL, NULL, 'RONALDO P. ZALAMEDA', 'RONALDO P. ZALAMEDA', '2024-04-17 08:39:13', NULL, 1, NULL, 1, 'Popoy Kaloy', 0, 'Jayson Cuason', 1),
(742, 135, '1th', '26', '2024-04-11', '0000-00-00', NULL, NULL, NULL, NULL, '   RONALDO P. ZALAMEDA', 'RONALDO P. ZALAMEDA', '2024-04-17 08:39:36', NULL, 1, NULL, 1, NULL, 0, NULL, 1),
(743, 135, '1th', '27', '2024-04-11', '0000-00-00', NULL, NULL, NULL, NULL, 'RONALDO P. ZALAMEDA', 'RONALDO P. ZALAMEDA', '2024-04-17 08:40:02', NULL, 1, NULL, 1, NULL, 1, NULL, 1),
(744, 135, '1th', '21', '2024-04-12', '2024-04-11', NULL, NULL, NULL, NULL, 'Jayson Cuason', 'RONALDO P. ZALAMEDA', '2024-04-17 08:40:29', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(745, 135, '1th', '22', '2024-04-19', '0000-00-00', NULL, NULL, NULL, NULL, 'Popoy Kaloy', 'addadadada', '2024-04-17 08:42:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(746, 135, '1th', '23', '2024-04-20', '0000-00-00', NULL, NULL, NULL, NULL, 'April 17, 2024', 'teetetetettetetet', '2024-04-17 08:43:00', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(747, 135, '1th', '24', NULL, '2024-04-12', '2024-04-11 18:11:00', NULL, NULL, NULL, 'April 17, 2024', 'RONALDO P. ZALAMEDA', '2024-04-17 08:43:32', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(748, 135, '1th', '25', '2021-04-11', '2024-04-11', NULL, NULL, NULL, 'RONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDARONALDO P. ZALAMEDA', 'RONALDO P. ZALAMEDA', 'RONALDO P. ZALAMEDA', '2024-04-17 08:44:03', 'RONALDO P. ZALAMEDA', 0, NULL, 0, NULL, 0, NULL, 0),
(749, 205, '1th', '7', '2024-01-29', '2024-01-29', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 01:31:08', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(750, 205, '1th', '8', '2024-01-29', '2024-01-29', '2024-02-01 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-19 01:34:26', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(751, 205, '1th', '9', '2024-01-29', '2024-01-29', '2024-02-01 21:00:00', '2024-01-29', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-19 01:36:25', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(752, 205, '1th', '16', '2024-02-01', '0000-00-00', NULL, NULL, NULL, NULL, '', 'Nagkasundo ang dalawang panig na sasagutin ni Jayson S. Estiva lahat ng gastusin sa pag-papagamot ni Mario M. De Guia sa nangyaring aksidente. Oobserbahan kung meron pang ibang maramdaman si Mario De Guia sa mga darating na araw at kung meron pa dapat gastusin, ito ay sasagutin ni Jayson Estiva.\r\nKung hindi sumunod si Jayson Estiva sa kasunduan, itutuloy ang reklamo kay Jayson Estiva.', '2024-04-19 01:50:55', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(753, 206, '1th', '7', '2024-02-04', '2024-02-04', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 02:09:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(754, 206, '1th', '8', '2024-02-05', '2024-02-05', '2024-02-08 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-19 02:10:36', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(755, 206, '1th', '9', '2024-02-05', '2024-02-05', '2024-02-08 01:00:00', '2024-02-05', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-19 02:11:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(756, 206, '1th', '16', '2024-02-07', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang dalawang panig. Humingi ng tawad si Mel Tejada kay Amparo Magbanua kung ano man ang nasabi ni Mel Tejada tungkol kay Amparo. Umalis naman ng maayos si Amparo kila Mel Tejada.\r\n2. Dito na natatapos ang usaping ito.', '2024-04-19 02:24:39', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(757, 207, '0', '7', '2024-02-10', '2024-02-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 02:43:22', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(758, 207, '1th', '7', '2024-02-10', '2024-02-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 02:44:15', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(759, 207, '1th', '8', '2024-02-10', '2024-02-10', '2024-02-13 22:00:00', NULL, NULL, NULL, '', NULL, '2024-04-19 02:46:34', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(760, 207, '1th', '9', '2024-02-10', '2024-02-10', '2024-02-13 22:00:00', '2024-02-10', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-19 02:47:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(761, 207, '1th', '16', '2024-02-13', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Napagkasunduan na bibigyan pa ng isang pagkakataon si Jenirey Olmidillo na tigilan ang kanyang paninira kila Mary Rose Alumbro at Ogie Alumbro Y Delas Armas.\r\n2. Sa oras na may marinig pa sila na paninira ni Jenirey, itutuloy nila ang pag-file ng kaso.', '2024-04-19 02:51:05', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(762, 105, '1th', '7', '2024-02-10', '2024-02-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 03:12:42', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(763, 105, '1th', '8', '2024-02-10', '2024-02-10', '2024-02-13 21:00:00', NULL, NULL, NULL, '', NULL, '2024-04-19 03:15:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(764, 105, '1th', '9', '2024-02-10', '2024-02-10', '2024-02-13 21:00:00', '2024-02-10', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-19 03:16:02', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(766, 105, '1th', '16', '2024-02-13', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang dalawang panig na huhulugan ni Cristina Talamo ang balanse na Php2,000.00.\r\n2. Huhulugan ni Cristina ng Php200.00 weekly.\r\n3. Dadalhin niya sa Barangay Batong Malake ang hulog tuwing linggo ng umaga at ito at kukunin ni Anabel sa barangay.\r\n4. Dito na natatapos ang usapin na ito.', '2024-04-19 04:35:32', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(767, 208, '1th', '7', '2024-02-10', '2024-02-10', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 05:02:44', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(768, 209, '1th', '7', '2024-02-12', '2024-02-12', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 05:17:06', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(769, 209, '1th', '8', '2024-02-12', '2024-02-12', '2024-02-15 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-19 05:18:17', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(770, 209, '1th', '9', '2024-02-12', '2024-02-12', '2024-02-15 01:00:00', '2024-02-12', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-19 05:19:19', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(771, 209, '1th', '16', '2024-02-14', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Nagkasundo ang dalawang panig na bibigyan ng isang buwan si Ramonato Carreon upang umalis sa lugar kung saan siya nakapwesto para sa paninda niyang softdrinks.\r\n2. Bibigyan siya hanggang March 15, 2024 upang mabakante ang lugar. Simula February 15, 2024 ang pagbakante sa nasabing lugar.', '2024-04-19 05:22:09', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(772, 211, '1th', '7', '2024-02-12', '2024-02-12', NULL, NULL, NULL, NULL, '', NULL, '2024-04-19 05:54:21', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(773, 211, '1th', '8', '2024-02-12', '2024-02-12', '2024-02-15 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-19 05:55:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(774, 211, '1th', '9', '2024-02-12', '2024-02-12', '2024-02-15 01:00:00', '2024-02-12', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-19 05:55:49', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(775, 211, '2th', '8', '2024-02-16', '2024-02-16', '2024-02-22 01:00:00', NULL, NULL, NULL, '', NULL, '2024-04-19 05:57:01', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(776, 211, '2th', '9', '2024-02-16', '2024-02-16', '2024-02-22 01:00:00', '2024-02-16', 1, '', 'RONALDO P. ZALAMEDA', NULL, '2024-04-19 05:57:51', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(777, 211, '2th', '16', '2024-02-21', '0000-00-00', NULL, NULL, NULL, NULL, '', '1. Inamin ni G. Padilla ang kanyang kasalanan na pagwawala at pagkasira ng dalawang upuan ni Gng. Helen na kanyang kapatid nang siya ay lasing.\r\n2. Nangako siyang papalitan ang nasirang upuan at gayundi ang hindi na mauulit pa ang ganitong pangyayari sa kanilang magkapatid.\r\n3. Kung maulit man, idudulog itong muli sa Barangay at kinauukulan.\r\n4. Dito nagtatapos ang usaping ito.', '2024-04-19 06:03:31', NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(778, 200, '2th', '11', '2021-01-11', '2024-04-12', NULL, NULL, NULL, 'Angel May DeGuzman', 'Angel May DeGuzman', NULL, '2024-04-19 07:00:30', NULL, 0, NULL, 0, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `luponforms`
--

CREATE TABLE `luponforms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `formUsed` int(11) NOT NULL,
  `made_date` date DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `lupon1` varchar(255) DEFAULT NULL,
  `lupon2` varchar(255) DEFAULT NULL,
  `lupon3` varchar(255) DEFAULT NULL,
  `lupon4` varchar(255) DEFAULT NULL,
  `lupon5` varchar(255) DEFAULT NULL,
  `lupon6` varchar(255) DEFAULT NULL,
  `lupon7` varchar(255) DEFAULT NULL,
  `lupon8` varchar(255) DEFAULT NULL,
  `lupon9` varchar(255) DEFAULT NULL,
  `lupon10` varchar(255) DEFAULT NULL,
  `lupon11` varchar(255) DEFAULT NULL,
  `lupon12` varchar(255) DEFAULT NULL,
  `lupon13` varchar(255) DEFAULT NULL,
  `lupon14` varchar(255) DEFAULT NULL,
  `lupon15` varchar(255) DEFAULT NULL,
  `lupon16` varchar(255) DEFAULT NULL,
  `lupon17` varchar(255) DEFAULT NULL,
  `lupon18` varchar(255) DEFAULT NULL,
  `lupon19` varchar(255) DEFAULT NULL,
  `lupon20` varchar(255) DEFAULT NULL,
  `pngbrgy` varchar(255) DEFAULT NULL,
  `brgysec` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `luponforms`
--

INSERT INTO `luponforms` (`id`, `user_id`, `formUsed`, `made_date`, `received_date`, `lupon1`, `lupon2`, `lupon3`, `lupon4`, `lupon5`, `lupon6`, `lupon7`, `lupon8`, `lupon9`, `lupon10`, `lupon11`, `lupon12`, `lupon13`, `lupon14`, `lupon15`, `lupon16`, `lupon17`, `lupon18`, `lupon19`, `lupon20`, `pngbrgy`, `brgysec`, `created`) VALUES
(1, 115, 1, '2024-04-02', '2024-04-05', 'Angel May DeGuzman', 'Kisha', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'CALABARZON', NULL, '2024-04-08 02:37:13'),
(2, 115, 6, '2024-04-12', '2024-04-08', 'Angel May DeGuzman', 'on', 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww', 'on', 'wwwwwwwwwwwwwwwwwwwwwwwwwww', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, '', NULL, '2024-04-08 03:28:55'),
(3, 115, 1, '2024-04-12', '2024-04-12', 'Angel May DeGuzman', 'Prince Salazar', 'Phil Bojo Repotente', 'Kisha Bautista', 'Carl Oropesa', 'Mary Grace Bautista', 'Jigen Cabral', 'Kevin Enriquez', 'Dran Marc Villamayor', 'JR Garcia', 'Delfin', '', '', '', '', '', '', '', '', '', 'IAN NORA KALAW', NULL, '2024-04-12 04:56:49'),
(4, 115, 2, '2024-04-11', NULL, 'Angel May DeGuzman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IAN NORA KALAW', 'Mary Grace De Guzmanism', '2024-04-15 12:53:04'),
(5, 115, 2, '2024-04-11', NULL, 'Angel May DeGuzman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IAN NORA KALAW', 'Mary Grace De Guzmanism', '2024-04-15 12:53:06'),
(6, 115, 2, '2024-04-11', NULL, 'Angel May DeGuzman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IAN NORA KALAW', 'Mary Grace De Guzmanism', '2024-04-15 12:53:06'),
(7, 115, 1, '2021-04-12', '2024-04-21', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14``', '141', '15', '161', '18', '71', '12', 'IAN NORA KALAW', NULL, '2024-04-17 06:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `lupons`
--

CREATE TABLE `lupons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name1` varchar(255) DEFAULT NULL,
  `name2` varchar(255) DEFAULT NULL,
  `name3` varchar(255) DEFAULT NULL,
  `name4` varchar(255) DEFAULT NULL,
  `name5` varchar(255) DEFAULT NULL,
  `name6` varchar(255) DEFAULT NULL,
  `name7` varchar(255) DEFAULT NULL,
  `name8` varchar(255) DEFAULT NULL,
  `name9` varchar(255) DEFAULT NULL,
  `name10` varchar(255) DEFAULT NULL,
  `name11` varchar(255) DEFAULT NULL,
  `name12` varchar(255) DEFAULT NULL,
  `name13` varchar(255) DEFAULT NULL,
  `name14` varchar(255) DEFAULT NULL,
  `name15` varchar(255) DEFAULT NULL,
  `name16` varchar(255) DEFAULT NULL,
  `name17` varchar(255) DEFAULT NULL,
  `name18` varchar(255) DEFAULT NULL,
  `name19` varchar(255) DEFAULT NULL,
  `name20` varchar(255) DEFAULT NULL,
  `punong_barangay` varchar(255) DEFAULT NULL,
  `lupon_chairman` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `appoint` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lupons`
--

INSERT INTO `lupons` (`id`, `user_id`, `name1`, `name2`, `name3`, `name4`, `name5`, `name6`, `name7`, `name8`, `name9`, `name10`, `name11`, `name12`, `name13`, `name14`, `name15`, `name16`, `name17`, `name18`, `name19`, `name20`, `punong_barangay`, `lupon_chairman`, `created_at`, `appoint`) VALUES
(89, 109, 'Romeo Estrella', 'John Oliver Ramos', 'Angelina Margallo', 'Ma. Elizabeth Taytay', 'Merlita Arias', 'Patrik Anthony ', 'Crispino TIbayan', 'Rudy Fernandez', 'Rosauro Castelltort', 'Eddie Ramos', 'Meliton Trinidad', 'Joseph Magsino ', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DR. APOLINARIO ALZONA', 'DR APOLINARIO ALZONA', '2024-03-10 18:24:01', 0),
(90, 110, 'Justina T. Pempengco', 'Pio Mijares Jr.', 'Fernando Paras Jr.', 'Myrna Servaï¿½ez', 'Olive Bejo', 'Edmund Apatan', 'Allan R. Leron', 'Orly Kalaw', 'Rolito Bacalangco', 'Vilma Bandian', 'Arabello S. Andres', 'Simonette Lim', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IAN N. KALAW', 'IAN N. KALAW', '2024-03-10 18:25:13', 0),
(91, 109, 'Romeo Estrella', 'John Oliver Ramos', 'Angelina Margallo', 'Ma. Elizabeth Taytay', 'Merlita Arias', 'Patrik Anthony ', 'Crispino TIbayan', 'Rudy Fernandez', 'Rosauro Castelltort', 'Eddie Ramos', 'Meliton Trinidad', 'Joseph Magsino ', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '2024-03-10 18:27:21', 1),
(92, 110, 'Justina T. Pempengco', 'Pio Mijares Jr.', 'Fernando Paras Jr.', 'Myrna Servañez', 'Olive Bejo', 'Edmund Apatan', 'Allan R. Leron', 'Orly Kalaw', 'Rolito Bacalangco', 'Vilma Bandian', 'Jojo Andres', 'Simonette Lim', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '2024-03-10 18:32:32', 1),
(95, 115, 'Angel May DeGuzman', 'Prince Salazar', 'Phil Bojo Repotente', 'Kisha Bautista', 'Carl Oropesa', 'Mary Grace Bautista', 'Jigen Cabral', 'Kevin Enriquez', 'Dran Marc Villamayor', 'JR Garcia', 'Delfin', 'Kisha', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IAN NORA KALAW', 'JAIME BERON', '2024-03-29 20:52:05', 0),
(96, 115, 'Angel May DeGuzman', 'Prince Salazar', 'Phil Bojo Repotente', 'Kisha Bautista', 'Carl Oropesa', 'Mary Grace Bautista', 'Jigen Cabral', 'Kevin Enriquez', 'Dran Marc Villamayor', 'JR Garcia', 'Delfin', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ian Nora Kalaw', 'Jaime Beron', '2024-03-31 17:37:55', 1),
(97, 135, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 03:19:35', 0),
(98, 136, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 03:51:53', 0),
(99, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-24 13:25:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mov`
--

CREATE TABLE `mov` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `IA_1a_pdf_File` varchar(255) DEFAULT NULL,
  `IA_1b_pdf_File` varchar(255) DEFAULT NULL,
  `IA_2_pdf_File` varchar(255) DEFAULT NULL,
  `IA_2a_pdf_File` varchar(255) DEFAULT NULL,
  `IA_2b_pdf_File` varchar(255) DEFAULT NULL,
  `IA_2c_pdf_File` varchar(255) DEFAULT NULL,
  `IA_2d_pdf_File` varchar(255) DEFAULT NULL,
  `IA_2e_pdf_File` varchar(255) DEFAULT NULL,
  `IB_1forcities_pdf_File` varchar(255) DEFAULT NULL,
  `IB_1aformuni_pdf_File` varchar(255) DEFAULT NULL,
  `IB_1bformuni_pdf_File` varchar(255) DEFAULT NULL,
  `IB_2_pdf_File` varchar(255) DEFAULT NULL,
  `IB_3_pdf_File` varchar(255) DEFAULT NULL,
  `IB_4_pdf_File` varchar(255) DEFAULT NULL,
  `IC_1_pdf_File` varchar(255) DEFAULT NULL,
  `IC_2_pdf_File` varchar(255) DEFAULT NULL,
  `ID_1_pdf_File` varchar(255) DEFAULT NULL,
  `ID_2_pdf_File` varchar(255) DEFAULT NULL,
  `IIA_pdf_File` varchar(225) DEFAULT NULL,
  `IIB_1_pdf_File` varchar(255) DEFAULT NULL,
  `IIB_2_pdf_File` varchar(255) DEFAULT NULL,
  `IIC_pdf_File` varchar(255) DEFAULT NULL,
  `IIIA_pdf_File` varchar(255) DEFAULT NULL,
  `IIIB_pdf_File` varchar(255) DEFAULT NULL,
  `IIIC_1forcities_pdf_File` varchar(255) DEFAULT NULL,
  `IIIC_1forcities2_pdf_File` varchar(255) DEFAULT NULL,
  `IIIC_1forcities3_pdf_File` varchar(255) DEFAULT NULL,
  `IIIC_2formuni1_pdf_File` varchar(255) DEFAULT NULL,
  `IIIC_2formuni2_pdf_File` varchar(255) DEFAULT NULL,
  `IIIC_2formuni3_pdf_File` varchar(255) DEFAULT NULL,
  `IIID_pdf_File` varchar(255) DEFAULT NULL,
  `IV_forcities_pdf_File` varchar(255) DEFAULT NULL,
  `IV_muni_pdf_File` varchar(255) DEFAULT NULL,
  `V_1_pdf_File` varchar(255) DEFAULT NULL,
  `threepeoplesorg` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mov`
--

INSERT INTO `mov` (`id`, `user_id`, `barangay_id`, `IA_1a_pdf_File`, `IA_1b_pdf_File`, `IA_2_pdf_File`, `IA_2a_pdf_File`, `IA_2b_pdf_File`, `IA_2c_pdf_File`, `IA_2d_pdf_File`, `IA_2e_pdf_File`, `IB_1forcities_pdf_File`, `IB_1aformuni_pdf_File`, `IB_1bformuni_pdf_File`, `IB_2_pdf_File`, `IB_3_pdf_File`, `IB_4_pdf_File`, `IC_1_pdf_File`, `IC_2_pdf_File`, `ID_1_pdf_File`, `ID_2_pdf_File`, `IIA_pdf_File`, `IIB_1_pdf_File`, `IIB_2_pdf_File`, `IIC_pdf_File`, `IIIA_pdf_File`, `IIIB_pdf_File`, `IIIC_1forcities_pdf_File`, `IIIC_1forcities2_pdf_File`, `IIIC_1forcities3_pdf_File`, `IIIC_2formuni1_pdf_File`, `IIIC_2formuni2_pdf_File`, `IIIC_2formuni3_pdf_File`, `IIID_pdf_File`, `IV_forcities_pdf_File`, `IV_muni_pdf_File`, `V_1_pdf_File`, `threepeoplesorg`, `date`) VALUES
(1, 135, 93, 'wa_20240918115653_426c9214.pdf', '_20240918115653_6d1e7428.', '_20240918115653_9ba34b30.', '_20240918115653_f42d79ef.', '_20240918115653_f16df572.', '_20240918115653_2ca05766.', '_20240918115653_f737097b.', '_20240918115653_6de1940a.', '_20240918115653_cb46c6cd.', '_20240918115653_53de83ec.', '_20240918115653_a60fa7c9.', '_20240918115653_2e0fdeb0.', '_20240918115653_28768d07.', '_20240918115653_8e3436d2.', '_20240918115653_fc91db4d.', '_20240918115653_b526712f.', '_20240918115653_20eec097.', '_20240918115653_1d70bda9.', '_20240918115653_39c7a81a.', '_20240918115653_f28cff9e.', '_20240918115653_bfa9855b.', '_20240918115653_cbe0550d.', '_20240918115653_4016cf7f.', '_20240918115653_29a38e42.', '_20240918115653_bf0a676e.', '_20240918115653_4843445a.', '_20240918115653_b39b1c26.', '_20240918115653_8a4ba49f.', '_20240918115653_bbd948c0.', '_20240918115653_f71b0f45.', '_20240918115653_f466e097.', '_20240918115653_288bec64.', '_20240918115653_ae06809e.', '_20240918115653_178d1e00.', '_20240918115653_95cf568e.', '2024-09-18 17:56:53'),
(2, 115, 1, '_20240924120405_737feb43.', '_20240924120405_50140068.', '_20240924120405_62fe5b5b.', '_20240924120405_c4606c9c.', '_20240924120405_4bcf3873.', '_20240924120405_4128527d.', '_20240924120405_3f5c44eb.', '_20240924120405_81fce7e7.', '_20240924120405_508de008.', '_20240924120405_9a46ad87.', '_20240924120405_81ad14ab.', '_20240924120405_095cbf15.', '_20240924120405_10d41cea.', '_20240924120405_89984736.', '_20240924120405_b2871587.', '_20240924120405_356f4ace.', '_20240924120405_e7243500.', '_20240924120405_7bd3171d.', '_20240924120405_42af90e3.', '_20240924120405_f4d9e8fb.', '_20240924120405_5470b665.', '_20240924120405_490e4f74.', '_20240924120405_910f65d2.', '_20240924120405_ee5aa0db.', '_20240924120405_7f6f1e39.', '_20240924120405_01322bf5.', '_20240924120405_9da3629d.', '_20240924120405_f3150f2a.', '_20240924120405_8a524513.', '_20240924120405_c6cc912a.', '_20240924120405_e65d4390.', '_20240924120405_dfb81c5b.', '_20240924120405_e2711fdd.', '_20240924120405_8d910198.', '_20240924120405_0e4ba518.', '2024-09-24 03:04:05'),
(3, 134, 92, 'wewe_20240925133454_0eafab4a.pdf', 'wewe_20240925133454_9e51f566.pdf', 'wewe_20240925133454_2f18a04b.pdf', 'wewe_20240925133454_e93952df.pdf', 'wewe_20240925133454_67568287.pdf', 'wewe_20240925133454_f2c729be.pdf', 'wewe_20240925133454_87f7732f.pdf', 'wewe_20240925133454_b41e9f4d.pdf', 'wewe_20240925133454_bbf6e8f5.pdf', 'wewe_20240925133454_3e56d4e9.pdf', 'wewe_20240925133454_ba8f0a19.pdf', 'wewe_20240925133454_b763064b.pdf', 'wewe_20240925133454_f89552bc.pdf', 'wewe_20240925133454_868f7dca.pdf', 'wewe_20240925133454_453d0236.pdf', 'wewe_20240925133454_a3ef7f44.pdf', 'wewe_20240925133454_8274802e.pdf', 'wewe_20240925133454_7ef96be4.pdf', 'wewe_20240925133454_241bbd63.pdf', 'wewe_20240925133454_1e716a38.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-25 04:34:54'),
(4, 137, 96, 'Capstone-Ipapacheck-bukas_20241007022726_809ef273.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_07ee14ec.pdf', NULL, 'Capstone-Ipapacheck-bukas_20241007022726_1a6dd7f4.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_6da952f6.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_8bfd0221.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_93e76f56.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_bf096b98.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_3897e5d7.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_1b14ea8e.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_e83b9a42.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_1932ed9c.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_2bae2359.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_30e62bc0.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_75ee2753.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_37d12445.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_af83983f.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_2e8e8243.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_a4fe0c0d.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_07fa9f4c.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_7f385d9e.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_f6b2cdd7.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_83fc12e5.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_87added2.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_d608ff3f.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_e97a5e2d.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_c1925cb7.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_b4c98bac.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_07b27fe2.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_c44fa404.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_b47b3a8f.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_dbf92181.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_8848ab54.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_13ae14bf.pdf', 'Capstone-Ipapacheck-bukas_20241007022726_41087630.pdf', '2024-10-07 08:27:26');

-- --------------------------------------------------------

--
-- Table structure for table `movrate`
--

CREATE TABLE `movrate` (
  `id` int(11) NOT NULL,
  `barangay` int(11) NOT NULL,
  `mov_id` int(255) NOT NULL,
  `IA_1a_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IA_1b_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IA_2a_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IA_2b_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IA_2c_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IA_2d_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IA_2e_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IB_1forcities_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IB_1aformuni_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IB_1bformuni_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IB_2_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IB_3_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IB_4_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IC_1_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IC_2_pdf_rate` decimal(11,0) DEFAULT NULL,
  `ID_1_pdf_rate` decimal(11,0) DEFAULT NULL,
  `ID_2_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIA_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIB_1_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIB_2_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIC_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIA_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIB_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIC_1forcities_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIC_1forcities2_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIC_1forcities3_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIC_2formuni1_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIC_2formuni2_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIIC_2formuni3_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IIID_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IV_forcities_pdf_rate` decimal(11,0) DEFAULT NULL,
  `IV_muni_pdf_rate` decimal(11,0) DEFAULT NULL,
  `V_1_pdf_rate` decimal(11,0) DEFAULT NULL,
  `threepeoplesorg_rate` decimal(11,0) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movrate`
--

INSERT INTO `movrate` (`id`, `barangay`, `mov_id`, `IA_1a_pdf_rate`, `IA_1b_pdf_rate`, `IA_2a_pdf_rate`, `IA_2b_pdf_rate`, `IA_2c_pdf_rate`, `IA_2d_pdf_rate`, `IA_2e_pdf_rate`, `IB_1forcities_pdf_rate`, `IB_1aformuni_pdf_rate`, `IB_1bformuni_pdf_rate`, `IB_2_pdf_rate`, `IB_3_pdf_rate`, `IB_4_pdf_rate`, `IC_1_pdf_rate`, `IC_2_pdf_rate`, `ID_1_pdf_rate`, `ID_2_pdf_rate`, `IIA_pdf_rate`, `IIB_1_pdf_rate`, `IIB_2_pdf_rate`, `IIC_pdf_rate`, `IIIA_pdf_rate`, `IIIB_pdf_rate`, `IIIC_1forcities_pdf_rate`, `IIIC_1forcities2_pdf_rate`, `IIIC_1forcities3_pdf_rate`, `IIIC_2formuni1_pdf_rate`, `IIIC_2formuni2_pdf_rate`, `IIIC_2formuni3_pdf_rate`, `IIID_pdf_rate`, `IV_forcities_pdf_rate`, `IV_muni_pdf_rate`, `V_1_pdf_rate`, `threepeoplesorg_rate`, `total`) VALUES
(30, 96, 4, NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movremark`
--

CREATE TABLE `movremark` (
  `id` int(11) NOT NULL,
  `barangay` int(11) NOT NULL,
  `mov_id` int(255) NOT NULL,
  `IA_1a_pdf_remark` varchar(255) DEFAULT NULL,
  `IA_1b_pdf_remark` varchar(255) DEFAULT NULL,
  `IA_2a_pdf_remark` varchar(255) DEFAULT NULL,
  `IA_2b_pdf_remark` varchar(255) DEFAULT NULL,
  `IA_2c_pdf_remark` varchar(255) DEFAULT NULL,
  `IA_2d_pdf_remark` varchar(255) DEFAULT NULL,
  `IA_2e_pdf_remark` varchar(255) DEFAULT NULL,
  `IB_1forcities_pdf_remark` varchar(255) DEFAULT NULL,
  `IB_1aformuni_pdf_remark` varchar(255) DEFAULT NULL,
  `IB_1bformuni_pdf_remark` varchar(255) DEFAULT NULL,
  `IB_2_pdf_remark` varchar(255) DEFAULT NULL,
  `IB_3_pdf_remark` varchar(255) DEFAULT NULL,
  `IB_4_pdf_remark` varchar(255) DEFAULT NULL,
  `IC_1_pdf_remark` varchar(255) DEFAULT NULL,
  `IC_2_pdf_remark` varchar(255) DEFAULT NULL,
  `ID_1_pdf_remark` varchar(255) DEFAULT NULL,
  `ID_2_pdf_remark` varchar(255) DEFAULT NULL,
  `IIA_pdf_remark` varchar(255) DEFAULT NULL,
  `IIB_1_pdf_remark` varchar(255) DEFAULT NULL,
  `IIB_2_pdf_remark` varchar(255) DEFAULT NULL,
  `IIC_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIA_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIB_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIC_1forcities_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIC_1forcities2_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIC_1forcities3_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIC_2formuni1_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIC_2formuni2_pdf_remark` varchar(255) DEFAULT NULL,
  `IIIC_2formuni3_pdf_remark` varchar(255) DEFAULT NULL,
  `IIID_pdf_rate_remark` int(11) DEFAULT NULL,
  `IV_forcities_pdf_remark` int(11) DEFAULT NULL,
  `IV_muni_pdf_remark` int(11) DEFAULT NULL,
  `V_1_pdf_remark` int(11) DEFAULT NULL,
  `threepeoplesorg_remark` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movremark`
--

INSERT INTO `movremark` (`id`, `barangay`, `mov_id`, `IA_1a_pdf_remark`, `IA_1b_pdf_remark`, `IA_2a_pdf_remark`, `IA_2b_pdf_remark`, `IA_2c_pdf_remark`, `IA_2d_pdf_remark`, `IA_2e_pdf_remark`, `IB_1forcities_pdf_remark`, `IB_1aformuni_pdf_remark`, `IB_1bformuni_pdf_remark`, `IB_2_pdf_remark`, `IB_3_pdf_remark`, `IB_4_pdf_remark`, `IC_1_pdf_remark`, `IC_2_pdf_remark`, `ID_1_pdf_remark`, `ID_2_pdf_remark`, `IIA_pdf_remark`, `IIB_1_pdf_remark`, `IIB_2_pdf_remark`, `IIC_pdf_remark`, `IIIA_pdf_remark`, `IIIB_pdf_remark`, `IIIC_1forcities_pdf_remark`, `IIIC_1forcities2_pdf_remark`, `IIIC_1forcities3_pdf_remark`, `IIIC_2formuni1_pdf_remark`, `IIIC_2formuni2_pdf_remark`, `IIIC_2formuni3_pdf_remark`, `IIID_pdf_rate_remark`, `IV_forcities_pdf_remark`, `IV_muni_pdf_remark`, `V_1_pdf_remark`, `threepeoplesorg_remark`) VALUES
(5, 96, 4, 'd', 'd', '2', 'sss', 's', 'ss', 's', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `municipalities`
--

CREATE TABLE `municipalities` (
  `id` int(11) NOT NULL,
  `municipality_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Dumping data for table `municipalities`
--

INSERT INTO `municipalities` (`id`, `municipality_name`) VALUES
(1, 'Sample Municipality'),
(41, 'Biñan'),
(42, 'Los Baños'),
(43, 'Sta Rosa'),
(44, 'San Pedro'),
(45, 'Calamba'),
(46, 'Calauan'),
(47, 'Bay'),
(48, 'San Pablo'),
(52, 'Sample Municipality'),
(54, 'Alaminos');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `report_date` date DEFAULT curdate(),
  `mayor` varchar(100) DEFAULT NULL,
  `region` varchar(4) DEFAULT NULL,
  `municipality` text NOT NULL,
  `budget` varchar(20) DEFAULT NULL,
  `population` varchar(10) DEFAULT NULL,
  `totalcase` int(11) DEFAULT NULL,
  `numlupon` int(11) DEFAULT NULL,
  `male` int(11) DEFAULT NULL,
  `female` int(11) DEFAULT NULL,
  `landarea` varchar(25) DEFAULT NULL,
  `criminal` int(11) DEFAULT NULL,
  `civil` int(11) DEFAULT NULL,
  `others` int(11) DEFAULT NULL,
  `totalNature` int(11) DEFAULT NULL,
  `media` int(11) DEFAULT NULL,
  `concil` int(11) DEFAULT NULL,
  `arbit` int(11) DEFAULT NULL,
  `totalSet` int(11) DEFAULT NULL,
  `pending` int(11) DEFAULT NULL,
  `dismissed` int(11) DEFAULT NULL,
  `repudiated` int(11) DEFAULT NULL,
  `certcourt` int(11) DEFAULT NULL,
  `dropped` int(11) DEFAULT NULL,
  `totalUnset` int(11) DEFAULT NULL,
  `outsideBrgy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `user_id`, `barangay_id`, `report_date`, `mayor`, `region`, `municipality`, `budget`, `population`, `totalcase`, `numlupon`, `male`, `female`, `landarea`, `criminal`, `civil`, `others`, `totalNature`, `media`, `concil`, `arbit`, `totalSet`, `pending`, `dismissed`, `repudiated`, `certcourt`, `dropped`, `totalUnset`, `outsideBrgy`) VALUES
(38, 102, 0, '2024-03-22', 'Anthony Ton Genuino', 'IV-A', '', '1,000,000', '', 2, 3, 0, 0, '', 0, 2, 0, 2, 0, 0, 0, 0, 2, 0, 0, 0, 0, 2, 0),
(39, 115, 1, '2024-04-02', 'Anthony Ton Genuino', 'IV-A', '', '4,970,354,459.84', '115, 353', 3, 12, 8, 4, '165,797.6525', 0, 3, 0, 3, 0, 0, 0, 0, 3, 0, 0, 0, 0, 3, 0),
(40, 115, 1, '2021-02-11', 'Anthony Ton Genuino', 'IV-A', '', '1,000,000', '115, 353', 25, 13, 20, 5, '165,797.6525', 5, 4, 3, 2, 2, 3, 1, 1, 2, 2, 2, 2, 3, 2, 2),
(41, 115, 1, '2021-03-01', 'Anthony Ton Genuino', 'IV-A', '', '1,000,000', '115, 353', 5, 13, 5, 5, '165,797.6525', 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5),
(42, 110, 76, '2024-04-18', 'Anthony \"Ton\" F. Genuino', '', '', '', '', 9, 12, 0, 0, '', 2, 7, 0, 9, 9, 0, 0, 9, 0, 0, 0, 0, 0, 0, 0),
(43, 115, 1, '2024-08-17', 'Anthony Ton Genuino', 'IV-A', '', '4,970,354,459.84', '115, 353', 2, 12, 8, 4, '165,797.6525', 0, 2, 0, 2, 1, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0),
(45, 134, 92, '2024-09-07', 'warren', 'IV-A', '', '1000', '12', 2, 0, 4, 8, '165,797.6525', 0, 2, 0, 2, 0, 0, 0, 0, 2, 0, 0, 0, 0, 2, 0),
(46, 136, 94, '2024-09-07', 'manolo', 'IV-A', 'Bay', '500', '10', 12, 3, 5, 5, '165,797.6525', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(48, 135, 93, '2024-09-07', 'susan', 'IV-A', 'San Pedro', '324234546', '4', 12, 3, 2, 2, '165,797.6525', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(49, 135, 93, '2024-08-14', 'susan', 'IV-A', 'San Pedro', '1000', '150', 5, 3, 100, 50, '165,797.6525', 5, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(50, 136, 94, '2024-08-14', 'manolo', 'IV-A', 'Bay', '1000000', '120,000', 12, 3, 100000, 20000, '165,797.6525', 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(51, 136, 94, '2024-06-22', 'wewe', 'IV-A', 'Bay', '2', '50', 43, 3, 43, 7, '2,000,000', 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question1` varchar(255) DEFAULT NULL,
  `answer1` varchar(255) DEFAULT NULL,
  `question2` varchar(255) DEFAULT NULL,
  `answer2` varchar(255) DEFAULT NULL,
  `question3` varchar(255) DEFAULT NULL,
  `answer3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`id`, `user_id`, `question1`, `answer1`, `question2`, `answer2`, `question3`, `answer3`) VALUES
(13, 109, '1', '$2y$10$DYZ0LRn8.Hv7daIdRsT4heZ.EJNAbk.tvKQ1pGMSuOdXPmcdFvgGW', '2', '$2y$10$RE6nrm2vcw4Kdzy/CEqWAOfwUzQmqkejRxVrm9CnVkIDWwOIevHy2', '3', '$2y$10$4.7u6XOH9dgk/TTwIhTC0e.HvoNZq/CcVVTjZwJa.xEmgltw45BK2'),
(14, 110, '3', '$2y$10$pVO5Gtn89ND6fo/ohiqTNOxgbJWq5DC1viryXtFsStv7DavdFIZ.u', '2', '$2y$10$bVu9wwWWNpzPOXz4LztEbucoEzdiXAiKiEKxFMeDYaOEGMYDUQP4O', '1', '$2y$10$N8UtCJtmttnKXCZG3dx/IOHAMimyq5DM5mvyXdBDEA5UO2eSUVVq6'),
(15, 118, '4', '$2y$10$0dgVJLBUu9q9WwsIP7BaxOmB.rNkjduhlK7ZvCqswhNLDQp7zpeQG', '3', '$2y$10$Ht15KMgOxVxoCBPM/yo09.CZSENmGfAN12oDumimrKKZEZCiNQuue', '1', '$2y$10$Dxbv/CRY22BL8itmzTJJjOU.KX.mYp4.tWDf3Lvl/VXjurwdzkah2'),
(25, 122, '2', '$2y$10$jHuq2.wCAznTZtTMjmYXou7ceVkrVzjSTwEq8pMtkrSQChYfnOoAy', '3', '$2y$10$2p/yBXy6pVkOYhzqnA6DgOV1PGJunl0YYeb8UnMfU6q1ZQxZMdx6O', '4', '$2y$10$9JC5rftD4mQDpRF7txi3qOf/cuu.FtfRCAKjyLBi7moqyM9z3rTba'),
(26, 1, '1', '$2y$10$MwTGTalfgjek.ILhr7oycuhnN7W2zpNGXa/hMDBDeP6kF8Y16spMK', '2', '$2y$10$bxRfSyFe6XZ8BVTPoeuJk.WMHvRgl6fnFIw2hyWrnSb8WSBUNx3AC', '3', '$2y$10$u778tZczP7jPmjU2eLFwK.9m6sffSfyHYbhCDPjiwTLjEdt8/VjJW'),
(29, 115, '1', '$2y$10$hkxKHeVGmJUSLFso.Wsz/.UN0Sk3N/Sdg9X2P3aUHKAoETMdLpvqS', '1', '$2y$10$hzpFqIAmqIm//aZfZ4vPD.4wkl22mONzSibpuKz5ztH0YZNa9I98S', '1', '$2y$10$U28nrBhK93gpeqvaOXeK0u.CE/IO.MwAg72RH8amyKOdk6DjwU9FC'),
(33, 125, '2', '$2y$10$5cxEMGZc8IToORJ6gx88Me.3jlggGNOQBam218rGGdSCMRFtkFt1G', '1', '$2y$10$TZ4Uos9L.a/eBhsAweNj3uHkCP8MUvfbJxIu9lI1vqYimsE.zXuva', '2', '$2y$10$43VHYjoRBa5E79eVcTagG.QTEoFAazMV29.ah3r9FkoVa/fvl8NO6'),
(34, 112, '1', '$2y$10$Lq0.57IS4klSD6kOx9dKYuLWpR8Sd1rLDtexSiJVUwV1cC25KUhKe', '2', '$2y$10$UBwxZ5nMKTLR13nYYBwsJePRhspXhAlyygdozUwTJm5A8cKy35msS', '1', '$2y$10$AM5rhhx79uJZZz3G.D.spewGVEZ4cL/b1opdeRUmG9r5IDec/idBy'),
(35, 117, '1', '$2y$10$lBrss4xbm4oq9lJVa7V72eDHgCkgtGxt5VnKnNZGr25gsWKEwGZ8e', '1', '$2y$10$IEklH.Wsfj9pAoRV1/QAc.RcE1nsuao0bI4gstOrcPShvBx9t3MLu', '2', '$2y$10$nMwhjI7u0IZ1N/VoIY0Uxe7I19trWcJgmIuSn57JA3tV5.Pz.VSoq'),
(36, 126, '2', '$2y$10$58tNqkdWhGbyCxag0RJhy.e/vBCaV3iOyNKvBAi1btxJclrU7DjZe', '1', '$2y$10$Togn6R/StMQCL3Wxwcs0zuAB6LKLQJa2K0UmEPIvCwJ5JQ8K6B0dC', '4', '$2y$10$w2doh4Eo5gDmGNo3p6h2IeWHC1MHM5JDT0FYgcPrqeRSCJgxJSEEe'),
(37, 128, '1', '$2y$10$xrkysiNGAysuAn7vSu07LeV5thIyaYzISu3HEz60F0.obcHyIx/2W', '1', '$2y$10$IuQTruOj.sLjwKsEJA8SourhzkccC2l5N7VIedWisDRE3X6H9rHuq', '2', '$2y$10$ozhfsUd5sBHguZMTqsiGZO4MKbB1XMnxKSodAqtutFQu1boJHMVyy'),
(38, 107, '1', '$2y$10$4ah374R2GZ5EluNcsFQcleKbt.ZalFfhceFgSZxeWVycwbwxIyRKq', '2', '$2y$10$5iYzRNkdNv.YyiPDlamVJe7XPI.bqRdCdQITVfqKGCkZmMF4X.036', '3', '$2y$10$As.vc2E474sg6l18X9Xi.u9klrsm2eGbFCp9sKg46udaIU1oBQIkG'),
(39, 134, '1', '$2y$10$fKlT4dqH.TOTYOmOWJrj5OtOigH01/LZh2MSkUCXtiiiXQR9rAvfG', '1', '$2y$10$DoA9Nqueag8ztjSJz9gT1OYWEP8Yt7L5m2FChabnpBSkC7KewCINi', '1', '$2y$10$a0yo74tnIzaCO/ecZfIqQO3HwDHAt9vJUo2pfijmx0JfMvwbmIenq'),
(40, 135, '1', '$2y$10$MvYzBW9Snk.B8.h2h817VO2Pt/I980biAoFMnRI5jHiOSuDJj.Ne.', '2', '$2y$10$lohKcQMIMh.0PabtMaUk1OMclAG.v9zYsrMAv0h.LsplwgqaY6x4a', '1', '$2y$10$o9eq5B9.aXcMx.sUJN8MYOBV4q4K3.0ItnQBfZvZBPZP2.MGbf5Yu'),
(41, 136, '1', '$2y$10$xrCIjFvc9Bs7ABQZOyZgKOA7zKJB1M/kaIEs76ZLbeO/y7lkTJZxy', '2', '$2y$10$3Dh./w8WXiE197zoCdLPPOzp7iTXBgHFh3W03hZIVbS4mvV8hnBhK', '2', '$2y$10$wrDbGj.IRRFYfLGbqSYARubjj095wA5WVP10w/5W144wdgn.WyhpW'),
(42, 108, '2', '$2y$10$MnAo9MKrfmoYLwZmbM.JXODMx6CO/y7l4kLPIaBu2/jCm1FWMZa4C', '2', '$2y$10$PFuiZaJU.L4HGganHM9p0ezJc3fBYbw6UNiSb7e7nZOXepFBEK2PS', '1', '$2y$10$aCqEv61a.pHi.8IqaBRLduLD.qoG9SHhJyBsUm1jSlyEEuoKRZY4W'),
(43, 113, '1', '$2y$10$6HuTv0Hj1sIJYzY4LDWXuujVNjbJRiWBQT25kTxMggdb5CQZcwbVG', '1', '$2y$10$tJU/F9u/KZwjTAazGlgtEeqWyGWVup7W5DQrG7mqEokBw7WTXISCu', '1', '$2y$10$5Jmhu5WZ25y0cbEyA1NkZONPU783vIP9ykbI3IDmhIOnck8chDTDK'),
(44, 137, '1', '$2y$10$2oyFK5Q1o5faZVTF5ZJIQ.7bOPdeu9SWNPyP.ZDPRYGp3FlpbckWG', '1', '$2y$10$z/mI41UXtbQvORvF2yu4v.xfCKIX.vFKkZH2fMwUMymx5siQeloKS', '1', '$2y$10$wq3nEQYxI.Q1K8xRdJSyNuyBZUxty4b2zYPuPu4BUeeg1O7eY0L.u'),
(45, NULL, '1', '$2y$10$EkZquI/AFQiUtJUYitw6X.d6UtodFIVrjeevyrKZkL.KnEALzhPrS', '1', '$2y$10$d8kq0YluA4xkuSGH/tCpv.bMtxvF1/oQcguovste3l3Z9lDBbIdQe', '1', '$2y$10$Rq0Pfswse.8Yiuz4Nc15O.nSEApUBc7U9lQYzdEPJ.aS5ndgQBsnq');

-- --------------------------------------------------------

--
-- Table structure for table `upload_files`
--

CREATE TABLE `upload_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `signed_form` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upload_files`
--

INSERT INTO `upload_files` (`id`, `user_id`, `barangay_id`, `case_id`, `file_name`, `file_path`, `upload_date`, `signed_form`) VALUES
(10, 115, 1, 135, 'NOVEMBER.docx', 'uploads/115/135/NOVEMBER.docx', '2024-04-02 02:30:48', NULL),
(11, 115, 1, 135, 'kp_form7_01-000-0424.pdf', 'uploads/115/135/kp_form7_01-000-0424.pdf', '2024-04-02 02:31:09', NULL),
(12, 110, 76, 120, '2023-1-01.pdf', 'uploads/110/120/2023-1-01.pdf', '2024-04-02 08:00:44', NULL),
(13, 110, 76, 111, '2023-1-02.pdf', 'uploads/110/111/2023-1-02.pdf', '2024-04-02 08:04:49', NULL),
(14, 110, 76, 112, '2023-1-03.pdf', 'uploads/110/112/2023-1-03.pdf', '2024-04-02 08:05:17', NULL),
(15, 110, 76, 113, '2023-1-04.pdf', 'uploads/110/113/2023-1-04.pdf', '2024-04-02 08:05:47', NULL),
(16, 110, 76, 114, '2023-1-05.pdf', 'uploads/110/114/2023-1-05.pdf', '2024-04-02 08:06:22', NULL),
(17, 110, 76, 115, '2023-1-06.pdf', 'uploads/110/115/2023-1-06.pdf', '2024-04-02 08:06:57', NULL),
(21, 110, 76, 123, '2023-2-10.pdf', 'uploads/110/123/2023-2-10.pdf', '2024-04-02 08:11:13', NULL),
(22, 110, 76, 124, '2023-2-11.pdf', 'uploads/110/124/2023-2-11.pdf', '2024-04-02 08:12:16', NULL),
(23, 110, 76, 125, '2023-3-12.pdf', 'uploads/110/125/2023-3-12.pdf', '2024-04-02 08:13:35', NULL),
(24, 110, 76, 119, '2023-3-14.pdf', 'uploads/110/119/2023-3-14.pdf', '2024-04-02 08:14:15', NULL),
(25, 110, 76, 127, '2023-3-15.pdf', 'uploads/110/127/2023-3-15.pdf', '2024-04-02 08:15:31', NULL),
(26, 110, 76, 128, '2023-3-16.pdf', 'uploads/110/128/2023-3-16.pdf', '2024-04-02 08:17:13', NULL),
(27, 110, 76, 129, '2023-3-17.pdf', 'uploads/110/129/2023-3-17.pdf', '2024-04-02 08:18:11', NULL),
(28, 110, 76, 130, '2023-3-18.pdf', 'uploads/110/130/2023-3-18.pdf', '2024-04-02 08:18:55', NULL),
(29, 110, 76, 132, '2023-3-20.pdf', 'uploads/110/132/2023-3-20.pdf', '2024-04-02 08:21:28', NULL),
(31, 110, 76, 136, '2023-3-22.pdf', 'uploads/110/136/2023-3-22.pdf', '2024-04-02 08:22:48', NULL),
(33, 110, 76, 139, '2023-4-26.pdf', 'uploads/110/139/2023-4-26.pdf', '2024-04-02 08:27:35', NULL),
(34, 110, 76, 142, '2023-5-24.pdf', 'uploads/110/142/2023-5-24.pdf', '2024-04-02 08:29:56', NULL),
(35, 110, 76, 140, '2023-5-27.pdf', 'uploads/110/140/2023-5-27.pdf', '2024-04-02 08:30:42', NULL),
(37, 110, 76, 143, '2023-5-30.pdf', 'uploads/110/143/2023-5-30.pdf', '2024-04-02 08:33:15', NULL),
(39, 110, 76, 152, '2023-7-40.pdf', 'uploads/110/152/2023-7-40.pdf', '2024-04-02 08:34:03', NULL),
(41, 110, 76, 159, '2023-8-46.pdf', 'uploads/110/159/2023-8-46.pdf', '2024-04-02 08:34:52', NULL),
(42, 110, 76, 160, '2023-8-47.pdf', 'uploads/110/160/2023-8-47.pdf', '2024-04-02 08:35:16', NULL),
(43, 110, 76, 161, '2023-8-48.pdf', 'uploads/110/161/2023-8-48.pdf', '2024-04-02 08:35:31', NULL),
(44, 110, 76, 162, '2023-8-49.pdf', 'uploads/110/162/2023-8-49.pdf', '2024-04-02 08:35:56', NULL),
(47, 110, 76, 173, '2023-10-62.pdf', 'uploads/110/173/2023-10-62.pdf', '2024-04-03 02:16:27', NULL),
(48, 110, 76, 171, '2023-10-60.pdf', 'uploads/110/171/2023-10-60.pdf', '2024-04-03 02:17:50', NULL),
(49, 110, 76, 168, '2023-9-56.pdf', 'uploads/110/168/2023-9-56.pdf', '2024-04-03 02:18:36', NULL),
(50, 110, 76, 190, '2023-12-80.pdf', 'uploads/110/190/2023-12-80.pdf', '2024-04-03 02:21:08', NULL),
(51, 110, 76, 186, '2023-11-75.pdf', 'uploads/110/186/2023-11-75.pdf', '2024-04-03 02:21:45', NULL),
(52, 110, 76, 166, '2023-9-53.pdf', 'uploads/110/166/2023-9-53.pdf', '2024-04-03 06:37:16', NULL),
(53, 110, 76, 196, '2023-9-54.pdf', 'uploads/110/196/2023-9-54.pdf', '2024-04-03 06:43:31', NULL),
(54, 110, 76, 167, '2023-9-55.pdf', 'uploads/110/167/2023-9-55.pdf', '2024-04-03 06:46:03', NULL),
(55, 110, 76, 170, '2023-10-59.pdf', 'uploads/110/170/2023-10-59.pdf', '2024-04-03 06:51:18', NULL),
(56, 110, 76, 133, '2023-4-24.pdf', 'uploads/110/133/2023-4-24.pdf', '2024-04-04 01:51:19', NULL),
(57, 110, 76, 158, '2023-7-45.pdf', 'uploads/110/158/2023-7-45.pdf', '2024-04-04 01:51:57', NULL),
(58, 110, 76, 145, '2023-06-32.pdf', 'uploads/110/145/2023-06-32.pdf', '2024-04-04 01:52:27', NULL),
(59, 110, 76, 178, '2023-10-67.pdf', 'uploads/110/178/2023-10-67.pdf', '2024-04-04 01:52:59', NULL),
(60, 110, 76, 157, '2023-7-44.pdf', 'uploads/110/157/2023-7-44.pdf', '2024-04-04 03:22:53', NULL),
(61, 110, 76, 138, '2023-4-25.pdf', 'uploads/110/138/2023-4-25.pdf', '2024-04-04 03:24:45', NULL),
(62, 110, 76, 144, '2023-5-31.pdf', 'uploads/110/144/2023-5-31.pdf', '2024-04-04 03:27:02', NULL),
(63, 110, 76, 151, '2023-6-38.pdf', 'uploads/110/151/2023-6-38.pdf', '2024-04-04 03:28:31', NULL),
(64, 110, 76, 148, '2023-6-35.pdf', 'uploads/110/148/2023-6-35.pdf', '2024-04-04 03:30:59', NULL),
(65, 110, 76, 149, '2023-6-36.pdf', 'uploads/110/149/2023-6-36.pdf', '2024-04-04 03:32:02', NULL),
(66, 110, 76, 116, '2023-1-07.pdf', 'uploads/110/116/2023-1-07.pdf', '2024-04-15 05:39:04', NULL),
(67, 110, 76, 126, '2023-3-13.pdf', 'uploads/110/126/2023-3-13.pdf', '2024-04-15 05:40:38', NULL),
(68, 110, 76, 131, '2023-3-19.pdf', 'uploads/110/131/2023-3-19.pdf', '2024-04-15 05:41:59', NULL),
(69, 110, 76, 134, '2023-3-21.pdf', 'uploads/110/134/2023-3-21.pdf', '2024-04-15 05:43:06', NULL),
(70, 110, 76, 137, '2023-3-23.pdf', 'uploads/110/137/2023-3-23.pdf', '2024-04-15 05:44:12', NULL),
(71, 110, 76, 141, '2023-5-28.pdf', 'uploads/110/141/2023-5-28.pdf', '2024-04-15 05:45:04', NULL),
(72, 110, 76, 146, '2023-6-33.pdf', 'uploads/110/146/2023-6-33.pdf', '2024-04-15 05:45:36', NULL),
(73, 110, 76, 147, '2023-6-34.pdf', 'uploads/110/147/2023-6-34.pdf', '2024-04-15 05:46:13', NULL),
(74, 110, 76, 150, '2023-6-37.pdf', 'uploads/110/150/2023-6-37.pdf', '2024-04-15 05:46:57', NULL),
(75, 110, 76, 155, '2023-7-39.pdf', 'uploads/110/155/2023-7-39.pdf', '2024-04-15 05:47:51', NULL),
(76, 110, 76, 153, '2023-7-41.pdf', 'uploads/110/153/2023-7-41.pdf', '2024-04-15 05:48:30', NULL),
(77, 110, 76, 154, '2023-7-42.pdf', 'uploads/110/154/2023-7-42.pdf', '2024-04-15 05:49:27', NULL),
(78, 110, 76, 156, '2023-7-43.pdf', 'uploads/110/156/2023-7-43.pdf', '2024-04-15 05:50:09', NULL),
(79, 110, 76, 163, '2023-8-50.pdf', 'uploads/110/163/2023-8-50.pdf', '2024-04-15 05:50:41', NULL),
(80, 110, 76, 164, '2023-9-51.pdf', 'uploads/110/164/2023-9-51.pdf', '2024-04-15 05:51:12', NULL),
(81, 110, 76, 169, '2023-9-57.pdf', 'uploads/110/169/2023-9-57.pdf', '2024-04-15 05:51:49', NULL),
(82, 110, 76, 165, '2023-9-52.pdf', 'uploads/110/165/2023-9-52.pdf', '2024-04-15 05:52:22', NULL),
(83, 110, 76, 195, '2023-9-58.pdf', 'uploads/110/195/2023-9-58.pdf', '2024-04-15 05:53:02', NULL),
(84, 110, 76, 172, '2023-10-61.pdf', 'uploads/110/172/2023-10-61.pdf', '2024-04-15 05:53:35', NULL),
(85, 110, 76, 174, '2023-10-63.pdf', 'uploads/110/174/2023-10-63.pdf', '2024-04-15 05:54:21', NULL),
(86, 110, 76, 175, '2023-10-64.pdf', 'uploads/110/175/2023-10-64.pdf', '2024-04-15 05:54:56', NULL),
(87, 110, 76, 176, '2023-10-65.pdf', 'uploads/110/176/2023-10-65.pdf', '2024-04-15 05:55:28', NULL),
(88, 110, 76, 177, '2023-10-66.pdf', 'uploads/110/177/2023-10-66.pdf', '2024-04-15 05:56:07', NULL),
(89, 110, 76, 179, '2023-10-68.pdf', 'uploads/110/179/2023-10-68.pdf', '2024-04-15 05:56:54', NULL),
(90, 110, 76, 180, '2023-10-69.pdf', 'uploads/110/180/2023-10-69.pdf', '2024-04-15 05:57:26', NULL),
(91, 110, 76, 181, '2023-11-70.pdf', 'uploads/110/181/2023-11-70.pdf', '2024-04-15 05:58:02', NULL),
(92, 110, 76, 182, '2023-11-71.pdf', 'uploads/110/182/2023-11-71.pdf', '2024-04-15 05:58:40', NULL),
(93, 110, 76, 183, '2023-11-72.pdf', 'uploads/110/183/2023-11-72.pdf', '2024-04-15 05:59:36', NULL),
(94, 110, 76, 184, '2023-11-73.pdf', 'uploads/110/184/2023-11-73.pdf', '2024-04-15 06:00:06', NULL),
(95, 110, 76, 187, '2023-11-76.pdf', 'uploads/110/187/2023-11-76.pdf', '2024-04-15 06:00:47', NULL),
(96, 110, 76, 188, '2023-12-77.pdf', 'uploads/110/188/2023-12-77.pdf', '2024-04-15 06:01:37', NULL),
(97, 110, 76, 189, '2023-12-79.pdf', 'uploads/110/189/2023-12-79.pdf', '2024-04-15 06:02:30', NULL),
(98, 110, 76, 121, '2023-2-08.pdf', 'uploads/110/121/2023-2-08.pdf', '2024-04-15 06:18:08', NULL),
(99, 110, 76, 185, '2023-11-74.pdf', 'uploads/110/185/2023-11-74.pdf', '2024-04-15 06:40:31', NULL),
(112, 134, 92, 221, '', 'uploads/134/221/kp_form7_02-000-0924.pdf', '2024-09-06 03:20:04', 'kp_form7_02-000-0924.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `user_type` enum('superadmin','admin','user') NOT NULL,
  `municipality_id` int(11) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `attempt_count` int(11) DEFAULT 0,
  `restrict_end` timestamp NULL DEFAULT NULL,
  `lgu_logo` varchar(255) DEFAULT NULL,
  `city_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `password`, `email`, `contact_number`, `user_type`, `municipality_id`, `barangay_id`, `registration_date`, `profile_picture`, `verified`, `attempt_count`, `restrict_end`, `lgu_logo`, `city_logo`) VALUES
(1, 'SuperAdmins', 'DILGs', 'Head', '$2y$10$TrBHp44V3RHaAaVwmtAreeDmUU5iSlSWXmXv6vmocjS6NtT.K8KF6', 'superadmin@gmail.com', '09212342546', 'superadmin', NULL, NULL, '2023-08-04 01:05:56', '1.jpg', 0, 0, NULL, 'angel.png', 'angel.png'),
(107, 'binanclgoo@eKP.Aces', 'Fatima Nona', 'Alon', '$2y$10$5i4PM0wyi8jMYs8Ixr8XNempA5Myc1qIIgzB5gj7G/GSRUOZHlzEq', 'clgoobinan@gmail.com', '09567004685', 'admin', 41, NULL, '2024-04-19 09:01:14', NULL, 0, 0, NULL, NULL, NULL),
(108, 'losbanosmlgoo@eKP.Aces', 'Michiko ', 'Escalante', '$2y$10$7dluF21OMfD.82Ihdnj7y.85w1XQvUY1h4r0FoVBnxAenU6KUiFIS', 'mlgoolosbanos2@gmail.com', '09567004685', 'admin', 42, NULL, '2024-03-08 08:47:23', NULL, 0, 0, NULL, NULL, NULL),
(109, 'SanVicente_Binan_eKP.Aces', 'Barangay San Vicente', 'City of Binan', '$2y$10$KLTiy/M2p/iszSETtzZpqeFQyFRSvqKUTrT9JLoKUieXCU4ldZDk2', 'barangaysanvicenteofficial@gmail.com', '09190955719', 'user', 41, 74, '2024-03-11 02:11:59', '109.png', 1, 0, NULL, 'Biñan City OFFICIAL LOGO.png', '243194454_199740088924858_2035192919547994160_n.png'),
(110, 'BatongMalake_LosBaÃ±os_eKP.Aces', 'Barangay Batong Malake', 'Los BaÃ±os', '$2y$10$eayLrM0RoJWODnE2MJ3xFuOYdVJ/yR2tq9CrKe1AXIavbYtBexLfe', 'nidomyla@gmail.com', '09650758255', 'user', 42, 76, '2024-03-11 02:16:57', '110.jpg', 1, 0, NULL, 'th (1).jpg', 'LUPON LOGO.jpg'),
(111, 'clgoosantarosa', 'Melody', 'Barairo', '$2y$10$tzq6l0PCamb2MqnpXF6hCexa2EvVzNLdmrpKZboo64W3wp46Mn09K', 'clgoosantarosa2@gmail.com', '09955880245', 'admin', 43, NULL, '2024-03-27 03:54:13', NULL, 0, 0, NULL, NULL, NULL),
(112, 'clgoosanpedro', 'LENIE', 'BAUTISTA', '$2y$10$fGE932U4UaDzIRWVYq6iwuVNlkTEejUZzY.3GuuMp8/71S2.f7L6u', 'clgoosanpedro1@gmail.com', '09985514533', 'admin', 44, NULL, '2024-03-27 03:58:17', NULL, 0, 0, NULL, NULL, NULL),
(113, 'clgoocalamba4', 'Jennifer', 'Quirante', '$2y$10$dt070nbAOYHBcUG8DJ3s7u9.YxvFdTVxtFBUJT3Jr/rcI9yM2pGcm', 'clgoocalamba4@gmail.com', '09178754605', 'admin', 45, NULL, '2024-03-27 04:04:20', NULL, 0, 0, NULL, NULL, NULL),
(115, 'samplebarangay', 'sample', 'Barangay', '$2y$10$G7d1ThN/qa2W2RNovjr.zO0f1CUXoUSTAPT/N31rkz.jmgN2A4ubq', 'samplebarangay@gmail.com', '09212342546', 'user', 52, 1, '2024-03-30 04:50:57', '115.jpg', 1, 1, NULL, 'drink.jpg', 'drink3.jpg'),
(116, 'MLGOO CALAUAN', 'LOIDA', 'VISTA', '$2y$10$KntShdyO8v6zviVwnFvTfe34DEO.lMROz3qnYElWffIOK6fqKxuZC', 'mlgoocalauan2023@gmail.com', '09273834670', 'admin', 46, NULL, '2024-04-19 00:37:07', NULL, 0, 0, NULL, NULL, NULL),
(117, 'MLGOO BAY', 'JAYSON', 'CHAVEZ', '$2y$10$TeoCPd6plmGxhQPPwPpnEOXRgNR.XoOH7pgV8HbpUiwQS2dmlQ4h6', 'mlgoobay2@gmail.com', '09285021005', 'admin', 47, NULL, '2024-04-19 00:42:32', NULL, 0, 0, NULL, NULL, NULL),
(118, 'CLGOO SAN PABLO', 'Maria Alma', 'Barrientos', '$2y$10$C.RO0yMg.1TdCFepROoae.YneBGF.58uEKUGO9rK9Dethmx.MAl/W', 'clgoosanpablo8@gmail.com', '09053708601', 'admin', 48, NULL, '2024-04-19 00:50:54', NULL, 0, 0, NULL, NULL, NULL),
(122, 'sampleadmin', 'Sample', 'Admin', '$2y$10$TrBHp44V3RHaAaVwmtAreeDmUU5iSlSWXmXv6vmocjS6NtT.K8KF6', 'sampleadmin@gmail.com', '09212342546', 'admin', 52, NULL, '2024-03-30 04:50:57', '122.jpg', NULL, 0, NULL, '', ''),
(128, 'AlaminosAdmin', 'Alaminos', 'Muni', '$2y$10$0jVVb.sdNDY6zMYoACdCC.aQb2RhdfTpmOpL4xHEZnhKm3RvFE7Ru', 'clgooalaminos@gmail.com', '09605595411', 'admin', 54, NULL, '2024-09-02 01:53:11', NULL, 0, 0, NULL, NULL, NULL),
(134, 'alaminosusername', 'alaminosfname', 'alaminoslname', '$2y$10$ugC96jU00wH6H8eBQ7aCWeTxUFugI55lt6h1RCCwC9Ssm9ElgOsmm', 'alaminos@gmail.com', '09605595411', 'user', 54, 92, '2024-09-02 03:44:13', NULL, 1, 0, NULL, NULL, NULL),
(135, 'sanpedrousername', 'sanpedrofname', 'sanpedrolname', '$2y$10$a4nxbj4.n03Hp7taCK7GL.BaMSfT8AFaEPVaagQr0654AubHSuhse', 'SanPedro@gmail.com', '09605595411', 'user', 44, 93, '2024-09-02 03:47:44', NULL, 1, 0, NULL, 'drink2.jpg', NULL),
(136, 'masayausername', 'masayafname', 'masayalname', '$2y$10$qyERj5ROeTdFBOtC.8DoYOXBb15i2g6G1AydAGu.fPtcComlrvK5O', 'masaya@gmail.com', '09605595411', 'user', 47, 94, '2024-09-07 04:55:00', NULL, 1, 0, NULL, NULL, NULL),
(137, 'jm', 'John Mark', 'Montecillo', '$2y$10$ZGFWjpa34H0l5GIPqlW7beK/PHzo2X7n37yFx1eRRrgpU68AxxFYq', 'johnmarkmontecillo@gmail.com', '09381949088', 'user', 45, 96, '2024-10-06 23:50:28', NULL, 1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_files`
--

CREATE TABLE `user_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_files`
--

INSERT INTO `user_files` (`id`, `user_id`, `file_name`, `file_path`, `uploaded_at`, `barangay_id`) VALUES
(18, 109, 'kp_form2_ (1).pdf', 'uploadsLP/kp_form2_ (1).pdf', '2024-03-11 02:31:29', 74),
(19, 109, 'kp_form3_.pdf', 'uploadsLP/kp_form3_.pdf', '2024-03-11 02:34:33', 74);

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `activity` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`log_id`, `user_id`, `timestamp`, `activity`) VALUES
(352, 107, '2024-03-08 08:38:10', 'User logged in'),
(353, 108, '2024-03-08 08:48:13', 'User logged in'),
(378, 107, '2024-03-11 02:13:39', 'User logged in'),
(379, 109, '2024-03-11 02:14:58', 'User logged in'),
(380, 108, '2024-03-11 02:17:38', 'User logged in'),
(381, 110, '2024-03-11 02:18:06', 'User logged in'),
(393, 109, '2024-03-12 02:53:43', 'User logged in'),
(394, 109, '2024-03-12 02:57:48', 'User logged in'),
(395, 109, '2024-03-12 03:13:03', 'User logged in'),
(396, 109, '2024-03-12 05:37:05', 'User logged in'),
(397, 110, '2024-03-12 07:58:21', 'User logged in'),
(398, 110, '2024-03-13 01:44:32', 'User logged in'),
(439, 110, '2024-03-19 04:59:03', 'User logged in'),
(457, 110, '2024-03-22 05:33:54', 'User logged in'),
(458, 110, '2024-03-24 02:26:00', 'User logged in'),
(460, 110, '2024-03-24 05:43:00', 'User logged in'),
(467, 110, '2024-03-25 02:45:11', 'User logged in'),
(470, 110, '2024-03-25 23:42:30', 'User logged in'),
(472, 110, '2024-03-26 00:53:36', 'User logged in'),
(476, 111, '2024-03-27 03:54:42', 'User logged in'),
(477, 112, '2024-03-27 03:59:13', 'User logged in'),
(478, 113, '2024-03-27 04:05:07', 'User logged in'),
(479, 114, '2024-03-30 04:50:02', 'User logged in'),
(480, 114, '2024-03-30 04:51:51', 'User logged in'),
(481, 115, '2024-03-30 04:52:02', 'User logged in'),
(482, 115, '2024-03-30 23:39:34', 'User logged in'),
(483, 115, '2024-03-30 23:39:59', 'User logged in'),
(484, 115, '2024-03-30 23:40:29', 'User logged in'),
(485, 115, '2024-03-30 23:43:16', 'User logged in'),
(486, 110, '2024-04-01 00:30:37', 'User logged in'),
(487, 115, '2024-04-01 01:34:18', 'User logged in'),
(488, 115, '2024-04-01 02:11:24', 'User logged in'),
(489, 115, '2024-04-01 02:31:50', 'User logged in'),
(490, 115, '2024-04-02 00:24:59', 'User logged in'),
(491, 115, '2024-04-02 00:38:35', 'User logged in'),
(492, 115, '2024-04-02 00:39:31', 'User logged in'),
(493, 110, '2024-04-02 00:39:49', 'User logged in'),
(494, 110, '2024-04-03 01:12:19', 'User logged in'),
(495, 115, '2024-04-04 01:01:41', 'User logged in'),
(496, 110, '2024-04-04 01:26:28', 'User logged in'),
(497, 115, '2024-04-04 02:58:55', 'User logged in'),
(498, 115, '2024-04-04 03:08:47', 'User logged in'),
(499, 115, '2024-04-04 03:14:12', 'User logged in'),
(500, 115, '2024-04-05 01:03:58', 'User logged in'),
(501, 115, '2024-04-05 01:08:05', 'User logged in'),
(502, 115, '2024-04-08 02:36:54', 'User logged in'),
(503, 115, '2024-04-08 02:51:19', 'User logged in'),
(504, 115, '2024-04-08 02:51:52', 'User logged in'),
(505, 115, '2024-04-08 05:00:52', 'User logged in'),
(506, 115, '2024-04-08 05:07:34', 'User logged in'),
(507, 110, '2024-04-08 07:30:23', 'User logged in'),
(508, 115, '2024-04-12 00:02:43', 'User logged in'),
(509, 114, '2024-04-12 00:26:18', 'User logged in'),
(510, 110, '2024-04-12 01:11:38', 'User logged in'),
(511, 115, '2024-04-12 01:38:07', 'User logged in'),
(512, 115, '2024-04-12 01:41:54', 'User logged in'),
(513, 1, '2024-04-12 01:45:31', 'User logged in'),
(514, 115, '2024-04-12 01:49:44', 'User logged in'),
(515, 1, '2024-04-12 01:50:50', 'User logged in'),
(516, 115, '2024-04-12 01:52:04', 'User logged in'),
(517, 114, '2024-04-12 01:52:20', 'User logged in'),
(518, 1, '2024-04-12 01:52:55', 'User logged in'),
(519, 115, '2024-04-12 01:57:06', 'User logged in'),
(520, 115, '2024-04-12 02:02:06', 'User logged in'),
(521, 1, '2024-04-12 02:14:17', 'User logged in'),
(522, 1, '2024-04-12 02:14:47', 'User logged in'),
(523, 1, '2024-04-12 02:18:07', 'User logged in'),
(524, 114, '2024-04-12 02:24:06', 'User logged in'),
(525, 110, '2024-04-12 03:12:31', 'User logged in'),
(526, 115, '2024-04-12 03:51:28', 'User logged in'),
(527, 115, '2024-04-12 03:53:49', 'User logged in'),
(528, 1, '2024-04-12 04:22:50', 'User logged in'),
(529, 115, '2024-04-12 04:24:07', 'User logged in'),
(530, 1, '2024-04-12 04:26:26', 'User logged in'),
(531, 114, '2024-04-12 04:26:54', 'User logged in'),
(532, 115, '2024-04-12 04:27:04', 'User logged in'),
(533, 1, '2024-04-12 04:27:22', 'User logged in'),
(534, 115, '2024-04-12 04:54:24', 'User logged in'),
(535, 110, '2024-04-12 05:42:51', 'User logged in'),
(536, 115, '2024-04-12 06:36:10', 'User logged in'),
(537, 110, '2024-04-12 08:12:38', 'User logged in'),
(538, 115, '2024-04-13 14:21:03', 'User logged in'),
(539, 115, '2024-04-15 00:58:43', 'User logged in'),
(540, 115, '2024-04-15 01:06:25', 'User logged in'),
(541, 115, '2024-04-15 01:32:19', 'User logged in'),
(542, 115, '2024-04-15 02:03:07', 'User logged in'),
(543, 110, '2024-04-15 02:17:37', 'User logged in'),
(544, 1, '2024-04-15 02:23:25', 'User logged in'),
(545, 115, '2024-04-15 02:23:38', 'User logged in'),
(546, 115, '2024-04-15 02:30:05', 'User logged in'),
(547, 115, '2024-04-15 02:48:33', 'User logged in'),
(548, 110, '2024-04-15 05:36:56', 'User logged in'),
(549, 115, '2024-04-15 05:41:40', 'User logged in'),
(550, 115, '2024-04-15 06:03:38', 'User logged in'),
(551, 1, '2024-04-15 07:11:07', 'User logged in'),
(552, 1, '2024-04-15 07:11:12', 'User logged in'),
(553, 115, '2024-04-15 12:01:26', 'User logged in'),
(554, 1, '2024-04-15 12:54:54', 'User logged in'),
(555, 115, '2024-04-15 13:01:48', 'User logged in'),
(556, 1, '2024-04-15 13:02:04', 'User logged in'),
(557, 1, '2024-04-15 13:07:39', 'User logged in'),
(558, 110, '2024-04-16 00:28:26', 'User logged in'),
(559, 110, '2024-04-16 01:03:00', 'User logged in'),
(560, 110, '2024-04-16 05:53:43', 'User logged in'),
(561, 115, '2024-04-17 02:10:52', 'User logged in'),
(562, 115, '2024-04-17 03:07:16', 'User logged in'),
(563, 114, '2024-04-17 03:27:33', 'User logged in'),
(564, 115, '2024-04-17 03:51:17', 'User logged in'),
(565, 115, '2024-04-17 04:05:25', 'User logged in'),
(566, 110, '2024-04-17 04:09:47', 'User logged in'),
(567, 1, '2024-04-17 04:45:23', 'User logged in'),
(568, 115, '2024-04-17 04:47:19', 'User logged in'),
(569, 110, '2024-04-17 04:49:18', 'User logged in'),
(570, 115, '2024-04-17 05:01:36', 'User logged in'),
(571, 1, '2024-04-17 05:15:05', 'User logged in'),
(572, 115, '2024-04-17 05:32:24', 'User logged in'),
(573, 1, '2024-04-17 05:54:40', 'User logged in'),
(574, 115, '2024-04-17 06:02:31', 'User logged in'),
(575, 115, '2024-04-17 08:07:25', 'User logged in'),
(576, 110, '2024-04-17 08:08:38', 'User logged in'),
(577, 115, '2024-04-17 08:17:38', 'User logged in'),
(578, 115, '2024-04-17 09:08:09', 'User logged in'),
(579, 115, '2024-04-17 09:11:34', 'User logged in'),
(580, 110, '2024-04-17 09:14:53', 'User logged in'),
(581, 115, '2024-04-17 12:32:48', 'User logged in'),
(582, 110, '2024-04-18 01:27:15', 'User logged in'),
(583, 116, '2024-04-19 00:37:54', 'User logged in'),
(584, 117, '2024-04-19 00:43:06', 'User logged in'),
(585, 118, '2024-04-19 00:52:33', 'User logged in'),
(586, 110, '2024-04-19 00:57:56', 'User logged in'),
(587, 1, '2024-04-19 01:33:13', 'User logged in'),
(588, 115, '2024-04-19 01:34:36', 'User logged in'),
(589, 120, '2024-04-19 02:11:23', 'User logged in'),
(590, 1, '2024-04-19 03:55:00', 'User logged in'),
(591, 1, '2024-04-19 04:02:09', 'User logged in'),
(592, 115, '2024-04-19 04:12:33', 'User logged in'),
(593, 122, '2024-04-19 04:15:24', 'User logged in'),
(594, 115, '2024-04-19 04:16:19', 'User logged in'),
(595, 115, '2024-04-19 04:16:45', 'User logged in'),
(596, 122, '2024-04-19 04:17:41', 'User logged in'),
(597, 110, '2024-04-19 04:32:53', 'User logged in'),
(598, 115, '2024-04-19 07:00:10', 'User logged in'),
(599, 122, '2024-04-19 08:53:09', 'User logged in'),
(600, 122, '2024-04-19 08:59:05', 'User logged in'),
(601, 107, '2024-04-19 09:03:39', 'User logged in'),
(602, 115, '2024-04-20 08:28:11', 'User logged in'),
(603, 115, '2024-08-10 19:18:17', 'User logged in'),
(604, 115, '2024-08-10 19:22:29', 'User logged in'),
(605, 115, '2024-08-10 19:25:45', 'User logged in'),
(606, 115, '2024-08-10 19:48:57', 'User logged in'),
(607, 122, '2024-08-10 20:05:47', 'User logged in'),
(608, 122, '2024-08-10 20:06:58', 'User logged in'),
(609, 122, '2024-08-10 20:11:44', 'User logged in'),
(610, 115, '2024-08-11 00:50:47', 'User logged in'),
(611, 115, '2024-08-11 01:17:04', 'User logged in'),
(612, 115, '2024-08-11 01:27:29', 'User logged in'),
(613, 115, '2024-08-11 01:29:31', 'User logged in'),
(614, 115, '2024-08-11 03:51:59', 'User logged in'),
(615, 115, '2024-08-11 07:18:33', 'User logged in'),
(616, 115, '2024-08-11 07:32:24', 'User logged in'),
(617, 115, '2024-08-12 04:54:08', 'User logged in'),
(618, 115, '2024-08-12 19:31:59', 'User logged in'),
(619, 115, '2024-08-12 19:41:50', 'User logged in'),
(620, 115, '2024-08-13 08:17:43', 'User logged in'),
(621, 115, '2024-08-13 09:04:38', 'User logged in'),
(622, 115, '2024-08-13 09:04:49', 'User logged in'),
(623, 115, '2024-08-13 09:04:55', 'User logged in'),
(624, 115, '2024-08-13 09:05:35', 'User logged in'),
(625, 115, '2024-08-13 09:05:40', 'User logged in'),
(626, 115, '2024-08-13 09:05:45', 'User logged in'),
(627, 115, '2024-08-13 09:31:53', 'User logged in'),
(628, 115, '2024-08-13 09:32:11', 'User logged in'),
(629, 115, '2024-08-13 09:33:46', 'User logged in'),
(630, 115, '2024-08-13 09:45:41', 'User logged in'),
(631, 115, '2024-08-13 09:46:06', 'User logged in'),
(632, 115, '2024-08-14 00:33:49', 'User logged in'),
(633, 115, '2024-08-14 01:23:16', 'User logged in'),
(634, 115, '2024-08-14 01:24:22', 'User logged in'),
(635, 115, '2024-08-14 01:25:23', 'User logged in'),
(636, 115, '2024-08-14 02:31:07', 'User logged in'),
(637, 115, '2024-08-14 02:44:29', 'User logged in'),
(638, 115, '2024-08-14 03:37:37', 'User logged in'),
(639, 115, '2024-08-14 03:56:38', 'User logged in'),
(640, 115, '2024-08-14 04:23:23', 'User logged in'),
(641, 115, '2024-08-14 08:57:19', 'User logged in'),
(642, 115, '2024-08-14 09:26:59', 'User logged in'),
(643, 115, '2024-08-14 09:41:33', 'User logged in'),
(644, 115, '2024-08-14 09:43:54', 'User logged in'),
(645, 115, '2024-08-15 00:18:31', 'User logged in'),
(646, 115, '2024-08-15 00:34:13', 'User logged in'),
(647, 115, '2024-08-15 00:51:26', 'User logged in'),
(648, 115, '2024-08-15 00:52:02', 'User logged in'),
(649, 115, '2024-08-15 00:55:53', 'User logged in'),
(650, 115, '2024-08-15 00:56:06', 'User logged in'),
(651, 115, '2024-08-16 00:55:30', 'User logged in'),
(652, 115, '2024-08-17 01:34:49', 'User logged in'),
(653, 115, '2024-08-17 05:25:40', 'User logged in'),
(654, 115, '2024-08-17 05:55:19', 'User logged in'),
(655, 115, '2024-08-17 05:55:59', 'User logged in'),
(656, 122, '2024-08-17 06:15:18', 'User logged in'),
(657, 115, '2024-08-17 06:16:57', 'User logged in'),
(658, 115, '2024-08-17 23:38:05', 'User logged in'),
(659, 115, '2024-08-18 00:03:22', 'User logged in'),
(660, 115, '2024-08-18 00:03:29', 'User logged in'),
(661, 122, '2024-08-18 00:35:03', 'User logged in'),
(662, 115, '2024-08-18 00:55:33', 'User logged in'),
(663, 122, '2024-08-18 00:55:56', 'User logged in'),
(664, 122, '2024-08-18 01:11:22', 'User logged in'),
(665, 115, '2024-08-18 01:16:27', 'User logged in'),
(666, 122, '2024-08-18 01:16:38', 'User logged in'),
(667, 115, '2024-08-18 01:28:55', 'User logged in'),
(668, 122, '2024-08-18 01:29:14', 'User logged in'),
(669, 115, '2024-08-18 01:32:26', 'User logged in'),
(670, 122, '2024-08-18 01:32:44', 'User logged in'),
(671, 122, '2024-08-18 02:18:47', 'User logged in'),
(672, 122, '2024-08-18 02:21:32', 'User logged in'),
(673, 122, '2024-08-18 02:21:51', 'User logged in'),
(674, 122, '2024-08-18 02:23:29', 'User logged in'),
(675, 115, '2024-08-18 02:23:51', 'User logged in'),
(676, 122, '2024-08-18 02:24:22', 'User logged in'),
(677, 122, '2024-08-18 02:26:05', 'User logged in'),
(678, 122, '2024-08-18 02:32:28', 'User logged in'),
(679, 122, '2024-08-18 02:45:53', 'User logged in'),
(680, 122, '2024-08-18 02:48:59', 'User logged in'),
(681, 122, '2024-08-18 03:10:16', 'User logged in'),
(682, 122, '2024-08-18 03:10:34', 'User logged in'),
(683, 115, '2024-08-18 03:10:45', 'User logged in'),
(684, 122, '2024-08-18 03:12:18', 'User logged in'),
(685, 122, '2024-08-18 12:42:47', 'User logged in'),
(686, 1, '2024-08-18 12:45:10', 'User logged in'),
(687, 1, '2024-08-18 12:47:15', 'User logged in'),
(688, 1, '2024-08-18 12:47:26', 'User logged in'),
(689, 115, '2024-08-18 13:30:13', 'User logged in'),
(690, 115, '2024-08-18 14:08:58', 'User logged in'),
(691, 1, '2024-08-18 14:13:13', 'User logged in'),
(692, 1, '2024-08-18 23:33:51', 'User logged in'),
(693, 122, '2024-08-18 23:41:35', 'User logged in'),
(694, 122, '2024-08-19 00:12:48', 'User logged in'),
(695, 115, '2024-08-19 00:13:00', 'User logged in'),
(696, 122, '2024-08-19 00:13:08', 'User logged in'),
(697, 115, '2024-08-19 00:19:49', 'User logged in'),
(698, 122, '2024-08-19 00:20:25', 'User logged in'),
(699, 122, '2024-08-19 00:22:57', 'User logged in'),
(700, 115, '2024-08-19 00:23:39', 'User logged in'),
(701, 122, '2024-08-19 00:23:53', 'User logged in'),
(702, 115, '2024-08-19 00:25:07', 'User logged in'),
(703, 122, '2024-08-19 00:25:15', 'User logged in'),
(704, 122, '2024-08-20 02:31:25', 'User logged in'),
(705, 115, '2024-08-20 02:31:54', 'User logged in'),
(706, 122, '2024-08-20 02:34:54', 'User logged in'),
(707, 115, '2024-08-20 02:43:20', 'User logged in'),
(708, 1, '2024-08-20 02:43:52', 'User logged in'),
(709, 1, '2024-08-20 03:07:25', 'User logged in'),
(710, 115, '2024-08-20 08:26:59', 'User logged in'),
(711, 1, '2024-08-20 08:38:11', 'User logged in'),
(712, 122, '2024-08-20 08:54:55', 'User logged in'),
(713, 122, '2024-08-20 09:03:26', 'User logged in'),
(714, 115, '2024-08-20 09:03:39', 'User logged in'),
(715, 115, '2024-08-20 09:53:47', 'User logged in'),
(716, 122, '2024-08-20 09:55:02', 'User logged in'),
(717, 115, '2024-08-20 09:55:35', 'User logged in'),
(718, 115, '2024-08-20 10:19:21', 'User logged in'),
(719, 115, '2024-08-20 11:36:11', 'User logged in'),
(720, 1, '2024-08-20 12:59:18', 'User logged in'),
(721, 122, '2024-08-20 13:01:15', 'User logged in'),
(722, 115, '2024-08-20 13:03:59', 'User logged in'),
(723, 122, '2024-08-20 13:05:43', 'User logged in'),
(724, 122, '2024-08-20 13:08:57', 'User logged in'),
(725, 1, '2024-08-20 13:11:42', 'User logged in'),
(726, 122, '2024-08-20 13:12:03', 'User logged in'),
(727, 1, '2024-08-20 13:14:55', 'User logged in'),
(728, 115, '2024-08-20 13:17:24', 'User logged in'),
(729, 115, '2024-08-21 12:59:56', 'User logged in'),
(730, 115, '2024-08-23 02:28:34', 'User logged in'),
(731, 115, '2024-08-23 07:27:00', 'User logged in'),
(732, 122, '2024-08-23 07:28:38', 'User logged in'),
(733, 1, '2024-08-23 07:29:10', 'User logged in'),
(734, 122, '2024-08-23 07:37:06', 'User logged in'),
(735, 1, '2024-08-23 07:37:48', 'User logged in'),
(736, 122, '2024-08-23 07:41:49', 'User logged in'),
(737, 122, '2024-08-23 07:46:01', 'User logged in'),
(738, 1, '2024-08-23 07:54:01', 'User logged in'),
(739, 117, '2024-08-23 07:57:57', 'User logged in'),
(740, 122, '2024-08-23 07:59:51', 'User logged in'),
(741, 1, '2024-08-23 08:00:02', 'User logged in'),
(742, 117, '2024-08-23 08:00:35', 'User logged in'),
(743, 125, '2024-08-23 08:01:36', 'User logged in'),
(744, 122, '2024-08-23 08:06:07', 'User logged in'),
(745, 1, '2024-08-23 08:06:20', 'User logged in'),
(746, 115, '2024-08-23 08:06:45', 'User logged in'),
(747, 1, '2024-08-23 08:08:22', 'User logged in'),
(748, 115, '2024-08-23 08:08:51', 'User logged in'),
(749, 115, '2024-08-23 10:29:49', 'User logged in'),
(750, 125, '2024-08-25 07:05:27', 'User logged in'),
(751, 125, '2024-08-25 07:08:59', 'User logged in'),
(752, 125, '2024-08-25 07:10:04', 'User logged in'),
(753, 125, '2024-08-25 07:14:39', 'User logged in'),
(754, 125, '2024-08-25 07:20:35', 'User logged in'),
(755, 125, '2024-08-25 07:29:39', 'User logged in'),
(756, 125, '2024-08-25 08:05:19', 'User logged in'),
(757, 122, '2024-08-25 08:14:59', 'User logged in'),
(758, 1, '2024-08-25 08:16:05', 'User logged in'),
(759, 125, '2024-08-25 08:16:16', 'User logged in'),
(760, 125, '2024-08-25 08:18:06', 'User logged in'),
(761, 125, '2024-08-25 08:28:37', 'User logged in'),
(762, 125, '2024-08-25 09:04:01', 'User logged in'),
(763, 115, '2024-08-25 09:04:15', 'User logged in'),
(764, 125, '2024-08-25 09:04:31', 'User logged in'),
(765, 115, '2024-08-25 09:09:35', 'User logged in'),
(766, 125, '2024-08-25 09:25:57', 'User logged in'),
(767, 125, '2024-08-25 09:28:32', 'User logged in'),
(768, 125, '2024-08-25 09:29:29', 'User logged in'),
(769, 115, '2024-08-25 09:29:36', 'User logged in'),
(770, 125, '2024-08-25 09:40:47', 'User logged in'),
(771, 115, '2024-08-25 09:42:36', 'User logged in'),
(772, 125, '2024-08-25 09:44:35', 'User logged in'),
(773, 115, '2024-08-25 09:44:47', 'User logged in'),
(774, 115, '2024-08-25 09:45:18', 'User logged in'),
(775, 115, '2024-08-25 09:47:36', 'User logged in'),
(776, 115, '2024-08-25 10:08:20', 'User logged in'),
(777, 125, '2024-08-25 10:09:32', 'User logged in'),
(778, 125, '2024-08-25 10:09:58', 'User logged in'),
(779, 115, '2024-08-25 10:10:38', 'User logged in'),
(780, 115, '2024-08-27 19:50:22', 'User logged in'),
(781, 115, '2024-08-27 19:53:43', 'User logged in'),
(782, 115, '2024-08-27 19:54:04', 'User logged in'),
(783, 115, '2024-08-27 19:55:26', 'User logged in'),
(784, 115, '2024-08-27 19:56:30', 'User logged in'),
(785, 115, '2024-08-27 20:01:09', 'User logged in'),
(786, 125, '2024-08-27 20:01:47', 'User logged in'),
(787, 125, '2024-08-27 20:01:59', 'User logged in'),
(788, 125, '2024-08-27 20:03:48', 'User logged in'),
(789, 122, '2024-08-27 20:04:05', 'User logged in'),
(790, 122, '2024-08-27 20:11:20', 'User logged in'),
(791, 122, '2024-08-27 20:18:47', 'User logged in'),
(792, 122, '2024-08-27 20:19:19', 'User logged in'),
(793, 122, '2024-08-27 20:20:51', 'User logged in'),
(794, 122, '2024-08-27 20:24:50', 'User logged in'),
(795, 122, '2024-08-27 20:36:25', 'User logged in'),
(796, 122, '2024-08-27 20:38:39', 'User logged in'),
(797, 122, '2024-08-27 20:38:57', 'User logged in'),
(798, 122, '2024-08-27 20:48:12', 'User logged in'),
(799, 1, '2024-08-27 20:48:57', 'User logged in'),
(800, 122, '2024-08-27 20:58:14', 'User logged in'),
(801, 1, '2024-08-27 20:59:21', 'User logged in'),
(802, 1, '2024-08-27 21:01:59', 'User logged in'),
(803, 1, '2024-08-28 01:54:47', 'User logged in'),
(804, 117, '2024-08-28 01:58:47', 'User logged in'),
(805, 115, '2024-08-28 02:00:04', 'User logged in'),
(806, 125, '2024-08-28 02:00:19', 'User logged in'),
(807, 115, '2024-08-28 02:56:01', 'User logged in'),
(808, 125, '2024-08-28 03:03:16', 'User logged in'),
(809, 1, '2024-08-28 03:07:06', 'User logged in'),
(810, 125, '2024-08-28 03:07:55', 'User logged in'),
(811, 125, '2024-08-28 04:50:55', 'User logged in'),
(812, 125, '2024-08-28 04:51:12', 'User logged in'),
(813, 122, '2024-08-28 04:56:58', 'User logged in'),
(814, 125, '2024-08-28 04:58:18', 'User logged in'),
(815, 115, '2024-08-28 05:01:06', 'User logged in'),
(816, 115, '2024-08-28 05:58:00', 'User logged in'),
(817, 125, '2024-08-28 08:05:06', 'User logged in'),
(818, 125, '2024-08-28 08:07:17', 'User logged in'),
(819, 115, '2024-08-28 12:39:55', 'User logged in'),
(820, 125, '2024-08-28 12:47:51', 'User logged in'),
(821, 115, '2024-08-28 13:13:36', 'User logged in'),
(822, 125, '2024-08-28 13:19:31', 'User logged in'),
(823, 125, '2024-08-28 15:14:58', 'User logged in'),
(824, 115, '2024-08-28 16:03:44', 'User logged in'),
(825, 125, '2024-08-28 16:03:57', 'User logged in'),
(826, 1, '2024-09-02 00:23:45', 'User logged in'),
(827, 1, '2024-09-02 00:49:02', 'User logged in'),
(828, 112, '2024-09-02 01:13:17', 'User logged in'),
(829, 122, '2024-09-02 01:14:46', 'User logged in'),
(830, 117, '2024-09-02 01:15:55', 'User logged in'),
(831, 112, '2024-09-02 01:17:13', 'User logged in'),
(832, 126, '2024-09-02 01:17:54', 'User logged in'),
(833, 117, '2024-09-02 01:36:00', 'User logged in'),
(834, 112, '2024-09-02 01:42:48', 'User logged in'),
(835, 1, '2024-09-02 01:48:21', 'User logged in'),
(836, 128, '2024-09-02 01:53:43', 'User logged in'),
(837, 128, '2024-09-02 01:57:12', 'User logged in'),
(838, 112, '2024-09-02 02:01:15', 'User logged in'),
(839, 130, '2024-09-02 02:01:56', 'User logged in'),
(840, 112, '2024-09-02 02:02:33', 'User logged in'),
(841, 128, '2024-09-02 02:03:00', 'User logged in'),
(842, 122, '2024-09-02 02:47:33', 'User logged in'),
(843, 1, '2024-09-02 02:47:43', 'User logged in'),
(844, 107, '2024-09-02 02:56:56', 'User logged in'),
(845, 107, '2024-09-02 03:00:41', 'User logged in'),
(846, 128, '2024-09-02 03:12:15', 'User logged in'),
(847, 107, '2024-09-02 03:14:48', 'User logged in'),
(848, 117, '2024-09-02 03:29:37', 'User logged in'),
(849, 128, '2024-09-02 03:32:09', 'User logged in'),
(850, 112, '2024-09-02 03:33:10', 'User logged in'),
(851, 117, '2024-09-02 03:35:06', 'User logged in'),
(852, 107, '2024-09-02 03:41:41', 'User logged in'),
(853, 128, '2024-09-02 03:45:04', 'User logged in'),
(854, 133, '2024-09-02 03:48:17', 'User logged in'),
(855, 107, '2024-09-02 03:49:14', 'User logged in'),
(856, 1, '2024-09-05 11:40:20', 'User logged in'),
(857, 115, '2024-09-05 11:50:19', 'User logged in'),
(858, 134, '2024-09-05 11:55:31', 'User logged in'),
(859, 134, '2024-09-06 03:15:05', 'User logged in'),
(860, 1, '2024-09-06 03:21:24', 'User logged in'),
(861, 1, '2024-09-07 02:01:45', 'User logged in'),
(862, 128, '2024-09-07 04:06:35', 'User logged in'),
(863, 128, '2024-09-07 04:07:43', 'User logged in'),
(864, 128, '2024-09-07 04:08:29', 'User logged in'),
(865, 134, '2024-09-07 04:08:57', 'User logged in'),
(866, 1, '2024-09-07 04:15:17', 'User logged in'),
(867, 128, '2024-09-07 04:18:24', 'User logged in'),
(868, 134, '2024-09-07 04:18:57', 'User logged in'),
(869, 134, '2024-09-07 04:46:18', 'User logged in'),
(870, 117, '2024-09-07 04:47:20', 'User logged in'),
(871, 115, '2024-09-07 04:47:31', 'User logged in'),
(872, 112, '2024-09-07 04:49:31', 'User logged in'),
(873, 135, '2024-09-07 04:50:08', 'User logged in'),
(874, 117, '2024-09-07 04:55:28', 'User logged in'),
(875, 136, '2024-09-07 04:56:56', 'User logged in'),
(876, 135, '2024-09-07 05:35:53', 'User logged in'),
(877, 1, '2024-09-07 05:44:55', 'User logged in'),
(878, 1, '2024-09-07 06:27:42', 'User logged in'),
(879, 135, '2024-09-07 07:12:57', 'User logged in'),
(880, 136, '2024-09-07 07:34:50', 'User logged in'),
(881, 1, '2024-09-08 23:29:01', 'User logged in'),
(882, 108, '2024-09-10 12:24:53', 'User logged in'),
(883, 135, '2024-09-10 12:26:49', 'User logged in'),
(884, 135, '2024-09-11 09:48:04', 'User logged in'),
(885, 135, '2024-09-12 12:06:57', 'User logged in'),
(886, 122, '2024-09-12 12:46:44', 'User logged in'),
(887, 1, '2024-09-12 12:57:36', 'User logged in'),
(888, 135, '2024-09-13 09:27:11', 'User logged in'),
(889, 135, '2024-09-15 00:27:17', 'User logged in'),
(890, 117, '2024-09-15 02:02:53', 'User logged in'),
(891, 1, '2024-09-15 02:03:04', 'User logged in'),
(892, 135, '2024-09-15 02:06:02', 'User logged in'),
(893, 122, '2024-09-15 02:26:25', 'User logged in'),
(894, 122, '2024-09-15 02:32:13', 'User logged in'),
(895, 135, '2024-09-15 02:36:52', 'User logged in'),
(896, 135, '2024-09-15 03:01:45', 'User logged in'),
(897, 135, '2024-09-15 03:28:06', 'User logged in'),
(898, 1, '2024-09-15 03:28:40', 'User logged in'),
(899, 117, '2024-09-15 03:37:11', 'User logged in'),
(900, 117, '2024-09-15 03:46:03', 'User logged in'),
(901, 135, '2024-09-15 03:47:29', 'User logged in'),
(902, 115, '2024-09-15 04:28:42', 'User logged in'),
(903, 115, '2024-09-15 04:49:22', 'User logged in'),
(904, 115, '2024-09-15 04:50:55', 'User logged in'),
(905, 135, '2024-09-15 05:18:37', 'User logged in'),
(906, 135, '2024-09-15 12:13:28', 'User logged in'),
(907, 1, '2024-09-15 13:00:54', 'User logged in'),
(908, 135, '2024-09-16 10:49:50', 'User logged in'),
(909, 108, '2024-09-17 03:35:49', 'User logged in'),
(910, 135, '2024-09-17 12:13:12', 'User logged in'),
(911, 117, '2024-09-17 12:47:54', 'User logged in'),
(912, 1, '2024-09-17 12:50:35', 'User logged in'),
(913, 135, '2024-09-17 12:51:18', 'User logged in'),
(914, 1, '2024-09-17 13:26:28', 'User logged in'),
(915, 115, '2024-09-17 18:06:33', 'User logged in'),
(916, 115, '2024-09-17 18:28:56', 'User logged in'),
(917, 1, '2024-09-17 18:59:28', 'User logged in'),
(918, 122, '2024-09-17 19:00:41', 'User logged in'),
(919, 135, '2024-09-17 19:04:27', 'User logged in'),
(920, 135, '2024-09-18 02:41:39', 'User logged in'),
(921, 115, '2024-09-18 07:00:20', 'User logged in'),
(922, 115, '2024-09-22 10:19:30', 'User logged in'),
(923, 115, '2024-09-22 10:51:38', 'User logged in'),
(924, 115, '2024-09-23 02:25:26', 'User logged in'),
(925, 1, '2024-09-23 02:47:41', 'User logged in'),
(926, 115, '2024-09-23 02:50:47', 'User logged in'),
(927, 115, '2024-09-23 02:51:32', 'User logged in'),
(928, 135, '2024-09-23 02:54:22', 'User logged in'),
(929, 1, '2024-09-23 02:56:00', 'User logged in'),
(930, 136, '2024-09-23 03:23:52', 'User logged in'),
(931, 135, '2024-09-23 07:05:24', 'User logged in'),
(932, 115, '2024-09-23 09:32:35', 'User logged in'),
(933, 108, '2024-09-23 09:45:19', 'User logged in'),
(934, 1, '2024-09-23 09:54:26', 'User logged in'),
(935, 115, '2024-09-24 09:50:10', 'User logged in'),
(936, 134, '2024-09-24 12:22:43', 'User logged in'),
(937, 134, '2024-09-24 13:24:36', 'User logged in'),
(938, 134, '2024-09-24 13:25:13', 'User logged in'),
(939, 134, '2024-09-24 13:33:34', 'User logged in'),
(940, 134, '2024-09-24 13:34:36', 'User logged in'),
(941, 134, '2024-09-24 13:35:58', 'User logged in'),
(942, 134, '2024-09-24 13:36:41', 'User logged in'),
(943, 134, '2024-09-24 13:42:00', 'User logged in'),
(944, 134, '2024-09-24 13:46:19', 'User logged in'),
(945, 134, '2024-09-24 13:48:20', 'User logged in'),
(946, 134, '2024-09-24 21:45:53', 'User logged in'),
(947, 134, '2024-09-24 21:47:52', 'User logged in'),
(948, 134, '2024-09-24 21:50:09', 'User logged in'),
(949, 134, '2024-09-24 21:51:49', 'User logged in'),
(950, 134, '2024-09-24 21:53:59', 'User logged in'),
(951, 134, '2024-09-24 21:55:01', 'User logged in'),
(952, 134, '2024-09-24 21:57:06', 'User logged in'),
(953, 134, '2024-09-24 22:01:04', 'User logged in'),
(954, 134, '2024-09-24 22:09:02', 'User logged in'),
(955, 134, '2024-09-24 22:12:58', 'User logged in'),
(956, 134, '2024-09-24 22:20:41', 'User logged in'),
(957, 134, '2024-09-24 22:21:26', 'User logged in'),
(958, 134, '2024-09-24 22:22:51', 'User logged in'),
(959, 134, '2024-09-24 22:31:28', 'User logged in'),
(960, 134, '2024-09-24 22:51:07', 'User logged in'),
(961, 134, '2024-09-24 23:16:48', 'User logged in'),
(962, 134, '2024-09-25 00:04:56', 'User logged in'),
(963, 134, '2024-09-25 00:12:15', 'User logged in'),
(964, 134, '2024-09-25 00:20:31', 'User logged in'),
(965, 134, '2024-09-25 01:00:11', 'User logged in'),
(966, 134, '2024-09-25 01:09:33', 'User logged in'),
(967, 134, '2024-09-25 01:24:03', 'User logged in'),
(968, 134, '2024-09-25 01:27:10', 'User logged in'),
(969, 134, '2024-09-25 01:27:42', 'User logged in'),
(970, 134, '2024-09-25 01:37:31', 'User logged in'),
(971, 134, '2024-09-25 06:12:21', 'User logged in'),
(972, 134, '2024-09-25 06:13:00', 'User logged in'),
(973, 134, '2024-09-25 06:13:31', 'User logged in'),
(974, 134, '2024-09-25 06:36:21', 'User logged in'),
(975, 134, '2024-09-25 06:36:50', 'User logged in'),
(976, 134, '2024-09-25 06:37:57', 'User logged in'),
(977, 134, '2024-09-25 06:46:31', 'User logged in'),
(978, 134, '2024-09-25 07:02:46', 'User logged in'),
(979, 134, '2024-09-25 11:27:58', 'User logged in'),
(980, 134, '2024-09-25 12:06:55', 'User logged in'),
(981, 115, '2024-09-25 12:31:49', 'User logged in'),
(982, 135, '2024-09-25 12:32:45', 'User logged in'),
(983, 115, '2024-09-25 12:39:46', 'User logged in'),
(984, 115, '2024-09-25 12:41:57', 'User logged in'),
(985, 134, '2024-09-25 13:00:41', 'User logged in'),
(986, 134, '2024-09-25 13:11:55', 'User logged in'),
(987, 134, '2024-09-25 23:08:51', 'User logged in'),
(988, 134, '2024-09-25 23:12:26', 'User logged in'),
(989, 134, '2024-09-25 23:26:21', 'User logged in'),
(990, 134, '2024-09-26 06:05:05', 'User logged in'),
(991, 108, '2024-10-04 14:26:24', 'User logged in'),
(992, 108, '2024-10-06 23:33:36', 'User logged in'),
(993, 113, '2024-10-06 23:55:33', 'User logged in'),
(994, 137, '2024-10-07 00:00:56', 'User logged in'),
(995, 137, '2024-10-07 00:10:37', 'User logged in'),
(996, 113, '2024-10-07 00:27:55', 'User logged in'),
(997, 137, '2024-10-07 13:59:37', 'User logged in'),
(998, 113, '2024-10-07 14:08:02', 'User logged in'),
(999, 113, '2024-10-07 14:13:16', 'User logged in'),
(1000, 113, '2024-10-07 14:14:24', 'User logged in'),
(1001, 113, '2024-10-07 14:18:32', 'User logged in'),
(1002, 137, '2024-10-12 14:03:49', 'User logged in'),
(1003, 137, '2024-10-13 06:56:11', 'User logged in'),
(1004, 113, '2024-10-13 07:17:06', 'User logged in'),
(1005, 137, '2024-10-15 04:11:21', 'User logged in'),
(1006, 113, '2024-10-15 04:12:28', 'User logged in'),
(1007, 113, '2024-10-15 04:19:40', 'User logged in'),
(1008, 113, '2024-10-15 04:24:30', 'User logged in'),
(1009, 113, '2024-10-15 05:02:00', 'User logged in'),
(1010, 113, '2024-10-15 05:05:33', 'User logged in'),
(1011, 113, '2024-10-15 05:05:50', 'User logged in'),
(1012, 113, '2024-10-15 05:07:36', 'User logged in'),
(1013, 113, '2024-10-15 05:11:44', 'User logged in'),
(1014, 113, '2024-10-19 11:50:17', 'User logged in');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_sessions`
--
ALTER TABLE `active_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipality_id` (`municipality_id`);

--
-- Indexes for table `case_progress`
--
ALTER TABLE `case_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_id` (`complaint_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BarangayID` (`BarangayID`);

--
-- Indexes for table `hearings`
--
ALTER TABLE `hearings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_id` (`complaint_id`);

--
-- Indexes for table `luponforms`
--
ALTER TABLE `luponforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lupons`
--
ALTER TABLE `lupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mov`
--
ALTER TABLE `mov`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `movrate`
--
ALTER TABLE `movrate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mov_id` (`mov_id`),
  ADD KEY `barangay` (`barangay`);

--
-- Indexes for table `movremark`
--
ALTER TABLE `movremark`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mov_id` (`mov_id`),
  ADD KEY `barangay` (`barangay`);

--
-- Indexes for table `municipalities`
--
ALTER TABLE `municipalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `upload_files`
--
ALTER TABLE `upload_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipality_id` (`municipality_id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `user_files`
--
ALTER TABLE `user_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_sessions`
--
ALTER TABLE `active_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `case_progress`
--
ALTER TABLE `case_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `hearings`
--
ALTER TABLE `hearings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=779;

--
-- AUTO_INCREMENT for table `luponforms`
--
ALTER TABLE `luponforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lupons`
--
ALTER TABLE `lupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `mov`
--
ALTER TABLE `mov`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `movrate`
--
ALTER TABLE `movrate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `movremark`
--
ALTER TABLE `movremark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `municipalities`
--
ALTER TABLE `municipalities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `upload_files`
--
ALTER TABLE `upload_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `user_files`
--
ALTER TABLE `user_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1015;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `active_sessions`
--
ALTER TABLE `active_sessions`
  ADD CONSTRAINT `active_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barangays`
--
ALTER TABLE `barangays`
  ADD CONSTRAINT `barangays_ibfk_1` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`);

--
-- Constraints for table `case_progress`
--
ALTER TABLE `case_progress`
  ADD CONSTRAINT `case_progress_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`);

--
-- Constraints for table `hearings`
--
ALTER TABLE `hearings`
  ADD CONSTRAINT `hearings_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`);

--
-- Constraints for table `luponforms`
--
ALTER TABLE `luponforms`
  ADD CONSTRAINT `luponforms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mov`
--
ALTER TABLE `mov`
  ADD CONSTRAINT `mov_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`);

--
-- Constraints for table `movrate`
--
ALTER TABLE `movrate`
  ADD CONSTRAINT `movrate_ibfk_2` FOREIGN KEY (`barangay`) REFERENCES `mov` (`barangay_id`),
  ADD CONSTRAINT `movrate_ibfk_3` FOREIGN KEY (`mov_id`) REFERENCES `mov` (`id`);

--
-- Constraints for table `movremark`
--
ALTER TABLE `movremark`
  ADD CONSTRAINT `movremark_ibfk_2` FOREIGN KEY (`barangay`) REFERENCES `mov` (`barangay_id`),
  ADD CONSTRAINT `movremark_ibfk_3` FOREIGN KEY (`mov_id`) REFERENCES `mov` (`id`);

--
-- Constraints for table `upload_files`
--
ALTER TABLE `upload_files`
  ADD CONSTRAINT `upload_files_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `complaints` (`id`);

--
-- Constraints for table `user_files`
--
ALTER TABLE `user_files`
  ADD CONSTRAINT `user_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
