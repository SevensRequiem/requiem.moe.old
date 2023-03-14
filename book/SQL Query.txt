CREATE TABLE guestbook(
id int(5) NOT NULL auto_increment,
name varchar(60) NOT NULL default ' ',
email varchar(60) NOT NULL default ' ',
message text NOT NULL,
Primary key(id)
);