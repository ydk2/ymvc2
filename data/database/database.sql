SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS sitedata;
CREATE TABLE IF NOT EXISTS sitedata (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  string TEXT DEFAULT '',
  access int(11) DEFAULT 9,
  groups varchar(255) NOT NULL DEFAULT 'main'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO sitedata (name, string) VALUES('page_title_str', 'Ymvc <small>System</small>');
INSERT INTO sitedata (name, string) VALUES('page_subtitle_str', 'Subtitle of this page');
INSERT INTO sitedata (name, string) VALUES('footer_title_str', 'Footer Header');
INSERT INTO sitedata (name, string) VALUES('page_short_title_str', 'Ymvc');
INSERT INTO sitedata (name, string) VALUES('footer_content_str', 'Footer Contents.');

DROP TABLE IF EXISTS translatedstrings;
CREATE TABLE IF NOT EXISTS translatedstrings (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name TEXT DEFAULT '',
  string TEXT DEFAULT '',
  access int(11) DEFAULT 9,
  groups varchar(255) NOT NULL DEFAULT 'main',
  lang varchar(11) DEFAULT 'en'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Contents.', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc <small>System</small>', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Subtitle of this page','', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Header', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Start', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('About Us', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Contact', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Table', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('New', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Old', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('File', '', 'en');

INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Contents.', 'Zawartość Stopki.', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc <small>System</small>', 'Ymvc <small>System</small>', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc', '', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Subtitle of this page', 'Podtytuł strony', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Header', 'Nagłówek stopki', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Start', 'Start', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('About Us', 'O Nas', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Contact', 'Kontakt', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Table', 'Tabela', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('New', 'Nowy', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Old', 'Stary', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('File', 'Plik', 'pl');


DROP TABLE IF EXISTS menus;
CREATE TABLE IF NOT EXISTS menus (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  pos int(11) NOT NULL,
  title varchar(255) NOT NULL,
  link varchar(255) NOT NULL,
  parent varchar(255) NOT NULL DEFAULT '',
  access int(11) DEFAULT 9,
  groups varchar(255) NOT NULL DEFAULT 'main',
  lang varchar(11) DEFAULT 'en'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(1, 'Start', 'start', '',9,'en');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(2, 'About Us', 'about', '',9,'en');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(3, 'Contact', 'contact', '',9,'en');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(4, 'Table', 'http://localhost/ymvc/?table=table', 'Start',9,'en');

INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(1, 'Start', 'start', '',9,'pl');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(2, 'O nas', 'about', '',9,'pl');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(3, 'Kontakt', 'contact', '',9,'pl');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(4, 'Tabela', 'http://localhost/ymvc/?table=table', 'Start',9,'pl');

DROP TABLE IF EXISTS pages;
CREATE TABLE IF NOT EXISTS pages (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) DEFAULT '',
  access int(11) DEFAULT 9,
  groups varchar(255) DEFAULT 'main',
  link varchar(255) DEFAULT '',
  content TEXT DEFAULT '',
  lang varchar(11) DEFAULT 'en',
  ctime int(11) DEFAULT 0,
  mtime int(11) DEFAULT 0
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO pages (id, title, access, groups, link, content, lang, ctime) VALUES(1, 'Start', 9,'main', 'start', 'the start page','en',1464551025);
INSERT INTO pages (id, title, access, groups, link, content, lang, ctime) VALUES(2, 'About Us',9, 'main', 'about', 'About Us','en',1464551025);
INSERT INTO pages (id, title, access, groups, link, content, lang, ctime) VALUES(3, 'Contact',9, 'main', 'contact', 'Contact with Us','en',1464551025);

INSERT INTO pages (id, title, access, groups, link, content, lang, ctime) VALUES(4, 'Start', 9,'main', 'start', 'Strona startowa','pl',1464551025);
INSERT INTO pages (id, title, access, groups, link, content, lang, ctime) VALUES(5, 'O Nas',9, 'main', 'about', 'Hej to o Nas','pl',1464551025);
INSERT INTO pages (id, title, access, groups, link, content, lang, ctime) VALUES(6, 'Kontakt',9, 'main', 'contact', 'Napisz do nas','pl',1464551025);

DROP TABLE IF EXISTS test;
CREATE TABLE IF NOT EXISTS test (
  id int(115) NOT NULL,
  title varchar(115) NOT NULL,
  parent int(115) NOT NULL,
  link varchar(115) NOT NULL,
  content text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO test (id, title, parent, link, content) VALUES(1, 'a', 0, 'a', 'a');
INSERT INTO test (id, title, parent, link, content) VALUES(4, 'b', 0, 'b', 'a');
INSERT INTO test (id, title, parent, link, content) VALUES(5, 'c', 0, 'c', 'a chuj');
INSERT INTO test (id, title, parent, link, content) VALUES(6, 'd', 0, 'd', 'a');
INSERT INTO test (id, title, parent, link, content) VALUES(7, 'e', 0, 'e', 'a');
INSERT INTO test (id, title, parent, link, content) VALUES(8, 'f', 4, 'f', 'a dupa');
INSERT INTO test (id, title, parent, link, content) VALUES(2, 'x', 0, 'x', 'a');
INSERT INTO test (id, title, parent, link, content) VALUES(9, 'z', 0, 'z', 'a');

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL PRIMARY KEY,
  name varchar(20) NOT NULL UNIQUE,
  email varchar(20) NOT NULL UNIQUE,
  password char(40) NOT NULL,
  role varchar(11) DEFAULT 'user',
  role_id int(11) NOT NULL DEFAULT 9,
  first_name varchar(99) DEFAULT '',
  last_name varchar(99) DEFAULT '',
  address varchar(199) DEFAULT '',
  phone varchar(20) DEFAULT '',
  description TEXT DEFAULT '',
  lang varchar(11) DEFAULT 'en'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO users (id, name, email, password, role, role_id) VALUES(1, 'admin', 'admin@localhost.to', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin',0);
INSERT INTO users (id, name, email, password, role, role_id) VALUES(2, 'me', 'me@be.mu', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'editor',7);
INSERT INTO users (id, name, email, password, role, role_id) VALUES(3, 'kupa', 'kupa@kibel.tu', '36a32e96cbfd11fd98e8c98e38d9ad9b41f57f1a', 'user',9);

