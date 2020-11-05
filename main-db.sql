-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2020 at 08:23 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_lte`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notification`
--

CREATE TABLE `admin_notification` (
  `id` bigint(20) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `type` tinyint(2) NOT NULL COMMENT 'p = post,\r\nu = user',
  `dateTime` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `parent`, `status`) VALUES
(15, 'Sports', 'This is Sports category.', 0, 1),
(25, 'International', '', 0, 1),
(26, 'National', '', 0, 1),
(27, 'Education', '', 0, 1),
(28, 'Technology', '', 0, 1),
(29, 'Science', '', 0, 1),
(31, 'Entertainment', '', 0, 1),
(33, 'Religion', '', 0, 1),
(38, 'Business', NULL, 0, 1),
(39, 'Cricket', NULL, 15, 1),
(41, 'Football', '', 15, 1),
(86, 'Space', '', 29, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `frontend_index_main_section`
-- (See below for the actual view)
--
CREATE TABLE `frontend_index_main_section` (
`p_id` int(11)
,`title` varchar(250)
,`description` varchar(200)
,`image` text
,`dateTimePosted` datetime
,`categoryId` int(11)
,`authorId` int(11)
,`categoryName` varchar(250)
,`catId` int(11)
,`authorName` varchar(155)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `frontend_index_main_section_without_national_sorting_view`
-- (See below for the actual view)
--
CREATE TABLE `frontend_index_main_section_without_national_sorting_view` (
`p_id` int(11)
,`title` varchar(250)
,`description` longtext
,`shortDescription` varchar(200)
,`tags` varchar(250)
,`image` text
,`dateTimePosted` datetime
,`categoryId` int(11)
,`authorId` int(11)
,`categoryName` varchar(250)
,`catId` int(11)
,`catParent` int(11)
,`authorName` varchar(155)
);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `p_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` longtext NOT NULL,
  `image` text NOT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 = Draf\r\n1= Published',
  `dateTimePosted` datetime NOT NULL,
  `categoryId` int(11) NOT NULL,
  `authorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`p_id`, `title`, `description`, `image`, `tags`, `status`, `dateTimePosted`, `categoryId`, `authorId`) VALUES
(11, 'শিক্ষা প্রতিষ্ঠানের ছুটি বাড়ল ৩১ অক্টোবর পর্যন্ত', 'শিক্ষাপ্রতিষ্ঠানের চলমান ছুটি ৩১ অক্টোবর পর্যন্ত বাড়ানো হয়েছে। আজ  বৃহস্পতিবার শিক্ষা মন্ত্রণালয়ের এক সংবাদ বিজ্ঞপ্তিতে এ কথা জানানো হয়েছে। এর আগে গতকাল বুধবার শিক্ষামন্ত্রী দীপু মনি জানিয়েছিলেন, শিক্ষাপ্রতিষ্ঠানের ছুটি বাড়বে। কারণ, এই মুহূর্তে শিক্ষাপ্রতিষ্ঠান খোলার মতো পরিস্থিত নেই।\r\n করোনাভাইরাসের কারণে গত ১৭ মার্চ থেকে দেশের সব শিক্ষাপ্রতিষ্ঠানে ছুটি চলছে। দফায় দফায় ছুটি বাড়িয়ে তা আগামী ৩ অক্টোবর পর্যন্ত করা হয়। এবার তা বাড়িয়ে ৩১ অক্টোবর পর্যন্ত করা হলো।\r\n\r\n করোনার বাস্তবতায় দীর্ঘদিন ধরে শিক্ষাপ্রতিষ্ঠানগুলো বন্ধ থাকায় প্রায় চার কোটি শিক্ষার্থীর পড়াশোনা অত্যন্ত ঝুঁকিতে পড়েছে। বাংলাদেশ শিক্ষা তথ্য ও পরিসংখ্যান ব্যুরোর তথ্য বলছে, দেশের মোট শিক্ষার্থীদের মধ্যে প্রাথমিক পর্যায়ে পড়ে প্রায় পৌনে দুই কোটি ছেলেমেয়ে। আর মাধ্যমিক পর্যায়ে শিক্ষার্থীর সংখ্যা সোয়া কোটির কিছু বেশি। বাকিরা অন্যান্য স্তরে পড়ছেন। এমন অবস্থায় শিক্ষক, শিক্ষার্থী ও অভিভাবকদের জিজ্ঞাসা ছিল ছুটি কি আরও বাড়বে, নাকি খুলে দেওয়া হবে শিক্ষাপ্রতিষ্ঠান। এই পরিস্থিতিতে আজ আবার ছুটি বাড়ানোর ঘোষণা এল।', '996426_20201002_021043_education_news.jpg', 'শিক্ষা প্রতিষ্ঠানের ছুটি,education', 1, '2020-10-02 02:38:43', 27, 19),
(13, 'দেশের মানুষ সব বাধা অতিক্রম করতে সক্ষম: প্রধানমন্ত্রী', 'প্রধানমন্ত্রী শেখ হাসিনা বলেছেন, বাংলাদেশের মানুষ সব ধরনের বাধা অতিক্রম করার সক্ষমতা রাখে। তিনি বলেছেন, ‘সবার সহযোগিতায় আমরা দেশকে এগিয়ে নিয়ে যাচ্ছি। এ জন্য আমি দেশের জনগণকে ধন্যবাদ জানাই। করোনাভাইরাস না এলে আমরা আরও অনেক কাজ করতে পারতাম। তবে যা কিছুই হোক না কেন, বাংলাদেশের জনগণ সব প্রতিবন্ধকতা অতিক্রম করার সক্ষমতা রাখে।’', '46072_20201002_021019_nat.jpg', 'sheikh hasina,প্রধানমন্ত্রী', 1, '2020-10-02 02:45:19', 26, 21),
(15, 'LUNAR LIEUTENANTS US Space Force to build first military base on the MOON – with robot troops', 'Speaking at an Air Force conference on Tuesday, US Space Command leader John Shaw said that he sees space soldiers as part of the military’s future plans.\r\n\r\n\"At some point, yes, we will be putting humans into space,\" Shaw told virtual attendees at the AFWERX Engage Space Conference, C4ISRNET reports.\r\n\r\n\"They may be operating a command centre somewhere in the lunar environment or someplace else that we are continuing to operate architecture that is largely autonomous.\"\r\n\r\nThe comments come days after the US Space Force – a new military branch dedicated to space warfare – partnerned with Nasa on several objectives including human spaceflight and planetary defence.\r\n\r\nMaj. Gen. Shaw admitted that while Space Force hopes to put troops in orbit, that day is a long way off.', '823239_20201002_021009_space.jpg', 'space,moon', 1, '2020-10-02 02:51:09', 86, 21),
(18, 'BD Covid-19 Daily Boletin', 'The Directorate General of Health Services (DGHS) disclosed the information through a press release in the afternoon.\r\n\r\nAs per the press release, 1,591 more patients recovered from Covid-19 in the last 24 hours to take the total recoveries in the country to 277,078.\r\n\r\nDuring the period, 11,420 samples were tested in 108 labs across the country. With this, a total of 1,959,075 samples have so far been tested in the country.\r\n\r\nThe positivity rate -- an indicator of the prevalence of the disease -- was recorded at 13.20 percent in the last 24 hours while the overall positivity rate is 18.63 percent.\r\n\r\nThe recovery rate continued to rise in Bangladesh reaching 75.79 percent while the mortality rate is 1.44 percent, one of the lowest in the world.\r\n\r\nOn Tuesday, Bangladesh recorded 32 deaths and 1,436 infections from coronavirus after testing 13,404 samples with a positivity rate of 10.71 percent.\r\n\r\nMeanwhile, the death toll from coronavirus has surged to 1,018,791 around the world as of Thursday morning.\r\n\r\nBesides, the virus has so far infected 34,159,055 people in different countries, according to Worldometer.\r\n \r\nOf the currently infected 7,709,821 patients, 7,643,916 are in mild condition while 65,905 are in serious or critical condition.\r\n\r\nSo far, 25,430,443 people have made recovery from the disease in different countries.\r\n\r\nThe US is the worst-hit country with highest cases and deaths in the world at 7,447,282 and 211,740 respectively while India has 2nd highest cases of 6,312,584 and Brazil has 2nd highest deaths of 143,962.', '68136_20201002_031042_corona-10611-lg.jpg', 'covid-19,corona', 1, '2020-10-02 03:59:42', 26, 19),
(19, 'HSC, equivalent examinations cancelled, evaluation to be based on JSC, SSC results', 'The education ministry has decided to cancel this year\'s Higher Secondary Certificate (HSC) and its equivalent examinations.\r\n\r\nThe examinees will be evaluated based on the results of the two public examinations they took previously -- Junior School Certificate (JSC) and Secondary School Certificate (SSC) and their equivalent examinations -- Education Minister Dipu Moni revealed while holding a virtual press conference this afternoon.\r\n\r\nThe evaluation of the candidates will be published by December this year, the minister hoped.\r\n\r\n\"The decision has been taken keeping in mind the well-being of the examinees and their family members across the country,\" Dipu Moni said.\r\n\r\nHSC and equivalent exams slated for April 1 were postponed on March 22 out of fear of coronavirus transmission.', '476252_20201007_191019_dipu_moni-1wb_0.jpg', 'education,bd hsc exam,hsc 2020', 1, '2020-10-07 19:29:19', 27, 26),
(21, 'Protests against rape continue across Bangladesh', 'People from different walks of life, including students, staged demonstrations across the country for the 4th consecutive day on Thursday as anger mounted over the growing incidents of rape and sexual harassment of women, reports UNB. \r\n\r\nPeople in different parts of the country took to the streets and raised their voices demanding that rapists be given stringent punishment.', '614534_20201009_001053_prothomalo-english_2020-10_cf1b686c-a708-4e82-94df-b540965a088d_2.jpg', 'protest,rape', 1, '2020-10-09 00:48:53', 26, 21),
(22, 'Bollywood actor Sushant case: Forensic dept hints at suicide, not murder', 'The forensic department of the All India Institute of Medical Sciences (AIIMS) in its report to the Central Bureau of Investigation (CBI) has \"hinted\" that the death of Bollywood actor Sushant Singh Rajput was suicide and not murder, sources said on Saturday.\r\n\r\nThe AIIMS forensic panel under physician Sudhir Gupta was formed at the request of the CBI in August to assist in giving medico-legal opinion in connection with the death of the late actor.\r\n\r\nAccording to AIIMS sources, the forensic team in its report has hinted the death of Sushant as suicide, thus rejecting the claims of \'poisoning\' and \'strangling\' made by the actor\'s family and their lawyer.', '236690_20201009_001050_susthant.jpg', 'bollywood,Sushant', 1, '2020-10-09 00:51:50', 31, 21),
(23, 'Indonesia focuses on finalising trade agreement with Bangladesh', 'Indonesia has vowed to finalise Indonesia Bangladesh Free Trade Agreement (IBTA) with Bangladesh to boost bilateral trade, reports news agency BSS.\r\n\r\nThe commitment has come at the FBCCI Cloud Conference titled ‘Bilateral Trade and Investment Opportunities in the Ongoing Global Pandemic and Beyond’ under the joint initiative the Indonesian Chambers of Commerce and Industry (KADIN), said a press release.', '630595_20201009_001037_ind_bd.jpg', 'trade agreement,Indonesia Bangladesh', 0, '2020-10-09 00:53:37', 38, 26),
(24, 'COVID-positive Trump says \'no\' to virtual debate', 'US president Donald Trump, who is still being treated for COVID-19, said Thursday he will refuse to take part in the presidential debate next week after it was switched to a virtual format.\r\n\r\n\"I\'m not going to do a virtual debate,\" he told Fox Business News, saying this was \"not acceptable to us.\"\r\n\r\nHe accused the bipartisan debate commission of trying to \"protect\" his opponent Joe Biden.', '657066_20201009_001036_prothomalo-english_2020-10.jpg', 'donald trump,usa election', 1, '2020-10-09 00:54:36', 25, 26),
(25, 'HP unit starts training camp after long COVID-19 hiatus', 'The high-performance unit of Bangladesh Cricket Board (BCB) has started a training camp after a long gap due to coronavirus pandemic on Wednesday at the academy ground in Mirpur.\r\n\r\nNaimur Rahman Durjoy, the chairman of HP, said this camp will continue to the last week of November.', '774923_20201009_001025_aoaokdjdj.jpg', 'bd cricket', 1, '2020-10-09 00:59:25', 39, 19),
(28, 'Nathaniel Clyne returns to Crystal Palace on short-term contract', 'Having missed last season with cruciate knee ligament damage, Clyne has trained with Palace over recent weeks in a bid to regain his fitness and played 45 minutes for the U23s against Aston Villa earlier this month.\r\n\r\nHe told the club\'s official website: \"I\'m a London boy, this is where I grew up. I\'m back home and all my family and friends are here.\r\n\r\n\r\nHaving missed last season with cruciate knee ligament damage, Clyne has trained with Palace over recent weeks in a bid to regain his fitness and played 45 minutes for the U23s against Aston Villa earlier this month.\r\n\r\nHe told the club\'s official website: \"I\'m a London boy, this is where I grew up. I\'m back home and all my family and friends are here.', '118560_20201015_021051_skysports-nathaniel-clyne-crystal-palace_5115941.jpg', 'football', 1, '2020-10-15 02:32:51', 41, 19),
(31, 'Dummy Sports Post', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '808804_20201021_201015_test_post.jpg', 'sports,dummy', 1, '2020-10-21 20:56:15', 15, 19),
(33, 'Demo post', 'Ichigo Kurosaki is a fictional character in the Bleach manga series and its adaptations created by Tite Kubo. He is the main protagonist of the series, who receives Soul Reaper powers after befriending Rukia Kuchiki, the Soul Reaper assigned to patrol around the fictional city of Karakura Town. Wikipedia\r\n\r\nIchigo Kurosaki is a fictional character in the Bleach manga series and its adaptations created by Tite Kubo. He is the main protagonist of the series, who receives Soul Reaper powers after befriending Rukia Kuchiki, the Soul Reaper assigned to patrol around the fictional city of Karakura Town. Wikipedia', '32515_20201021_211058_test_post.jpg', 'demo', 1, '2020-10-21 21:52:58', 38, 52),
(34, 'The diabolical ironclad beetle can survive getting run over by a car. Here’s how', '<p>The <strong>diabolical</strong> ironclad beetle is like a tiny tank on six legs. This insect&rsquo;s rugged exoskeleton is so tough that the beetle can survive getting run over by cars, and many would-be predators don&rsquo;t stand a chance of cracking one open. Phloeodes diabolicus is basically nature&rsquo;s jawbreaker. Analyses of microscope images, 3-D printed models and computer simulations of the beetle&rsquo;s armor have now revealed the secrets to its strength. Tightly interlocked and impact-absorbing structures that connect pieces of the beetle&rsquo;s exoskeleton help it survive enormous crushing forces, researchers report in the Oct. 22 Nature. Those features could inspire new, sturdier designs for things such as body armor, buildings, bridges and vehicles. The diabolical ironclad beetle, which dwells in desert regions of western North America, has a distinctly hard-to-squish shape. &ldquo;Unlike a stink beetle, or a Namibian beetle, which is more rounded &hellip; it&rsquo;s low to the ground [and] it&rsquo;s flat on top,&rdquo; says David Kisailus, a materials scientist at the University of California, Irvine. In compression experiments, Kisailus and colleagues found that the beetle could withstand around <strong>39,000</strong> times its own body weight. That would be like a person shouldering a stack of about 40 M1 Abrams battle tanks. Within the diabolical ironclad beetle&rsquo;s own tanklike physique, two key microscopic features help it withstand crushing forces. The first is a series of connections between the top and bottom halves of the exoskeleton. &ldquo;You can imagine the beetle&rsquo;s exoskeleton almost like two halves of a clamshell sitting on top of each other,&rdquo; <em>Kisailus</em> says. Ridges along the outer edges of the top and bottom latch together.</p>', '704903_20201022_121023_102020_mt_ironclad-beetle_feat-1028x579.jpg', 'diabolical', 1, '2020-10-22 12:49:23', 29, 19);

-- --------------------------------------------------------

--
-- Stand-in structure for view `postview`
-- (See below for the actual view)
--
CREATE TABLE `postview` (
`p_id` int(11)
,`title` varchar(250)
,`description` longtext
,`image` text
,`tags` varchar(250)
,`status` tinyint(1)
,`dateTimePosted` datetime
,`categoryId` int(11)
,`authorId` int(11)
,`userName` varchar(155)
,`userId` int(11)
,`userRole` int(1)
,`categoryName` varchar(250)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `single_post`
-- (See below for the actual view)
--
CREATE TABLE `single_post` (
`p_id` int(11)
,`title` varchar(250)
,`description` longtext
,`image` text
,`tags` varchar(250)
,`status` tinyint(1)
,`dateTimePosted` datetime
,`categoryId` int(11)
,`authorId` int(11)
,`singlePostCategoryName` varchar(250)
,`singlePostAuthorName` varchar(155)
,`authorRole` int(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `site_visitor`
--

CREATE TABLE `site_visitor` (
  `vid` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `dateRegistered` date NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '0 = unverified,\r\n1 = verified/active,\r\n2 = suspended,\r\n3 = deactivated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_visitor`
--

INSERT INTO `site_visitor` (`vid`, `name`, `email`, `password`, `dateRegistered`, `status`) VALUES
(1, 'Min Hyuk', 'renji@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-10-23', 1),
(22, 'Rukia Kuchuki', 'rukia@yahoo.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-10-23', 1),
(23, 'Edward Elric', 'edward@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-10-23', 2),
(24, 'Yeon Ah', 'seo@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-10-23', 1),
(25, 'Ishin Kuroaski', 'ishin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2020-10-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_visitor_comments_on_post`
--

CREATE TABLE `site_visitor_comments_on_post` (
  `cid` bigint(20) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `dateTime` datetime NOT NULL,
  `pid` int(11) NOT NULL,
  `vid` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '0 = hidden, 1 = public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_visitor_comments_on_post`
--

INSERT INTO `site_visitor_comments_on_post` (`cid`, `comment`, `dateTime`, `pid`, `vid`, `status`) VALUES
(50, 'First Comment!', '2020-10-24 17:27:58', 21, 1, 1),
(51, 'So sad :( :I', '2020-10-24 19:33:16', 21, 24, 0),
(52, 'Good news.', '2020-10-24 19:35:21', 19, 24, 1),
(53, 'WoW, great!', '2020-10-24 19:35:40', 15, 24, 1),
(54, 'Yayyyyy....', '2020-10-24 19:36:58', 11, 24, 1),
(55, 'This is so bad :(', '2020-10-24 19:37:26', 21, 22, 1),
(56, 'ohhhhh', '2020-10-24 19:37:49', 34, 22, 0),
(57, 'BD cricket fighting!', '2020-10-24 19:38:07', 25, 22, 1),
(58, 'এগিয়ে যাক দেশ!', '2020-10-24 19:38:34', 13, 22, 1),
(59, 'First Comment!', '2020-10-25 14:03:18', 34, 25, 1),
(60, 'Second comment!!!!!!', '2020-10-25 14:03:36', 34, 25, 0),
(61, 'Hey I\'m here again', '2020-10-25 14:04:47', 21, 22, 1),
(62, 'Ooohhhh Nooooo', '2020-10-25 14:05:13', 18, 22, 1),
(63, 'TEst Comment edited', '2020-10-25 14:05:47', 33, 24, 1),
(64, 'My third comment updated', '2020-10-25 14:13:49', 21, 22, 0),
(65, '2nd comment', '2020-10-25 14:14:36', 34, 25, 1),
(66, 'Im first', '2020-10-25 14:14:50', 33, 25, 1),
(67, 'WOW', '2020-10-25 14:16:12', 34, 24, 0),
(68, 'So sad edit', '2020-10-25 14:31:28', 21, 25, 0),
(69, 'Nice one', '2020-10-25 14:32:12', 34, 24, 1),
(70, 'Im first', '2020-10-25 14:32:23', 31, 24, 0),
(71, 'I\'m angry', '2020-10-25 14:34:07', 21, 24, 1),
(72, 'Hola', '2020-10-31 21:06:16', 21, 1, 0),
(73, 'Heiiii', '2020-10-31 21:06:21', 21, 1, 0),
(74, 'haahhaaaa', '2020-10-31 21:06:26', 21, 1, 0),
(75, 'aaaaaaaa', '2020-10-31 21:07:00', 21, 1, 0),
(76, 'aaaaaaaaaaaaaaaaaaaacccccccccc', '2020-10-31 21:07:05', 21, 1, 0),
(77, 'First', '2020-11-03 18:16:49', 18, 25, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sv_comments_onp_view`
-- (See below for the actual view)
--
CREATE TABLE `sv_comments_onp_view` (
`cid` bigint(20)
,`comment` varchar(250)
,`dateTime` datetime
,`pid` int(11)
,`vid` int(11)
,`status` tinyint(2)
,`visitorName` varchar(150)
,`visitorStatus` tinyint(2)
,`postTitle` varchar(250)
);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `address` varchar(250) DEFAULT 'N/A',
  `phone` varchar(50) NOT NULL,
  `role` int(1) NOT NULL COMMENT '1 = Admin, 2 = Moderator',
  `status` tinyint(1) NOT NULL COMMENT '0 = in-active, 1 = active',
  `image` text DEFAULT NULL,
  `joinedDate` date NOT NULL,
  `bio` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `address`, `phone`, `role`, `status`, `image`, `joinedDate`, `bio`) VALUES
(19, 'Saleh Ibne Omar', 'salehibneomar@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Dhaka-1212', '01700000000', 1, 1, '52149_salehibneomar_20201027_221039_35599978.jpg', '2020-09-23', 'I\'m the developer of this app 😀'),
(21, 'Pranto', 'pranto@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Mohakhali, Dhaka', '01800000000', 1, 1, '3349_pranto_20201002_031045_pranto.jpg', '2020-09-25', 'Love this app.'),
(26, 'Rikuo', 'nura@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Dhaka - 1127', '01300000000', 2, 1, '48170_rikuo_20201026_181042_nura.jpg', '2020-09-26', 'Very nice app.'),
(52, 'Ichigo Kurosaki', 'ichigo@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'N/A', '01200000000', 2, 1, '', '2020-10-21', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `widget_category_counts_view`
-- (See below for the actual view)
--
CREATE TABLE `widget_category_counts_view` (
`widgetCategoryName` varchar(250)
,`counts` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `frontend_index_main_section`
--
DROP TABLE IF EXISTS `frontend_index_main_section`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `frontend_index_main_section`  AS  select `p`.`p_id` AS `p_id`,`p`.`title` AS `title`,substr(`p`.`description`,1,200) AS `description`,`p`.`image` AS `image`,`p`.`dateTimePosted` AS `dateTimePosted`,`p`.`categoryId` AS `categoryId`,`p`.`authorId` AS `authorId`,`c`.`name` AS `categoryName`,`c`.`id` AS `catId`,`u`.`name` AS `authorName` from ((`post` `p` join `category` `c`) join `user` `u`) where `p`.`status` = 1 and `p`.`categoryId` = `c`.`id` and `p`.`authorId` = `u`.`id` order by field(`c`.`name`,'National') desc,`p`.`p_id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `frontend_index_main_section_without_national_sorting_view`
--
DROP TABLE IF EXISTS `frontend_index_main_section_without_national_sorting_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `frontend_index_main_section_without_national_sorting_view`  AS  select `p`.`p_id` AS `p_id`,`p`.`title` AS `title`,`p`.`description` AS `description`,substr(`p`.`description`,1,200) AS `shortDescription`,`p`.`tags` AS `tags`,`p`.`image` AS `image`,`p`.`dateTimePosted` AS `dateTimePosted`,`p`.`categoryId` AS `categoryId`,`p`.`authorId` AS `authorId`,`c`.`name` AS `categoryName`,`c`.`id` AS `catId`,`c`.`parent` AS `catParent`,`u`.`name` AS `authorName` from ((`post` `p` join `category` `c`) join `user` `u`) where `p`.`status` = 1 and `p`.`categoryId` = `c`.`id` and `p`.`authorId` = `u`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `postview`
--
DROP TABLE IF EXISTS `postview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `postview`  AS  select `p`.`p_id` AS `p_id`,`p`.`title` AS `title`,`p`.`description` AS `description`,`p`.`image` AS `image`,`p`.`tags` AS `tags`,`p`.`status` AS `status`,`p`.`dateTimePosted` AS `dateTimePosted`,`p`.`categoryId` AS `categoryId`,`p`.`authorId` AS `authorId`,`u`.`name` AS `userName`,`u`.`id` AS `userId`,`u`.`role` AS `userRole`,`c`.`name` AS `categoryName` from ((`post` `p` join `user` `u`) join `category` `c`) where `p`.`categoryId` = `c`.`id` and `p`.`authorId` = `u`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `single_post`
--
DROP TABLE IF EXISTS `single_post`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `single_post`  AS  select `p`.`p_id` AS `p_id`,`p`.`title` AS `title`,`p`.`description` AS `description`,`p`.`image` AS `image`,`p`.`tags` AS `tags`,`p`.`status` AS `status`,`p`.`dateTimePosted` AS `dateTimePosted`,`p`.`categoryId` AS `categoryId`,`p`.`authorId` AS `authorId`,`c`.`name` AS `singlePostCategoryName`,`u`.`name` AS `singlePostAuthorName`,`u`.`role` AS `authorRole` from ((`post` `p` join `category` `c`) join `user` `u`) where `p`.`status` = 1 and `p`.`categoryId` = `c`.`id` and `p`.`authorId` = `u`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `sv_comments_onp_view`
--
DROP TABLE IF EXISTS `sv_comments_onp_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sv_comments_onp_view`  AS  select `cmt`.`cid` AS `cid`,`cmt`.`comment` AS `comment`,`cmt`.`dateTime` AS `dateTime`,`cmt`.`pid` AS `pid`,`cmt`.`vid` AS `vid`,`cmt`.`status` AS `status`,`v`.`name` AS `visitorName`,`v`.`status` AS `visitorStatus`,`p`.`title` AS `postTitle` from ((`site_visitor_comments_on_post` `cmt` join `site_visitor` `v`) join `post` `p`) where `cmt`.`pid` = `p`.`p_id` and `cmt`.`vid` = `v`.`vid` ;

-- --------------------------------------------------------

--
-- Structure for view `widget_category_counts_view`
--
DROP TABLE IF EXISTS `widget_category_counts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `widget_category_counts_view`  AS  select `c`.`name` AS `widgetCategoryName`,count(`p`.`p_id`) AS `counts` from (`category` `c` left join `post` `p` on((`p`.`categoryId` in (select `category`.`id` from `category` where `category`.`parent` = `c`.`id` and `category`.`status` = 1) or `p`.`categoryId` = `c`.`id`) and `p`.`status` = 1)) where `c`.`status` = 1 group by `c`.`name` order by `c`.`name` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `authorId` (`authorId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `site_visitor`
--
ALTER TABLE `site_visitor`
  ADD PRIMARY KEY (`vid`);

--
-- Indexes for table `site_visitor_comments_on_post`
--
ALTER TABLE `site_visitor_comments_on_post`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `site_visitor`
--
ALTER TABLE `site_visitor`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `site_visitor_comments_on_post`
--
ALTER TABLE `site_visitor_comments_on_post`
  MODIFY `cid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
