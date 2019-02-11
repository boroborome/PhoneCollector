create table students (
  id INT NOT NULL AUTO_INCREMENT,
  parent_name NVARCHAR(100) NOT NULL,
  baby_name NVARCHAR(100) NOT NULL,
  phone_num VARCHAR(100) NOT NULL,
  baby_age int(20) not null,
  create_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  --update_time timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  updater VARCHAR(100),
  PRIMARY KEY ( id )
) charset utf8;

create unique index students_phone on students(phone_num);
