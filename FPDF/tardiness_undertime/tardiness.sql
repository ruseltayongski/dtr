CREATE DEFINER=`root`@`localhost` PROCEDURE `TardinessUndertimePermanent`(IN datein_from VARCHAR(20), IN datein_to VARCHAR(20))
    READS SQL DATA
    DETERMINISTIC
BEGIN
SELECT
	logs.userid,
    logs.name,
    logs.datein,
    logs.sched,
    logs.dayname,
    logs.am_in,
    logs.am_out,
    logs.pm_in,
    logs.pm_out,
    (
		CONCAT(logs.am_in,'|',logs.am_out,'|',logs.pm_in,'|',logs.pm_out)
    ) time,
    logs.late,
    logs.total_late
from(
	SELECT user.userid as userid,UPPER(CONCAT(user.lname,', ',user.fname)) as name,dtr.datein,sched.id sched,DAYNAME(dtr.datein) dayname,
	(
		COALESCE(
			(SELECT CONCAT(dtr1.time,"_",IF(dtr1.remark = "MOBILE","U","")) time from dtr_file dtr1 where
				dtr1.userid = user.userid and
				#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
				dtr1.time < "12:00" and
				dtr1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #NORMAL LOGS
			(SELECT CONCAT("SO #",so1.remark,"_BUI_",so1.time) time from so_logs so1 where
				so1.userid = user.userid and
				so1.event = "IN" and
				so1.time = "08:00:00" and
				so1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #SO LOGS
			(SELECT CONCAT("CDO","_BUI_",cdo1.time) time from cdo_logs cdo1 where
				cdo1.userid = user.userid and
				cdo1.event = "IN" and
				cdo1.time = "08:00:00" and
				cdo1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #CDO LOGS
			(SELECT CONCAT(leave1.remark,"_BUI_",leave1.time,'_leave') time from leave_logs leave1 where
				leave1.userid = user.userid and
				leave1.event = "IN" and
				leave1.time = "08:00:00" and
				leave1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #LEAVE LOGS
			(SELECT CONCAT(edited1.time,"_BUI") from edited_logs edited1 where
				edited1.userid = user.userid and
				edited1.event = "IN" and
				edited1.time < "12:00:00" and
				edited1.edited = 1 and
				edited1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #EDITED LOGS
			(SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday1 where
				holiday1.userid = "001" and
				holiday1.event = "IN" and
				holiday1.time = "08:00:00" and
				holiday1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #HOLIDAY LOGS
			(SELECT CONCAT("JO BREAK_BUI_",jo_break1.time,"_jobreak") time from edited_logs jo_break1 where
				jo_break1.userid = user.userid and
				jo_break1.event = "IN" and
				jo_break1.time = "08:00:00" and
				jo_break1.remark = "JO BREAK" and
				jo_break1.edited = 2 and
				jo_break1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #JO BREAK LOGS
			(SELECT CONCAT("TO #",to1.remark,"_BUI_",to1.time,'_to') time from edited_logs to1 where
				to1.userid = user.userid and
				to1.event = "IN" and
				to1.time = "08:00:00" and
				to1.edited = 3 and
				to1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
			(SELECT CONCAT(dtr1.time,"__",dtr1.time,"_normal") time from dtr_file dtr1 where
				dtr1.userid = user.userid and
				dtr1.event = "ID-UNKNOWN" and
				dtr1.time < "12:00:00" and
				dtr1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #NORMAL LOGS
			"empty_BUI_empty_empty"
		)
    ) am_in,
    (
		COALESCE(
			IF(
				COALESCE(
					(SELECT time from dtr_file dtr2 where
						dtr2.userid = user.userid and
						dtr2.event = "OUT" and
						dtr2.time >= "12:00:00" and
						dtr2.time < "13:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					),
					(SELECT time from dtr_file dtr2 where
						dtr2.userid = user.userid and
						dtr2.event = "OUT" and
						dtr2.time > "9:30:00" and
						dtr2.time < "12:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME DESC
						LIMIT 1
					),
					(SELECT time from dtr_file dtr2 where
						dtr2.userid = user.userid and
						dtr2.event = "OUT" and
						dtr2.time >= "13:00:00" and
						dtr2.time < "15:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					)
				) #if first condition
				<
				COALESCE(
					(SELECT time from dtr_file dtr3 where
						dtr3.userid = user.userid and
						dtr3.event = "IN" and
						dtr3.time >= "12:00:00" and
						dtr3.time < "13:00:00" and
						dtr3.datein = dtr.datein
						ORDER BY TIME DESC
						LIMIT 1
					),
					(SELECT time from dtr_file dtr3 where
						dtr3.userid = user.userid and
						dtr3.event = "IN" and
						dtr3.time >= "13:00:00" and
						dtr3.time < "17:00:00" and
						dtr3.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					),
					"17:00:00" #SET DEFAULT WHEN IT RETURN NULL
				), #IF SECOND CONDITION
				COALESCE(
					(SELECT CONCAT(dtr2.time,"_",IF(dtr2.remark = "MOBILE","U",""),'_',dtr2.time,"_",IF(dtr2.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr2.latitude,"empty"),'_',COALESCE(dtr2.longitude,"empty")) time from dtr_file dtr2 where
						dtr2.userid = user.userid and
						dtr2.event = "OUT" and
						dtr2.time >= "12:00:00" and
						dtr2.time < "13:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					),
					(SELECT CONCAT(dtr2.time,"_",IF(dtr2.remark = "MOBILE","U",""),'_',dtr2.time,"_",IF(dtr2.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr2.latitude,"empty"),'_',COALESCE(dtr2.longitude,"empty")) time from dtr_file dtr2 where
						dtr2.userid = user.userid and
						dtr2.event = "OUT" and
						dtr2.time > "09:30:00" and
						dtr2.time < "12:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME DESC
						LIMIT 1
					),
					(SELECT CONCAT(dtr2.time,"_",IF(dtr2.remark = "MOBILE","U",""),'_',dtr2.time,"_",IF(dtr2.remark = "MOBILE","mobile","normal")) time from dtr_file dtr2 where
						dtr2.userid = user.userid and
						dtr2.event = "OUT" and
						dtr2.time >= "13:00:00" and
						dtr2.time < "15:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					)
				), #if true
				COALESCE(
					(SELECT CONCAT("SO #",so2.remark,"_BUI_",so2.time,'_so') time from so_logs so2 where
						so2.userid = user.userid and
						so2.event = "OUT" and
						so2.time = "12:00:00" and
						so2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #SO LOGS
					(SELECT CONCAT("CDO_BUI_",cdo2.time,'_cdo') time from cdo_logs cdo2 where
						cdo2.userid = user.userid and
						cdo2.event = "OUT" and
						cdo2.time = "12:00:00" and
						cdo2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #CDO LOGS
					(SELECT CONCAT(leave2.remark,"_BUI_",leave2.time,'_leave') time from leave_logs leave2 where
						leave2.userid = user.userid and
						leave2.event = "OUT" and
						leave2.time = "12:00:00" and
						leave2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #LEAVE LOGS
					(SELECT CONCAT(edited2.time,"_BUI_",edited2.time,'_edited') from edited_logs edited2 where
						edited2.userid = user.userid and
						edited2.event = "OUT" and
						edited2.time > "8:00:00" and
						edited2.time <= "14:00:00" and
						edited2.edited = 1 and
						edited2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #EDITED LOGS
					(SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday2 where
						holiday2.userid = "001" and
						holiday2.event = "OUT" and
						holiday2.time = "12:00:00" and
						holiday2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #HOLIDAY LOGS
					(SELECT CONCAT("JO BREAK_BUI_",jo_break2.time,"_jobreak") time from edited_logs jo_break2 where
						jo_break2.userid = user.userid and
						jo_break2.event = "OUT" and
						jo_break2.time = "12:00:00" and
						jo_break2.remark = "JO BREAK" and
						jo_break2.edited = 2 and
						jo_break2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #JO BREAK LOGS
					(SELECT CONCAT("TO #",to2.remark,"_BUI_",to2.time,'_to') time from edited_logs to2 where
						to2.userid = user.userid and
						to2.event = "OUT" and
						to2.time = "12:00:00" and
						to2.edited = 3 and
						to2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #TO LOGS
					"empty_BUI_empty_empty"
				) #if false
			), #end if
			"empty_BUI_empty_empty"
		)
    ) am_out,
    (
		COALESCE(
			(SELECT CONCAT(dtr3.time,"_",IF(dtr3.remark = "MOBILE","U",""),'_',dtr3.time,'_',IF(dtr3.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr3.latitude,"empty"),'_',COALESCE(dtr3.longitude,"empty")) time from dtr_file dtr3 where
				dtr3.userid = user.userid and
				dtr3.event = "IN" and
				dtr3.time >= "12:00:00" and
				dtr3.time < "13:00:00" and
				dtr3.datein = dtr.datein
				ORDER BY TIME DESC
				LIMIT 1
			),
			(SELECT CONCAT(dtr3.time,"_",IF(dtr3.remark = "MOBILE","U",""),'_',dtr3.time,'_',IF(dtr3.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr3.latitude,"empty"),'_',COALESCE(dtr3.longitude,"empty")) time from dtr_file dtr3 where
				dtr3.userid = user.userid and
				dtr3.event = "IN" and
				dtr3.time >= "13:00:00" and
				dtr3.time < "15:00:00" and
				dtr3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			),
			(SELECT CONCAT("SO #",so3.remark,"_BUI_",so3.time,"_so") time from so_logs so3 where
				so3.userid = user.userid and
				so3.event = "IN" and
				so3.time >= "12:00" and
				so3.time < "17:00" and
				so3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #SO LOGS
			(SELECT CONCAT("CDO_BUI_",cdo3.time,"_cdo") time from cdo_logs cdo3 where
				cdo3.userid = user.userid and
				cdo3.event = "IN" and
				cdo3.time >= "12:00" and
				cdo3.time < "17:00" and
				cdo3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #CDO LOGS
			(SELECT CONCAT(leave3.remark,"_BUI_",leave3.time,"_leave") time from leave_logs leave3 where
				leave3.userid = user.userid and
				leave3.event = "IN" and
				leave3.time >= "12:00" and
				leave3.time < "17:00" and
				leave3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #LEAVE LOGS
			(SELECT CONCAT(edited3.time,"_BUI_",edited3.time,"_edited") time from edited_logs edited3 where
				edited3.userid = user.userid and
				edited3.event = "IN" and
				edited3.time >= "12:00:00" and
				edited3.time < "17:00:00" and
				edited3.edited = 1 and
				edited3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #EDITED LOGS
			(SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday3 where
				holiday3.userid = "001" and
				holiday3.event = "IN" and
				holiday3.time = "13:00:00" and
				holiday3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #HOLIDAY LOGS
			(SELECT CONCAT("JO BREAK_BUI_",jo_break3.time,"_jobreak") time from edited_logs jo_break3 where
				jo_break3.userid = user.userid and
				jo_break3.event = "IN" and
				jo_break3.time = "13:00:00" and
				jo_break3.remark = "JO BREAK" and
				jo_break3.edited = 2 and
				jo_break3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #JO BREAK LOGS
			(SELECT CONCAT("TO #",to3.remark,"_BUI_",to3.time,'_to') time from edited_logs to3 where
				to3.userid = user.userid and
				to3.event = "IN" and
				to3.time = "13:00:00" and
				to3.edited = 3 and
				to3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
			"empty_BUI_empty_empty"
		)
    ) pm_in,
    (
		COALESCE(
			(SELECT CONCAT(dtr4.time,"_",IF(dtr4.remark = "MOBILE","U",""),'_',dtr4.time,"_",IF(dtr4.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr4.latitude,"empty"),'_',COALESCE(dtr4.longitude,"empty")) from dtr_file dtr4 where
				dtr4.userid = user.userid and
				dtr4.time > "14:00:00" and
				dtr4.datein = dtr.datein
				ORDER BY TIME DESC
				LIMIT 1
			), #NORMAL LOGS
			(SELECT CONCAT(dtr4.time,"_",IF(dtr4.remark = "MOBILE","U",""),'_',dtr4.time,"_",IF(dtr4.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr4.latitude,"empty"),'_',COALESCE(dtr4.longitude,"empty")) from dtr_file dtr4 where
				dtr4.userid = user.userid and
				dtr4.event = "OUT" and
				dtr4.time >= "17:00:00" and
				dtr4.datein = dtr.datein
				ORDER BY TIME DESC
				LIMIT 1
			), #NORMAL LOGS
			(SELECT CONCAT("SO #",so4.remark,"_BUI_",so4.time,'_so') time from so_logs so4 where
				so4.userid = user.userid and
				so4.event = "OUT" and
				so4.time > "13:00" and
				so4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #SO LOGS
			(SELECT CONCAT("CDO_BUI_",cdo4.time,'_cdo') time from cdo_logs cdo4 where
				cdo4.userid = user.userid and
				cdo4.event = "OUT" and
				cdo4.time > "13:00" and
				cdo4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #CDO LOGS
			(SELECT CONCAT(leave4.remark,"_BUI_",leave4.time,'_leave') time from leave_logs leave4 where
				leave4.userid = user.userid and
				leave4.event = "OUT" and
				leave4.time > "13:00" and
				leave4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #LEAVE LOGS
			(SELECT CONCAT(edited4.time,"_BUI_",edited4.time,'_edited') time from edited_logs edited4 where
				edited4.userid = user.userid and
				edited4.event = "OUT" and
				edited4.time >= "13:00:00" and
				edited4.edited = 1 and
				edited4.datein = dtr.datein
				ORDER BY TIME DESC
				LIMIT 1
			), #EDITED LOGS
			(SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday4 where
				holiday4.userid = "001" and
				holiday4.event = "OUT" and
				holiday4.time = "18:00:00" and
				holiday4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #HOLIDAY LOGS
			(SELECT CONCAT("JO BREAK_BUI_",jo_break4.time,"_jobreak") time from edited_logs jo_break4 where
				jo_break4.userid = user.userid and
				jo_break4.event = "OUT" and
				jo_break4.time = "18:00:00" and
				jo_break4.remark = "JO BREAK" and
				jo_break4.edited = 2 and
				jo_break4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #JO BREAK LOGS
			(SELECT CONCAT("TO #",to4.remark,"_BUI_",to4.time,'_to') time from edited_logs to4 where
				to4.userid = user.userid and
				to4.event = "OUT" and
				to4.time = "18:00:00" and
				to4.edited = 3 and
				to4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
			(SELECT CONCAT(dtr4.time,"__",dtr4.time,"_normal") time from dtr_file dtr4 where
				dtr4.userid = user.userid and
				dtr4.event = "ID-UNKNOWN" and
				dtr4.time >= "17:00:00" and
				dtr4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #NORMAL LOGS UNKNOWN user.userid
			"empty_BUI_empty_empty"
		)
    ) pm_out,
	IF(
		(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is not null or
		DAYNAME(dtr.datein) = "Saturday" or
		DAYNAME(dtr.datein) = "Sunday",
		" ", #set empty if holiday,saturday and sunday
		(
			COALESCE(
				GREATEST(
					TIMESTAMPDIFF(MINUTE,
						CONCAT(dtr.datein," ",IF(
												DAYNAME(dtr.datein) = "Monday" and
												(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null,
												"08:30:00",
												IF(
													DAYNAME(dtr.datein) = "Tuesday" and
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday monday
													"08:30:00",
													IF(
														 DAYNAME(dtr.datein) = "Wednesday" and
														 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
														 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday monday
														 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday tuesday
														 "08:30:00",
														  IF(
															  DAYNAME(dtr.datein) = "Thursday" and
															  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
															  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 3 DAY) limit 1) is not null and #holiday monday
															  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday tuesday
															  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday wednesday
															  "08:30:00",
															   IF(
																	DAYNAME(dtr.datein) = "Friday" and
																	(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
																	(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 4 DAY) limit 1) is not null and #holiday monday
																	(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 3 DAY) limit 1) is not null and #holiday tuesday
																	(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday wednesday
																	(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday thursday
																	"08:30:00",
																	"09:00:00" #default set morning late
															   )
														  )
													 )
												 )
											 )
						),
						CONCAT(
							dtr.datein," ",
							COALESCE(
								(SELECT time from dtr_file dtr1 where
									dtr1.userid = user.userid and
									#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
									dtr1.time < "12:00:00" and
									dtr1.datein = dtr.datein
									ORDER BY TIME ASC
									LIMIT 1
								), #normal logs
								(SELECT time from edited_logs edited1 where
									edited1.userid = user.userid and
									edited1.event = "IN" and
									edited1.time < "12:00:00" and
									edited1.datein = dtr.datein
									ORDER BY TIME ASC
									LIMIT 1
								) #edited logs
							) #end coalesce
						) #2nd condition timetampdiff
					)
				,0)
			,0) + #morning late
			COALESCE(
				GREATEST(
					TIMESTAMPDIFF(MINUTE,
						CONCAT(dtr.datein," ","13:00:00"), #13:00:00 1st condition timetamppdiff default
						CONCAT(
							dtr.datein," ",
							COALESCE(
								(SELECT time time from dtr_file dtr3 where
									dtr3.userid = user.userid and
									dtr3.event = "IN" and
									dtr3.time >= "12:00:00" and
									dtr3.time < "16:00:00" and #4pm
									dtr3.datein = dtr.datein
									ORDER BY TIME ASC
									LIMIT 1
								), #normal logs
								(SELECT time from edited_logs edited3 where
									edited3.userid = user.userid and
									edited3.event = "IN" and
									edited3.time >= "12:00:00" and
									edited3.time < "16:00:00" and #4pm
									edited3.datein = dtr.datein
									ORDER BY TIME ASC
									LIMIT 1
								) #EDITED LOGS
							) #END COALESCE
						) #2nd condition timetampdiff
					)
				,0)
			,0) #afternoon late
		)
	) late,
	(
		SELECT sum(y.late) from(
			SELECT x.userid,x.datein,x.late from(
				SELECT dtr_late.userid,dtr_late.datein,
				IF(
					(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr_late.datein limit 1) is not null or
					DAYNAME(dtr_late.datein) = "Saturday" or
					DAYNAME(dtr_late.datein) = "Sunday",
					" ", #set empty if holiday,saturday and sunday
					(
						COALESCE(
							GREATEST(
								TIMESTAMPDIFF(MINUTE,
									CONCAT(dtr_late.datein," ",IF(
															DAYNAME(dtr_late.datein) = "Monday" and
															(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr_late.datein limit 1) is null,
															"08:30:00",
															IF(
																DAYNAME(dtr_late.datein) = "Tuesday" and
																(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr_late.datein limit 1) is null and
																(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday monday
																"08:30:00",
																IF(
																	 DAYNAME(dtr_late.datein) = "Wednesday" and
																	 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr_late.datein limit 1) is null and
																	 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday monday
																	 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday tuesday
																	 "08:30:00",
																	  IF(
																		  DAYNAME(dtr_late.datein) = "Thursday" and
																		  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr_late.datein limit 1) is null and
																		  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 3 DAY) limit 1) is not null and #holiday monday
																		  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday tuesday
																		  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday wednesday
																		  "08:30:00",
																		   IF(
																				DAYNAME(dtr_late.datein) = "Friday" and
																				(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr_late.datein limit 1) is null and
																				(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 4 DAY) limit 1) is not null and #holiday monday
																				(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 3 DAY) limit 1) is not null and #holiday tuesday
																				(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday wednesday
																				(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr_late.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday thursday
																				"08:30:00",
																				"09:00:00" #default set morning late
																		   )
																	  )
																 )
															 )
														 )
									),
									CONCAT(
										dtr_late.datein," ",
										COALESCE(
											(SELECT time from dtr_file dtr1 where
												dtr1.userid = dtr_user.userid and
												#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
												dtr1.time < "12:00:00" and
												dtr1.datein = dtr_late.datein
												ORDER BY TIME ASC
												LIMIT 1
											), #normal logs
											(SELECT time from edited_logs edited1 where
												edited1.userid = dtr_user.userid and
												edited1.event = "IN" and
												edited1.time < "12:00:00" and
												edited1.datein = dtr_late.datein
												ORDER BY TIME ASC
												LIMIT 1
											) #edited logs
										) #end coalesce
									) #2nd condition timetampdiff
								)
							,0)
						,0) + #morning late
						COALESCE(
							GREATEST(
								TIMESTAMPDIFF(MINUTE,
									CONCAT(dtr_late.datein," ","13:00:00"), #13:00:00 1st condition timetamppdiff default
									CONCAT(
										dtr_late.datein," ",
										COALESCE(
											(SELECT time time from dtr_file dtr3 where
												dtr3.userid = dtr_user.userid and
												dtr3.event = "IN" and
												dtr3.time >= "12:00:00" and
												dtr3.time < "16:00:00" and #4pm
												dtr3.datein = dtr_late.datein
												ORDER BY TIME ASC
												LIMIT 1
											), #normal logs
											(SELECT time from edited_logs edited3 where
												edited3.userid = dtr_user.userid and
												edited3.event = "IN" and
												edited3.time >= "12:00:00" and
												edited3.time < "16:00:00" and #4pm
												edited3.datein = dtr_late.datein
												ORDER BY TIME ASC
												LIMIT 1
											) #EDITED LOGS
										) #END COALESCE
									) #2nd condition timetampdiff
								)
							,0)
						,0) #afternoon late
					)
				) late
				from (
						(select userid,datein,time from dohdtr.dtr_file where datein >= datein_from and datein <= datein_to)
						union
						(select userid,datein,time from dohdtr.edited_logs where datein >= datein_from and datein <= datein_to)
					 ) dtr_late
				left join users dtr_user on dtr_user.userid = dtr_late.userid
				left join edited_logs edited on edited.userid = dtr_user.userid
				left join work_sched sched on sched.id = dtr_user.sched
				) x
			where x.late != (0 or ' ')
			group by x.userid,x.datein
		) y
		where y.userid = dtr.userid
		group by y.userid
	) total_late
	from (
		(select userid,datein,time from dohdtr.dtr_file where datein >= datein_from and datein <= datein_to)
		union
		(select userid,datein,time from dohdtr.edited_logs where datein >= datein_from and datein <= datein_to)
	) dtr
	left join pis.personal_information user_pis on user_pis.userid = dtr.userid
	left join users user on user.userid = dtr.userid
	left join edited_logs edited on edited.userid = user.userid
	left join work_sched sched on sched.id = user.sched
	where user_pis.job_status = 'permanent'
	group by dtr.userid,dtr.datein
) logs
where logs.late != (0 or ' ')
order by logs.total_late desc,logs.userid,logs.datein

;END