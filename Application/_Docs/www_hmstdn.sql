-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2016 at 06:03 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `www_hmstdn`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_clinics`
--

CREATE TABLE `app_clinics` (
  `id` int(16) NOT NULL,
  `clinic_id` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `location_state` int(11) NOT NULL,
  `location_street` varchar(200) NOT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_phone` varchar(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_clinics`
--

INSERT INTO `app_clinics` (`id`, `clinic_id`, `name`, `location_state`, `location_street`, `contact_email`, `contact_phone`, `status`) VALUES
(1, 'UNNMED', 'University of Nigeria Medical Center Nsukka', 22, 'University of Nigeria, Nsukka', 'enugu.medical@unn.edu.ng', '08031231238', 1),
(2, 'UNTHIT', 'University of Nigeria Teaching Hospital Ituku', 22, 'Ituku Ozalla, Nkanu-West', 'ituku@unth.ng', '08031231231', 1),
(3, 'UNTHEN', 'University of Nigeria Teaching Hospital Enugu', 22, 'Old Park, Ogui Enugu', 'enugu@unth.ng', '08031231232', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_consultations`
--

CREATE TABLE `app_consultations` (
  `id` int(16) NOT NULL,
  `clinic` int(16) NOT NULL,
  `doctor` int(16) DEFAULT NULL,
  `patient` int(16) DEFAULT NULL,
  `meeting_date` int(20) NOT NULL,
  `start_time` int(20) NOT NULL,
  `end_time` int(20) NOT NULL,
  `notes` text,
  `diagnoses` text,
  `treatment` text,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_consultations`
--

INSERT INTO `app_consultations` (`id`, `clinic`, `doctor`, `patient`, `meeting_date`, `start_time`, `end_time`, `notes`, `diagnoses`, `treatment`, `status`) VALUES
(17, 1, 19, 15, 1454367600, 1454396400, 1454400000, NULL, NULL, NULL, 2),
(18, 1, 5, 20, 1454367600, 1454400000, 1454403600, NULL, NULL, NULL, 2),
(19, 3, 20, 21, 1454540400, 1454572800, 1454576400, NULL, NULL, NULL, 2),
(20, 1, 19, 18, 1454367600, 1454410800, 1454414400, NULL, NULL, NULL, 2),
(21, 1, 19, 15, 1454454000, 1454482800, 1454486400, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `app_diseases`
--

CREATE TABLE `app_diseases` (
  `id` int(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `causative_organisms` text NOT NULL,
  `signs_and_symptoms` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_diseases`
--

INSERT INTO `app_diseases` (`id`, `name`, `causative_organisms`, `signs_and_symptoms`, `status`) VALUES
(1, 'Dracunculiasis', '<p>Dracunculus medinensis,\r</p><p>Echinococcus granulosus</p>', '<p>painful burning sensation, fever, nausea, and vomiting. allergi, rashes, nausea, diarrhea, dizziness, and localized edema.</p>', 1),
(2, 'Enterobiasis', '<p>Enterobius vermicularis</p>', '<p>pruritus ani and perineal pruritus, i.e., itching in and around the anus and around the perineum.\r</p><p>\r</p>', 1),
(3, 'Echinococcosis', '<p>Echinococcus granulosus\r</p><p>And Echinococcus \r</p><p>multilocularis\r</p>', '<p>abdominal pain, weight loss, and turn yellow. Lung disease may cause pain in the chest, shortness of breath and coughing.\r</p><p>\r</p>', 1),
(4, 'African trypanosomiasis', '<p>Trypanosoma brucei gambiense,\r</p><p>Trypanosoma brucei rhodesiense\r</p>', '<p>fever, headache, lymphadenopathy, nocturnal sleeping pattern, personality change, cognitive decline, and coma.</p>', 1),
(5, 'Buruli ulcer', '<p>Mycobacterium ulcerans</p>', '<p>deformity, disability, and skin lesions.</p>', 1),
(6, 'Chagas disease', '<p>Trypanosoma cruzi</p>', '<p> skin chancres, unilateral purplish orbital oedema, local lymphoadenopathies, and fever accompanied by a variety of other symptoms depending on infection site.</p>', 1),
(7, 'Cysticercosis and taeniasis', '<p>Taenia solium , Taenia saginata Taenia asiatica</p>', '<p>weight loss, dizziness, abdominal pain, diarrhea, headaches, nausea, constipation, chronic indigestion, and loss of appetite.</p>', 1),
(8, 'Dengue fever', '<p>Flavivirus</p>', '<p>high fever and flu-like symptoms</p>', 1),
(9, 'Dracunculiasis', '<p>guinea-worm larvae</p>', '<p>Inches and painful blister</p>', 1),
(10, 'Echinococcosis', '<p>E. granulosus, E. multilocularis, E. oligarthrus and E. vogeli</p>', '<p>abdominal pain, nausea and vomiting while cysts in the lungs cause chronic cough, chest pain, and shortness of breath.</p>', 1),
(11, 'Leishmaniasis', '<p>Leishmania species (L. major, L. infantum, and L. braziliensis)</p>', '<p>ulcers of the skin, mouth, and nose, fever, low red blood cells, and enlarged spleen and liver.</p>', 1),
(12, 'Leprosy', '<p>Mycobacterium</p>', '<p>Corneal ulcer, eye pain,fever, joit pain, neuropathy, rash,skin biopsy disabled or disfigured.</p>', 1),
(13, 'Lymphatic filariasis', '<p>Wuchereria bancrofti, Brugia malayi, and Brugia timori</p>', '<p>lymphoedema of the limbs, genital disease, painful recurrent attacks, lymphatic damage and kidney damage.</p>', 1),
(14, 'Onchocerciasis', '<p>Onchocerca volvulus</p>', '<p>blindness, skin rashes, lesions, intense itching and skin depigmentation.</p>', 1),
(15, 'Rabies', '<p>Rhabdovirus</p>', '<p>fever, myalgia (muscle pains) and headache, which eventually progresses to brain inflammation, seizures, confusion, paralysis, coma and death.</p>', 1),
(16, 'Schistosomiasis', '<p>Schistosoma mansoni\r</p><p>Schistosoma haematobium\r</p><p>Schistosoma japonicum</p>', '<p>abdominal pain, diarrhea, bloody stool, or blood in the urine., liver damage, kidney failure, portal hypertension, cervical lesions, bladder cancer and haematemesis,</p>', 1),
(17, 'Soil-transmitted helminthiasis', '<p>ascariasis (roundworms), trichuriasis (whipworm), and strongyloidiasis.</p>', '<p>intestinal problems, lack of energy, and compromised physical and cognitive development.</p>', 1),
(18, 'Trachoma', '<p>Chlamydia trachomatis</p>', '<p>partially blind, blindness</p>', 1),
(19, 'Yaws', '<p>Treponemes</p>', '<p>skin lesions</p>', 1),
(20, 'Yellow fever', '<p>Yellow fever virus(Flaviviridae)</p>', '<p>severe hepatitis and hemorrhagic fever</p>', 1),
(21, 'Plague', '<p>Pasteurella pestis</p>', '<p>Fever, headache, and painfully swollen lymph nodes</p>', 1),
(22, 'Leptospirosis', '<p>Leptospira</p>', '<p>headaches, muscle pains, and fevers, bleeding from the lungs or meningitis.</p>', 1),
(23, 'Meningococcal meningitis', '<p>Neisseria meningitidis</p>', '<p>Stiff neck, high fever, headaches, and vomiting</p>', 1),
(24, 'Lassa fever', '<p>Arenaviridae</p>', '<p>Slight fever, general malaise, weakness, headache, hemorrhaging (in gums, eyes, or nose, as examples), respiratory distress, repeated vomiting, facial swelling, pain in the chest, back, and abdomen, and shock.</p>', 1),
(25, 'Malaria', '<p>Plasmodium species(Plasmodium falciparum, Plasmodium vivax, Plasmodium knowles, Plasmodium ovale and Plasmodium malariae.)</p>', '<p>flu-like symptoms that include high fever and chills headaches, and vomiting.</p>', 1),
(26, 'Typhiod fever', '<p>Salmonella typhi bacteria Salmonella paratyphi.</p>', '<p>Poor appetite ,Headaches, Generalized aches and pains Fever as high as 104 degrees Farenheit Lethargy and Diarrhea</p>', 1),
(27, 'Ebola', '<p>Ebola virus</p>', '<p>fever, chills, general malaise, fatigue, headache, vomiting, diarrhea, loss of appetite, nonpruritic maculopapular rash, massive gastrointestinal bleeding dehydration, hypotension,shock</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_employment_data`
--

CREATE TABLE `app_employment_data` (
  `id` int(16) NOT NULL COMMENT 'site_users.id',
  `clinic` int(16) NOT NULL,
  `department` varchar(50) NOT NULL,
  `specialization` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_employment_data`
--

INSERT INTO `app_employment_data` (`id`, `clinic`, `department`, `specialization`) VALUES
(1, 1, 'IT', 'Security'),
(4, 1, 'Customer Service', 'Receptionist'),
(5, 1, 'Dentistry', 'Dental Surgery'),
(6, 1, 'Lab. Sciences', 'Last Scientist'),
(18, 1, 'Reception', 'Receptionist'),
(19, 1, 'Pediatrics', 'Pediatrician'),
(20, 1, 'Dental Care', 'Dentist'),
(21, 3, 'Administration', 'Web Admin.');

-- --------------------------------------------------------

--
-- Table structure for table `app_lab_tests`
--

CREATE TABLE `app_lab_tests` (
  `id` int(16) NOT NULL,
  `consultation` int(16) NOT NULL,
  `operator` int(16) DEFAULT NULL,
  `disease` int(16) NOT NULL,
  `request_date` int(20) NOT NULL,
  `test_date` int(20) DEFAULT NULL,
  `patient_location` int(16) DEFAULT NULL,
  `result` int(1) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_lab_tests`
--

INSERT INTO `app_lab_tests` (`id`, `consultation`, `operator`, `disease`, `request_date`, `test_date`, `patient_location`, `result`, `status`) VALUES
(1, 20, 6, 26, 1454358646, 1454359058, 22, 1, 1),
(2, 17, 6, 25, 1454400222, 1454400302, 22, 1, 1),
(3, 17, 6, 26, 1454400268, 1454400302, 10, 1, 1),
(4, 17, 6, 5, 1455615707, 1455615801, 28, 1, 1),
(5, 17, 6, 7, 1455615707, 1455615801, 28, 1, 1),
(6, 17, 6, 1, 1455615707, 1455615801, 28, 1, 1),
(7, 17, 6, 3, 1455615707, 1455615801, 28, 1, 1),
(8, 17, 6, 2, 1455615707, 1455615801, 28, 1, 1),
(9, 17, 6, 25, 1455615707, 1455615801, 28, 1, 1),
(10, 17, 6, 21, 1455615707, 1455615801, 28, 1, 1),
(11, 17, 6, 16, 1455615707, 1455615801, 28, 1, 1),
(12, 17, 6, 5, 1455615735, 1455615801, 28, 1, 1),
(13, 17, 6, 7, 1455615735, 1455615801, 28, 1, 1),
(14, 17, 6, 1, 1455615735, 1455615801, 28, 1, 1),
(15, 17, 6, 3, 1455615735, 1455615801, 28, 1, 1),
(16, 17, 6, 2, 1455615735, 1455615801, 28, 1, 1),
(17, 17, 6, 25, 1455615735, 1455615801, 28, 1, 1),
(18, 17, 6, 21, 1455615735, 1455615801, 28, 1, 1),
(19, 17, 6, 16, 1455615735, 1455615801, 28, 1, 1),
(20, 17, 6, 6, 1455728201, 1455728238, 28, 1, 1),
(21, 17, NULL, 7, 1455728201, NULL, 28, NULL, 2),
(22, 17, 6, 1, 1455728201, 1455728238, 28, 1, 1),
(23, 17, 6, 27, 1455728201, 1455728241, 28, 0, 1),
(24, 17, NULL, 3, 1455728201, NULL, 28, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `app_patients`
--

CREATE TABLE `app_patients` (
  `id` int(16) NOT NULL,
  `card_number` varchar(10) NOT NULL,
  `blood_group` varchar(2) NOT NULL,
  `genotype` varchar(2) NOT NULL,
  `personal_info` varchar(17) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_patients`
--

INSERT INTO `app_patients` (`id`, `card_number`, `blood_group`, `genotype`, `personal_info`, `status`) VALUES
(15, '000001', 'O+', 'AA', 'p15', 1),
(18, '000003', 'O-', 'AS', 'p18', 1),
(20, '000002', 'O+', 'AS', 'p20', 1),
(21, '000004', 'AB', 'AA', 'p21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_categories`
--

CREATE TABLE `site_categories` (
  `id` int(16) NOT NULL,
  `guid` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(16) DEFAULT NULL COMMENT 'site_posts_categories.id',
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_comments`
--

CREATE TABLE `site_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent` int(16) UNSIGNED DEFAULT '0',
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` int(16) NOT NULL,
  `comment_time` bigint(32) NOT NULL,
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_locations`
--

CREATE TABLE `site_locations` (
  `id` bigint(16) NOT NULL,
  `parent` bigint(16) DEFAULT NULL,
  `location_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(5,3) DEFAULT NULL,
  `longitude` decimal(5,3) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_locations`
--

INSERT INTO `site_locations` (`id`, `parent`, `location_name`, `slogan`, `location_type`, `latitude`, `longitude`, `status`) VALUES
(1, NULL, 'Kano', NULL, 'state', NULL, NULL, 1),
(2, NULL, 'Lagos', NULL, 'state', NULL, NULL, 1),
(3, NULL, 'Kaduna', NULL, 'state', NULL, NULL, 1),
(4, NULL, 'Katsina', NULL, 'state', NULL, NULL, 1),
(5, NULL, 'Oyo', NULL, 'state', NULL, NULL, 1),
(6, NULL, 'Rivers', NULL, 'state', NULL, NULL, 1),
(7, NULL, 'Bauchi', NULL, 'state', NULL, NULL, 1),
(8, NULL, 'Jigawa', NULL, 'state', NULL, NULL, 1),
(9, NULL, 'Benue', NULL, 'state', NULL, NULL, 1),
(10, NULL, 'Anambra', NULL, 'state', NULL, NULL, 1),
(11, NULL, 'Borno', NULL, 'state', NULL, NULL, 1),
(12, NULL, 'Delta', NULL, 'state', NULL, NULL, 1),
(13, NULL, 'Imo', NULL, 'state', NULL, NULL, 1),
(14, NULL, 'Niger', NULL, 'state', NULL, NULL, 1),
(15, NULL, 'Akwa Ibom', NULL, 'state', NULL, NULL, 1),
(16, NULL, 'Ogun', NULL, 'state', NULL, NULL, 1),
(17, NULL, 'Sokoto', NULL, 'state', NULL, NULL, 1),
(18, NULL, 'Ondo', NULL, 'state', NULL, NULL, 1),
(19, NULL, 'Osun', NULL, 'state', NULL, NULL, 1),
(20, NULL, 'Kogi', NULL, 'state', NULL, NULL, 1),
(21, NULL, 'Zamfara', NULL, 'state', NULL, NULL, 1),
(22, NULL, 'Enugu', NULL, 'state', NULL, NULL, 1),
(23, NULL, 'Kebbi', NULL, 'state', NULL, NULL, 1),
(24, NULL, 'Edo', NULL, 'state', NULL, NULL, 1),
(25, NULL, 'Plateau', NULL, 'state', NULL, NULL, 1),
(26, NULL, 'Adamawa', NULL, 'state', NULL, NULL, 1),
(27, NULL, 'Cross River', NULL, 'state', NULL, NULL, 1),
(28, NULL, 'Abia', NULL, 'state', NULL, NULL, 1),
(29, NULL, 'Ekiti', NULL, 'state', NULL, NULL, 1),
(30, NULL, 'Kwara', NULL, 'state', NULL, NULL, 1),
(31, NULL, 'Gombe', NULL, 'state', NULL, NULL, 1),
(32, NULL, 'Yobe', NULL, 'state', NULL, NULL, 1),
(33, NULL, 'Taraba', NULL, 'state', NULL, NULL, 1),
(34, NULL, 'Ebonyi', NULL, 'state', NULL, NULL, 1),
(35, NULL, 'Nasarawa', NULL, 'state', NULL, NULL, 1),
(36, NULL, 'Bayelsa', NULL, 'state', NULL, NULL, 1),
(37, NULL, 'Abuja (Federal Capital Territory)', NULL, 'state', NULL, NULL, 1),
(38, 11, 'Abadam', NULL, 'lga', NULL, NULL, 1),
(39, 37, 'Abaji', NULL, 'lga', NULL, NULL, 1),
(40, 15, 'Abak', NULL, 'lga', NULL, NULL, 1),
(41, 34, 'Abakaliki', NULL, 'lga', NULL, NULL, 1),
(42, 28, 'Aba North', NULL, 'lga', NULL, NULL, 1),
(43, 28, 'Aba South', NULL, 'lga', NULL, NULL, 1),
(44, 16, 'Abeokuta North', NULL, 'lga', NULL, NULL, 1),
(45, 16, 'Abeokuta South', NULL, 'lga', NULL, NULL, 1),
(46, 27, 'Abi', NULL, 'lga', NULL, NULL, 1),
(47, 13, 'Aboh Mbaise', NULL, 'lga', NULL, NULL, 1),
(48, 6, 'Abua/Odual', NULL, 'lga', NULL, NULL, 1),
(49, 20, 'Adavi', NULL, 'lga', NULL, NULL, 1),
(50, 29, 'Ado Ekiti', NULL, 'lga', NULL, NULL, 1),
(51, 16, 'Ado-Odo/Ota', NULL, 'lga', NULL, NULL, 1),
(52, 5, 'Afijio', NULL, 'lga', NULL, NULL, 1),
(53, 34, 'Afikpo North', NULL, 'lga', NULL, NULL, 1),
(54, 34, 'Afikpo South', NULL, 'lga', NULL, NULL, 1),
(55, 14, 'Agaie', NULL, 'lga', NULL, NULL, 1),
(56, 9, 'Agatu', NULL, 'lga', NULL, NULL, 1),
(57, 14, 'Agwara', NULL, 'lga', NULL, NULL, 1),
(58, 2, 'Agege', NULL, 'lga', NULL, NULL, 1),
(59, 10, 'Aguata', NULL, 'lga', NULL, NULL, 1),
(60, 13, 'Ahiazu Mbaise', NULL, 'lga', NULL, NULL, 1),
(61, 6, 'Ahoada East', NULL, 'lga', NULL, NULL, 1),
(62, 6, 'Ahoada West', NULL, 'lga', NULL, NULL, 1),
(63, 20, 'Ajaokuta', NULL, 'lga', NULL, NULL, 1),
(64, 2, 'Ajeromi-Ifelodun', NULL, 'lga', NULL, NULL, 1),
(65, 1, 'Ajingi', NULL, 'lga', NULL, NULL, 1),
(66, 27, 'Akamkpa', NULL, 'lga', NULL, NULL, 1),
(67, 5, 'Akinyele', NULL, 'lga', NULL, NULL, 1),
(68, 31, 'Akko', NULL, 'lga', NULL, NULL, 1),
(69, 24, 'Akoko-Edo', NULL, 'lga', NULL, NULL, 1),
(70, 18, 'Akoko North-East', NULL, 'lga', NULL, NULL, 1),
(71, 18, 'Akoko North-West', NULL, 'lga', NULL, NULL, 1),
(72, 18, 'Akoko South-West', NULL, 'lga', NULL, NULL, 1),
(73, 18, 'Akoko South-East', NULL, 'lga', NULL, NULL, 1),
(74, 27, 'Akpabuyo', NULL, 'lga', NULL, NULL, 1),
(75, 6, 'Akuku-Toru', NULL, 'lga', NULL, NULL, 1),
(76, 18, 'Akure North', NULL, 'lga', NULL, NULL, 1),
(77, 18, 'Akure South', NULL, 'lga', NULL, NULL, 1),
(78, 35, 'Akwanga', NULL, 'lga', NULL, NULL, 1),
(79, 1, 'Albasu', NULL, 'lga', NULL, NULL, 1),
(80, 23, 'Aleiro', NULL, 'lga', NULL, NULL, 1),
(81, 2, 'Alimosho', NULL, 'lga', NULL, NULL, 1),
(82, 7, 'Alkaleri', NULL, 'lga', NULL, NULL, 1),
(83, 2, 'Amuwo-Odofin', NULL, 'lga', NULL, NULL, 1),
(84, 10, 'Anambra East', NULL, 'lga', NULL, NULL, 1),
(85, 10, 'Anambra West', NULL, 'lga', NULL, NULL, 1),
(86, 10, 'Anaocha', NULL, 'lga', NULL, NULL, 1),
(87, 6, 'Andoni', NULL, 'lga', NULL, NULL, 1),
(88, 22, 'Aninri', NULL, 'lga', NULL, NULL, 1),
(89, 12, 'Aniocha North', NULL, 'lga', NULL, NULL, 1),
(90, 12, 'Aniocha South', NULL, 'lga', NULL, NULL, 1),
(91, 21, 'Anka', NULL, 'lga', NULL, NULL, 1),
(92, 20, 'Ankpa', NULL, 'lga', NULL, NULL, 1),
(93, 9, 'Apa', NULL, 'lga', NULL, NULL, 1),
(94, 2, 'Apapa', NULL, 'lga', NULL, NULL, 1),
(95, 9, 'Ado', NULL, 'lga', NULL, NULL, 1),
(96, 33, 'Ardo Kola', NULL, 'lga', NULL, NULL, 1),
(97, 23, 'Arewa Dandi', NULL, 'lga', NULL, NULL, 1),
(98, 23, 'Argungu', NULL, 'lga', NULL, NULL, 1),
(99, 28, 'Arochukwu', NULL, 'lga', NULL, NULL, 1),
(100, 30, 'Asa', NULL, 'lga', NULL, NULL, 1),
(101, 6, 'Asari-Toru', NULL, 'lga', NULL, NULL, 1),
(102, 11, 'Askira/Uba', NULL, 'lga', NULL, NULL, 1),
(103, 19, 'Atakunmosa East', NULL, 'lga', NULL, NULL, 1),
(104, 19, 'Atakunmosa West', NULL, 'lga', NULL, NULL, 1),
(105, 5, 'Atiba', NULL, 'lga', NULL, NULL, 1),
(106, 5, 'Atisbo', NULL, 'lga', NULL, NULL, 1),
(107, 23, 'Augie', NULL, 'lga', NULL, NULL, 1),
(108, 8, 'Auyo', NULL, 'lga', NULL, NULL, 1),
(109, 35, 'Awe', NULL, 'lga', NULL, NULL, 1),
(110, 22, 'Awgu', NULL, 'lga', NULL, NULL, 1),
(111, 10, 'Awka North', NULL, 'lga', NULL, NULL, 1),
(112, 10, 'Awka South', NULL, 'lga', NULL, NULL, 1),
(113, 10, 'Ayamelum', NULL, 'lga', NULL, NULL, 1),
(114, 19, 'Aiyedaade', NULL, 'lga', NULL, NULL, 1),
(115, 19, 'Aiyedire', NULL, 'lga', NULL, NULL, 1),
(116, 8, 'Babura', NULL, 'lga', NULL, NULL, 1),
(117, 2, 'Badagry', NULL, 'lga', NULL, NULL, 1),
(118, 23, 'Bagudo', NULL, 'lga', NULL, NULL, 1),
(119, 1, 'Bagwai', NULL, 'lga', NULL, NULL, 1),
(120, 27, 'Bakassi', NULL, 'lga', NULL, NULL, 1),
(121, 25, 'Bokkos', NULL, 'lga', NULL, NULL, 1),
(122, 4, 'Bakori', NULL, 'lga', NULL, NULL, 1),
(123, 21, 'Bakura', NULL, 'lga', NULL, NULL, 1),
(124, 31, 'Balanga', NULL, 'lga', NULL, NULL, 1),
(125, 33, 'Bali', NULL, 'lga', NULL, NULL, 1),
(126, 11, 'Bama', NULL, 'lga', NULL, NULL, 1),
(127, 32, 'Bade', NULL, 'lga', NULL, NULL, 1),
(128, 25, 'Barkin Ladi', NULL, 'lga', NULL, NULL, 1),
(129, 30, 'Baruten', NULL, 'lga', NULL, NULL, 1),
(130, 20, 'Bassa', NULL, 'lga', NULL, NULL, 1),
(131, 25, 'Bassa', NULL, 'lga', NULL, NULL, 1),
(132, 4, 'Batagarawa', NULL, 'lga', NULL, NULL, 1),
(133, 4, 'Batsari', NULL, 'lga', NULL, NULL, 1),
(134, 7, 'Bauchi', NULL, 'lga', NULL, NULL, 1),
(135, 4, 'Baure', NULL, 'lga', NULL, NULL, 1),
(136, 11, 'Bayo', NULL, 'lga', NULL, NULL, 1),
(137, 1, 'Bebeji', NULL, 'lga', NULL, NULL, 1),
(138, 27, 'Bekwarra', NULL, 'lga', NULL, NULL, 1),
(139, 28, 'Bende', NULL, 'lga', NULL, NULL, 1),
(140, 27, 'Biase', NULL, 'lga', NULL, NULL, 1),
(141, 1, 'Bichi', NULL, 'lga', NULL, NULL, 1),
(142, 14, 'Bida', NULL, 'lga', NULL, NULL, 1),
(143, 31, 'Billiri', NULL, 'lga', NULL, NULL, 1),
(144, 4, 'Bindawa', NULL, 'lga', NULL, NULL, 1),
(145, 17, 'Binji', NULL, 'lga', NULL, NULL, 1),
(146, 8, 'Biriniwa', NULL, 'lga', NULL, NULL, 1),
(147, 3, 'Birnin Gwari', NULL, 'lga', NULL, NULL, 1),
(148, 23, 'Birnin Kebbi', NULL, 'lga', NULL, NULL, 1),
(149, 8, 'Birnin Kudu', NULL, 'lga', NULL, NULL, 1),
(150, 21, 'Birnin Magaji/Kiyaw', NULL, 'lga', NULL, NULL, 1),
(151, 11, 'Biu', NULL, 'lga', NULL, NULL, 1),
(152, 17, 'Bodinga', NULL, 'lga', NULL, NULL, 1),
(153, 7, 'Bogoro', NULL, 'lga', NULL, NULL, 1),
(154, 27, 'Boki', NULL, 'lga', NULL, NULL, 1),
(155, 19, 'Boluwaduro', NULL, 'lga', NULL, NULL, 1),
(156, 12, 'Bomadi', NULL, 'lga', NULL, NULL, 1),
(157, 6, 'Bonny', NULL, 'lga', NULL, NULL, 1),
(158, 14, 'Borgu', NULL, 'lga', NULL, NULL, 1),
(159, 19, 'Boripe', NULL, 'lga', NULL, NULL, 1),
(160, 32, 'Bursari', NULL, 'lga', NULL, NULL, 1),
(161, 14, 'Bosso', NULL, 'lga', NULL, NULL, 1),
(162, 36, 'Brass', NULL, 'lga', NULL, NULL, 1),
(163, 8, 'Buji', NULL, 'lga', NULL, NULL, 1),
(164, 21, 'Bukkuyum', NULL, 'lga', NULL, NULL, 1),
(165, 9, 'Buruku', NULL, 'lga', NULL, NULL, 1),
(166, 21, 'Bungudu', NULL, 'lga', NULL, NULL, 1),
(167, 1, 'Bunkure', NULL, 'lga', NULL, NULL, 1),
(168, 23, 'Bunza', NULL, 'lga', NULL, NULL, 1),
(169, 12, 'Burutu', NULL, 'lga', NULL, NULL, 1),
(170, 37, 'Bwari', NULL, 'lga', NULL, NULL, 1),
(171, 27, 'Calabar Municipal', NULL, 'lga', NULL, NULL, 1),
(172, 27, 'Calabar South', NULL, 'lga', NULL, NULL, 1),
(173, 14, 'Chanchaga', NULL, 'lga', NULL, NULL, 1),
(174, 4, 'Charanchi', NULL, 'lga', NULL, NULL, 1),
(175, 11, 'Chibok', NULL, 'lga', NULL, NULL, 1),
(176, 3, 'Chikun', NULL, 'lga', NULL, NULL, 1),
(177, 1, 'Dala', NULL, 'lga', NULL, NULL, 1),
(178, 32, 'Damaturu', NULL, 'lga', NULL, NULL, 1),
(179, 7, 'Damban', NULL, 'lga', NULL, NULL, 1),
(180, 1, 'Dambatta', NULL, 'lga', NULL, NULL, 1),
(181, 11, 'Damboa', NULL, 'lga', NULL, NULL, 1),
(182, 23, 'Dandi', NULL, 'lga', NULL, NULL, 1),
(183, 4, 'Dandume', NULL, 'lga', NULL, NULL, 1),
(184, 17, 'Dange Shuni', NULL, 'lga', NULL, NULL, 1),
(185, 4, 'Danja', NULL, 'lga', NULL, NULL, 1),
(186, 4, 'Dan Musa', NULL, 'lga', NULL, NULL, 1),
(187, 7, 'Darazo', NULL, 'lga', NULL, NULL, 1),
(188, 7, 'Dass', NULL, 'lga', NULL, NULL, 1),
(189, 4, 'Daura', NULL, 'lga', NULL, NULL, 1),
(190, 1, 'Dawakin Kudu', NULL, 'lga', NULL, NULL, 1),
(191, 1, 'Dawakin Tofa', NULL, 'lga', NULL, NULL, 1),
(192, 6, 'Degema', NULL, 'lga', NULL, NULL, 1),
(193, 20, 'Dekina', NULL, 'lga', NULL, NULL, 1),
(194, 26, 'Demsa', NULL, 'lga', NULL, NULL, 1),
(195, 11, 'Dikwa', NULL, 'lga', NULL, NULL, 1),
(196, 1, 'Doguwa', NULL, 'lga', NULL, NULL, 1),
(197, 35, 'Doma', NULL, 'lga', NULL, NULL, 1),
(198, 33, 'Donga', NULL, 'lga', NULL, NULL, 1),
(199, 31, 'Dukku', NULL, 'lga', NULL, NULL, 1),
(200, 10, 'Dunukofia', NULL, 'lga', NULL, NULL, 1),
(201, 8, 'Dutse', NULL, 'lga', NULL, NULL, 1),
(202, 4, 'Dutsi', NULL, 'lga', NULL, NULL, 1),
(203, 4, 'Dutsin Ma', NULL, 'lga', NULL, NULL, 1),
(204, 15, 'Eastern Obolo', NULL, 'lga', NULL, NULL, 1),
(205, 34, 'Ebonyi', NULL, 'lga', NULL, NULL, 1),
(206, 14, 'Edati', NULL, 'lga', NULL, NULL, 1),
(207, 19, 'Ede North', NULL, 'lga', NULL, NULL, 1),
(208, 19, 'Ede South', NULL, 'lga', NULL, NULL, 1),
(209, 30, 'Edu', NULL, 'lga', NULL, NULL, 1),
(210, 19, 'Ife Central', NULL, 'lga', NULL, NULL, 1),
(211, 19, 'Ife East', NULL, 'lga', NULL, NULL, 1),
(212, 19, 'Ife North', NULL, 'lga', NULL, NULL, 1),
(213, 19, 'Ife South', NULL, 'lga', NULL, NULL, 1),
(214, 29, 'Efon', NULL, 'lga', NULL, NULL, 1),
(215, 16, 'Egbado North', NULL, 'lga', NULL, NULL, 1),
(216, 16, 'Egbado South', NULL, 'lga', NULL, NULL, 1),
(217, 5, 'Egbeda', NULL, 'lga', NULL, NULL, 1),
(218, 19, 'Egbedore', NULL, 'lga', NULL, NULL, 1),
(219, 24, 'Egor', NULL, 'lga', NULL, NULL, 1),
(220, 13, 'Ehime Mbano', NULL, 'lga', NULL, NULL, 1),
(221, 19, 'Ejigbo', NULL, 'lga', NULL, NULL, 1),
(222, 36, 'Ekeremor', NULL, 'lga', NULL, NULL, 1),
(223, 15, 'Eket', NULL, 'lga', NULL, NULL, 1),
(224, 30, 'Ekiti', NULL, 'lga', NULL, NULL, 1),
(225, 29, 'Ekiti East', NULL, 'lga', NULL, NULL, 1),
(226, 29, 'Ekiti South-West', NULL, 'lga', NULL, NULL, 1),
(227, 29, 'Ekiti West', NULL, 'lga', NULL, NULL, 1),
(228, 10, 'Ekwusigo', NULL, 'lga', NULL, NULL, 1),
(229, 6, 'Eleme', NULL, 'lga', NULL, NULL, 1),
(230, 6, 'Emuoha', NULL, 'lga', NULL, NULL, 1),
(231, 29, 'Emure', NULL, 'lga', NULL, NULL, 1),
(232, 22, 'Enugu East', NULL, 'lga', NULL, NULL, 1),
(233, 22, 'Enugu North', NULL, 'lga', NULL, NULL, 1),
(234, 22, 'Enugu South', NULL, 'lga', NULL, NULL, 1),
(235, 2, 'Epe', NULL, 'lga', NULL, NULL, 1),
(236, 24, 'Esan Central', NULL, 'lga', NULL, NULL, 1),
(237, 24, 'Esan North-East', NULL, 'lga', NULL, NULL, 1),
(238, 24, 'Esan South-East', NULL, 'lga', NULL, NULL, 1),
(239, 24, 'Esan West', NULL, 'lga', NULL, NULL, 1),
(240, 18, 'Ese Odo', NULL, 'lga', NULL, NULL, 1),
(241, 15, 'Esit Eket', NULL, 'lga', NULL, NULL, 1),
(242, 15, 'Essien Udim', NULL, 'lga', NULL, NULL, 1),
(243, 6, 'Etche', NULL, 'lga', NULL, NULL, 1),
(244, 12, 'Ethiope East', NULL, 'lga', NULL, NULL, 1),
(245, 12, 'Ethiope West', NULL, 'lga', NULL, NULL, 1),
(246, 15, 'Etim Ekpo', NULL, 'lga', NULL, NULL, 1),
(247, 15, 'Etinan', NULL, 'lga', NULL, NULL, 1),
(248, 2, 'Eti Osa', NULL, 'lga', NULL, NULL, 1),
(249, 24, 'Etsako Central', NULL, 'lga', NULL, NULL, 1),
(250, 24, 'Etsako East', NULL, 'lga', NULL, NULL, 1),
(251, 24, 'Etsako West', NULL, 'lga', NULL, NULL, 1),
(252, 27, 'Etung', NULL, 'lga', NULL, NULL, 1),
(253, 16, 'Ewekoro', NULL, 'lga', NULL, NULL, 1),
(254, 22, 'Ezeagu', NULL, 'lga', NULL, NULL, 1),
(255, 13, 'Ezinihitte', NULL, 'lga', NULL, NULL, 1),
(256, 34, 'Ezza North', NULL, 'lga', NULL, NULL, 1),
(257, 34, 'Ezza South', NULL, 'lga', NULL, NULL, 1),
(258, 1, 'Fagge', NULL, 'lga', NULL, NULL, 1),
(259, 23, 'Fakai', NULL, 'lga', NULL, NULL, 1),
(260, 4, 'Faskari', NULL, 'lga', NULL, NULL, 1),
(261, 32, 'Fika', NULL, 'lga', NULL, NULL, 1),
(262, 26, 'Fufure', NULL, 'lga', NULL, NULL, 1),
(263, 31, 'Funakaye', NULL, 'lga', NULL, NULL, 1),
(264, 32, 'Fune', NULL, 'lga', NULL, NULL, 1),
(265, 4, 'Funtua', NULL, 'lga', NULL, NULL, 1),
(266, 1, 'Gabasawa', NULL, 'lga', NULL, NULL, 1),
(267, 17, 'Gada', NULL, 'lga', NULL, NULL, 1),
(268, 8, 'Gagarawa', NULL, 'lga', NULL, NULL, 1),
(269, 7, 'Gamawa', NULL, 'lga', NULL, NULL, 1),
(270, 7, 'Ganjuwa', NULL, 'lga', NULL, NULL, 1),
(271, 26, 'Ganye', NULL, 'lga', NULL, NULL, 1),
(272, 8, 'Garki', NULL, 'lga', NULL, NULL, 1),
(273, 1, 'Garko', NULL, 'lga', NULL, NULL, 1),
(274, 1, 'Garun Mallam', NULL, 'lga', NULL, NULL, 1),
(275, 33, 'Gashaka', NULL, 'lga', NULL, NULL, 1),
(276, 33, 'Gassol', NULL, 'lga', NULL, NULL, 1),
(277, 1, 'Gaya', NULL, 'lga', NULL, NULL, 1),
(278, 26, 'Gayuk', NULL, 'lga', NULL, NULL, 1),
(279, 1, 'Gezawa', NULL, 'lga', NULL, NULL, 1),
(280, 14, 'Gbako', NULL, 'lga', NULL, NULL, 1),
(281, 9, 'Gboko', NULL, 'lga', NULL, NULL, 1),
(282, 29, 'Gbonyin', NULL, 'lga', NULL, NULL, 1),
(283, 32, 'Geidam', NULL, 'lga', NULL, NULL, 1),
(284, 7, 'Giade', NULL, 'lga', NULL, NULL, 1),
(285, 3, 'Giwa', NULL, 'lga', NULL, NULL, 1),
(286, 6, 'Gokana', NULL, 'lga', NULL, NULL, 1),
(287, 31, 'Gombe', NULL, 'lga', NULL, NULL, 1),
(288, 26, 'Gombi', NULL, 'lga', NULL, NULL, 1),
(289, 17, 'Goronyo', NULL, 'lga', NULL, NULL, 1),
(290, 26, 'Grie', NULL, 'lga', NULL, NULL, 1),
(291, 11, 'Gubio', NULL, 'lga', NULL, NULL, 1),
(292, 17, 'Gudu', NULL, 'lga', NULL, NULL, 1),
(293, 32, 'Gujba', NULL, 'lga', NULL, NULL, 1),
(294, 32, 'Gulani', NULL, 'lga', NULL, NULL, 1),
(295, 9, 'Guma', NULL, 'lga', NULL, NULL, 1),
(296, 8, 'Gumel', NULL, 'lga', NULL, NULL, 1),
(297, 21, 'Gummi', NULL, 'lga', NULL, NULL, 1),
(298, 14, 'Gurara', NULL, 'lga', NULL, NULL, 1),
(299, 8, 'Guri', NULL, 'lga', NULL, NULL, 1),
(300, 21, 'Gusau', NULL, 'lga', NULL, NULL, 1),
(301, 11, 'Guzamala', NULL, 'lga', NULL, NULL, 1),
(302, 17, 'Gwadabawa', NULL, 'lga', NULL, NULL, 1),
(303, 37, 'Gwagwalada', NULL, 'lga', NULL, NULL, 1),
(304, 1, 'Gwale', NULL, 'lga', NULL, NULL, 1),
(305, 23, 'Gwandu', NULL, 'lga', NULL, NULL, 1),
(306, 8, 'Gwaram', NULL, 'lga', NULL, NULL, 1),
(307, 1, 'Gwarzo', NULL, 'lga', NULL, NULL, 1),
(308, 9, 'Gwer East', NULL, 'lga', NULL, NULL, 1),
(309, 9, 'Gwer West', NULL, 'lga', NULL, NULL, 1),
(310, 8, 'Gwiwa', NULL, 'lga', NULL, NULL, 1),
(311, 11, 'Gwoza', NULL, 'lga', NULL, NULL, 1),
(312, 8, 'Hadejia', NULL, 'lga', NULL, NULL, 1),
(313, 11, 'Hawul', NULL, 'lga', NULL, NULL, 1),
(314, 26, 'Hong', NULL, 'lga', NULL, NULL, 1),
(315, 5, 'Ibadan North', NULL, 'lga', NULL, NULL, 1),
(316, 5, 'Ibadan North-East', NULL, 'lga', NULL, NULL, 1),
(317, 5, 'Ibadan North-West', NULL, 'lga', NULL, NULL, 1),
(318, 5, 'Ibadan South-East', NULL, 'lga', NULL, NULL, 1),
(319, 5, 'Ibadan South-West', NULL, 'lga', NULL, NULL, 1),
(320, 20, 'Ibaji', NULL, 'lga', NULL, NULL, 1),
(321, 5, 'Ibarapa Central', NULL, 'lga', NULL, NULL, 1),
(322, 5, 'Ibarapa East', NULL, 'lga', NULL, NULL, 1),
(323, 5, 'Ibarapa North', NULL, 'lga', NULL, NULL, 1),
(324, 2, 'Ibeju-Lekki', NULL, 'lga', NULL, NULL, 1),
(325, 15, 'Ibeno', NULL, 'lga', NULL, NULL, 1),
(326, 15, 'Ibesikpo Asutan', NULL, 'lga', NULL, NULL, 1),
(327, 33, 'Ibi', NULL, 'lga', NULL, NULL, 1),
(328, 15, 'Ibiono-Ibom', NULL, 'lga', NULL, NULL, 1),
(329, 20, 'Idah', NULL, 'lga', NULL, NULL, 1),
(330, 18, 'Idanre', NULL, 'lga', NULL, NULL, 1),
(331, 13, 'Ideato North', NULL, 'lga', NULL, NULL, 1),
(332, 13, 'Ideato South', NULL, 'lga', NULL, NULL, 1),
(333, 10, 'Idemili North', NULL, 'lga', NULL, NULL, 1),
(334, 10, 'Idemili South', NULL, 'lga', NULL, NULL, 1),
(335, 5, 'Ido', NULL, 'lga', NULL, NULL, 1),
(336, 29, 'Ido Osi', NULL, 'lga', NULL, NULL, 1),
(337, 2, 'Ifako-Ijaiye', NULL, 'lga', NULL, NULL, 1),
(338, 19, 'Ifedayo', NULL, 'lga', NULL, NULL, 1),
(339, 18, 'Ifedore', NULL, 'lga', NULL, NULL, 1),
(340, 30, 'Ifelodun', NULL, 'lga', NULL, NULL, 1),
(341, 19, 'Ifelodun', NULL, 'lga', NULL, NULL, 1),
(342, 16, 'Ifo', NULL, 'lga', NULL, NULL, 1),
(343, 3, 'Igabi', NULL, 'lga', NULL, NULL, 1),
(344, 20, 'Igalamela Odolu', NULL, 'lga', NULL, NULL, 1),
(345, 22, 'Igbo Etiti', NULL, 'lga', NULL, NULL, 1),
(346, 22, 'Igbo Eze North', NULL, 'lga', NULL, NULL, 1),
(347, 22, 'Igbo Eze South', NULL, 'lga', NULL, NULL, 1),
(348, 24, 'Igueben', NULL, 'lga', NULL, NULL, 1),
(349, 10, 'Ihiala', NULL, 'lga', NULL, NULL, 1),
(350, 13, 'Ihitte/Uboma', NULL, 'lga', NULL, NULL, 1),
(351, 18, 'Ilaje', NULL, 'lga', NULL, NULL, 1),
(352, 16, 'Ijebu East', NULL, 'lga', NULL, NULL, 1),
(353, 16, 'Ijebu North', NULL, 'lga', NULL, NULL, 1),
(354, 16, 'Ijebu North East', NULL, 'lga', NULL, NULL, 1),
(355, 16, 'Ijebu Ode', NULL, 'lga', NULL, NULL, 1),
(356, 29, 'Ijero', NULL, 'lga', NULL, NULL, 1),
(357, 20, 'Ijumu', NULL, 'lga', NULL, NULL, 1),
(358, 15, 'Ika', NULL, 'lga', NULL, NULL, 1),
(359, 12, 'Ika North East', NULL, 'lga', NULL, NULL, 1),
(360, 3, 'Ikara', NULL, 'lga', NULL, NULL, 1),
(361, 12, 'Ika South', NULL, 'lga', NULL, NULL, 1),
(362, 13, 'Ikeduru', NULL, 'lga', NULL, NULL, 1),
(363, 2, 'Ikeja', NULL, 'lga', NULL, NULL, 1),
(364, 16, 'Ikenne', NULL, 'lga', NULL, NULL, 1),
(365, 29, 'Ikere', NULL, 'lga', NULL, NULL, 1),
(366, 29, 'Ikole', NULL, 'lga', NULL, NULL, 1),
(367, 27, 'Ikom', NULL, 'lga', NULL, NULL, 1),
(368, 15, 'Ikono', NULL, 'lga', NULL, NULL, 1),
(369, 2, 'Ikorodu', NULL, 'lga', NULL, NULL, 1),
(370, 15, 'Ikot Abasi', NULL, 'lga', NULL, NULL, 1),
(371, 15, 'Ikot Ekpene', NULL, 'lga', NULL, NULL, 1),
(372, 24, 'Ikpoba Okha', NULL, 'lga', NULL, NULL, 1),
(373, 6, 'Ikwerre', NULL, 'lga', NULL, NULL, 1),
(374, 34, 'Ikwo', NULL, 'lga', NULL, NULL, 1),
(375, 28, 'Ikwuano', NULL, 'lga', NULL, NULL, 1),
(376, 19, 'Ila', NULL, 'lga', NULL, NULL, 1),
(377, 29, 'Ilejemeje', NULL, 'lga', NULL, NULL, 1),
(378, 18, 'Ile Oluji/Okeigbo', NULL, 'lga', NULL, NULL, 1),
(379, 19, 'Ilesa East', NULL, 'lga', NULL, NULL, 1),
(380, 19, 'Ilesa West', NULL, 'lga', NULL, NULL, 1),
(381, 17, 'Illela', NULL, 'lga', NULL, NULL, 1),
(382, 30, 'Ilorin East', NULL, 'lga', NULL, NULL, 1),
(383, 30, 'Ilorin South', NULL, 'lga', NULL, NULL, 1),
(384, 30, 'Ilorin West', NULL, 'lga', NULL, NULL, 1),
(385, 16, 'Imeko Afon', NULL, 'lga', NULL, NULL, 1),
(386, 4, 'Ingawa', NULL, 'lga', NULL, NULL, 1),
(387, 15, 'Ini', NULL, 'lga', NULL, NULL, 1),
(388, 16, 'Ipokia', NULL, 'lga', NULL, NULL, 1),
(389, 18, 'Irele', NULL, 'lga', NULL, NULL, 1),
(390, 5, 'Irepo', NULL, 'lga', NULL, NULL, 1),
(391, 30, 'Irepodun', NULL, 'lga', NULL, NULL, 1),
(392, 19, 'Irepodun', NULL, 'lga', NULL, NULL, 1),
(393, 29, 'Irepodun/Ifelodun', NULL, 'lga', NULL, NULL, 1),
(394, 19, 'Irewole', NULL, 'lga', NULL, NULL, 1),
(395, 17, 'Isa', NULL, 'lga', NULL, NULL, 1),
(396, 29, 'Ise/Orun', NULL, 'lga', NULL, NULL, 1),
(397, 5, 'Iseyin', NULL, 'lga', NULL, NULL, 1),
(398, 34, 'Ishielu', NULL, 'lga', NULL, NULL, 1),
(399, 13, 'Isiala Mbano', NULL, 'lga', NULL, NULL, 1),
(400, 28, 'Isiala Ngwa North', NULL, 'lga', NULL, NULL, 1),
(401, 28, 'Isiala Ngwa South', NULL, 'lga', NULL, NULL, 1),
(402, 30, 'Isin', NULL, 'lga', NULL, NULL, 1),
(403, 22, 'Isi Uzo', NULL, 'lga', NULL, NULL, 1),
(404, 19, 'Isokan', NULL, 'lga', NULL, NULL, 1),
(405, 12, 'Isoko North', NULL, 'lga', NULL, NULL, 1),
(406, 12, 'Isoko South', NULL, 'lga', NULL, NULL, 1),
(407, 13, 'Isu', NULL, 'lga', NULL, NULL, 1),
(408, 28, 'Isuikwuato', NULL, 'lga', NULL, NULL, 1),
(409, 7, 'Itas/Gadau', NULL, 'lga', NULL, NULL, 1),
(410, 5, 'Itesiwaju', NULL, 'lga', NULL, NULL, 1),
(411, 15, 'Itu', NULL, 'lga', NULL, NULL, 1),
(412, 34, 'Ivo', NULL, 'lga', NULL, NULL, 1),
(413, 5, 'Iwajowa', NULL, 'lga', NULL, NULL, 1),
(414, 19, 'Iwo', NULL, 'lga', NULL, NULL, 1),
(415, 34, 'Izzi', NULL, 'lga', NULL, NULL, 1),
(416, 3, 'Jaba', NULL, 'lga', NULL, NULL, 1),
(417, 26, 'Jada', NULL, 'lga', NULL, NULL, 1),
(418, 8, 'Jahun', NULL, 'lga', NULL, NULL, 1),
(419, 32, 'Jakusko', NULL, 'lga', NULL, NULL, 1),
(420, 33, 'Jalingo', NULL, 'lga', NULL, NULL, 1),
(421, 7, 'Jama''are', NULL, 'lga', NULL, NULL, 1),
(422, 23, 'Jega', NULL, 'lga', NULL, NULL, 1),
(423, 3, 'Jema''a', NULL, 'lga', NULL, NULL, 1),
(424, 11, 'Jere', NULL, 'lga', NULL, NULL, 1),
(425, 4, 'Jibia', NULL, 'lga', NULL, NULL, 1),
(426, 25, 'Jos East', NULL, 'lga', NULL, NULL, 1),
(427, 25, 'Jos North', NULL, 'lga', NULL, NULL, 1),
(428, 25, 'Jos South', NULL, 'lga', NULL, NULL, 1),
(429, 20, 'Kabba/Bunu', NULL, 'lga', NULL, NULL, 1),
(430, 1, 'Kabo', NULL, 'lga', NULL, NULL, 1),
(431, 3, 'Kachia', NULL, 'lga', NULL, NULL, 1),
(432, 3, 'Kaduna North', NULL, 'lga', NULL, NULL, 1),
(433, 3, 'Kaduna South', NULL, 'lga', NULL, NULL, 1),
(434, 8, 'Kafin Hausa', NULL, 'lga', NULL, NULL, 1),
(435, 4, 'Kafur', NULL, 'lga', NULL, NULL, 1),
(436, 11, 'Kaga', NULL, 'lga', NULL, NULL, 1),
(437, 3, 'Kagarko', NULL, 'lga', NULL, NULL, 1),
(438, 30, 'Kaiama', NULL, 'lga', NULL, NULL, 1),
(439, 4, 'Kaita', NULL, 'lga', NULL, NULL, 1),
(440, 5, 'Kajola', NULL, 'lga', NULL, NULL, 1),
(441, 3, 'Kajuru', NULL, 'lga', NULL, NULL, 1),
(442, 11, 'Kala/Balge', NULL, 'lga', NULL, NULL, 1),
(443, 23, 'Kalgo', NULL, 'lga', NULL, NULL, 1),
(444, 31, 'Kaltungo', NULL, 'lga', NULL, NULL, 1),
(445, 25, 'Kanam', NULL, 'lga', NULL, NULL, 1),
(446, 4, 'Kankara', NULL, 'lga', NULL, NULL, 1),
(447, 25, 'Kanke', NULL, 'lga', NULL, NULL, 1),
(448, 4, 'Kankia', NULL, 'lga', NULL, NULL, 1),
(449, 1, 'Kano Municipal', NULL, 'lga', NULL, NULL, 1),
(450, 32, 'Karasuwa', NULL, 'lga', NULL, NULL, 1),
(451, 1, 'Karaye', NULL, 'lga', NULL, NULL, 1),
(452, 33, 'Karim Lamido', NULL, 'lga', NULL, NULL, 1),
(453, 35, 'Karu', NULL, 'lga', NULL, NULL, 1),
(454, 7, 'Katagum', NULL, 'lga', NULL, NULL, 1),
(455, 14, 'Katcha', NULL, 'lga', NULL, NULL, 1),
(456, 4, 'Katsina', NULL, 'lga', NULL, NULL, 1),
(457, 9, 'Katsina-Ala', NULL, 'lga', NULL, NULL, 1),
(458, 3, 'Kaura', NULL, 'lga', NULL, NULL, 1),
(459, 21, 'Kaura Namoda', NULL, 'lga', NULL, NULL, 1),
(460, 3, 'Kauru', NULL, 'lga', NULL, NULL, 1),
(461, 8, 'Kazaure', NULL, 'lga', NULL, NULL, 1),
(462, 35, 'Keana', NULL, 'lga', NULL, NULL, 1),
(463, 17, 'Kebbe', NULL, 'lga', NULL, NULL, 1),
(464, 35, 'Keffi', NULL, 'lga', NULL, NULL, 1),
(465, 6, 'Khana', NULL, 'lga', NULL, NULL, 1),
(466, 1, 'Kibiya', NULL, 'lga', NULL, NULL, 1),
(467, 7, 'Kirfi', NULL, 'lga', NULL, NULL, 1),
(468, 8, 'Kiri Kasama', NULL, 'lga', NULL, NULL, 1),
(469, 1, 'Kiru', NULL, 'lga', NULL, NULL, 1),
(470, 8, 'Kiyawa', NULL, 'lga', NULL, NULL, 1),
(471, 20, 'Kogi', NULL, 'lga', NULL, NULL, 1),
(472, 23, 'Koko/Besse', NULL, 'lga', NULL, NULL, 1),
(473, 35, 'Kokona', NULL, 'lga', NULL, NULL, 1),
(474, 36, 'Kolokuma/Opokuma', NULL, 'lga', NULL, NULL, 1),
(475, 11, 'Konduga', NULL, 'lga', NULL, NULL, 1),
(476, 9, 'Konshisha', NULL, 'lga', NULL, NULL, 1),
(477, 14, 'Kontagora', NULL, 'lga', NULL, NULL, 1),
(478, 2, 'Kosofe', NULL, 'lga', NULL, NULL, 1),
(479, 8, 'Kaugama', NULL, 'lga', NULL, NULL, 1),
(480, 3, 'Kubau', NULL, 'lga', NULL, NULL, 1),
(481, 3, 'Kudan', NULL, 'lga', NULL, NULL, 1),
(482, 37, 'Kuje', NULL, 'lga', NULL, NULL, 1),
(483, 11, 'Kukawa', NULL, 'lga', NULL, NULL, 1),
(484, 1, 'Kumbotso', NULL, 'lga', NULL, NULL, 1),
(485, 33, 'Kumi', NULL, 'lga', NULL, NULL, 1),
(486, 1, 'Kunchi', NULL, 'lga', NULL, NULL, 1),
(487, 1, 'Kura', NULL, 'lga', NULL, NULL, 1),
(488, 4, 'Kurfi', NULL, 'lga', NULL, NULL, 1),
(489, 4, 'Kusada', NULL, 'lga', NULL, NULL, 1),
(490, 37, 'Kwali', NULL, 'lga', NULL, NULL, 1),
(491, 9, 'Kwande', NULL, 'lga', NULL, NULL, 1),
(492, 31, 'Kwami', NULL, 'lga', NULL, NULL, 1),
(493, 17, 'Kware', NULL, 'lga', NULL, NULL, 1),
(494, 11, 'Kwaya Kusar', NULL, 'lga', NULL, NULL, 1),
(495, 35, 'Lafia', NULL, 'lga', NULL, NULL, 1),
(496, 5, 'Lagelu', NULL, 'lga', NULL, NULL, 1),
(497, 2, 'Lagos Island', NULL, 'lga', NULL, NULL, 1),
(498, 2, 'Lagos Mainland', NULL, 'lga', NULL, NULL, 1),
(499, 25, 'Langtang South', NULL, 'lga', NULL, NULL, 1),
(500, 25, 'Langtang North', NULL, 'lga', NULL, NULL, 1),
(501, 14, 'Lapai', NULL, 'lga', NULL, NULL, 1),
(502, 26, 'Lamurde', NULL, 'lga', NULL, NULL, 1),
(503, 33, 'Lau', NULL, 'lga', NULL, NULL, 1),
(504, 14, 'Lavun', NULL, 'lga', NULL, NULL, 1),
(505, 3, 'Lere', NULL, 'lga', NULL, NULL, 1),
(506, 9, 'Logo', NULL, 'lga', NULL, NULL, 1),
(507, 20, 'Lokoja', NULL, 'lga', NULL, NULL, 1),
(508, 32, 'Machina', NULL, 'lga', NULL, NULL, 1),
(509, 26, 'Madagali', NULL, 'lga', NULL, NULL, 1),
(510, 1, 'Madobi', NULL, 'lga', NULL, NULL, 1),
(511, 11, 'Mafa', NULL, 'lga', NULL, NULL, 1),
(512, 14, 'Magama', NULL, 'lga', NULL, NULL, 1),
(513, 11, 'Magumeri', NULL, 'lga', NULL, NULL, 1),
(514, 4, 'Mai''Adua', NULL, 'lga', NULL, NULL, 1),
(515, 11, 'Maiduguri', NULL, 'lga', NULL, NULL, 1),
(516, 8, 'Maigatari', NULL, 'lga', NULL, NULL, 1),
(517, 26, 'Maiha', NULL, 'lga', NULL, NULL, 1),
(518, 23, 'Maiyama', NULL, 'lga', NULL, NULL, 1),
(519, 3, 'Makarfi', NULL, 'lga', NULL, NULL, 1),
(520, 1, 'Makoda', NULL, 'lga', NULL, NULL, 1),
(521, 8, 'Malam Madori', NULL, 'lga', NULL, NULL, 1),
(522, 4, 'Malumfashi', NULL, 'lga', NULL, NULL, 1),
(523, 25, 'Mangu', NULL, 'lga', NULL, NULL, 1),
(524, 4, 'Mani', NULL, 'lga', NULL, NULL, 1),
(525, 21, 'Maradun', NULL, 'lga', NULL, NULL, 1),
(526, 14, 'Mariga', NULL, 'lga', NULL, NULL, 1),
(527, 9, 'Makurdi', NULL, 'lga', NULL, NULL, 1),
(528, 11, 'Marte', NULL, 'lga', NULL, NULL, 1),
(529, 21, 'Maru', NULL, 'lga', NULL, NULL, 1),
(530, 14, 'Mashegu', NULL, 'lga', NULL, NULL, 1),
(531, 4, 'Mashi', NULL, 'lga', NULL, NULL, 1),
(532, 4, 'Matazu', NULL, 'lga', NULL, NULL, 1),
(533, 26, 'Mayo Belwa', NULL, 'lga', NULL, NULL, 1),
(534, 13, 'Mbaitoli', NULL, 'lga', NULL, NULL, 1),
(535, 15, 'Mbo', NULL, 'lga', NULL, NULL, 1),
(536, 26, 'Michika', NULL, 'lga', NULL, NULL, 1),
(537, 8, 'Miga', NULL, 'lga', NULL, NULL, 1),
(538, 25, 'Mikang', NULL, 'lga', NULL, NULL, 1),
(539, 1, 'Minjibir', NULL, 'lga', NULL, NULL, 1),
(540, 7, 'Misau', NULL, 'lga', NULL, NULL, 1),
(541, 29, 'Moba', NULL, 'lga', NULL, NULL, 1),
(542, 11, 'Mobbar', NULL, 'lga', NULL, NULL, 1),
(543, 26, 'Mubi North', NULL, 'lga', NULL, NULL, 1),
(544, 26, 'Mubi South', NULL, 'lga', NULL, NULL, 1),
(545, 14, 'Mokwa', NULL, 'lga', NULL, NULL, 1),
(546, 11, 'Monguno', NULL, 'lga', NULL, NULL, 1),
(547, 20, 'Mopa Muro', NULL, 'lga', NULL, NULL, 1),
(548, 30, 'Moro', NULL, 'lga', NULL, NULL, 1),
(549, 14, 'Moya', NULL, 'lga', NULL, NULL, 1),
(550, 15, 'Mkpat-Enin', NULL, 'lga', NULL, NULL, 1),
(551, 37, 'Municipal Area Council', NULL, 'lga', NULL, NULL, 1),
(552, 4, 'Musawa', NULL, 'lga', NULL, NULL, 1),
(553, 2, 'Mushin', NULL, 'lga', NULL, NULL, 1),
(554, 31, 'Nafada', NULL, 'lga', NULL, NULL, 1),
(555, 32, 'Nangere', NULL, 'lga', NULL, NULL, 1),
(556, 1, 'Nasarawa', NULL, 'lga', NULL, NULL, 1),
(557, 35, 'Nasarawa', NULL, 'lga', NULL, NULL, 1),
(558, 35, 'Nasarawa Egon', NULL, 'lga', NULL, NULL, 1),
(559, 12, 'Ndokwa East', NULL, 'lga', NULL, NULL, 1),
(560, 12, 'Ndokwa West', NULL, 'lga', NULL, NULL, 1),
(561, 36, 'Nembe', NULL, 'lga', NULL, NULL, 1),
(562, 11, 'Ngala', NULL, 'lga', NULL, NULL, 1),
(563, 11, 'Nganzai', NULL, 'lga', NULL, NULL, 1),
(564, 23, 'Ngaski', NULL, 'lga', NULL, NULL, 1),
(565, 13, 'Ngor Okpala', NULL, 'lga', NULL, NULL, 1),
(566, 32, 'Nguru', NULL, 'lga', NULL, NULL, 1),
(567, 7, 'Ningi', NULL, 'lga', NULL, NULL, 1),
(568, 13, 'Njaba', NULL, 'lga', NULL, NULL, 1),
(569, 10, 'Njikoka', NULL, 'lga', NULL, NULL, 1),
(570, 22, 'Nkanu East', NULL, 'lga', NULL, NULL, 1),
(571, 22, 'Nkanu West', NULL, 'lga', NULL, NULL, 1),
(572, 13, 'Nkwerre', NULL, 'lga', NULL, NULL, 1),
(573, 10, 'Nnewi North', NULL, 'lga', NULL, NULL, 1),
(574, 10, 'Nnewi South', NULL, 'lga', NULL, NULL, 1),
(575, 15, 'Nsit-Atai', NULL, 'lga', NULL, NULL, 1),
(576, 15, 'Nsit-Ibom', NULL, 'lga', NULL, NULL, 1),
(577, 15, 'Nsit-Ubium', NULL, 'lga', NULL, NULL, 1),
(578, 22, 'Nsukka', NULL, 'lga', NULL, NULL, 1),
(579, 26, 'Numan', NULL, 'lga', NULL, NULL, 1),
(580, 13, 'Nwangele', NULL, 'lga', NULL, NULL, 1),
(581, 16, 'Obafemi Owode', NULL, 'lga', NULL, NULL, 1),
(582, 27, 'Obanliku', NULL, 'lga', NULL, NULL, 1),
(583, 9, 'Obi', NULL, 'lga', NULL, NULL, 1),
(584, 35, 'Obi', NULL, 'lga', NULL, NULL, 1),
(585, 28, 'Obi Ngwa', NULL, 'lga', NULL, NULL, 1),
(586, 6, 'Obio/Akpor', NULL, 'lga', NULL, NULL, 1),
(587, 19, 'Obokun', NULL, 'lga', NULL, NULL, 1),
(588, 15, 'Obot Akara', NULL, 'lga', NULL, NULL, 1),
(589, 13, 'Obowo', NULL, 'lga', NULL, NULL, 1),
(590, 27, 'Obubra', NULL, 'lga', NULL, NULL, 1),
(591, 27, 'Obudu', NULL, 'lga', NULL, NULL, 1),
(592, 16, 'Odeda', NULL, 'lga', NULL, NULL, 1),
(593, 18, 'Odigbo', NULL, 'lga', NULL, NULL, 1),
(594, 16, 'Odogbolu', NULL, 'lga', NULL, NULL, 1),
(595, 19, 'Odo Otin', NULL, 'lga', NULL, NULL, 1),
(596, 27, 'Odukpani', NULL, 'lga', NULL, NULL, 1),
(597, 30, 'Offa', NULL, 'lga', NULL, NULL, 1),
(598, 20, 'Ofu', NULL, 'lga', NULL, NULL, 1),
(599, 6, 'Ogba/Egbema/Ndoni', NULL, 'lga', NULL, NULL, 1),
(600, 9, 'Ogbadibo', NULL, 'lga', NULL, NULL, 1),
(601, 10, 'Ogbaru', NULL, 'lga', NULL, NULL, 1),
(602, 36, 'Ogbia', NULL, 'lga', NULL, NULL, 1),
(603, 5, 'Ogbomosho North', NULL, 'lga', NULL, NULL, 1),
(604, 5, 'Ogbomosho South', NULL, 'lga', NULL, NULL, 1),
(605, 6, 'Ogu/Bolo', NULL, 'lga', NULL, NULL, 1),
(606, 27, 'Ogoja', NULL, 'lga', NULL, NULL, 1),
(607, 5, 'Ogo Oluwa', NULL, 'lga', NULL, NULL, 1),
(608, 20, 'Ogori/Magongo', NULL, 'lga', NULL, NULL, 1),
(609, 16, 'Ogun Waterside', NULL, 'lga', NULL, NULL, 1),
(610, 13, 'Oguta', NULL, 'lga', NULL, NULL, 1),
(611, 28, 'Ohafia', NULL, 'lga', NULL, NULL, 1),
(612, 13, 'Ohaji/Egbema', NULL, 'lga', NULL, NULL, 1),
(613, 34, 'Ohaozara', NULL, 'lga', NULL, NULL, 1),
(614, 34, 'Ohaukwu', NULL, 'lga', NULL, NULL, 1),
(615, 9, 'Ohimini', NULL, 'lga', NULL, NULL, 1),
(616, 24, 'Orhionmwon', NULL, 'lga', NULL, NULL, 1),
(617, 22, 'Oji River', NULL, 'lga', NULL, NULL, 1),
(618, 2, 'Ojo', NULL, 'lga', NULL, NULL, 1),
(619, 9, 'Oju', NULL, 'lga', NULL, NULL, 1),
(620, 20, 'Okehi', NULL, 'lga', NULL, NULL, 1),
(621, 20, 'Okene', NULL, 'lga', NULL, NULL, 1),
(622, 30, 'Oke Ero', NULL, 'lga', NULL, NULL, 1),
(623, 13, 'Okigwe', NULL, 'lga', NULL, NULL, 1),
(624, 18, 'Okitipupa', NULL, 'lga', NULL, NULL, 1),
(625, 15, 'Okobo', NULL, 'lga', NULL, NULL, 1),
(626, 12, 'Okpe', NULL, 'lga', NULL, NULL, 1),
(627, 6, 'Okrika', NULL, 'lga', NULL, NULL, 1),
(628, 20, 'Olamaboro', NULL, 'lga', NULL, NULL, 1),
(629, 19, 'Ola Oluwa', NULL, 'lga', NULL, NULL, 1),
(630, 19, 'Olorunda', NULL, 'lga', NULL, NULL, 1),
(631, 5, 'Olorunsogo', NULL, 'lga', NULL, NULL, 1),
(632, 5, 'Oluyole', NULL, 'lga', NULL, NULL, 1),
(633, 20, 'Omala', NULL, 'lga', NULL, NULL, 1),
(634, 6, 'Omuma', NULL, 'lga', NULL, NULL, 1),
(635, 5, 'Ona Ara', NULL, 'lga', NULL, NULL, 1),
(636, 18, 'Ondo East', NULL, 'lga', NULL, NULL, 1),
(637, 18, 'Ondo West', NULL, 'lga', NULL, NULL, 1),
(638, 34, 'Onicha', NULL, 'lga', NULL, NULL, 1),
(639, 10, 'Onitsha North', NULL, 'lga', NULL, NULL, 1),
(640, 10, 'Onitsha South', NULL, 'lga', NULL, NULL, 1),
(641, 15, 'Onna', NULL, 'lga', NULL, NULL, 1),
(642, 9, 'Okpokwu', NULL, 'lga', NULL, NULL, 1),
(643, 6, 'Opobo/Nkoro', NULL, 'lga', NULL, NULL, 1),
(644, 24, 'Oredo', NULL, 'lga', NULL, NULL, 1),
(645, 5, 'Orelope', NULL, 'lga', NULL, NULL, 1),
(646, 19, 'Oriade', NULL, 'lga', NULL, NULL, 1),
(647, 5, 'Ori Ire', NULL, 'lga', NULL, NULL, 1),
(648, 13, 'Orlu', NULL, 'lga', NULL, NULL, 1),
(649, 19, 'Orolu', NULL, 'lga', NULL, NULL, 1),
(650, 15, 'Oron', NULL, 'lga', NULL, NULL, 1),
(651, 13, 'Orsu', NULL, 'lga', NULL, NULL, 1),
(652, 13, 'Oru East', NULL, 'lga', NULL, NULL, 1),
(653, 15, 'Oruk Anam', NULL, 'lga', NULL, NULL, 1),
(654, 10, 'Orumba North', NULL, 'lga', NULL, NULL, 1),
(655, 10, 'Orumba South', NULL, 'lga', NULL, NULL, 1),
(656, 13, 'Oru West', NULL, 'lga', NULL, NULL, 1),
(657, 18, 'Ose', NULL, 'lga', NULL, NULL, 1),
(658, 12, 'Oshimili North', NULL, 'lga', NULL, NULL, 1),
(659, 12, 'Oshimili South', NULL, 'lga', NULL, NULL, 1),
(660, 2, 'Oshodi-Isolo', NULL, 'lga', NULL, NULL, 1),
(661, 28, 'Osisioma', NULL, 'lga', NULL, NULL, 1),
(662, 19, 'Osogbo', NULL, 'lga', NULL, NULL, 1),
(663, 9, 'Oturkpo', NULL, 'lga', NULL, NULL, 1),
(664, 24, 'Ovia North-East', NULL, 'lga', NULL, NULL, 1),
(665, 24, 'Ovia South-West', NULL, 'lga', NULL, NULL, 1),
(666, 24, 'Owan East', NULL, 'lga', NULL, NULL, 1),
(667, 24, 'Owan West', NULL, 'lga', NULL, NULL, 1),
(668, 13, 'Owerri Municipal', NULL, 'lga', NULL, NULL, 1),
(669, 13, 'Owerri North', NULL, 'lga', NULL, NULL, 1),
(670, 13, 'Owerri West', NULL, 'lga', NULL, NULL, 1),
(671, 18, 'Owo', NULL, 'lga', NULL, NULL, 1),
(672, 29, 'Oye', NULL, 'lga', NULL, NULL, 1),
(673, 10, 'Oyi', NULL, 'lga', NULL, NULL, 1),
(674, 6, 'Oyigbo', NULL, 'lga', NULL, NULL, 1),
(675, 5, 'Oyo', NULL, 'lga', NULL, NULL, 1),
(676, 5, 'Oyo East', NULL, 'lga', NULL, NULL, 1),
(677, 30, 'Oyun', NULL, 'lga', NULL, NULL, 1),
(678, 14, 'Paikoro', NULL, 'lga', NULL, NULL, 1),
(679, 25, 'Pankshin', NULL, 'lga', NULL, NULL, 1),
(680, 12, 'Patani', NULL, 'lga', NULL, NULL, 1),
(681, 30, 'Pategi', NULL, 'lga', NULL, NULL, 1),
(682, 6, 'Port Harcourt', NULL, 'lga', NULL, NULL, 1),
(683, 32, 'Potiskum', NULL, 'lga', NULL, NULL, 1),
(684, 25, 'Qua''an Pan', NULL, 'lga', NULL, NULL, 1),
(685, 17, 'Rabah', NULL, 'lga', NULL, NULL, 1),
(686, 14, 'Rafi', NULL, 'lga', NULL, NULL, 1),
(687, 1, 'Rano', NULL, 'lga', NULL, NULL, 1),
(688, 16, 'Remo North', NULL, 'lga', NULL, NULL, 1),
(689, 14, 'Rijau', NULL, 'lga', NULL, NULL, 1),
(690, 4, 'Rimi', NULL, 'lga', NULL, NULL, 1),
(691, 1, 'Rimin Gado', NULL, 'lga', NULL, NULL, 1),
(692, 8, 'Ringim', NULL, 'lga', NULL, NULL, 1),
(693, 25, 'Riyom', NULL, 'lga', NULL, NULL, 1),
(694, 1, 'Rogo', NULL, 'lga', NULL, NULL, 1),
(695, 8, 'Roni', NULL, 'lga', NULL, NULL, 1),
(696, 17, 'Sabon Birni', NULL, 'lga', NULL, NULL, 1),
(697, 3, 'Sabon Gari', NULL, 'lga', NULL, NULL, 1),
(698, 4, 'Sabuwa', NULL, 'lga', NULL, NULL, 1),
(699, 4, 'Safana', NULL, 'lga', NULL, NULL, 1),
(700, 36, 'Sagbama', NULL, 'lga', NULL, NULL, 1),
(701, 23, 'Sakaba', NULL, 'lga', NULL, NULL, 1),
(702, 5, 'Saki East', NULL, 'lga', NULL, NULL, 1),
(703, 5, 'Saki West', NULL, 'lga', NULL, NULL, 1),
(704, 4, 'Sandamu', NULL, 'lga', NULL, NULL, 1),
(705, 3, 'Sanga', NULL, 'lga', NULL, NULL, 1),
(706, 12, 'Sapele', NULL, 'lga', NULL, NULL, 1),
(707, 33, 'Sardauna', NULL, 'lga', NULL, NULL, 1),
(708, 16, 'Shagamu', NULL, 'lga', NULL, NULL, 1),
(709, 17, 'Shagari', NULL, 'lga', NULL, NULL, 1),
(710, 23, 'Shanga', NULL, 'lga', NULL, NULL, 1),
(711, 11, 'Shani', NULL, 'lga', NULL, NULL, 1),
(712, 1, 'Shanono', NULL, 'lga', NULL, NULL, 1),
(713, 26, 'Shelleng', NULL, 'lga', NULL, NULL, 1),
(714, 25, 'Shendam', NULL, 'lga', NULL, NULL, 1),
(715, 21, 'Shinkafi', NULL, 'lga', NULL, NULL, 1),
(716, 7, 'Shira', NULL, 'lga', NULL, NULL, 1),
(717, 14, 'Shiroro', NULL, 'lga', NULL, NULL, 1),
(718, 31, 'Shongom', NULL, 'lga', NULL, NULL, 1),
(719, 2, 'Shomolu', NULL, 'lga', NULL, NULL, 1),
(720, 17, 'Silame', NULL, 'lga', NULL, NULL, 1),
(721, 3, 'Soba', NULL, 'lga', NULL, NULL, 1),
(722, 17, 'Sokoto North', NULL, 'lga', NULL, NULL, 1),
(723, 17, 'Sokoto South', NULL, 'lga', NULL, NULL, 1),
(724, 26, 'Song', NULL, 'lga', NULL, NULL, 1),
(725, 36, 'Southern Ijaw', NULL, 'lga', NULL, NULL, 1),
(726, 14, 'Suleja', NULL, 'lga', NULL, NULL, 1),
(727, 8, 'Sule Tankarkar', NULL, 'lga', NULL, NULL, 1),
(728, 1, 'Sumaila', NULL, 'lga', NULL, NULL, 1),
(729, 23, 'Suru', NULL, 'lga', NULL, NULL, 1),
(730, 5, 'Surulere', NULL, 'lga', NULL, NULL, 1),
(731, 2, 'Surulere', NULL, 'lga', NULL, NULL, 1),
(732, 14, 'Tafa', NULL, 'lga', NULL, NULL, 1),
(733, 7, 'Tafawa Balewa', NULL, 'lga', NULL, NULL, 1),
(734, 6, 'Tai', NULL, 'lga', NULL, NULL, 1),
(735, 1, 'Takai', NULL, 'lga', NULL, NULL, 1),
(736, 33, 'Takum', NULL, 'lga', NULL, NULL, 1),
(737, 21, 'Talata Mafara', NULL, 'lga', NULL, NULL, 1),
(738, 17, 'Tambuwal', NULL, 'lga', NULL, NULL, 1),
(739, 17, 'Tangaza', NULL, 'lga', NULL, NULL, 1),
(740, 1, 'Tarauni', NULL, 'lga', NULL, NULL, 1),
(741, 9, 'Tarka', NULL, 'lga', NULL, NULL, 1),
(742, 32, 'Tarmuwa', NULL, 'lga', NULL, NULL, 1),
(743, 8, 'Taura', NULL, 'lga', NULL, NULL, 1),
(744, 26, 'Toungo', NULL, 'lga', NULL, NULL, 1),
(745, 1, 'Tofa', NULL, 'lga', NULL, NULL, 1),
(746, 7, 'Toro', NULL, 'lga', NULL, NULL, 1),
(747, 35, 'Toto', NULL, 'lga', NULL, NULL, 1),
(748, 21, 'Chafe', NULL, 'lga', NULL, NULL, 1),
(749, 1, 'Tsanyawa', NULL, 'lga', NULL, NULL, 1),
(750, 1, 'Tudun Wada', NULL, 'lga', NULL, NULL, 1),
(751, 17, 'Tureta', NULL, 'lga', NULL, NULL, 1),
(752, 22, 'Udenu', NULL, 'lga', NULL, NULL, 1),
(753, 22, 'Udi', NULL, 'lga', NULL, NULL, 1),
(754, 12, 'Udu', NULL, 'lga', NULL, NULL, 1),
(755, 15, 'Udung-Uko', NULL, 'lga', NULL, NULL, 1),
(756, 12, 'Ughelli North', NULL, 'lga', NULL, NULL, 1),
(757, 12, 'Ughelli South', NULL, 'lga', NULL, NULL, 1),
(758, 28, 'Ugwunagbo', NULL, 'lga', NULL, NULL, 1),
(759, 24, 'Uhunmwonde', NULL, 'lga', NULL, NULL, 1),
(760, 15, 'Ukanafun', NULL, 'lga', NULL, NULL, 1),
(761, 9, 'Ukum', NULL, 'lga', NULL, NULL, 1),
(762, 28, 'Ukwa East', NULL, 'lga', NULL, NULL, 1),
(763, 28, 'Ukwa West', NULL, 'lga', NULL, NULL, 1),
(764, 12, 'Ukwuani', NULL, 'lga', NULL, NULL, 1),
(765, 28, 'Umuahia North', NULL, 'lga', NULL, NULL, 1),
(766, 28, 'Umuahia South', NULL, 'lga', NULL, NULL, 1),
(767, 28, 'Umu Nneochi', NULL, 'lga', NULL, NULL, 1),
(768, 1, 'Ungogo', NULL, 'lga', NULL, NULL, 1),
(769, 13, 'Unuimo', NULL, 'lga', NULL, NULL, 1),
(770, 15, 'Uruan', NULL, 'lga', NULL, NULL, 1),
(771, 15, 'Urue-Offong/Oruko', NULL, 'lga', NULL, NULL, 1),
(772, 9, 'Ushongo', NULL, 'lga', NULL, NULL, 1),
(773, 33, 'Ussa', NULL, 'lga', NULL, NULL, 1),
(774, 12, 'Uvwie', NULL, 'lga', NULL, NULL, 1),
(775, 15, 'Uyo', NULL, 'lga', NULL, NULL, 1),
(776, 22, 'Uzo Uwani', NULL, 'lga', NULL, NULL, 1),
(777, 9, 'Vandeikya', NULL, 'lga', NULL, NULL, 1),
(778, 17, 'Wamako', NULL, 'lga', NULL, NULL, 1),
(779, 35, 'Wamba', NULL, 'lga', NULL, NULL, 1),
(780, 1, 'Warawa', NULL, 'lga', NULL, NULL, 1),
(781, 7, 'Warji', NULL, 'lga', NULL, NULL, 1),
(782, 12, 'Warri North', NULL, 'lga', NULL, NULL, 1),
(783, 12, 'Warri South', NULL, 'lga', NULL, NULL, 1),
(784, 12, 'Warri South West', NULL, 'lga', NULL, NULL, 1),
(785, 23, 'Wasagu/Danko', NULL, 'lga', NULL, NULL, 1),
(786, 25, 'Wase', NULL, 'lga', NULL, NULL, 1),
(787, 1, 'Wudil', NULL, 'lga', NULL, NULL, 1),
(788, 33, 'Wukari', NULL, 'lga', NULL, NULL, 1),
(789, 17, 'Wurno', NULL, 'lga', NULL, NULL, 1),
(790, 14, 'Wushishi', NULL, 'lga', NULL, NULL, 1),
(791, 17, 'Yabo', NULL, 'lga', NULL, NULL, 1),
(792, 20, 'Yagba East', NULL, 'lga', NULL, NULL, 1),
(793, 20, 'Yagba West', NULL, 'lga', NULL, NULL, 1),
(794, 27, 'Yakuur', NULL, 'lga', NULL, NULL, 1),
(795, 27, 'Yala', NULL, 'lga', NULL, NULL, 1),
(796, 31, 'Yamaltu/Deba', NULL, 'lga', NULL, NULL, 1),
(797, 8, 'Yankwashi', NULL, 'lga', NULL, NULL, 1),
(798, 23, 'Yauri', NULL, 'lga', NULL, NULL, 1),
(799, 36, 'Yenagoa', NULL, 'lga', NULL, NULL, 1),
(800, 26, 'Yola North', NULL, 'lga', NULL, NULL, 1),
(801, 26, 'Yola South', NULL, 'lga', NULL, NULL, 1),
(802, 33, 'Yorro', NULL, 'lga', NULL, NULL, 1),
(803, 32, 'Yunusari', NULL, 'lga', NULL, NULL, 1),
(804, 32, 'Yusufari', NULL, 'lga', NULL, NULL, 1),
(805, 7, 'Zaki', NULL, 'lga', NULL, NULL, 1),
(806, 4, 'Zango', NULL, 'lga', NULL, NULL, 1),
(807, 3, 'Zangon Kataf', NULL, 'lga', NULL, NULL, 1),
(808, 3, 'Zaria', NULL, 'lga', NULL, NULL, 1),
(809, 33, 'Zing', NULL, 'lga', NULL, NULL, 1),
(810, 21, 'Zurmi', NULL, 'lga', NULL, NULL, 1),
(811, 23, 'Zuru', NULL, 'lga', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_personal_info`
--

CREATE TABLE `site_personal_info` (
  `id` varchar(17) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` int(16) DEFAULT NULL COMMENT 'uploads.id',
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_names` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` int(32) DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'maps_countries.id',
  `state_of_origin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'maps_states.id',
  `lga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'maps_lga.id',
  `residence_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'maps_countries.id',
  `residence_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'maps_states.id',
  `residence_city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence_street` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_personal_info`
--

INSERT INTO `site_personal_info` (`id`, `photo`, `first_name`, `last_name`, `other_names`, `gender`, `date_of_birth`, `nationality`, `state_of_origin`, `lga`, `residence_country`, `residence_state`, `residence_city`, `residence_street`, `email`, `phone`, `biography`) VALUES
('1', NULL, 'Chukwuemeka', 'Nwobodo', 'Joseph', 'M', 500000000, 'NIGERIAN', 'ENUGU', 'AKANU-EAST', 'NIGERIA', 'ENUGU', 'ENUGU', 'NWOSU TERRACE', 'jc.nwobodo@gmail.com', '08133621591', NULL),
('11', NULL, 'James', 'Eze', '', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'james.eze@gmail.com', NULL, NULL),
('12', NULL, 'Okereke', 'Fidelis', '', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'okereke.fidelis@gmail.com', NULL, NULL),
('18', NULL, 'Madam', 'Receptionist', 'One', 'F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'receptionist1@site.com', '08031231233', NULL),
('19', NULL, 'Odinakachukwu', 'Okeke', '', 'F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'odinakachukwu@gmail.com', '08031231239', NULL),
('20', NULL, 'Fidelis', 'Ikworentus', '', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '08031231240', NULL),
('21', NULL, 'Gentle', 'Joe', 'Young', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '08031231242', NULL),
('4', 3, 'Nice', 'Victor', 'John', 'F', 191113200, 'Nigerian', 'Anambra', 'Nnewi soutth', 'United kingdom', 'ALASKA', 'Isolo', 'ROAD T HOUSE 1', 'chukwudi@gmail.com', '08124345567', NULL),
('5', 17, 'Michael', 'Ndubuisi', 'Chukwuemeka', 'M', 191286000, 'Nigerian', 'Enugu', 'Udi', 'Nigeria', 'Enugu', 'Nsukka', 'Alvan-Ikoku Hostel, Rm 128, UNN', 'ndu11michael@gmail.com', '08131206054', NULL),
('6', 18, 'Ogochukwu', 'Nnamega', '', 'F', 759279600, 'Nigerian', 'Enugu', 'Nkanu-East', 'Nigeria', 'Enugu', 'Enugu', 'UNEC, Enugu', 'jc.nwobodo2@gmail.com', '08176309077', NULL),
('7', 19, 'Blessing', 'Ogbuokili', '', 'M', 191286000, 'Nigerian', 'Anambra', 'Nnewi soutth', 'Nigeria', 'Enugu', 'Nsukka', 'UNN, Nsukka', 'blessing.ogbuokoli@unn.edu.ng', '08069656025', NULL),
('p15', NULL, 'Young', 'Moses', '', 'M', 636505200, NULL, NULL, NULL, NULL, 'Enugu', NULL, 'P & T Quarters, Ogui Enugu', 'young.moses@gmail.com', '08031231234', NULL),
('p18', NULL, 'Barrack', 'Obama', '', 'M', -299034000, NULL, NULL, NULL, NULL, 'Abuja (Federal Capital Territory)', NULL, 'Some Random House in Garrki, Abuja', '', '08031231235', NULL),
('p20', NULL, 'Bernard', 'Shaw', 'Lawlence', 'M', -1188003600, NULL, NULL, NULL, NULL, 'Anambra', NULL, '46 Zik Avenue, Fegge Onitsha', '', '08031231236', NULL),
('p21', NULL, 'Flora', 'Shaw', '', 'F', -1277254800, NULL, NULL, NULL, NULL, 'Kogi', NULL, 'Kogi-Abuja Boundry, Lokoja', '', '08031231237', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_posts`
--

CREATE TABLE `site_posts` (
  `id` int(16) NOT NULL,
  `parent` int(16) DEFAULT NULL COMMENT 'site_posts.id',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guid` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `featured_image` int(16) DEFAULT NULL COMMENT 'uploads.id',
  `category` int(16) DEFAULT NULL COMMENT 'site_posts_categories.id',
  `author` int(16) NOT NULL COMMENT 'users.id',
  `date_created` int(32) NOT NULL,
  `last_update` int(32) NOT NULL,
  `comment_count` int(16) DEFAULT '0',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_posts`
--

INSERT INTO `site_posts` (`id`, `parent`, `post_type`, `guid`, `title`, `content`, `excerpt`, `featured_image`, `category`, `author`, `date_created`, `last_update`, `comment_count`, `status`) VALUES
(1, NULL, 'page', 'about', 'About HMSTDN', '<p><p class="lead">Powered by\r</p><p><h1>BareBones PHP Framework</h1> with <h2>GUI crafted out of Bootstrap</h2>\r</p><p>by <h3>J. C. Nwobodo</h3>\r</p><p><hr>\r</p><p><p class="lead">There is much to say about this project;\r</p><p><ol>\r</p><p><li>It''s gonna save lives if it were a commercial project</li>\r</p><p><li>Unfortunately, it''s just another <strong>MSc Project</strong></li>\r</p><p></ol></p>', '<p><p class="lead">Powered by\r</p><p><h1>BareBones PHP Framework</h1> with <h2>GUI crafted out of Bootstrap</h2>\r</p><p>by <h3>J. C. Nwobodo</h3></p>', NULL, NULL, 1, 1453609560, 1453762149, NULL, 1),
(2, NULL, 'page', 'terms-of-use', 'Terms of Use', '<p><h1>Enjoy ! It''s Inexpensive</h1>\r</p><p><p class="lead">Developed for <strong>academic use only</strong> as an MSc Project for whom it may concern.</p></p>', '<p>To be discussed at a later time.\r</p><p>For now...\r</p><p>\r</p><p><h1>Enjoy !</h1></p>', NULL, NULL, 1, 1453613760, 1453615836, NULL, 1),
(3, NULL, 'page', 'legal-notice', 'Legal Notice', '<p><p class="lead">This is a free country, isn''t it?</p>\r</p><p>\r</p><p><h2>Just Take Note of the Following</h2>\r</p><p><ol>\r</p><p><li>BareBones PHP Framework is Private Project of <strong>Phoenix Laboratories</strong></li>\r</p><p><li>Phoenix Laboratories is a Private, Unregistered Company of <strong>J. C. Nwobodo</strong></li>\r</p><p><li><strong>Bootstrap</strong> and all it''s components are registered trademarks of there respective owners</li>\r</p><p></ol>\r</p><p>\r</p><p><p class="lead">Therefore, Please Do not Misuse.</p>\r</p><p>\r</p><p><h3>Thanks !</h3></p>', '<p><p class="lead">This is a free country, isn''t it?</p></p>', NULL, NULL, 1, 1453614120, 1453762478, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_sessions`
--

CREATE TABLE `site_sessions` (
  `id` int(16) NOT NULL,
  `session_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(16) NOT NULL COMMENT 'users.id',
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'users_access_levels.user_type',
  `start_time` int(32) NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity_time` int(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_sessions`
--

INSERT INTO `site_sessions` (`id`, `session_id`, `user_id`, `user_type`, `start_time`, `user_agent`, `ip_address`, `last_activity_time`, `status`) VALUES
(2, '569f5f262931c8.72247079', 1, 'Admin', 1453285158, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453289019, 0),
(3, '569f6e4493b446.35514231', 1, 'Admin', 1453289028, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453467329, 0),
(4, '56a2271e4e17d8.74607779', 1, 'Admin', 1453467422, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453477176, 0),
(5, '56a2512c1d6b00.39876575', 1, 'Admin', 1453478188, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453486648, 0),
(6, '56a276cf839d73.62592753', 1, 'Admin', 1453487823, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453488642, 0),
(7, '56a2e218583196.95183725', 5, 'Doctor', 1453515288, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453522338, 0),
(8, '56a2fdabc6ab57.27640447', 1, 'Admin', 1453522347, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453522841, 0),
(11, '56a379d7d02f57.33240440', 1, 'Admin', 1453554135, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453554139, 0),
(12, '56a379e0bc97a4.05775643', 5, 'Doctor', 1453554144, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453560814, 0),
(13, '56a393f5dbe283.97418141', 1, 'Admin', 1453560821, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453561874, 0),
(14, '56a3981ce13320.35177377', 6, 'LabTechnician', 1453561884, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453562833, 0),
(15, '56a39bda551c77.20110894', 5, 'Doctor', 1453562842, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453563031, 0),
(16, '56a39ca12b1ec6.98987198', 6, 'LabTechnician', 1453563041, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453565025, 0),
(17, '56a3a46bc39586.33489925', 1, 'Admin', 1453565036, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453565073, 0),
(18, '56a3a4999fa587.33588107', 5, 'Doctor', 1453565081, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453571816, 0),
(19, '56a3beef2e8657.17778596', 1, 'Admin', 1453571823, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453607969, 0),
(20, '56a44c5f25ac56.37572468', 6, 'LabTechnician', 1453608031, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453609103, 0),
(21, '56a45098a44c87.44513704', 5, 'Doctor', 1453609112, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453609555, 0),
(22, '56a4525d13b0c8.02579579', 1, 'Admin', 1453609565, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453615871, 0),
(23, '56a46b186874d3.38610914', 5, 'Doctor', 1453615896, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453616446, 0),
(24, '56a46d4691b155.89493864', 1, 'Admin', 1453616454, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453617332, 0),
(25, '56a4713418e8f6.12719790', 5, 'Doctor', 1453617460, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453625169, 0),
(26, '56a4c29fc7dee2.60908627', 6, 'LabTechnician', 1453638303, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453640670, 0),
(27, '56a4cbe6cdd204.56972069', 5, 'Doctor', 1453640678, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453643789, 0),
(28, '56a4dfa65017b4.96029176', 7, 'Researcher', 1453645738, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453647420, 0),
(29, '56a4e643b871b5.11242188', 5, 'Doctor', 1453647427, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453647803, 0),
(30, '56a4e7ce198be8.95646347', 1, 'Admin', 1453647822, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453647837, 0),
(31, '56a4e7e3eb22c6.84565012', 7, 'Researcher', 1453647843, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453658252, 0),
(32, '56a5109b79d849.69248315', 1, 'Admin', 1453658267, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453658331, 0),
(33, '56a510efdfeea3.66914621', 5, 'Doctor', 1453658351, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453658471, 0),
(34, '56a5116e0ac836.93204444', 6, 'LabTechnician', 1453658478, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453658499, 0),
(35, '56a511a2738065.96209842', 7, 'Researcher', 1453658530, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453666139, 0),
(36, '56a533b2e42f18.78788972', 1, 'Admin', 1453667251, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453667701, 0),
(37, '56a5373c9e92c4.26401543', 6, 'LabTechnician', 1453668156, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453668163, 0),
(38, '56a5374b29e657.15283887', 7, 'Researcher', 1453668171, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453670060, 0),
(39, '56a6a3094f7d30.92281223', 7, 'Researcher', 1453761290, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453761496, 0),
(40, '56a6a3f84b3dd1.71997639', 1, 'Admin', 1453761528, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', '127.0.0.1', 1453762905, 1),
(41, '56a8b65deec021.22930204', 7, 'Researcher', 1453897310, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36', '127.0.0.1', 1453907072, 0),
(42, '56a8dc948a1727.12206478', 1, 'Admin', 1453907092, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36', '127.0.0.1', 1453908141, 0),
(43, '56a8e0b4635a46.91367079', 7, 'Researcher', 1453908148, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36', '127.0.0.1', 1453964980, 0),
(44, '56aabade4ab956.48528340', 7, 'Researcher', 1454029534, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', '127.0.0.1', 1454029535, 1),
(45, '56af009948c4a2.28236151', 7, 'Researcher', 1454309529, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454310607, 0),
(46, '56af0584790824.08728078', 7, 'Researcher', 1454310788, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454310871, 0),
(47, '56af19ef7940f4.08574094', 1, 'Admin', 1454316015, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454321069, 0),
(48, '56af2e07543db1.91649060', 5, 'Doctor', 1454321159, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454321836, 0),
(49, '56af3191481731.60618274', 1, 'Admin', 1454322065, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454327909, 0),
(50, '56af48b22bf8e8.68677531', 1, 'Admin', 1454327986, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454328028, 0),
(51, '56af490008f5e9.98607163', 1, 'Admin', 1454328064, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454328068, 0),
(52, '56af49201ef0a3.36750458', 6, 'LabTechnician', 1454328096, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454328146, 0),
(53, '56af495b0bbbd1.27801533', 5, 'Doctor', 1454328155, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454328564, 0),
(54, '56af4afb07c3d1.91993138', 7, 'Researcher', 1454328571, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454328842, 0),
(55, '56af4c10be8aa2.21688153', 1, 'Admin', 1454328848, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454356842, 0),
(56, '56afbd68650ef8.45447698', 1, 'Admin', 1454357864, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454358301, 0),
(57, '56afbf5876d011.89981403', 19, 'Doctor', 1454358360, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454358969, 0),
(58, '56afc1c52f4e40.77235415', 6, 'LabTechnician', 1454358981, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454359084, 0),
(59, '56afc233388376.83832494', 19, 'Doctor', 1454359091, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454360030, 0),
(60, '56afc5e7df3a53.11388787', 1, 'Admin', 1454360039, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454363706, 1),
(61, '56b04cac3e30f0.10411943', 1, 'Admin', 1454394540, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454394963, 0),
(62, '56b04e5b7e5545.62256829', 4, 'Receptionist', 1454394971, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454397535, 0),
(63, '56b0586f50bc69.56674670', 6, 'LabTechnician', 1454397551, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454397568, 0),
(64, '56b0589987a265.31190279', 19, 'Doctor', 1454397593, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454397631, 0),
(65, '56b058c7a69f47.18340477', 20, 'Doctor', 1454397639, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454397792, 0),
(66, '56b05968a8c523.97035703', 4, 'Receptionist', 1454397800, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454398609, 0),
(67, '56b05c9881b258.40167833', 1, 'Admin', 1454398616, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454399844, 0),
(68, '56b062c433ae76.29610772', 19, 'Doctor', 1454400196, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454400270, 0),
(69, '56b0631608f5f1.92764430', 6, 'LabTechnician', 1454400278, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454400439, 0),
(70, '56b1a18f5439c1.86417647', 1, 'Admin', 1454481807, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36', '127.0.0.1', 1454482056, 1),
(71, '56b367132e8ac7.81817299', 1, 'Admin', 1454597907, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.103 Safari/537.36', '127.0.0.1', 1454597908, 1),
(72, '56b4ba59817e05.42331215', 1, 'Admin', 1454684761, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.103 Safari/537.36', '127.0.0.1', 1454684805, 0),
(73, '56b4bb1262fa29.74731280', 1, 'Admin', 1454684946, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.103 Safari/537.36', '127.0.0.1', 1454684946, 1),
(74, '56c18bfeb737d6.63277481', 1, 'Admin', 1455524862, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455524863, 1),
(75, '56c2dd2a61d7d0.17770036', 6, 'LabTechnician', 1455611178, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455611188, 0),
(76, '56c2de24b796b5.34964254', 7, 'Researcher', 1455611428, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455613364, 0),
(77, '56c2e5bf5469a5.05222900', 1, 'Admin', 1455613375, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455614803, 0),
(78, '56c2eb58ab2fd9.77352863', 1, 'Admin', 1455614808, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455614827, 0),
(79, '56c2eb712d8d94.89283878', 19, 'Doctor', 1455614833, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455615779, 0),
(80, '56c2ef29075468.49894015', 6, 'LabTechnician', 1455615785, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455615821, 0),
(81, '56c2ef52599ae0.54516649', 7, 'Researcher', 1455615826, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455615889, 0),
(82, '56c2ef99a99be8.40046415', 1, 'Admin', 1455615897, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455616250, 0),
(83, '56c4a5bd0b4631.80315576', 7, 'Researcher', 1455728061, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455728104, 0),
(84, '56c4a5ef7d3df7.36891939', 1, 'Admin', 1455728111, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455728167, 0),
(85, '56c4a62cee3df3.74894564', 19, 'Doctor', 1455728172, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455728220, 0),
(86, '56c4a6620a2ba2.55549036', 6, 'LabTechnician', 1455728226, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36', '127.0.0.1', 1455728263, 0);

-- --------------------------------------------------------

--
-- Table structure for table `site_uploads`
--

CREATE TABLE `site_uploads` (
  `id` int(16) NOT NULL,
  `author` int(16) DEFAULT NULL COMMENT 'site_users.id',
  `upload_time` int(32) NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_uploads`
--

INSERT INTO `site_uploads` (`id`, `author`, `upload_time`, `location`, `file_name`, `file_size`, `status`) VALUES
(1, NULL, 1453297033, 'Uploads/passports', 'passport_569f8d89cf40e.jpg', 135712, 2),
(2, NULL, 1453299477, 'Uploads/passports', 'passport_569f9715e9a10.jpg', 135712, 2),
(3, NULL, 1453417785, 'Uploads/passports', 'passport_56a16539d5386.jpg', 135712, 2),
(6, NULL, 1453426538, 'Uploads/passports', 'passport_56a1876a57ad8.jpg', 135712, 2),
(7, NULL, 1453427014, 'Uploads/passports', 'passport_56a1894675310.jpg', 135712, 2),
(8, NULL, 1453427423, 'Uploads/passports', 'passport_56a18adf750c5.jpg', 135712, 2),
(9, NULL, 1453427496, 'Uploads/passports', 'passport_56a18b28bc09c.jpg', 135712, 2),
(10, NULL, 1453427797, 'Uploads/passports', 'passport_56a18c5528c11.jpg', 135712, 2),
(11, NULL, 1453427913, 'Uploads/passports', 'passport_56a18cc95ac12.jpg', 135712, 2),
(12, NULL, 1453428112, 'Uploads/passports', 'passport_56a18d9060607.jpg', 135712, 2),
(13, NULL, 1453428392, 'Uploads/passports', 'passport_56a18ea88a1b3.jpg', 135712, 2),
(14, NULL, 1453436257, 'Uploads/passports', 'passport_56a1ad60e3659.jpg', 135712, 2),
(15, NULL, 1453436459, 'Uploads/passports', 'passport_56a1ae2b2eacb.jpg', 135712, 2),
(17, NULL, 1453447854, 'Uploads/passports', 'passport_56a1daae30d8a.jpg', 135712, 2),
(18, NULL, 1453561132, 'Uploads/passports', 'passport_56a3952cb3175.jpg', 135712, 2),
(19, NULL, 1453645452, 'Uploads/passports', 'passport_56a4de8c229f9.jpg', 135712, 2);

-- --------------------------------------------------------

--
-- Table structure for table `site_users`
--

CREATE TABLE `site_users` (
  `id` int(16) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lawyer',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_users`
--

INSERT INTO `site_users` (`id`, `username`, `password`, `user_type`, `status`) VALUES
(1, 'UNNMED/ADM/001', 'some-key', 'Admin', 1),
(4, 'UNNMED/REC/001', 'some-key', 'Receptionist', 1),
(5, 'UNNMED/DEN/002', 'some-key', 'Doctor', 1),
(6, 'UNNMED/LAB/001', 'some-key', 'LabTechnician', 1),
(7, 'blessing@gmail.com', 'some-key', 'Researcher', 1),
(11, 'james@gmail.com', 'some-key', 'Researcher', 1),
(12, 'fidelis@gmail.com', 'some-key', 'Researcher', 1),
(18, 'UNNMED/REC/002', 'some-key', 'Receptionist', 1),
(19, 'UNNMED/PED/001', 'some-key', 'Doctor', 1),
(20, 'UNNMED/DEN/001', 'some-key', 'Doctor', 1),
(21, 'unthen/adm/001', 'some-key', 'Admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_clinics`
--
ALTER TABLE `app_clinics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_consultations`
--
ALTER TABLE `app_consultations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_diseases`
--
ALTER TABLE `app_diseases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_employment_data`
--
ALTER TABLE `app_employment_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_lab_tests`
--
ALTER TABLE `app_lab_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_patients`
--
ALTER TABLE `app_patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_number` (`card_number`);

--
-- Indexes for table `site_categories`
--
ALTER TABLE `site_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guid` (`guid`);

--
-- Indexes for table `site_comments`
--
ALTER TABLE `site_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_locations`
--
ALTER TABLE `site_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_personal_info`
--
ALTER TABLE `site_personal_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `photo_id` (`photo`);

--
-- Indexes for table `site_posts`
--
ALTER TABLE `site_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pamalink` (`guid`);

--
-- Indexes for table `site_sessions`
--
ALTER TABLE `site_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `site_uploads`
--
ALTER TABLE `site_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_users`
--
ALTER TABLE `site_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_clinics`
--
ALTER TABLE `app_clinics`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `app_consultations`
--
ALTER TABLE `app_consultations`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `app_diseases`
--
ALTER TABLE `app_diseases`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `app_lab_tests`
--
ALTER TABLE `app_lab_tests`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `app_patients`
--
ALTER TABLE `app_patients`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `site_categories`
--
ALTER TABLE `site_categories`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `site_comments`
--
ALTER TABLE `site_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `site_locations`
--
ALTER TABLE `site_locations`
  MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=812;
--
-- AUTO_INCREMENT for table `site_posts`
--
ALTER TABLE `site_posts`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `site_sessions`
--
ALTER TABLE `site_sessions`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `site_uploads`
--
ALTER TABLE `site_uploads`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `site_users`
--
ALTER TABLE `site_users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
