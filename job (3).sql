-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 12:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_information`
--

CREATE TABLE `client_information` (
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_information`
--

INSERT INTO `client_information` (`client_id`) VALUES
(4),
(5),
(6),
(6),
(22),
(24),
(25),
(26),
(27),
(29),
(31),
(32),
(34),
(36),
(37),
(38),
(40),
(43),
(44),
(45),
(48);

-- --------------------------------------------------------

--
-- Table structure for table `instant_jobs`
--

CREATE TABLE `instant_jobs` (
  `inst_job_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `number_of_workers` int(11) NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `bargain_option` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_posts`
--

CREATE TABLE `job_posts` (
  `job_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `skills_and_requirements` text DEFAULT NULL,
  `number_of_workers` int(11) DEFAULT NULL,
  `fare` decimal(10,2) DEFAULT NULL,
  `is_instant_job` tinyint(1) DEFAULT NULL,
  `is_long_term_job` tinyint(1) DEFAULT NULL,
  `type` enum('instant','long_term') NOT NULL,
  `visibility` enum('everyone','all_contracts','invited_only') NOT NULL DEFAULT 'everyone',
  `can_bargain` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending' COMMENT 'pending, completed, cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_posts`
--

INSERT INTO `job_posts` (`job_id`, `client_id`, `title`, `description`, `skills_and_requirements`, `number_of_workers`, `fare`, `is_instant_job`, `is_long_term_job`, `type`, `visibility`, `can_bargain`, `created_at`, `latitude`, `longitude`, `status`) VALUES
(1, 5, ' Need Help with House Cleaning', 'I need someone to come by and clean my 2-bedroom apartment. Duties include vacuuming, mopping, dusting, and cleaning the bathroom and kitchen. I would prefer someone with previous experience, and all cleaning supplies will be provided. The job should take about 2-3 hours.', 'Attention to detail\r\nPrevious cleaning experience preferred\r\nReliable and punctual\r\nAbility to clean thoroughly within the time frame', 1, 2000.00, 1, 0, 'instant', 'everyone', 1, '2024-10-06 13:35:44', 23.750798, 90.421954, 'pending'),
(2, 5, 'Plumber Needed for Pipe Fixing', 'I\'m looking for a licensed plumber to fix a leaking pipe under my kitchen sink. It seems like the pipe may need to be replaced. I need this to be done as soon as possible. The job should be completed within an hour or two.', 'Certified plumber\r\nExperience with household plumbing\r\nQuick and efficient problem solving\r\nMust have own tools', 1, 1000.00, 1, 0, 'instant', 'all_contracts', 1, '2024-10-06 13:45:27', 23.750798, 90.421954, 'pending'),
(3, 4, 'Dog Walking Service Needed', 'Looking for someone to walk my two dogs (Labrador and Beagle) for 30 minutes daily in the evening. They are friendly, but they can be energetic. Please ensure you have experience with dogs and know how to handle them.', 'Experience with dog walking\r\nComfortable handling large dogs\r\nFriendly and trustworthy\r\nAvailable in the evenings', 1, 1500.00, 1, 0, 'instant', 'invited_only', 1, '2024-10-06 13:47:50', 23.750798, 90.421954, 'pending'),
(4, 4, 'Gardener Needed for Lawn Mowing and Hedge Trimming', 'I need a gardener to mow the lawn and trim the hedges in my backyard. It’s a medium-sized yard and should take around 2 hours. You must bring your own equipment.', 'Experience in lawn mowing and hedge trimming\r\nOwn lawn care tools and equipment\r\nAbility to work in an outdoor environment\r\nReliable and punctual', 1, 1200.00, 1, 0, 'instant', 'everyone', 1, '2024-10-06 13:49:08', 23.750798, 90.421954, 'pending'),
(5, 6, ' Handyman Required for Minor Home Repairs', 'I’m looking for a handyman to help with some small home repair tasks including fixing a loose door handle, replacing a light bulb in a high ceiling, and patching up a small hole in the drywall. The job should take no more than 2 hours.', 'General home repair experience\r\nAbility to work with basic tools\r\nAttention to detail\r\nReliable and trustworthy', 1, 500.00, 1, 0, 'instant', 'everyone', 1, '2024-10-06 13:50:22', 23.750798, 90.421954, 'pending'),
(15, 25, 'Electrician', 'I want an electrician to sort out our elcetric issues of home', 'Nothing', 1, 1400.00, 1, 0, 'instant', 'everyone', 1, '2024-10-11 07:35:12', 23.802865, 90.427846, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `seeker_information`
--

CREATE TABLE `seeker_information` (
  `seeker_id` int(11) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `age` varchar(5) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `education` varchar(20) DEFAULT NULL,
  `experience` varchar(20) DEFAULT NULL,
  `skills` varchar(20) DEFAULT NULL,
  `work_experience` varchar(20) DEFAULT NULL,
  `certification` varchar(20) DEFAULT NULL,
  `profile_description` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `profile_title` varchar(20) DEFAULT NULL,
  `accomplishments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seeker_information`
--

INSERT INTO `seeker_information` (`seeker_id`, `contact`, `age`, `address`, `city`, `education`, `experience`, `skills`, `work_experience`, `certification`, `profile_description`, `latitude`, `longitude`, `profile_title`, `accomplishments`) VALUES
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_information`
--

CREATE TABLE `users_information` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `role` enum('client','seeker') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_information`
--

INSERT INTO `users_information` (`user_id`, `firstname`, `lastname`, `email`, `password`, `country`, `contact`, `role`) VALUES
(4, 'Tailor', 'Swift', 'tailor@gmail.com', '$2y$10$m3tokn.db4hMXq42ywIxoeCLmG2FEvqnHaDS6RAChiQgEcE3aY8xO', 'Germany', NULL, 'client'),
(5, 'Bob', 'Dillan', 'bob@gmail.com', '$2y$10$J8Qltk9EWFCMhQKavRRsb.ZLyynTaWqCdWJ7FZEPH6JJA4kbVw3YG', 'Argentina', NULL, 'client'),
(6, 'Billie ', 'Ilish', 'billie@gmail.com', '$2y$10$DCIsMAnGX7E/fLDlOitEFOe9QnRrnbo7x830iFC62vaomwJN2gY16', 'Mexico', NULL, 'client'),
(15, 'Milly', 'Michel', 'milly@gmail.com', '$2y$10$uZaWnQDt9uy9Qp7HrBGJC.2l.UkEqBHvFL0Nvl7C1a2LhyojzCDLO', 'Poland', NULL, 'seeker'),
(16, 'Selena', 'Gomes', 'selena@gmail.com', '$2y$10$Xx.HilB.G7Ulo1o4i7IFHeDY9Q0uPgApPLhfWwsq9XK44zjnddyle', 'Mexico', NULL, 'seeker'),
(17, 'Tasnema ', 'Ferdous', 'tasnema@gmail.com', '$2y$10$yXTwUe14IpoKggQR9mkSWu8HxSNaiBP83N1Xw.Bwo5l1fwIHUTbNK', 'Australia', NULL, 'seeker'),
(18, 'Justin', 'Beiber', 'justin@gmail.com', '$2y$10$dczH7GYYxubOMgJjyMlbpOtJXjes7/XByluYTlcSG2Qcafxc4xKNm', 'Uganda', NULL, 'seeker'),
(21, 'Helen', 'Killer', 'helen@gmail.com', '$2y$10$VWaIIFR/btvtlUxwT3pKMucZjFANIIO6IbTNuU1RJ19fGA/IfctRy', 'Greece', NULL, 'seeker'),
(22, 'Maynul Hossen', 'sabuj', 'maynulsabuj111@gmail.com', '$2y$10$yW4Tl1LcEMAOXs0y0MP.XeTCBn7TqXdGfvInADQJDJte5eMRSv9wy', 'Bangladesh', NULL, 'client'),
(23, 'Maynul Hossen', 'sabuj', 'maynulsabuj11@gmail.com', '$2y$10$VnYD7atHJGo5chKxj5bYxOCm60mSwYBRDXHoLtDdkIQd9XZL8EHqm', 'Bangladesh', NULL, 'seeker'),
(24, 'John', 'Doe', 'john@gmail.com', '$2y$10$JdCOshYg04xah3cKiw.DAe04MoD9cLfrUjh5rkMX/4mXza1Oz6D56', 'Barbados', NULL, 'client'),
(25, 'John', 'Do', 'john1@gmail.com', '$2y$10$EfcEEhRXnrDwS6IoDQvHceuBBBN/Efya/VIJSslZDB7s18b/9cfjC', 'Bangladesh', NULL, 'client'),
(26, 'Md.Maynul', 'Hossen', 'mhossen@gmail.com', '$2y$10$heSHYF/kIybaVKzFpbGoNePQnXU3L0gdXaKrJU3TE5y.PCxF3OQGC', 'Bangladesh', NULL, 'client'),
(27, 'Maynul', 'Hossen', 'mhossen22@gmail.com', '$2y$10$J2KcFx9DZTDVlJ4iyCZjceFupvG4y8Jt7yRAveDH54MjaH3MFR7y2', 'Bangladesh', NULL, 'client'),
(28, 'John', 'Wick', 'wick@gmail.com', '$2y$10$YRD1eeZPOuA5DnjvjcuH9e/xH/U9gol0w7sU4pFmkQp3e28vUTkLG', 'Bangladesh', NULL, 'seeker'),
(29, 'Md.Maynul', 'Hossen', 'msabuj11@gmail.com', '$2y$10$ThekgbJmzYKM6w1M61akK.RdQxPhT0sZTs.pkjpBFgjX9lql7EqXi', 'Bangladesh', NULL, 'client'),
(30, 'John', 'Wick', 'john23@gmail.com', '$2y$10$vxhlrj7lp1m4G1VEcBKU.eKCiWRWoZZA9lnD/QpkD5qOWWkG6PLTq', 'Bangladesh', NULL, 'seeker'),
(31, 'Maynul', 'Sabuj', 'maynul@gmail.com', '$2y$10$ZpT9SscSYqlzohLvVhC7OubbFBQXITd7C29.uSb0wGGPfoBkRnt16', 'Bangladesh', NULL, 'client'),
(32, 'Maynul', 'Hossen', 'maynul11111@gmail.com', '$2y$10$vFMF9C63qPkec5J2Ha2pG./X3lC0k/3tc5W5ict4PBh.w.G8cJftC', 'Bangladesh', NULL, 'client'),
(33, 'John', 'Doe', 'Doe111@gmail.com', '$2y$10$ffBR1Ayg72LYA32wC80NyebMq0o.7vuImlWcSAOHgXXdSJbtAuEzW', 'Bangladesh', NULL, 'seeker'),
(34, 'Maynul', 'Sabuj', 'sabuj11111@gmail.com', '$2y$10$slgQE7TuwveoTfsVcg9RWelIZuCbPcn6d6KEzuYGhXwmA0ccdIykC', 'Bangladesh', NULL, 'client'),
(35, 'John', 'Doe', 'John123@gmail.com', '$2y$10$b8VjDXTB/gbX947ZdedHAO/nVjAu/OFVKh8G.FL0cfJlpa1RuBzxu', 'Bangladesh', NULL, 'seeker'),
(36, 'Maynul Hossen', 'sabuj', 'maynulls11@gmail.com', '$2y$10$oUgxM00/ok00Y0dUKawvi.RPYAFcftzNyFbNRyz0FHAbHV72wvk5W', 'Bangladesh', NULL, 'client'),
(37, 'Maynul Hossen', 'sabuj', 'maynul1@gmail.com', '$2y$10$NRe1fpv2CpASLSfaDEaL.eNZ0SQ52goEP/mAjQpOn9L8i10O11N.u', 'Bangladesh', NULL, 'client'),
(38, 'Maynul Hossen', 'sabuj', 'mmaynulsabuj111@gmail.com', '$2y$10$zyt/GMTo9G6GYcXFVHnMBeXijFewXFjeWF165VJf0qHsBBTj3/85u', 'Bangladesh', NULL, 'client'),
(39, 'Maynul Hossen', 'sabuj', 'mmmaynulsabuj111@gmail.com', '$2y$10$SzbvhOmn9B8Pe0Cqb66WDOG7/fmbNTzRu2XCivV8WtsgxE0XMFfWG', 'Bangladesh', NULL, 'seeker'),
(40, 'Maynul Hossen', 'sabuj', 'maynul234@gmail.com', '$2y$10$UWGZxA7nrv40nL681jB6ee833Z29.575/fblxy1l01w9SrMlnObTW', 'Bangladesh', NULL, 'client'),
(41, 'Maynul Hossen', 'sabuj', 'maynulsabuj11333331@gmail.com', '$2y$10$Tq3wTOXgiFb9ZLjA4kbMRe1t33d6SjVw8L4jFxef//44HQysoA3NW', 'Bangladesh', NULL, 'seeker'),
(42, 'Maynul Hossen', 'sabuj', 'maynulsabuj11222221@gmail.com', '$2y$10$mHTrfyE5Jik4RBRgyMzzLuWdcQhNHRZ2nOzFs8rzhCsB.q/Q7Kq6W', 'Bangladesh', NULL, 'seeker'),
(43, 'Maynul Hossen', 'sabuj', 'maynulsabuj111111111@gmail.com', '$2y$10$zPmDkJyf83G4SbUhJ2Nyn.hLT/UVSMEJ8BsI48kS/Y.gd5sDMeRh.', 'Bangladesh', NULL, 'client'),
(44, 'Maynul Hossen', 'sabuj', 'maynulsabuj11111111111@gmail.com', '$2y$10$SkcITNbhQBvSLSj6/9HptuPQkBRxJVooVHqh6lodJms7BzjkmEaNm', 'Bangladesh', NULL, 'client'),
(45, 'Maynul Hossen', 'sabuj', 'maynulsabuj11122122111@gmail.com', '$2y$10$w0CssAh5Elt2xQl7KoyfGuxyYLlDPeGcPeXyrksZ/Z5s2B4HQDd6a', 'Bangladesh', NULL, 'client'),
(46, 'Maynul Hossen', 'sabuj', 'maynulsabuj11234551@gmail.com', '$2y$10$M.YUfCDcWTgM08TtIi05TOGhaagG3SszwKupG95MoeqkVEqGCq5Mm', 'Bangladesh', NULL, 'seeker'),
(47, 'Maynul Hossen', 'sabuj', 'maynulsabuj132111@gmail.com', '$2y$10$M9SVU9kXOVnbQNjBis257uCgiJINs./7/T2UeuDUb5pwnH4UlPoAK', 'Bangladesh', NULL, 'seeker'),
(48, 'Maynul Hossen', 'sabuj', 'maynulsabuj118756551@gmail.com', '$2y$10$Z/M1xZtR4qviZZ.3QASUXuHKGzcfVgi8r965AodgTCcZHt8JArCoW', 'Bangladesh', NULL, 'client'),
(49, 'Maynul Hossen', 'sabuj', 'maynulsabuj11cxbdgwnhj1@gmail.com', '$2y$10$WXjV1R4A6wzSqJdITmske..R8r.oSBR6sBLX90N8hW21CwwPQN5.6', 'Bangladesh', NULL, 'seeker');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_information`
--
ALTER TABLE `client_information`
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `instant_jobs`
--
ALTER TABLE `instant_jobs`
  ADD PRIMARY KEY (`inst_job_id`);

--
-- Indexes for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `seeker_information`
--
ALTER TABLE `seeker_information`
  ADD PRIMARY KEY (`seeker_id`);

--
-- Indexes for table `users_information`
--
ALTER TABLE `users_information`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instant_jobs`
--
ALTER TABLE `instant_jobs`
  MODIFY `inst_job_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users_information`
--
ALTER TABLE `users_information`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_information`
--
ALTER TABLE `client_information`
  ADD CONSTRAINT `client_information_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users_information` (`user_id`);

--
-- Constraints for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD CONSTRAINT `job_posts_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users_information` (`user_id`);

--
-- Constraints for table `seeker_information`
--
ALTER TABLE `seeker_information`
  ADD CONSTRAINT `seeker_information_ibfk_1` FOREIGN KEY (`seeker_id`) REFERENCES `users_information` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
