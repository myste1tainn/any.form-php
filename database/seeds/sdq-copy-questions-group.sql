insert into question_groups
(
id,
name,
label,
questionaireID,
created_at,
updated_at)
select
id + 6,
name,
label,
questionaireID + 1,
created_at,
updated_at
from question_groups
where questionaireID = 35


######################################################################################


insert into question_groups
(
id,
name,
label,
questionaireID,
created_at,
updated_at)
select
id + 6,
name,
label,
questionaireID + 1,
created_at,
updated_at
from question_groups
where questionaireID = 36