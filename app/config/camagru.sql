SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `camagru`;

CREATE TABLE `comment` (
  `id` int(30) NOT NULL,
  `user` int(30) NOT NULL,
  `photo` int(30) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `comment` (`id`, `user`, `photo`, `message`, `createdAt`, `updatedAt`, `deleted`) VALUES
(265, 33, 5, 'йцу', '2018-10-03 14:51:31', NULL, b'0'),
(266, 33, 4, 'йцу', '2018-10-03 14:51:32', NULL, b'0'),
(267, 33, 4, 'яяя', '2018-10-03 14:51:34', NULL, b'0'),
(275, 33, 6, ':D :D :D', '2018-10-04 13:02:52', NULL, b'0'),
(276, 34, 1, 'Haha, funny Sasha ))', '2018-10-04 13:03:09', NULL, b'0'),
(277, 34, 3, 'Love you &lt;3', '2018-10-04 13:03:14', NULL, b'0'),
(278, 17, 2, 'Wow girl', '2018-10-04 13:04:01', NULL, b'0'),
(286, 33, 11, 'Nice ^_^', '2018-10-04 15:29:22', NULL, b'0');



CREATE TABLE `like` (
  `id` int(30) NOT NULL,
  `user` int(30) NOT NULL,
  `photo` int(30) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `like` (`id`, `user`, `photo`, `createdAt`, `updatedAt`, `deleted`) VALUES
(351, 17, 2, '2018-09-21 14:40:38', NULL, b'0'),
(374, 34, 3, '2018-09-26 11:25:12', NULL, b'0'),
(384, 34, 4, '2018-09-28 08:57:46', NULL, b'0'),
(387, 34, 2, '2018-09-28 09:45:34', NULL, b'0'),
(388, 34, 1, '2018-09-28 09:45:35', NULL, b'0'),
(391, 33, 7, '2018-09-28 13:02:53', NULL, b'0'),
(395, 33, 1, '2018-10-03 12:20:48', NULL, b'0'),
(397, 33, 2, '2018-10-03 12:32:35', NULL, b'0'),
(399, 33, 3, '2018-10-03 14:28:23', NULL, b'0'),
(405, 36, 6, '2018-10-04 14:12:27', NULL, b'0'),
(408, 36, 3, '2018-10-04 14:12:29', NULL, b'0'),
(409, 36, 10, '2018-10-04 14:12:54', NULL, b'0');



CREATE TABLE `photo` (
  `id` int(30) NOT NULL,
  `user` int(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL,
  `likes_amount` int(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `photo` (`id`, `user`, `url`, `createdAt`, `updatedAt`, `likes_amount`) VALUES
(1, 33, '/uploads/2018-09-18-qqq.png', '2018-09-18 10:51:06', NULL, 0),
(2, 17, '/uploads/2018-09-18-qwe.png', '2018-09-18 10:57:22', NULL, 0),
(3, 17, '/uploads/2018-09-18-azs.png', '2018-09-20 13:53:26', NULL, 0),
(6, 33, '/uploads/photo_5bb4e130e75ef1538580784.947686.gif', '2018-10-03 15:33:05', NULL, 0),
(11, 33, '/uploads/photo_5bb62f3dc92de1538666301.824023.png', '2018-10-04 15:18:21', NULL, 0);



CREATE TABLE `user` (
  `id` int(30) NOT NULL,
  `username` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `password` varchar(130) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notification` tinyint(1) NOT NULL DEFAULT '1',
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `tokenValidated` varchar(100) DEFAULT NULL,
  `tokenLost` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `user` (`id`, `username`, `name`, `password`, `email`, `notification`, `validated`, `createdAt`, `updatedAt`, `deleted`, `tokenValidated`, `tokenLost`) VALUES
(17, 'admin2', 'admin', '4e0658d00f47d86d19a0e792e4bb94b16db2e902d307da5637f57cf60e7a174cb4bb6d7095621745b2065df0c87b77af69f5d0fbd63359ad3cc6b72f076c3e1e', 'admin@gmail.com', 0, 1, '2018-09-13 14:11:45', NULL, b'0', NULL, NULL),
(33, 'pavliuk', 'Alex Pavliuk', '4e0658d00f47d86d19a0e792e4bb94b16db2e902d307da5637f57cf60e7a174cb4bb6d7095621745b2065df0c87b77af69f5d0fbd63359ad3cc6b72f076c3e1e', 'pavliuk@gmail.com', 1, 1, '2018-09-18 10:21:02', NULL, b'0', '', NULL),
(34, 'zaza', 'zaza', '4e0658d00f47d86d19a0e792e4bb94b16db2e902d307da5637f57cf60e7a174cb4bb6d7095621745b2065df0c87b77af69f5d0fbd63359ad3cc6b72f076c3e1e', 'zaza3@gmail.com', 0, 1, '2018-09-25 08:20:33', NULL, b'0', '', NULL),
(35, 'kaka2', 'kaka', 'fd9d94340dbd72c11b37ebb0d2a19b4d05e00fd78e4e2ce8923b9ea3a54e900df181cfb112a8a73228d1f3551680e2ad9701a4fcfb248fa7fa77b95180628bb2', 'jaja@jaja.com', 1, 0, '2018-09-28 08:42:10', NULL, b'0', '85MvywyfphQeqxnjYdmCj6TSlWGRfiiSZHJKQ88C0MZGwYhjrS6fe5dc7bdc746918ed7028b5398805bc', NULL),
(36, 'aaaa', 'dddd', '47e9b25f7e69eb4ff72c0aea103c90a6d18cf6ff0338655f74af95bcb520fe7c47f64254dd383ad07563df8e73bbb9f2c3b208a0663ffd9f0fed69abe286ebc8', 'neznam.ua@gmail.com', 1, 1, '2018-10-04 13:15:14', NULL, b'0', '', NULL),
(37, 'admin112', 'Вадим Любко', 'cfd6db2d5800215f84c2455945c233c6f8404554960771a0d444a9905edcaa3aeffa0c32b1ba34bc4156580123f540a412d7822cb07abd164607149850fcc1e6', 'neznam.ua1@gmail.com', 1, 0, '2018-10-04 14:05:44', NULL, b'0', 'vAUMeJKh6s9iseRvAsFVUxJWkXe7kOikiOWTA2Ev1jpum1giHG335b3386835ef2ee16472008ebee52b1', NULL);


ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);


ALTER TABLE `like`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);


ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);


ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);


ALTER TABLE `comment`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;


ALTER TABLE `like`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;


ALTER TABLE `photo`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;


ALTER TABLE `user`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;
