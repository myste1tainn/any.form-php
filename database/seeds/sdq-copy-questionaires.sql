insert into questionaires
	(
	id,
	parentID,
	name,
	header,
	level,
	created_at,
	updated_at,
	type
	)
select
	id + 1
	parentID,
	concat(name, ' อาจารย์ประเมิน'),
	header,
	1,
	created_at,
	updated_at,
	type
from questionaires
where id = 35

###############################################################

insert into questionaires
	(
	id,
	parentID,
	name,
	header,
	level,
	created_at,
	updated_at,
	type
	)
select
	id + 2
	parentID,
	concat(name, ' ผู้ปกครองประเมิน'),
	header,
	1,
	created_at,
	updated_at,
	type
from questionaires
where id = 35