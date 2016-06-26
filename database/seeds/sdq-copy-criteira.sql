insert into criteria
  (label,
  `from`,
  to,
  questionaireID,
  groupID,
  created_at,
  updated_at)	
select
  label,
  `from`,
  to,
  36,
  groupID + 6,
  created_at,
  updated_at
from criteria
where questionaireID = 35;

###################################################################################

insert into criteria
  (label,
  `from`,
  to,
  questionaireID,
  groupID,
  created_at,
  updated_at)	
select
  label,
  `from`,
  to,
  37,
  groupID + 6,
  created_at,
  updated_at
from criteria
where questionaireID = 36;