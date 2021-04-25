create view `v_colony_skills` as
select s.`id` as skill, c.`id` as colony,
ifnull(sum(bs.`points`), 0) as building_points,
ifnull(sum(csu.`points`), 0) as owner_points,
ifnull(sum(csl.`points`), 0) as leader_points
from `skills` s
cross join `colonies` c
left join `colonyskills` cs on cs.`skill_id`=s.`id` and cs.`colony_id`=c.`id`
left join `colonybuildings` cb on cb.`colony_id`=c.`id`
left join `buildingskills` bs on bs.`skill_id`=s.`id` and bs.`building_id`=cb.`building_id`
left join `users` u on u.`id`=c.`owner_id`
left join `characterskills` csu on csu.`character_id`=u.`maincharacter_id` and csu.`skill_id`=s.`id`
left join `characterskills` csl on csl.`character_id`=c.`leader_id` and csl.`skill_id`=s.`id`
group by s.`id`, c.`id`;

