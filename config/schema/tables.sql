CREATE TABLE sessions (
  id char(40) PRIMARY KEY, 
  created datetime DEFAULT current_timestamp(), 
  modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(), 
  data blob DEFAULT NULL, 
  expires int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE users (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  username varchar(20) NOT NULL, 
  password varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE user_sessions (
  user_id int(11) NOT NULL,
  session_id char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 
