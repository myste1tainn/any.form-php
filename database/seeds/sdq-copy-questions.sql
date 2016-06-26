insert into questions
(`order`,
label,
name,
description,
type,
questionaireID,
groupID,
created_at,
updated_at)
select
  `order`,
  label,
  name,
  description,
  type,
  questionaireID + 1,
  groupID + 6,
  created_at,
  updated_at
from questions
where questionaireID = 35


#############################################################################################


insert into questions
(`order`,
label,
name,
description,
type,
questionaireID,
groupID,
created_at,
updated_at)
select
  `order`,
  label,
  name,
  description,
  type,
  questionaireID + 1,
  groupID + 6,
  created_at,
  updated_at
from questions
where questionaireID = 36