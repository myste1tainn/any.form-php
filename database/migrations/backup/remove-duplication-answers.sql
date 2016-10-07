# delete duplicate resutls
delete from questionaire_results where id in (
	select id from (
		select id from questionaire_results
		where questionaireID = 35
		and participantID in (
			select participantID from (
				select participantID, count(participantID) from questionaire_results
				where questionaireID = 35
				group by participantID
				having count(participantID) > 1
			) b
		)
		and id not in (
			select max(id) from questionaire_results
			where questionaireID = 35
			and participantID in (
				select participantID from (
					select participantID, count(participantID) from questionaire_results
					where questionaireID = 35
					group by participantID
					having count(participantID) > 1
				) b
			)
			group by participantID
		)
	) a
);

# delete duplicate answers
delete from participant_answers
where id in (
	select id from 
	(
		select id 
		from participant_answers a
		inner join (
			select maxID, participantID, questionID, choiceID from (
				select max(id) as maxID, participantID, questionID, choiceID, count(*) as c from participant_answers
				group by participantID, questionID, choiceID
				having c > 1
			) a
		) b 
		on a.participantID = b.participantID 
		and a.questionID = b.questionID 
		and a.choiceID = b.choiceID
		and a.id <> b.maxID
	) dd
)
;