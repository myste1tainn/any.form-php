insert into additional_inputs
(
name,
placeholder,
type,
choiceID,
created_at,
updated_at
)

select
name,
placeholder,
type,
choiceID + 115,
created_at,
updated_at
from additional_inputs
where id = 4;

##################################################################################################################

insert into additional_inputs
(
name,
placeholder,
type,
choiceID,
created_at,
updated_at
)

select
name,
placeholder,
type,
choiceID + 242,
created_at,
updated_at
from additional_inputs
where id = 4;