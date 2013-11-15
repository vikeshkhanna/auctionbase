drop table if exists Time;

create table Time(now datetime);
insert into Time values("2001-12-20 00:00:01");
select now from Time;
