-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mer 15 Mars 2017 à 14:00
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `siteMax`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci,
  `date` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `categorie_id`, `titre`, `contenu`, `date`, `image`, `image_url`) VALUES
(1, 1, 'La préparation physique en général.', '<p>Hey !! Altera sententia est, quae definit amicitiam paribus officiis ac voluntatibus. Hoc quidem est nimis exigue et exiliter ad calculos vocare amicitiam, ut par sit ratio acceptorum et datorum. Divitior mihi et affluentior videtur esse vera amicitia nec observare restricte, ne plus reddat quam acceperit; neque enim verendum est, ne quid excidat, aut ne quid in terram defluat, aut ne plus aequo quid in amicitiam congeratur. Paphius quin etiam et Cornelius senatores, ambo venenorum artibus pravis se polluisse confessi, eodem pronuntiante Maximino sunt interfecti. pari sorte etiam procurator monetae extinctus est. Sericum enim et Asbolium supra dictos, quoniam cum hortaretur passim nominare, quos vellent, adiecta religione firmarat, nullum igni vel ferro se puniri iussurum, plumbi validis ictibus interemit. et post hoe flammis Campensem aruspicem dedit, in negotio eius nullo sacramento constrictus. Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</p>', NULL, '868b3d117c5399e3dd3137bfadea4371.jpeg', '55f929696bfac042414522c85f3c3717.jpeg'),
(2, 1, 'La préparation vélo', '<p>Altera sententia est, quae definit amicitiam paribus officiis ac voluntatibus. Hoc quidem est nimis exigue et exiliter ad calculos vocare amicitiam, ut par sit ratio acceptorum et datorum. Divitior mihi et affluentior videtur esse vera amicitia nec observare restricte, ne plus reddat quam acceperit; neque enim verendum est, ne quid excidat, aut ne quid in terram defluat, aut ne plus aequo quid in amicitiam congeratur. Paphius quin etiam et Cornelius senatores, ambo venenorum artibus pravis se polluisse confessi, eodem pronuntiante Maximino sunt interfecti. pari sorte etiam procurator monetae extinctus est. Sericum enim et Asbolium supra dictos, quoniam cum hortaretur passim nominare, quos vellent, adiecta religione firmarat, nullum igni vel ferro se puniri iussurum, plumbi validis ictibus interemit. et post hoe flammis Campensem aruspicem dedit, in negotio eius nullo sacramento constrictus. Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</p>', NULL, 'img/ironVelo.jpg', '64e6b8ae838970eefee1704fedfd7a20.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `projet_id` int(11) NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `titre`, `contenu`, `image`, `projet_id`, `image_url`) VALUES
(1, 'Préparation', NULL, NULL, 1, NULL),
(2, 'L\'ironcorsaire', NULL, NULL, 1, NULL),
(3, 'Matériel', NULL, NULL, 1, NULL),
(4, 'test nouvelle cate', 'test', NULL, 2, '335dba3c2ad06bb7c630f85777a315ef.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `article_id`, `contenu`) VALUES
(62, 2, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus at commodi distinctio, dolore ducimus expedita facere id ipsam itaque, modi necessitatibus perferendis quaerat quis, quod recusandae reiciendis veritatis voluptate voluptatem.'),
(63, 2, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus at commodi distinctio, dolore ducimus expedita facere id ipsam itaque, modi necessitatibus perferendis quaerat quis, quod recusandae reiciendis veritatis voluptate voluptatem.'),
(64, 2, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus at commodi distinctio, dolore ducimus expedita facere id ipsam itaque, modi necessitatibus perferendis quaerat quis, quod recusandae reiciendis veritatis voluptate voluptatem.'),
(66, 2, 'test'),
(67, 2, 'test'),
(68, 2, 'test last qsdflqùmdgjqdglmj');

-- --------------------------------------------------------

--
-- Structure de la table `fos_user`
--

CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'maxime', 'maxime', 'contact@maximmeraguideau.com', 'contact@maximmeraguideau.com', 1, NULL, '$2y$13$BjZB4EgHqnADhkOH53W73.qgt414pDKSq5U3E3xb7tIP029RdC9rS', '2017-03-08 17:54:11', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `titre_menu` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`id`, `titre`, `contenu`, `image`, `image_url`, `titre_menu`) VALUES
(1, 'Ironcorsair', '<p>C\'est parti pour 3,8km de nage, 180km de v&eacute;lo et pour finir un marathon. C\'est une &eacute;preuve autant physique que psychologique, o&ugrave; il ne faut jamais voir le haut de l\'&eacute;chelle, mais simplement le prochain barreau, et se f&eacute;liciter de l\'avoir franchi. J\'ai appris le crawl pour l\'occasion, et je m\'en sort plut&ocirc;t bien en 1h01. Premi&egrave;re transition, premier changement de tenue et c\'est parti pour le v&eacute;lo, mon point faible, on me double, on me double... mais je dois rester humble, la course est encore longue! Apr&egrave;s 7h32 de v&eacute;lo, j\'arrive dans les derniers. Deuxi&egrave;me transition, dernier changement de tenue, derni&egrave;re &eacute;preuve... Je commence mon marathon et j\'entends d&eacute;j&agrave; des cris, le premier vient d\'arriver. Moi je pars pour mon premier tour de 14km, je devrais en faire 3. Je rattrape mon retard, mais il ne faut pas s\'enflammer... premier tour... deuxi&egrave;me tour... dernier tour...! J\'ai mainte et mainte fois r&ecirc;v&eacute; ce moment, passant la ligne d\'arriv&eacute;e, la rage, levant les bras en criant! Ou tombant &agrave; genoux... il est long ce dernier tour... Mais au loin se dessine l\'arche d\'arriv&eacute;e, au bout de la promenade du Sillon, j\'entends les cris de mes supporters, toujours l&agrave; depuis ce matin!! Il est 20h12, apr&egrave;s 13h32 de course, j\'ai pass&eacute; la ligne d\'arriv&eacute;e, debout, sans crier. J\'ai pleur&eacute; comme une fillette. J\'ai gagn&eacute; mon pari. J\'ai gagn&eacute; 10 euros.</p>', 'img/iron1.jpg', '84a77646302f0c38b53f646ceab591db.jpeg', 'Ironcorsair'),
(2, 'Haute randonnée pyrénéenne', '<p>Pitch hrp Mon ann&eacute;e 2016 a &eacute;t&eacute; marqu&eacute;e par l\'IronCorsair. Apr&egrave;s une tr&egrave;s longue p&eacute;riode de pr&eacute;paration, l\'&eacute;preuve mythique a &eacute;t&eacute; boucl&eacute;e, rendant d\'un coup possible tout un tas d\'exp&eacute;riences que je pensais auparavant r&eacute;serv&eacute;es aux conqu&eacute;rants de l\'impossible. Il est difficile de trouver de nouveaux buts, de nouveaux objectifs apr&egrave;s cela. Mais vous imaginez bien que si vous &ecirc;tes l&agrave;, c\'est que j\'ai trouv&eacute;! Apr&egrave;s m&ucirc;re r&eacute;flexion, me revoil&agrave; donc parti pour une nouvelle exp&eacute;rience... nettement plus longue, la HRP en solitaire. La Haute Route des Pyr&eacute;n&eacute;es, est une ligne imaginaire suivant les cr&ecirc;tes des Pyr&eacute;n&eacute;es, partant de Hendaye sur la c&ocirc;te atlantique et rejoignant Banyuls-sur-Mer sur la c&ocirc;te m&eacute;diterran&eacute;enne. Je dis ligne imaginaire car il n\'y a pas vraiment de trac&eacute; officiel, ni de chemins d\'ailleurs. En quelques chiffres, ma HRP c\'est environ 800km pour 42000m de d&eacute;nivel&eacute;, oscillant entre 1500m et 3400m, un parcours qui traverse 3 parcs nationaux, tant&ocirc;t en France, tant&ocirc;t en Espagne. Ma vie personnelle et mes engagements professionnels ajoutent une difficult&eacute; &agrave; ce d&eacute;fi, le temps. Annonc&eacute;e en 42 jours, je me fixe 30j de marche sur la p&eacute;riode la plus propice, les semaines 25 &agrave; 29, le tout en bivouac, avec tente, sac de couchage, r&eacute;chaud, balise (...) et ravitaillement sur le dos.</p>', 'img/hrp1.jpg', '5d1510ee02e7fd31242f6c92d302ba37.jpeg', 'HRP');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BFDD3168BCF5E72D` (`categorie_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3AF34668C18272` (`projet_id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D9BEC0C47294869C` (`article_id`);

--
-- Index pour la table `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT pour la table `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `FK_BFDD3168BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FK_3AF34668C18272` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `FK_D9BEC0C47294869C` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;
