DROP TABLE countries;

CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(48) CHARACTER SET utf8 NOT NULL,
  `capital` varchar(48) CHARACTER SET utf8 NOT NULL,
  `area` int(20) NOT NULL,
  `population` int(20) NOT NULL,
  `continent` varchar(32) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO countries VALUES("1","Portugal","Lisboa","50000","200000","Europe");
INSERT INTO countries VALUES("3","България","София","110453","7547688","Европа");
INSERT INTO countries VALUES("4","Белгия","Брюксел","3068768","1013223","Европа");
INSERT INTO countries VALUES("5","Австрия","Виена","83233","8234344","Европа");
INSERT INTO countries VALUES("6","Китай","Пекин","93545556","15657878","Азия");
INSERT INTO countries VALUES("7","Чехия","Прага","783243","104657","Европа");
INSERT INTO countries VALUES("15","Бразилия","Бразилия","123455","754342","Южна Америка");
INSERT INTO countries VALUES("16","ru","ty","0","0","jyh");
INSERT INTO countries VALUES("17","re","er","0","0","er");



DROP TABLE project;

CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pin` int(11) NOT NULL,
  `name` varchar(48) CHARACTER SET utf8 NOT NULL,
  `location` varchar(84) CHARACTER SET utf8 NOT NULL,
  `production` varchar(48) CHARACTER SET utf8 NOT NULL,
  `gsm` int(24) NOT NULL,
  `tel` int(24) NOT NULL,
  `pass` varchar(12) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE table1;

CREATE TABLE `table1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(48) NOT NULL,
  `l_name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE table2;

CREATE TABLE `table2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(48) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `com_code` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

INSERT INTO table2 VALUES("45","djemi","sharkova@pirintex.com","1234567","a754da847186ac2165951d853e4a5aa7");
INSERT INTO table2 VALUES("46","alex","alex@pirintex.com","1154","148d128e73a03010c093e80d2b345105");
INSERT INTO table2 VALUES("47","dvaiska","dvaiska@abv.bg","123456789","13fe085264c7ac03358190d91419defc");
INSERT INTO table2 VALUES("58","radi","radi@abv.bg","12345","92a412a1a6df99270a759fd914f4c298");
INSERT INTO table2 VALUES("59","vladi","vladi@pirintex.com","123456","98a8ce8ffa215c3ae5c183521bf80af5");
INSERT INTO table2 VALUES("60","natali","natali@pirintex.com","123654789","593d34527e5cfa77efb59f69922d0045");
INSERT INTO table2 VALUES("61","djemile","djemi_1990@abv.bg","23111990","ccdb52deb2b29d5e3b283699c7b0332d");
INSERT INTO table2 VALUES("62","tan4e","tan4eto@abv.bg","1234567","290b136d36b130f38851b929f447bc04");
INSERT INTO table2 VALUES("63","ilianka","sladuranka@abv.bg","123654","240ed4056bf7058982cf7ae68c5d31ba");
INSERT INTO table2 VALUES("64","daniel","dani@pirintex.com","asdfg","e9d3f410ca3a4a7b55b1001b4aa6c9b3");
INSERT INTO table2 VALUES("65","emira","emi_sharkova@abv.bg","123456","71ee021b65c7ec971726f155f9a2734f");
INSERT INTO table2 VALUES("66","ivana","ivana@pirintex.com","1234567","d4f5c7650634f93c1da0158f572c517c");
INSERT INTO table2 VALUES("67","cvetelina","cveti@abv.bg","123456","18115a7f81cc54ffdcb2f9d6f6bf1ebb");
INSERT INTO table2 VALUES("68","fat","fat_sh@pirintex.com","1234","e593ac083c0c6b0d2ce554b675b575a0");
INSERT INTO table2 VALUES("69","djemile","djemile@gmail.com","123123123","17dbb0b5744fa6106c7a9295008324ef");
INSERT INTO table2 VALUES("70","sharo","sharko@gmail.com","147852369","c35efda747300d24b68f0b06c782c320");
INSERT INTO table2 VALUES("71","alex","alex@gmail.com","1234567","47939b567b2689f27b4520c9ab0b749d");
INSERT INTO table2 VALUES("72","musti","mustafa@abv.bg","123456789","0822db273c2d2ab373e5f232204141c1");
INSERT INTO table2 VALUES("73","teste","teste@teste.com","asdf","e7cd282613743dd6261471efb29da196");
INSERT INTO table2 VALUES("74","nuri","nuri@swu.bg","1234567","0ef870de8aac4c7b1b6d54de74c184cd");
INSERT INTO table2 VALUES("75","asq","asq@swu.bg","12345","402ab79128bc8ab8144929b8631c681e");
INSERT INTO table2 VALUES("76","setruy","djem@swu.bg","123456","2882a999254c9002bcfedd786ff1451e");
INSERT INTO table2 VALUES("77","admin","admin@pirintex.com","123456789","5cab4a1fa655c14dea42c4523efbb6fd");
INSERT INTO table2 VALUES("78","ina","in4e@swu.bg","12345","261b6c23f5274ec42352d6510391b9a0");
INSERT INTO table2 VALUES("79","djemi","djemile@pirintex.com","1234567","fbef58efb389c20056a8ea8f39a7d56f");
INSERT INTO table2 VALUES("80","asq","asa@abv.bg","1234567","434782a69e9f188d07a89aa6fca5da6f");
INSERT INTO table2 VALUES("81","admin","admin@abv.bg","123456789","97b54ceeb20e782d641494a5ad4ec0ee");



