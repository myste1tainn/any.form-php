insert into choices

(label,
name,
description,
note,
value,
type,
enabled,
questionID,
parentID,
created_at,
updated_at)

select

label,
name,
description,
note,
value,
type,
enabled,
questionID + 159,
IF(parentID = 429, parentID + 115, parentID + 112),
created_at,
updated_at

from choices
where questionID > 56
and questionID < 90;


###################################################################################################


insert into choices

(label,
name,
description,
note,
value,
type,
enabled,
questionID,
parentID,
created_at,
updated_at)

select

label,
name,
description,
note,
value,
type,
enabled,
questionID + 222,
IF(parentID = 429, parentID + 242, parentID + 239),
created_at,
updated_at

from choices
where questionID > 56
and questionID < 90