-- phpMyAdmin SQL Dump
-- version 5.2.3-1.fc43
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 18, 2026 at 12:06 PM
-- Server version: 10.11.15-MariaDB
-- PHP Version: 8.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `playground`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(3) DEFAULT NULL,
  `customer_id` varchar(15) DEFAULT NULL,
  `first_name` varchar(10) DEFAULT NULL,
  `last_name` varchar(11) DEFAULT NULL,
  `company` varchar(31) DEFAULT NULL,
  `email` varchar(34) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_id`, `first_name`, `last_name`, `company`, `email`) VALUES
(1, 'DD37Cf93aecA6Dc', 'Sheryl', 'Baxter', 'Rasmussen Group', 'zunigavanessa@smith.info'),
(2, '1Ef7b82A4CAAD10', 'Preston', 'Lozano', 'Vega-Gentry', 'vmata@colon.com'),
(3, '6F94879bDAfE5a6', 'Roy', 'Berry', 'Murillo-Perry', 'beckycarr@hogan.com'),
(4, '5Cef8BFA16c5e3c', 'Linda', 'Olsen', 'Dominguez, Mcmillan and Donovan', 'stanleyblackwell@benson.org'),
(5, '053d585Ab6b3159', 'Joanna', 'Bender', 'Martin, Lang and Andrade', 'colinalvarado@miles.net'),
(6, '2d08FB17EE273F4', 'Aimee', 'Downs', 'Steele Group', 'louis27@gilbert.com'),
(7, 'EA4d384DfDbBf77', 'Darren', 'Peck', 'Lester, Woodard and Mitchell', 'tgates@cantrell.com'),
(8, '0e04AFde9f225dE', 'Brett', 'Mullen', 'Sanford, Davenport and Giles', 'asnow@colon.com'),
(9, 'C2dE4dEEc489ae0', 'Sheryl', 'Meyers', 'Browning-Simon', 'mariokhan@ryan-pope.org'),
(10, '8C2811a503C7c5a', 'Michelle', 'Gallagher', 'Beck-Hendrix', 'mdyer@escobar.net'),
(11, '216E205d6eBb815', 'Carl', 'Schroeder', 'Oconnell, Meza and Everett', 'kirksalas@webb.com'),
(12, 'CEDec94deE6d69B', 'Jenna', 'Dodson', 'Hoffman, Reed and Mcclain', 'mark42@robbins.com'),
(13, 'e35426EbDEceaFF', 'Tracey', 'Mata', 'Graham-Francis', 'alex56@walls.org'),
(14, 'A08A8aF8BE9FaD4', 'Kristine', 'Cox', 'Carpenter-Cook', 'holdenmiranda@clarke.com'),
(15, '6fEaA1b7cab7B6C', 'Faith', 'Lutz', 'Carter-Hancock', 'cassieparrish@blevins-chapman.net'),
(16, '8cad0b4CBceaeec', 'Miranda', 'Beasley', 'Singleton and Sons', 'vduncan@parks-hardy.com'),
(17, 'a5DC21AE3a21eaA', 'Caroline', 'Foley', 'Winters-Mendoza', 'holtgwendolyn@watson-davenport.com'),
(18, 'F8Aa9d6DfcBeeF8', 'Greg', 'Mata', 'Valentine LLC', 'jaredjuarez@carroll.org'),
(19, 'F160f5Db3EfE973', 'Clifford', 'Jacobson', 'Simon LLC', 'joseph26@jacobson.com'),
(20, '0F60FF3DdCd7aB0', 'Joanna', 'Kirk', 'Mays-Mccormick', 'tuckerangie@salazar.net'),
(21, '9F9AdB7B8A6f7F2', 'Maxwell', 'Frye', 'Patterson Inc', 'fgibson@drake-webb.com'),
(22, 'FBd0Ded4F02a742', 'Kiara', 'Houston', 'Manning, Hester and Arroyo', 'blanchardbob@wallace-shannon.com'),
(23, '2FB0FAA1d429421', 'Colleen', 'Howard', 'Greer and Sons', 'rsingleton@ryan-cherry.com'),
(24, '010468dAA11382c', 'Janet', 'Valenzuela', 'Watts-Donaldson', 'stefanie71@spence.com'),
(25, 'eC1927Ca84E033e', 'Shane', 'Wilcox', 'Tucker LLC', 'mariah88@santos.com'),
(26, '09D7D7C8Fe09aea', 'Marcus', 'Moody', 'Giles Ltd', 'donnamullins@norris-barrett.org'),
(27, 'aBdfcF2c50b0bfD', 'Dakota', 'Poole', 'Simmons Group', 'stacey67@fields.org'),
(28, 'b92EBfdF8a3f0E6', 'Frederick', 'Harper', 'Hinton, Chaney and Stokes', 'jacobkhan@bright.biz'),
(29, '3B5dAAFA41AFa22', 'Stefanie', 'Fitzpatrick', 'Santana-Duran', 'wterrell@clark.com'),
(30, 'EDA69ca7a6e96a2', 'Kent', 'Bradshaw', 'Sawyer PLC', 'qjimenez@boyd.com'),
(31, '64DCcDFaB9DFd4e', 'Jack', 'Tate', 'Acosta, Petersen and Morrow', 'gfigueroa@boone-zavala.com'),
(32, '679c6c83DD872d6', 'Tom', 'Trujillo', 'Mcgee Group', 'tapiagreg@beard.info'),
(33, '7Ce381e4Afa4ba9', 'Gabriel', 'Mejia', 'Adkins-Salinas', 'coleolson@jennings.net'),
(34, 'A09AEc6E3bF70eE', 'Kaitlyn', 'Santana', 'Herrera Group', 'georgeross@miles.org'),
(35, 'aA9BAFfBc3710fe', 'Faith', 'Moon', 'Waters, Chase and Aguilar', 'willistonya@randolph-baker.com'),
(36, 'E11dfb2DB8C9f72', 'Tammie', 'Haley', 'Palmer, Barnes and Houston', 'harrisisaiah@jenkins.com'),
(37, '889eCf90f68c5Da', 'Nicholas', 'Sosa', 'Jordan Ltd', 'fwolfe@dorsey.com'),
(38, '7a1Ee69F4fF4B4D', 'Jordan', 'Gay', 'Glover and Sons', 'tiffanydavies@harris-mcfarland.org'),
(39, 'dca4f1D0A0fc5c9', 'Bruce', 'Esparza', 'Huerta-Mclean', 'preese@frye-vega.com'),
(40, '17aD8e2dB3df03D', 'Sherry', 'Garza', 'Anderson Ltd', 'ann48@miller.com'),
(41, '2f79Cd309624Abb', 'Natalie', 'Gentry', 'Monroe PLC', 'tcummings@fitzpatrick-ashley.com'),
(42, '6e5ad5a5e2bB5Ca', 'Bryan', 'Dunn', 'Kaufman and Sons', 'woodwardandres@phelps.com'),
(43, '7E441b6B228DBcA', 'Wayne', 'Simpson', 'Perkins-Trevino', 'barbarapittman@holder.com'),
(44, 'D3fC11A9C235Dc6', 'Luis', 'Greer', 'Cross PLC', 'bstuart@williamson-mcclure.com'),
(45, '30Dfa48fe5Ede78', 'Rhonda', 'Frost', 'Herrera, Shepherd and Underwood', 'zkrueger@wolf-chavez.net'),
(46, 'fD780ED8dbEae7B', 'Joanne', 'Montes', 'Price, Sexton and Mcdaniel', 'juan80@henson.net'),
(47, '300A40d3ce24bBA', 'Geoffrey', 'Guzman', 'Short-Wiggins', 'bauercrystal@gay.com'),
(48, '283DFCD0Dba40aF', 'Gloria', 'Mccall', 'Brennan, Acosta and Ramos', 'bartlettjenna@zuniga-moss.biz'),
(49, 'F4Fc91fEAEad286', 'Brady', 'Cohen', 'Osborne-Erickson', 'mccalltyrone@durham-rose.biz'),
(50, '80F33Fd2AcebF05', 'Latoya', 'Mccann', 'Hobbs, Garrett and Sanford', 'bobhammond@barry.biz'),
(51, 'Aa20BDe68eAb0e9', 'Gerald', 'Hawkins', 'Phelps, Forbes and Koch', 'uwarner@steele-arias.com'),
(52, 'e898eEB1B9FE22b', 'Samuel', 'Crawford', 'May, Goodwin and Martin', 'xpittman@ritter-carney.net'),
(53, 'faCEF517ae7D8eB', 'Patricia', 'Goodwin', 'Christian, Winters and Ellis', 'vaughanchristy@lara.biz'),
(54, 'c09952De6Cda8aA', 'Stacie', 'Richard', 'Byrd Inc', 'clinton85@colon-arias.org'),
(55, 'f3BEf3Be028166f', 'Robin', 'West', 'Nixon, Blackwell and Sosa', 'greenemiranda@zimmerman.com'),
(56, 'C6F2Fc6a7948a4e', 'Ralph', 'Haas', 'Montes PLC', 'goodmancesar@figueroa.biz'),
(57, 'c8FE57cBBdCDcb2', 'Phyllis', 'Maldonado', 'Costa PLC', 'yhanson@warner-diaz.org'),
(58, 'B5acdFC982124F2', 'Danny', 'Parrish', 'Novak LLC', 'howelldarren@house-cohen.com'),
(59, '8c7DdF10798bCC3', 'Kathy', 'Hill', 'Moore, Mccoy and Glass', 'ncamacho@boone-simmons.org'),
(60, 'C681dDd0cc422f7', 'Kelli', 'Hardy', 'Petty Ltd', 'kristopher62@oliver.com'),
(61, 'a940cE42e035F28', 'Lynn', 'Pham', 'Brennan, Camacho and Tapia', 'mpham@rios-guzman.com'),
(62, '9Cf5E6AFE0aeBfd', 'Shelley', 'Harris', 'Prince, Malone and Pugh', 'zachary96@mitchell-bryant.org'),
(63, 'aEcbe5365BbC67D', 'Eddie', 'Jimenez', 'Caldwell Group', 'kristiwhitney@bernard.com'),
(64, 'FCBdfCEAe20A8Dc', 'Chloe', 'Hutchinson', 'Simon LLC', 'leah85@sutton-terrell.com'),
(65, '636cBF0835E10ff', 'Eileen', 'Lynch', 'Knight, Abbott and Hubbard', 'levigiles@vincent.com'),
(66, 'fF1b6c9E8Fbf1ff', 'Fernando', 'Lambert', 'Church-Banks', 'fisherlinda@schaefer.net'),
(67, '2A13F74EAa7DA6c', 'Makayla', 'Cannon', 'Henderson Inc', 'scottcurtis@hurley.biz'),
(68, 'a014Ec1b9FccC1E', 'Tom', 'Alvarado', 'Donaldson-Dougherty', 'nicholsonnina@montgomery.info'),
(69, '421a109cABDf5fa', 'Virginia', 'Dudley', 'Warren Ltd', 'zvalencia@phelps.com'),
(70, 'CC68FD1D3Bbbf22', 'Riley', 'Good', 'Wade PLC', 'alex06@galloway.com'),
(71, 'CBCd2Ac8E3eBDF9', 'Alexandria', 'Buck', 'Keller-Coffey', 'lee48@manning.com'),
(72, 'Ef859092FbEcC07', 'Richard', 'Roth', 'Conway-Mcbride', 'aharper@maddox-townsend.org'),
(73, 'F560f2d3cDFb618', 'Candice', 'Keller', 'Huynh and Sons', 'buckleycory@odonnell.net'),
(74, 'A3F76Be153Df4a3', 'Anita', 'Benson', 'Parrish Ltd', 'angie04@oconnell.com'),
(75, 'D01Af0AF7cBbFeA', 'Regina', 'Stein', 'Guzman-Brown', 'zrosario@rojas-hardin.net'),
(76, 'd40e89dCade7b2F', 'Debra', 'Riddle', 'Chang, Aguirre and Leblanc', 'shieldskerry@robles.com'),
(77, 'BF6a1f9bd1bf8DE', 'Brittany', 'Zuniga', 'Mason-Hester', 'mchandler@cochran-huerta.org'),
(78, 'FfaeFFbbbf280db', 'Cassidy', 'Mcmahon', 'Mcguire, Huynh and Hopkins', 'katrinalane@fitzgerald.com'),
(79, 'CbAE1d1e9a8dCb1', 'Laurie', 'Pennington', 'Sanchez, Marsh and Hale', 'cookejill@powell.com'),
(80, 'A7F85c1DE4dB87f', 'Alejandro', 'Blair', 'Combs, Waller and Durham', 'elizabethbarr@ewing.com'),
(81, 'D6CEAfb3BDbaa1A', 'Leslie', 'Jennings', 'Blankenship-Arias', 'corey75@wiggins.com'),
(82, 'Ebdb6F6F7c90b69', 'Kathleen', 'Mckay', 'Coffey, Lamb and Johnson', 'chloelester@higgins-wilkinson.com'),
(83, 'E8E7e8Cfe516ef0', 'Hunter', 'Moreno', 'Fitzpatrick-Lawrence', 'isaac26@benton-finley.com'),
(84, '78C06E9b6B3DF20', 'Chad', 'Davidson', 'Garcia-Jimenez', 'justinwalters@jimenez.com'),
(85, '03A1E62ADdeb31c', 'Corey', 'Holt', 'Mcdonald, Bird and Ramirez', 'maurice46@morgan.com'),
(86, 'C6763c99d0bd16D', 'Emma', 'Cunningham', 'Stephens Inc', 'walter83@juarez.org'),
(87, 'ebe77E5Bf9476CE', 'Duane', 'Woods', 'Montoya-Miller', 'kmercer@wagner.com'),
(88, 'E4Bbcd8AD81fC5f', 'Alison', 'Vargas', 'Vaughn, Watts and Leach', 'vcantu@norton.com'),
(89, 'efeb73245CDf1fF', 'Vernon', 'Kane', 'Carter-Strickland', 'hilljesse@barrett.info'),
(90, '37Ec4B395641c1E', 'Lori', 'Flowers', 'Decker-Mcknight', 'tyrone77@valenzuela.info'),
(91, '5ef6d3eefdD43bE', 'Nina', 'Chavez', 'Byrd-Campbell', 'elliserica@frank.com'),
(92, '98b3aeDcC3B9FF3', 'Shane', 'Foley', 'Rocha-Hart', 'nsteele@sparks.com'),
(93, 'aAb6AFc7AfD0fF3', 'Collin', 'Ayers', 'Lamb-Peterson', 'dudleyemily@gonzales.biz'),
(94, '54B5B5Fe9F1B6C5', 'Sherry', 'Young', 'Lee, Lucero and Johnson', 'alan79@gates-mclaughlin.com'),
(95, 'BE91A0bdcA49Bbc', 'Darrell', 'Douglas', 'Newton, Petersen and Mathis', 'grayjean@lowery-good.com'),
(96, 'cb8E23e48d22Eae', 'Karl', 'Greer', 'Carey LLC', 'hhart@jensen.com'),
(97, 'CeD220bdAaCfaDf', 'Lynn', 'Atkinson', 'Ware, Burns and Oneal', 'vkemp@ferrell.com'),
(98, '28CDbC0dFe4b1Db', 'Fred', 'Guerra', 'Schmitt-Jones', 'swagner@kane.org'),
(99, 'c23d1D9EE8DEB0A', 'Yvonne', 'Farmer', 'Fitzgerald-Harrell', 'mccarthystephen@horn-green.biz'),
(100, '2354a0E336A91A1', 'Clarence', 'Haynes', 'Le, Nash and Cross', 'colleen91@faulkner.biz');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
