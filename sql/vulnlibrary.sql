# noinspection SqlNoDataSourceInspectionForFile

--
-- テーブルの構造 `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `publisher` varchar(191) NOT NULL,
  `author` varchar(191) NOT NULL,
  `published` date NOT NULL,
  `del_flg` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- テーブルのデータのダンプ `books`
--

INSERT INTO `books` (`id`, `name`, `publisher`, `author`, `published`, `del_flg`, `created`, `modified`) VALUES
(1, '僕らが毎日やっている最強の読み方 ', '東洋経済新報社', '池上 彰', '2016-12-01', NULL, NULL, NULL),
(2, 'アマゾンと物流大戦争', 'NHK出版', '角井 亮一', '2016-09-01', NULL, NULL, NULL),
(3, '考える力がつく本 ', 'プレジデント社', '池上 彰', '2016-10-01', NULL, NULL, NULL),
(4, '60分でわかる!AIビジネス最前線', '技術評論社', 'AIビジネス研究会', '2016-11-01', NULL, NULL, NULL),
(5, '本を読む ', '山川出版社', '安野 光雅', '2016-12-01', NULL, NULL, NULL),
(6, '人間力を高める読書法 ', 'プレジデント社', '武田 鉄矢', '2016-12-01', NULL, NULL, NULL),
(7, '今すぐ使えるかんたんExcel 2016  ', '技術評論社', '技術評論社編集部', '2015-11-01', NULL, NULL, NULL),
(8, '絵本のあるくらし  ', '吉備人出版', 'プーさん文庫', '1999-08-01', 1, NULL, NULL),
(9, 'できるWord & Excel 2013困った!&便利技パーフェクトブック ', 'インプレスジャパン', '井上 香緒里', '2014-04-01', NULL, NULL, NULL),
(10, '将来の学力は10歳までの「読書量」で決まる! ', 'すばる舎', '松永 暢史', '2014-12-01', NULL, NULL, NULL);

INSERT INTO `books` (`id`, `name`, `publisher`, `author`, `published`, `del_flg`, `created`, `modified`)
SELECT
    (@row_number := @row_number + 11) AS `id`,
    SUBSTRING(MD5(RAND()), 1, 10) AS `name`,
    CONCAT('Publisher ', FLOOR(RAND() * 100)) AS `publisher`,
    CONCAT('Author ', FLOOR(RAND() * 100)) AS `author`,
    DATE_ADD('2023-01-01', INTERVAL FLOOR(RAND() * 365) DAY) AS `published`,
    NULL AS `del_flg`,
    NOW() AS `created`,
    NULL AS `modified`
FROM
    (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION
     SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION
     SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION
     SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20 UNION
     SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25 UNION
     SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30) AS `dummy`;
-- --------------------------------------------------------

--
-- テーブルの構造 `reserves`
--

CREATE TABLE `reserves` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reserved` date NOT NULL,
  `returned` date DEFAULT NULL,
  `del_flg` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `reserves` (`id`, `user_id`, `book_id`, `reserved`, `returned`, `del_flg`, `created`, `modified`) VALUES
(1, '1', '1', '2018-12-20', '2018-12-25', NULL, NULL, NULL),
(2, '1', '2', '2018-12-20', '2018-12-25', NULL, NULL, NULL),
(3, '1', '3', '2018-12-20', '2018-12-25', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login_id` varchar(191) NOT NULL,
  `passwd` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `is_admin` tinyint(4) DEFAULT NULL,
  `del_flg` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` (`id`, `login_id`, `passwd`, `name`, `is_admin`, `del_flg`, `created`, `modified`) VALUES
(1, 'nishikawa', 'Password!', 'nishikawa', NULL, NULL, NULL, NULL),
(2, 'admin', 'admin', '管理者', 1, NULL, NULL, NULL),
(3, 'test', 'test', 'テストユーザー', NULL, NULL, NULL, NULL);


-- --------------------------------------------------------

--
-- テーブルの構造 `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `del_flg` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reserves`
--
ALTER TABLE `reserves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
