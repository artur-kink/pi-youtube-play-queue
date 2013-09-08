drop table history;

create table history(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	ip nvarchar(16),
	video nvarchar(255),
	title nvarchar(255),
	duration nvarchar(10),
	played bit default 0,
	reqtime timestamp
);

drop table checkhistory;

create table checkhistory(
	checktime timestamp
);
