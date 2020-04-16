CREATE DEFINER=`root`@`localhost` PROCEDURE `Gliding_2020`(IN ID VARCHAR(15), IN datein_from VARCHAR(20), IN datein_to VARCHAR(20))
    READS SQL DATA
    DETERMINISTIC
BEGIN
SELECT logs.* from(
	SELECT ID as userid,UPPER(CONCAT(user.lname,', ',user.fname)) as name,dtr.datein,sched.id sched,DAYNAME(dtr.datein) dayname,
    CONCAT(
		COALESCE(
			(SELECT CONCAT(dtr1.time,"_",IF(dtr1.remark = "MOBILE","U",""),'_',dtr1.time,'_',IF(dtr1.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr1.latitude,"empty"),'_',COALESCE(dtr1.longitude,"empty"),'_',COALESCE(dtr1.log_image,"empty")) time from dtr_file dtr1 where
				dtr1.userid = ID and
				#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
				dtr1.time < "12:00" and
				dtr1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #NORMAL LOGS
            (SELECT CONCAT(dtr1.time,"__",dtr1.time,"_normal") time from dtr_file dtr1 where
				dtr1.userid = ID and
				dtr1.event = "ID-UNKNOWN" and
				dtr1.time < "12:00:00" and
				dtr1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #NORMAL LOGS ID-UNKNOWN
            (SELECT CONCAT("SO #",so1.remark,"_BUI_",so1.time,'_so') time from so_logs so1 where
				so1.userid = ID and
				so1.event = "IN" and
				so1.time = "08:00:00" and
				so1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #SO LOGS
			(SELECT CONCAT("CDO","_BUI_",cdo1.time,'_cdo') time from cdo_logs cdo1 where
				cdo1.userid = ID and
				cdo1.event = "IN" and
				cdo1.time = "08:00:00" and
				cdo1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #CDO LOGS
			(SELECT CONCAT(leave1.remark,"_BUI_",leave1.time,'_leave') time from leave_logs leave1 where
				leave1.userid = ID and
				leave1.event = "IN" and
				leave1.time = "08:00:00" and
				leave1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #LEAVE LOGS
            (SELECT CONCAT(edited1.time,"_BUI_",edited1.time,'_edited') from edited_logs edited1 where
				edited1.userid = ID and
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
            (SELECT CONCAT("JO BREAK_BUI_",jo_break1.time,'_jobreak') time from edited_logs jo_break1 where
				jo_break1.userid = ID and
				jo_break1.event = "IN" and
				jo_break1.time = "08:00:00" and
				jo_break1.remark = "JO BREAK" and
                jo_break1.edited = 2 and
				jo_break1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #JO BREAK LOGS
            (SELECT CONCAT("TO #",to1.remark,"_BUI_",to1.time,'_to') time from edited_logs to1 where
				to1.userid = ID and
				to1.event = "IN" and
				to1.time = "08:00:00" and
                to1.edited = 3 and
				to1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
            (SELECT CONCAT("MO #",mo1.remark,"_BUI_",mo1.time,'_mo') time from edited_logs mo1 where
				mo1.userid = ID and
				mo1.event = "IN" and
				mo1.time = "08:00:00" and
                mo1.edited = 4 and
				mo1.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #MEMO LOGS
			"empty_BUI_empty_empty"
        ),"|",
		COALESCE(
			IF(
				COALESCE(
					(SELECT time from dtr_file dtr2 where
						dtr2.userid = ID and
						dtr2.event = "OUT" and
						dtr2.time >= "12:00:00" and
                        dtr2.time < "13:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					),
                    (SELECT time from dtr_file dtr2 where
						dtr2.userid = ID and
						dtr2.event = "OUT" and
						dtr2.time > "9:30:00" and
                        dtr2.time < "12:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME DESC
						LIMIT 1
					),
                    (SELECT time from dtr_file dtr2 where
						dtr2.userid = ID and
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
						dtr3.userid = ID and
						dtr3.event = "IN" and
						dtr3.time >= "12:00:00" and
						dtr3.time < "13:00:00" and
						dtr3.datein = dtr.datein
						ORDER BY TIME DESC
						LIMIT 1
					),
                    (SELECT time from dtr_file dtr3 where
						dtr3.userid = ID and
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
					(SELECT CONCAT(dtr2.time,"_",IF(dtr2.remark = "MOBILE","U",""),'_',dtr2.time,"_",IF(dtr2.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr2.latitude,"empty"),'_',COALESCE(dtr2.longitude,"empty"),'_',COALESCE(dtr2.log_image,"empty")) time from dtr_file dtr2 where
						dtr2.userid = ID and
						dtr2.event = "OUT" and
						dtr2.time >= "12:00:00" and
                        dtr2.time < "13:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					),
                    (SELECT CONCAT(dtr2.time,"_",IF(dtr2.remark = "MOBILE","U",""),'_',dtr2.time,"_",IF(dtr2.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr2.latitude,"empty"),'_',COALESCE(dtr2.longitude,"empty"),'_',COALESCE(dtr2.log_image,"empty")) time from dtr_file dtr2 where
						dtr2.userid = ID and
						dtr2.event = "OUT" and
						dtr2.time > "09:30:00" and
                        dtr2.time < "12:00:00" and
						dtr2.datein = dtr.datein
						ORDER BY TIME DESC
						LIMIT 1
					),
                    (SELECT CONCAT(dtr2.time,"_",IF(dtr2.remark = "MOBILE","U",""),'_',dtr2.time,"_",IF(dtr2.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr2.latitude,"empty"),'_',COALESCE(dtr2.longitude,"empty"),'_',COALESCE(dtr2.log_image,"empty")) time from dtr_file dtr2 where
						dtr2.userid = ID and
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
						so2.userid = ID and
						so2.event = "OUT" and
						so2.time = "12:00:00" and
						so2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #SO LOGS
					(SELECT CONCAT("CDO_BUI_",cdo2.time,'_cdo') time from cdo_logs cdo2 where
						cdo2.userid = ID and
						cdo2.event = "OUT" and
						cdo2.time = "12:00:00" and
						cdo2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #CDO LOGS
					(SELECT CONCAT(leave2.remark,"_BUI_",leave2.time,'_leave') time from leave_logs leave2 where
						leave2.userid = ID and
						leave2.event = "OUT" and
						leave2.time = "12:00:00" and
						leave2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #LEAVE LOGS
					(SELECT CONCAT(edited2.time,"_BUI_",edited2.time,'_edited') from edited_logs edited2 where
						edited2.userid = ID and
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
						jo_break2.userid = ID and
						jo_break2.event = "OUT" and
						jo_break2.time = "12:00:00" and
						jo_break2.remark = "JO BREAK" and
						jo_break2.edited = 2 and
						jo_break2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #JO BREAK LOGS
                    (SELECT CONCAT("TO #",to2.remark,"_BUI_",to2.time,'_to') time from edited_logs to2 where
						to2.userid = ID and
						to2.event = "OUT" and
						to2.time = "12:00:00" and
						to2.edited = 3 and
						to2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #TO LOGS
                    (SELECT CONCAT("MO #",mo2.remark,"_BUI_",mo2.time,'_mo') time from edited_logs mo2 where
						mo2.userid = ID and
						mo2.event = "OUT" and
						mo2.time = "12:00:00" and
						mo2.edited = 4 and
						mo2.datein = dtr.datein
						ORDER BY TIME ASC
						LIMIT 1
					), #TO LOGS
                    "empty_BUI_empty_empty"
                ) #if false
			), #end if
			"empty_BUI_empty_empty"
        ),"|",
		COALESCE(
			(SELECT CONCAT(dtr3.time,"_",IF(dtr3.remark = "MOBILE","U",""),'_',dtr3.time,'_',IF(dtr3.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr3.latitude,"empty"),'_',COALESCE(dtr3.longitude,"empty"),'_',COALESCE(dtr3.log_image,"empty")) time from dtr_file dtr3 where
				dtr3.userid = ID and
				dtr3.event = "IN" and
				dtr3.time >= "12:00:00" and
				dtr3.time < "13:00:00" and
				dtr3.datein = dtr.datein
				ORDER BY TIME DESC
				LIMIT 1
			),
			(SELECT CONCAT(dtr3.time,"_",IF(dtr3.remark = "MOBILE","U",""),'_',dtr3.time,'_',IF(dtr3.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr3.latitude,"empty"),'_',COALESCE(dtr3.longitude,"empty"),'_',COALESCE(dtr3.log_image,"empty")) time from dtr_file dtr3 where
				dtr3.userid = ID and
				dtr3.event = "IN" and
				dtr3.time >= "13:00:00" and
				dtr3.time < "15:00:00" and
				dtr3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			),
            (SELECT CONCAT("SO #",so3.remark,"_BUI_",so3.time,"_so") time from so_logs so3 where
				so3.userid = ID and
				so3.event = "IN" and
				so3.time >= "12:00" and
				so3.time < "17:00" and
				so3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #SO LOGS
			(SELECT CONCAT("CDO_BUI_",cdo3.time,"_cdo") time from cdo_logs cdo3 where
				cdo3.userid = ID and
				cdo3.event = "IN" and
				cdo3.time >= "12:00" and
				cdo3.time < "17:00" and
				cdo3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #CDO LOGS
			(SELECT CONCAT(leave3.remark,"_BUI_",leave3.time,"_leave") time from leave_logs leave3 where
				leave3.userid = ID and
				leave3.event = "IN" and
				leave3.time >= "12:00" and
				leave3.time < "17:00" and
				leave3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #LEAVE LOGS
            (SELECT CONCAT(edited3.time,"_BUI_",edited3.time,"_edited") time from edited_logs edited3 where
				edited3.userid = ID and
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
            (SELECT CONCAT("JO BREAK_BUI_",jo_break3.time,'_jobreak') time from edited_logs jo_break3 where
				jo_break3.userid = ID and
				jo_break3.event = "IN" and
				jo_break3.time = "13:00:00" and
				jo_break3.remark = "JO BREAK" and
				jo_break3.edited = 2 and
				jo_break3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #JO BREAK LOGS
            (SELECT CONCAT("TO #",to3.remark,"_BUI_",to3.time,'_to') time from edited_logs to3 where
				to3.userid = ID and
				to3.event = "IN" and
				to3.time = "13:00:00" and
                to3.edited = 3 and
				to3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
            (SELECT CONCAT("MO #",mo3.remark,"_BUI_",mo3.time,'_mo') time from edited_logs mo3 where
				mo3.userid = ID and
				mo3.event = "IN" and
				mo3.time = "13:00:00" and
                mo3.edited = 4 and
				mo3.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
			"empty_BUI_empty_empty"
        ),"|",
		COALESCE(
			(SELECT CONCAT(dtr4.time,"_",IF(dtr4.remark = "MOBILE","U",""),'_',dtr4.time,"_",IF(dtr4.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr4.latitude,"empty"),'_',COALESCE(dtr4.longitude,"empty"),'_',COALESCE(dtr4.log_image,"empty")) from dtr_file dtr4 where
				dtr4.userid = ID and
				dtr4.time > "14:00:00" and
				dtr4.datein = dtr.datein
				ORDER BY TIME DESC
				LIMIT 1
			), #NORMAL LOGS
            (SELECT CONCAT(dtr4.time,"_",IF(dtr4.remark = "MOBILE","U",""),'_',dtr4.time,"_",IF(dtr4.remark = "MOBILE","mobile","normal"),'_',COALESCE(dtr4.latitude,"empty"),'_',COALESCE(dtr4.longitude,"empty"),'_',COALESCE(dtr4.log_image,"empty")) from dtr_file dtr4 where
				dtr4.userid = ID and
				dtr4.event = "OUT" and
				dtr4.time >= "17:00:00" and
				dtr4.datein = dtr.datein
				ORDER BY TIME DESC
				LIMIT 1
			), #NORMAL LOGS
            (SELECT CONCAT(dtr4.time,"__",dtr4.time,"_normal") time from dtr_file dtr4 where
				dtr4.userid = ID and
				dtr4.event = "ID-UNKNOWN" and
				dtr4.time >= "17:00:00" and
				dtr4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #NORMAL LOGS UNKNOWN ID
            (SELECT CONCAT("SO #",so4.remark,"_BUI_",so4.time,'_so') time from so_logs so4 where
				so4.userid = ID and
				so4.event = "OUT" and
				so4.time > "13:00" and
				so4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #SO LOGS
			(SELECT CONCAT("CDO_BUI_",cdo4.time,'_cdo') time from cdo_logs cdo4 where
				cdo4.userid = ID and
				cdo4.event = "OUT" and
				cdo4.time > "13:00" and
				cdo4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #CDO LOGS
			(SELECT CONCAT(leave4.remark,"_BUI_",leave4.time,'_leave') time from leave_logs leave4 where
				leave4.userid = ID and
				leave4.event = "OUT" and
				leave4.time > "13:00" and
				leave4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #LEAVE LOGS
            (SELECT CONCAT(edited4.time,"_BUI_",edited4.time,'_edited') time from edited_logs edited4 where
				edited4.userid = ID and
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
				jo_break4.userid = ID and
				jo_break4.event = "OUT" and
				jo_break4.time = "18:00:00" and
				jo_break4.remark = "JO BREAK" and
				jo_break4.edited = 2 and
				jo_break4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #JO BREAK LOGS
            (SELECT CONCAT("TO #",to4.remark,"_BUI_",to4.time,'_to') time from edited_logs to4 where
				to4.userid = ID and
				to4.event = "OUT" and
				to4.time = "18:00:00" and
                to4.edited = 3 and
				to4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
            (SELECT CONCAT("MO #",mo4.remark,"_BUI_",mo4.time,'_mo') time from edited_logs mo4 where
				mo4.userid = ID and
				mo4.event = "OUT" and
				mo4.time = "18:00:00" and
                mo4.edited = 4 and
				mo4.datein = dtr.datein
				ORDER BY TIME ASC
				LIMIT 1
			), #TO LOGS
			"empty_BUI_empty_empty"
        )
    ) time, #END CONCAT
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
									dtr1.userid = ID and
									#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
									dtr1.time < "12:00:00" and
									dtr1.datein = dtr.datein
									ORDER BY TIME ASC
									LIMIT 1
								), #normal logs
								(SELECT time from edited_logs edited1 where
									edited1.userid = ID and
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
									dtr3.userid = ID and
									dtr3.event = "IN" and
									dtr3.time >= "12:00:00" and
									dtr3.time < "16:00:00" and #4pm
									dtr3.datein = dtr.datein
									ORDER BY TIME ASC
									LIMIT 1
								), #normal logs
								(SELECT time from edited_logs edited3 where
									edited3.userid = ID and
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
    IF(
		(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is not null or
        DAYNAME(dtr.datein) = "Saturday" or
        DAYNAME(dtr.datein) = "Sunday",
        " ", #set empty if holiday,saturday and sunday
        (
			COALESCE(
				GREATEST(
					TIMESTAMPDIFF(MINUTE,
						CONCAT(dtr.datein," ",
							IF(
								COALESCE(
									(SELECT time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time >= "12:00:00" and
										dtr2.time < "13:00:00" and
										dtr2.datein = dtr.datein
										ORDER BY TIME ASC
										LIMIT 1
									),
									(SELECT time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time > "09:30:00" and
										dtr2.time < "12:00:00" and
										dtr2.datein = dtr.datein
										ORDER BY TIME DESC
										LIMIT 1
									),
									(SELECT time from dtr_file dtr2 where
										dtr2.userid = ID and
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
										dtr3.userid = ID and
										dtr3.event = "IN" and
										dtr3.time >= "12:00:00" and
										dtr3.time < "13:00:00" and
										dtr3.datein = dtr.datein
										ORDER BY TIME DESC
										LIMIT 1
									),
									(SELECT time from dtr_file dtr3 where
										dtr3.userid = ID and
										dtr3.event = "IN" and
										dtr3.time >= "13:00:00" and
										dtr3.time < "15:00:00" and
										dtr3.datein = dtr.datein
										ORDER BY TIME ASC
										LIMIT 1
									),
									"17:00:00" #SET DEFAULT WHEN IT RETURN NULL
								), #IF SECOND CONDITION
								COALESCE(
									(SELECT dtr2.time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time >= "12:00:00" and
										dtr2.time < "13:00:00" and
										dtr2.datein = dtr.datein
										ORDER BY TIME ASC
										LIMIT 1
									),
									(SELECT dtr2.time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time > "09:30:00" and
										dtr2.time < "12:00:00" and
										dtr2.datein = dtr.datein
										ORDER BY TIME DESC
										LIMIT 1
									),
									(SELECT dtr2.time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time >= "13:00:00" and
										dtr2.time < "15:00:00" and
										dtr2.datein = dtr.datein
										ORDER BY TIME ASC
										LIMIT 1
									)
								), #if true
								COALESCE(
									(SELECT edited2.time from edited_logs edited2 where
										edited2.userid = ID and
										edited2.event = "OUT" and
										edited2.time > "8:00:00" and
										edited2.datein = dtr.datein
										ORDER BY TIME ASC
										LIMIT 1
									), #EDITED LOGS
									null
								) #if false
							) #end if ge kuha tanan logs sa out. Kay if ever naay ni undertime then ni panso balik, ma correct ra siya :)
						), #1st condition timedifference
						CONCAT(
							dtr.datein," ",sched.am_out #12:00:00
						) #2nd condition timedifference
					) #end time timedifference
				,0)
			,0) +
			COALESCE(
				GREATEST( #get the highest if the result is negative it will output the zero
					TIMESTAMPDIFF(MINUTE,
						CONCAT(dtr.datein," ",
							COALESCE(
								(SELECT time from dtr_file dtr4 where
									dtr4.userid = ID and
									dtr4.time > "14:00:00" and
									dtr4.datein = dtr.datein
									ORDER BY TIME DESC
									LIMIT 1
								), #NORMAL LOGS
								(SELECT time from edited_logs edited4 where
									edited4.userid = ID and
									edited4.event = "OUT" and
									edited4.time > "13:00:00" and
									edited4.datein = dtr.datein
									ORDER BY TIME DESC
									LIMIT 1
								) #EDITED LOGS
							)
						),
						CONCAT(
							dtr.datein,
							" ",
							IF(
								DAYNAME(dtr.datein) = "Monday" and (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1)
								is null, #condition
								IF(
									COALESCE(
										(SELECT time from dtr_file dtr1 where
											dtr1.userid = ID and
											#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
											dtr1.time < "12:00:00" and
											dtr1.datein = dtr.datein
											ORDER BY TIME ASC
											LIMIT 1
										), #normal logs
										(SELECT time from edited_logs edited1 where
											edited1.userid = ID and
											edited1.event = "IN" and
											edited1.time < "12:00:00" and
											edited1.datein = dtr.datein
											ORDER BY TIME ASC
											LIMIT 1
										) #edited logs
									) is null, #end coalesce if absent siya sa morning #condition
									"17:00:00", #true
									ADDTIME(
										IF(
											COALESCE(
												(SELECT time from dtr_file dtr1 where
													dtr1.userid = ID and
													#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
													dtr1.time < "12:00:00" and
													dtr1.datein = dtr.datein
													ORDER BY TIME ASC
													LIMIT 1
												), #normal logs
												(SELECT time from edited_logs edited1 where
													edited1.userid = ID and
													edited1.event = "IN" and
													edited1.time < "12:00:00" and
													edited1.datein = dtr.datein
													ORDER BY TIME ASC
													LIMIT 1
												) #edited logs
											)
											>=
											"08:30:00",
											"08:30:00", #statement true
											IF(
												COALESCE(
													(SELECT time from dtr_file dtr1 where
														dtr1.userid = ID and
														#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
														dtr1.time < "12:00:00" and
														dtr1.datein = dtr.datein
														ORDER BY TIME ASC
														LIMIT 1
													), #normal logs
													(SELECT time from edited_logs edited1 where
														edited1.userid = ID and
														edited1.event = "IN" and
														edited1.time < "12:00:00" and
														edited1.datein = dtr.datein
														ORDER BY TIME ASC
														LIMIT 1
													) #edited logs
												)
												<=
												"07:00:00",
												"07:00:00", #statement true
												IF(
													COALESCE(
														(SELECT time from dtr_file dtr1 where
															dtr1.userid = ID and
															#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
															dtr1.time < "12:00:00" and
															dtr1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														), #normal logs
														(SELECT time from edited_logs edited1 where
															edited1.userid = ID and
															edited1.event = "IN" and
															edited1.time < "12:00:00" and
															edited1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														) #edited logs
													) is null, #end coalesce if absent siya sa morning
													"08:00:00",
													COALESCE(
														(SELECT time from dtr_file dtr1 where
															dtr1.userid = ID and
															#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
															dtr1.time < "12:00:00" and
															dtr1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														), #normal logs
														(SELECT time from edited_logs edited1 where
															edited1.userid = ID and
															edited1.event = "IN" and
															edited1.time < "12:00:00" and
															edited1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														) #edited logs
													)
												)
											) #statement  false
										), #end if
									"09:00:00") # end addtime MORNING TIMEIN
								), #first condition if statement true
								IF(
									DAYNAME(dtr.datein) = "Tuesday" and
									(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
									(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday monday
									IF(
										COALESCE(
											(SELECT time from dtr_file dtr1 where
												dtr1.userid = ID and
												#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
												dtr1.time < "12:00:00" and
												dtr1.datein = dtr.datein
												ORDER BY TIME ASC
												LIMIT 1
											), #normal logs
											(SELECT time from edited_logs edited1 where
												edited1.userid = ID and
												edited1.event = "IN" and
												edited1.time < "12:00:00" and
												edited1.datein = dtr.datein
												ORDER BY TIME ASC
												LIMIT 1
											) #edited logs
										) is null, #end coalesce if absent siya sa morning
										"17:00:00",

										ADDTIME(
											IF(
												COALESCE(
													(SELECT time from dtr_file dtr1 where
														dtr1.userid = ID and
														#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
														dtr1.time < "12:00:00" and
														dtr1.datein = dtr.datein
														ORDER BY TIME ASC
														LIMIT 1
													), #normal logs
													(SELECT time from edited_logs edited1 where
														edited1.userid = ID and
														edited1.event = "IN" and
														edited1.time < "12:00:00" and
														edited1.datein = dtr.datein
														ORDER BY TIME ASC
														LIMIT 1
													) #edited logs
												)
												>=
												"08:30:00",
												"08:30:00", #statement true
												IF(
													COALESCE(
														(SELECT time from dtr_file dtr1 where
															dtr1.userid = ID and
															#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
															dtr1.time < "12:00:00" and
															dtr1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														), #normal logs
														(SELECT time from edited_logs edited1 where
															edited1.userid = ID and
															edited1.event = "IN" and
															edited1.time < "12:00:00" and
															edited1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														) #edited logs
													)
													<=
													"07:00:00",
													"07:00:00", #statement true
													IF(
														COALESCE(
															(SELECT time from dtr_file dtr1 where
																dtr1.userid = ID and
																#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																dtr1.time < "12:00:00" and
																dtr1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															), #normal logs
															(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															) #edited logs
														) is null, #end coalesce if absent siya sa morning
														"08:00:00",
														COALESCE(
															(SELECT time from dtr_file dtr1 where
																dtr1.userid = ID and
																#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																dtr1.time < "12:00:00" and
																dtr1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															), #normal logs
															(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															) #edited logs
														)
													) #false if
												)
											), #end if
										"09:00:00") # end addtime MORNING TIMEIN

									), #false if
									IF(
										 DAYNAME(dtr.datein) = "Wednesday" and
										 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
										 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday monday
										 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday tuesday
										 IF(
											COALESCE(
												(SELECT time from dtr_file dtr1 where
													dtr1.userid = ID and
													#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
													dtr1.time < "12:00:00" and
													dtr1.datein = dtr.datein
													ORDER BY TIME ASC
													LIMIT 1
												), #normal logs
												(SELECT time from edited_logs edited1 where
													edited1.userid = ID and
													edited1.event = "IN" and
													edited1.time < "12:00:00" and
													edited1.datein = dtr.datein
													ORDER BY TIME ASC
													LIMIT 1
												) #edited logs
											) is null, #end coalesce if absent siya sa morning
											"17:00:00",

											ADDTIME(
												IF(
													COALESCE(
														(SELECT time from dtr_file dtr1 where
															dtr1.userid = ID and
															#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
															dtr1.time < "12:00:00" and
															dtr1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														), #normal logs
														(SELECT time from edited_logs edited1 where
															edited1.userid = ID and
															edited1.event = "IN" and
															edited1.time < "12:00:00" and
															edited1.datein = dtr.datein
															ORDER BY TIME ASC
															LIMIT 1
														) #edited logs
													)
													>=
													"08:30:00",
													"08:30:00", #statement true
													IF(
														COALESCE(
															(SELECT time from dtr_file dtr1 where
																dtr1.userid = ID and
																#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																dtr1.time < "12:00:00" and
																dtr1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															), #normal logs
															(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															) #edited logs
														)
														<=
														"07:00:00",
														"07:00:00", #statement true
														IF(
															COALESCE(
																(SELECT time from dtr_file dtr1 where
																	dtr1.userid = ID and
																	#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																	dtr1.time < "12:00:00" and
																	dtr1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																), #normal logs
																(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																) #edited logs
															) is null, #end coalesce if absent siya sa morning
															"08:00:00",
															COALESCE(
																(SELECT time from dtr_file dtr1 where
																	dtr1.userid = ID and
																	#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																	dtr1.time < "12:00:00" and
																	dtr1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																), #normal logs
																(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																) #edited logs
															)
														) #false if
													)
												), #end if
											"09:00:00") # end addtime MORNING TIMEIN

										), #false if
										  IF(
											  DAYNAME(dtr.datein) = "Thursday" and
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 3 DAY) limit 1) is not null and #holiday monday
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday tuesday
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday wednesday
											  IF(
												 COALESCE(
													(SELECT time from dtr_file dtr1 where
														dtr1.userid = ID and
														#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
														dtr1.time < "12:00:00" and
														dtr1.datein = dtr.datein
														ORDER BY TIME ASC
														LIMIT 1
													), #normal logs
													(SELECT time from edited_logs edited1 where
														edited1.userid = ID and
														edited1.event = "IN" and
														edited1.time < "12:00:00" and
														edited1.datein = dtr.datein
														ORDER BY TIME ASC
														LIMIT 1
													) #edited logs
												 ) is null, #end coalesce if absent siya sa morning
												 "17:00:00",

												 ADDTIME(
													IF(
														COALESCE(
															(SELECT time from dtr_file dtr1 where
																dtr1.userid = ID and
																#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																dtr1.time < "12:00:00" and
																dtr1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															), #normal logs
															(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															) #edited logs
														)
														>=
														"08:30:00",
														"08:30:00", #statement true
														IF(
															COALESCE(
																(SELECT time from dtr_file dtr1 where
																	dtr1.userid = ID and
																	#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																	dtr1.time < "12:00:00" and
																	dtr1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																), #normal logs
																(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																) #edited logs
															)
															<=
															"07:00:00",
															"07:00:00", #statement true
															IF(
																COALESCE(
																	(SELECT time from dtr_file dtr1 where
																		dtr1.userid = ID and
																		#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																		dtr1.time < "12:00:00" and
																		dtr1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	), #normal logs
																	(SELECT time from edited_logs edited1 where
																		edited1.userid = ID and
																		edited1.event = "IN" and
																		edited1.time < "12:00:00" and
																		edited1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	) #edited logs
																) is null, #end coalesce if absent siya sa morning
																"08:00:00",
																COALESCE(
																	(SELECT time from dtr_file dtr1 where
																		dtr1.userid = ID and
																		#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																		dtr1.time < "12:00:00" and
																		dtr1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	), #normal logs
																	(SELECT time from edited_logs edited1 where
																		edited1.userid = ID and
																		edited1.event = "IN" and
																		edited1.time < "12:00:00" and
																		edited1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	) #edited logs
																)
															) #false if
														)
													), #end if
												"09:00:00") # end addtime MORNING TIMEIN

											   ), #false if
											   IF(
													DAYNAME(dtr.datein) = "Friday" and
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = dtr.datein limit 1) is null and
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 4 DAY) limit 1) is not null and #holiday monday
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 3 DAY) limit 1) is not null and #holiday tuesday
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 2 DAY) limit 1) is not null and #holiday wednesday
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB(dtr.datein, INTERVAL 1 DAY) limit 1) is not null, #holiday thursday
													IF(
														COALESCE(
															(SELECT time from dtr_file dtr1 where
																dtr1.userid = ID and
																#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																dtr1.time < "12:00:00" and
																dtr1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															), #normal logs
															(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.datein = dtr.datein
																ORDER BY TIME ASC
																LIMIT 1
															) #edited logs
														) is null, #end coalesce if absent siya sa morning
														"17:00:00",

														ADDTIME(
															IF(
																COALESCE(
																	(SELECT time from dtr_file dtr1 where
																		dtr1.userid = ID and
																		#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																		dtr1.time < "12:00:00" and
																		dtr1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	), #normal logs
																	(SELECT time from edited_logs edited1 where
																		edited1.userid = ID and
																		edited1.event = "IN" and
																		edited1.time < "12:00:00" and
																		edited1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	) #edited logs
																)
																>=
																"08:30:00",
																"08:30:00", #statement true
																IF(
																	COALESCE(
																		(SELECT time from dtr_file dtr1 where
																			dtr1.userid = ID and
																			#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																			dtr1.time < "12:00:00" and
																			dtr1.datein = dtr.datein
																			ORDER BY TIME ASC
																			LIMIT 1
																		), #normal logs
																		(SELECT time from edited_logs edited1 where
																			edited1.userid = ID and
																			edited1.event = "IN" and
																			edited1.time < "12:00:00" and
																			edited1.datein = dtr.datein
																			ORDER BY TIME ASC
																			LIMIT 1
																		) #edited logs
																	)
																	<=
																	"07:00:00",
																	"07:00:00", #statement true
																	IF(
																		COALESCE(
																			(SELECT time from dtr_file dtr1 where
																				dtr1.userid = ID and
																				#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																				dtr1.time < "12:00:00" and
																				dtr1.datein = dtr.datein
																				ORDER BY TIME ASC
																				LIMIT 1
																			), #normal logs
																			(SELECT time from edited_logs edited1 where
																				edited1.userid = ID and
																				edited1.event = "IN" and
																				edited1.time < "12:00:00" and
																				edited1.datein = dtr.datein
																				ORDER BY TIME ASC
																				LIMIT 1
																			) #edited logs
																		) is null, #end coalesce if absent siya sa morning
																		"08:00:00",
																		COALESCE(
																			(SELECT time from dtr_file dtr1 where
																				dtr1.userid = ID and
																				#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																				dtr1.time < "12:00:00" and
																				dtr1.datein = dtr.datein
																				ORDER BY TIME ASC
																				LIMIT 1
																			), #normal logs
																			(SELECT time from edited_logs edited1 where
																				edited1.userid = ID and
																				edited1.event = "IN" and
																				edited1.time < "12:00:00" and
																				edited1.datein = dtr.datein
																				ORDER BY TIME ASC
																				LIMIT 1
																			) #edited logs
																		)
																	) #false if
																)
															), #end if
														"09:00:00") # end addtime MORNING TIMEIN
													),
													ADDTIME(
														IF(
															COALESCE(
																(SELECT time from dtr_file dtr1 where
																	dtr1.userid = ID and
																	#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																	dtr1.time < "12:00:00" and
																	dtr1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																), #normal logs
																(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.datein = dtr.datein
																	ORDER BY TIME ASC
																	LIMIT 1
																) #edited logs
															)
															>=
															"09:00:00",
															"09:00:00", #statement true
															IF(
																COALESCE(
																	(SELECT time from dtr_file dtr1 where
																		dtr1.userid = ID and
																		#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																		dtr1.time < "12:00:00" and
																		dtr1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	), #normal logs
																	(SELECT time from edited_logs edited1 where
																		edited1.userid = ID and
																		edited1.event = "IN" and
																		edited1.time < "12:00:00" and
																		edited1.datein = dtr.datein
																		ORDER BY TIME ASC
																		LIMIT 1
																	) #edited logs
																)
																<=
																"07:00:00",
																"07:00:00", #statement true
																IF(
																	COALESCE(
																		(SELECT time from dtr_file dtr1 where
																			dtr1.userid = ID and
																			#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																			dtr1.time < "12:00:00" and
																			dtr1.datein = dtr.datein
																			ORDER BY TIME ASC
																			LIMIT 1
																		), #normal logs
																		(SELECT time from edited_logs edited1 where
																			edited1.userid = ID and
																			edited1.event = "IN" and
																			edited1.time < "12:00:00" and
																			edited1.datein = dtr.datein
																			ORDER BY TIME ASC
																			LIMIT 1
																		) #edited logs
																	) is null, #end coalesce if absent siya sa morning
																	"08:00:00",
																	COALESCE(
																		(SELECT time from dtr_file dtr1 where
																			dtr1.userid = ID and
																			#dtr1.event = "IN" and temporary remove event condition kay ang biometric wala naka auto
																			dtr1.time < "12:00:00" and
																			dtr1.datein = dtr.datein
																			ORDER BY TIME ASC
																			LIMIT 1
																		), #normal logs
																		(SELECT time from edited_logs edited1 where
																			edited1.userid = ID and
																			edited1.event = "IN" and
																			edited1.time < "12:00:00" and
																			edited1.datein = dtr.datein
																			ORDER BY TIME ASC
																			LIMIT 1
																		) #edited logs
																	)
																) #false if
															)
														), #end if
													"09:00:00") # end addtime MORNING TIMEIN
											   )
										  )
									 )
								 )
							 ) #END IF
						) #end concat
					) #end TIMESTAMPDIFF
				,0) #end greatest
			,0) #end coalesce
		)
    ) undertime
    from dohdtr.dtr_file dtr
    left join users user on user.userid = ID
    left join work_sched sched on sched.id = user.sched
    where dtr.datein >= datein_from and dtr.datein <= datein_to and dtr.userid = ID

    UNION

	select * from
	(select
		ID as userid,
		UPPER(CONCAT((SELECT lname from users where userid = ID),', ',(SELECT fname from users where userid = ID))) as name,
		adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) datein,
        "sched",
        DAYNAME(adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)) dayname,
        (
			IF(DAYNAME(adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i))
				= "Saturday" or DAYNAME(adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)) = "Sunday",
				CONCAT(
					COALESCE(
						(SELECT CONCAT("SO #",so1.remark,"_BUI_",so1.time,'_so') time from so_logs so1 where
							so1.userid = ID and
							so1.event = "IN" and
							so1.time = "08:00:00" and
							so1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo1.time,'_cdo') time from cdo_logs cdo1 where
							cdo1.userid = ID and
							cdo1.event = "IN" and
							cdo1.time = "08:00:00" and
							cdo1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave1.remark,"_BUI_",leave1.time,'_leave') time from leave_logs leave1 where
							leave1.userid = ID and
							leave1.event = "IN" and
							leave1.time = "08:00:00" and
							leave1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
						(SELECT CONCAT(edited1.time,"_BUI_",edited1.time,'_edited') time from edited_logs edited1 where
							edited1.userid = ID and
							edited1.event = "IN" and
							edited1.time < "12:00" and
							edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #EDITED LOGS
                        (SELECT CONCAT("TO #",to1.remark,"_BUI_",to1.time,'_to') time from edited_logs to1 where
							to1.userid = ID and
							to1.event = "IN" and
							to1.time = "08:00:00" and
                            to1.edited = 3 and
							to1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("MO #",mo1.remark,"_BUI_",mo1.time,'_mo') time from edited_logs mo1 where
							mo1.userid = ID and
							mo1.event = "IN" and
							mo1.time = "08:00:00" and
                            mo1.edited = 4 and
							mo1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
                        "DAY OFF_BUI_dayoff_dayoff"
					),
                    "|",
                    COALESCE(
						(SELECT CONCAT("SO #",so2.remark,"_BUI_",so2.time,'_so') time from so_logs so2 where
							so2.userid = ID and
							so2.event = "OUT" and
							so2.time = "12:00:00" and
							so2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo2.time,'_cdo') time from cdo_logs cdo2 where
							cdo2.userid = ID and
							cdo2.event = "OUT" and
							cdo2.time = "12:00:00" and
							cdo2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave2.remark,"_BUI_",leave2.time,'_leave') time from leave_logs leave2 where
							leave2.userid = ID and
							leave2.event = "OUT" and
							leave2.time = "12:00:00" and
							leave2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
                        (SELECT CONCAT(edited2.time,"_BUI_",edited2.time,'_edited') from edited_logs edited2 where
							edited2.userid = ID and
							edited2.event = "OUT" and
							edited2.time > "08:00:00" and
							edited2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						),
                        (SELECT CONCAT("TO #",to2.remark,"_BUI_",to2.time,'_to') time from edited_logs to2 where
							to2.userid = ID and
							to2.event = "OUT" and
							to2.time > "08:00:00" and
                            to2.edited = 3 and
							to2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("MO #",mo2.remark,"_BUI_",mo2.time,'_mo') time from edited_logs mo2 where
							mo2.userid = ID and
							mo2.event = "OUT" and
							mo2.time > "08:00:00" and
                            mo2.edited = 4 and
							mo2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
						"DAY OFF_BUI_dayoff_dayoff"
					),
                    "|",
                    COALESCE(
						(SELECT CONCAT("SO #",so3.remark,"_BUI_",so3.time,'_so') time from so_logs so3 where
							so3.userid = ID and
							so3.event = "IN" and
							so3.time = "13:00:00" and
							so3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo3.time,'_cdo') time from cdo_logs cdo3 where
							cdo3.userid = ID and
							cdo3.event = "IN" and
							cdo3.time = "13:00:00" and
							cdo3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave3.remark,"_BUI_",leave3.time,'_leave') time from leave_logs leave3 where
							leave3.userid = ID and
							leave3.event = "IN" and
							leave3.time = "13:00:00" and
							leave3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
						(SELECT CONCAT(edited3.time,"_BUI_",edited3.time,'_edited') time from edited_logs edited3 where
							edited3.userid = ID and
							edited3.event = "IN" and
							edited3.time >= "12:00:00" and
							edited3.time < "17:00:00" and
							edited3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #EDITED LOGS
                        (SELECT CONCAT("TO #",to3.remark,"_BUI_",to3.time,'_to') time from edited_logs to3 where
							to3.userid = ID and
							to3.event = "IN" and
							to3.time >= "12:00:00" and
                            to3.time < "17:00:00" and
                            to3.edited = 3 and
							to3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("MO #",mo3.remark,"_BUI_",mo3.time,'_mo') time from edited_logs mo3 where
							mo3.userid = ID and
							mo3.event = "IN" and
							mo3.time >= "12:00:00" and
                            mo3.time < "17:00:00" and
                            mo3.edited = 4 and
							mo3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
						"DAY OFF_BUI_dayoff_dayoff"
					),
                    "|",
                    COALESCE(
						(SELECT CONCAT("SO #",so4.remark,"_BUI_",so4.time,'_so') time from so_logs so4 where
							so4.userid = ID and
							so4.event = "OUT" and
							so4.time = "18:00:00" and
							so4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo4.time,'_cdo') time from cdo_logs cdo4 where
							cdo4.userid = ID and
							cdo4.event = "OUT" and
							cdo4.time = "18:00:00" and
							cdo4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave4.remark,"_BUI_",leave4.time,'_leave') time from leave_logs leave4 where
							leave4.userid = ID and
							leave4.event = "OUT" and
							leave4.time = "18:00:00" and
							leave4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
						(SELECT CONCAT(edited4.time,"_BUI_",edited4.time,'_edited') from edited_logs edited4 where
							edited4.userid = ID and
							edited4.event = "OUT" and
							edited4.time >= "13:00:00" and
							edited4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #EDITED LOGS
                        (SELECT CONCAT("TO #",to4.remark,"_BUI_",to4.time,'_to') time from edited_logs to4 where
							to4.userid = ID and
							to4.event = "OUT" and
							to4.time = "08:00:00" and
                            to4.edited = 3 and
							to4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("MO #",mo4.remark,"_BUI_",mo4.time,'_mo') time from edited_logs mo4 where
							mo4.userid = ID and
							mo4.event = "OUT" and
							mo4.time = "08:00:00" and
                            mo4.edited = 4 and
							mo4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
						"DAY OFF_BUI_dayoff_dayoff"
					)
				),
				CONCAT(
					COALESCE(
						(SELECT CONCAT("SO #",so1.remark,"_BUI_",so1.time,'_so') time from so_logs so1 where
							so1.userid = ID and
							so1.event = "IN" and
							so1.time = "08:00:00" and
							so1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo1.time,'_cdo') time from cdo_logs cdo1 where
							cdo1.userid = ID and
							cdo1.event = "IN" and
							cdo1.time = "08:00:00" and
							cdo1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave1.remark,"_BUI_",leave1.time,'_leave') time from leave_logs leave1 where
							leave1.userid = ID and
							leave1.event = "IN" and
							leave1.time = "08:00:00" and
							leave1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
						(SELECT CONCAT(edited1.time,"_BUI_",edited1.time,'_edited') time from edited_logs edited1 where
							edited1.userid = ID and
							edited1.event = "IN" and
							edited1.time < "12:00:00" and
                            edited1.edited = 1 and
							edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #EDITED LOGS
                        (SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday1 where
							holiday1.userid = "001" and
							holiday1.event = "OUT" and
							holiday1.time = "12:00:00" and
							holiday1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #HOLIDAY LOGS
                        (SELECT CONCAT("JO BREAK_BUI_",jo_break1.time,'_jobreak') time from edited_logs jo_break1 where
							jo_break1.userid = ID and
							jo_break1.event = "IN" and
							jo_break1.time = "08:00:00" and
							jo_break1.remark = "JO BREAK" and
                            jo_break1.edited = 2 and
							jo_break1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #JO BREAK LOGS
                        (SELECT CONCAT("TO #",to1.remark,"_BUI_",to1.time,'_to') time from edited_logs to1 where
							to1.userid = ID and
							to1.event = "IN" and
							to1.time = "08:00:00" and
                            to1.edited = 3 and
							to1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("MO #",mo1.remark,"_BUI_",mo1.time,'_mo') time from edited_logs mo1 where
							mo1.userid = ID and
							mo1.event = "IN" and
							mo1.time = "08:00:00" and
                            mo1.edited = 4 and
							mo1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
						"empty_BUI_empty_empty"
					),
					"|",
                    COALESCE(
						(SELECT CONCAT("SO #",so2.remark,"_BUI_",so2.time,'_so') time from so_logs so2 where
							so2.userid = ID and
							so2.event = "OUT" and
							so2.time = "12:00:00" and
							so2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo2.time,'_cdo') time from cdo_logs cdo2 where
							cdo2.userid = ID and
							cdo2.event = "OUT" and
							cdo2.time = "12:00:00" and
							cdo2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave2.remark,"_BUI_",leave2.time,'_leave') time from leave_logs leave2 where
							leave2.userid = ID and
							leave2.event = "OUT" and
							leave2.time = "12:00:00" and
							leave2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
                        (SELECT CONCAT(edited2.time,"_BUI_",edited2.time,'_edited') from edited_logs edited2 where
							edited2.userid = ID and
							edited2.event = "OUT" and
							edited2.time > "08:00:00" and
                            edited2.edited = 1 and
							edited2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #EDITED LOGS
                        (SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday2 where
							holiday2.userid = "001" and
							holiday2.event = "OUT" and
							holiday2.time = "12:00:00" and
							holiday2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #HOLIDAY LOGS
                        (SELECT CONCAT("JO BREAK_BUI_",jo_break2.time,"_jobreak") time from edited_logs jo_break2 where
							jo_break2.userid = ID and
							jo_break2.event = "OUT" and
							jo_break2.time = "12:00:00" and
							jo_break2.remark = "JO BREAK" and
                            jo_break2.edited = 2 and
							jo_break2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #JO BREAK LOGS
                        (SELECT CONCAT("TO #",to2.remark,"_BUI_",to2.time,'_to') time from edited_logs to2 where
							to2.userid = ID and
							to2.event = "OUT" and
							to2.time = "12:00:00" and
                            to2.edited = 3 and
							to2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("Memo #",mo2.remark,"_BUI_",mo2.time,'_to') time from edited_logs mo2 where
							mo2.userid = ID and
							mo2.event = "OUT" and
							mo2.time = "12:00:00" and
                            mo2.edited = 4 and
							mo2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
						"empty_BUI_empty_empty"
					),
                    "|",
                    COALESCE(
						(SELECT CONCAT("SO #",so3.remark,"_BUI_",so3.time,'_so') time from so_logs so3 where
							so3.userid = ID and
							so3.event = "IN" and
							so3.time = "13:00:00" and
							so3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo3.time,'_cdo') time from cdo_logs cdo3 where
							cdo3.userid = ID and
							cdo3.event = "IN" and
							cdo3.time = "13:00:00" and
							cdo3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave3.remark,"_BUI_",leave3.time,'_leave') time from leave_logs leave3 where
							leave3.userid = ID and
							leave3.event = "IN" and
							leave3.time = "13:00:00" and
							leave3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
						(SELECT CONCAT(edited3.time,"_BUI_",edited3.time,'_edited') time from edited_logs edited3 where
							edited3.userid = ID and
							edited3.event = "IN" and
                            edited3.edited = 1 and
							edited3.time >= "12:00:00" and
							edited3.time < "17:00:00" and
							edited3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #EDITED LOGS
                        (SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday3 where
							holiday3.userid = "001" and
							holiday3.event = "IN" and
							holiday3.time = "13:00:00" and
							holiday3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #HOLIDAY LOGS
                        (SELECT CONCAT("JO BREAK_BUI_",jo_break3.time,'_jobreak') time from edited_logs jo_break3 where
							jo_break3.userid = ID and
							jo_break3.event = "IN" and
							jo_break3.time >= "12:00:00" and
							jo_break3.time < "17:00:00" and
							jo_break3.remark = "JO BREAK" and
                            jo_break3.edited = 2 and
							jo_break3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #JO BREAK LOGS
                        (SELECT CONCAT("TO #",to3.remark,"_BUI_",to3.time,'_to') time from edited_logs to3 where
							to3.userid = ID and
							to3.event = "IN" and
                            to3.time >= "12:00:00" and
							to3.time < "17:00:00" and
                            to3.edited = 3 and
							to3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("MO #",mo3.remark,"_BUI_",mo3.time,'_mo') time from edited_logs mo3 where
							mo3.userid = ID and
							mo3.event = "IN" and
                            mo3.time >= "12:00:00" and
							mo3.time < "17:00:00" and
                            mo3.edited = 4 and
							mo3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
						"empty_BUI_empty_empty"
					),
                    "|",
                    COALESCE(
						(SELECT CONCAT("SO #",so4.remark,"_BUI_",so4.time,'_so') time from so_logs so4 where
							so4.userid = ID and
							so4.event = "OUT" and
							so4.time > "13:00:00" and
							so4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #SO LOGS
						(SELECT CONCAT("CDO_BUI_",cdo4.time,'_cdo') time from cdo_logs cdo4 where
							cdo4.userid = ID and
							cdo4.event = "OUT" and
							cdo4.time > "13:00:00" and
							cdo4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #CDO LOGS
						(SELECT CONCAT(leave4.remark,"_BUI_",leave4.time,'_leave') time from leave_logs leave4 where
							leave4.userid = ID and
							leave4.event = "OUT" and
							leave4.time > "13:00:00" and
							leave4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #LEAVE LOGS
						(SELECT CONCAT(edited4.time,"_BUI_",edited4.time,'_edited') from edited_logs edited4 where
							edited4.userid = ID and
							edited4.event = "OUT" and
							edited4.time > "13:00:00" and
							edited4.edited = 1 and
							edited4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #EDITED LOGS
                        (SELECT "HOLIDAY_BUI_holiday_holiday" time from edited_logs holiday4 where
							holiday4.userid = "001" and
							holiday4.event = "OUT" and
							holiday4.time > "13:00:00" and
							holiday4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #HOLIDAY LOGS
                        (SELECT CONCAT("JO BREAK_BUI_",jo_break4.time,"_jobreak") time from edited_logs jo_break4 where
							jo_break4.userid = ID and
							jo_break4.event = "OUT" and
							jo_break4.time > "13:00:00" and
							jo_break4.remark = "JO BREAK" and
                            jo_break4.edited = 2 and
							jo_break4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #JO BREAK LOGS
                        (SELECT CONCAT("TO #",to4.remark,"_BUI_",to4.time,'_to') time from edited_logs to4 where
							to4.userid = ID and
							to4.event = "OUT" and
							to4.time > "13:00:00" and
                            to4.edited = 3 and
							to4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #TO LOGS
                        (SELECT CONCAT("MO #",mo4.remark,"_BUI_",mo4.time,'_mo') time from edited_logs mo4 where
							mo4.userid = ID and
							mo4.event = "OUT" and
							mo4.time > "13:00:00" and
                            mo4.edited = 4 and
							mo4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
							ORDER BY TIME ASC
							LIMIT 1
						), #MEMO LOGS
						"empty_BUI_empty_empty"
					)
                )
			)
		) time,
		IF(
			(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is not null,
			' ', #statement true,empty the late if holiday exist
            (
				COALESCE(
					GREATEST(
						TIMESTAMPDIFF(MINUTE,
							CONCAT(
									adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i),
									" ",
									IF(
										DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Monday" and
										(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null,
										"08:30:00",
										IF(
											DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Tuesday" and
											(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
											(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) , INTERVAL 1 DAY) limit 1) is not null, #holiday monday
											"08:30:00",
											IF(
												 DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Wednesday" and
												 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
												 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) , INTERVAL 2 DAY) limit 1) is not null and #holiday monday
												 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) , INTERVAL 1 DAY) limit 1) is not null, #holiday tuesday
												 "08:30:00",
												  IF(
													  DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Thursday" and
													  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
													  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) , INTERVAL 3 DAY) limit 1) is not null and #holiday monday
													  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 2 DAY) limit 1) is not null and #holiday tuesday
													  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 1 DAY) limit 1) is not null, #holiday wednesday
													  "08:30:00",
													   IF(
															DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Friday" and
															(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
															(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) , INTERVAL 4 DAY) limit 1) is not null and #holiday monday
															(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 3 DAY) limit 1) is not null and #holiday tuesday
															(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 2 DAY) limit 1) is not null and #holiday wednesday
															(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 1 DAY) limit 1) is not null, #holiday thursday
															"08:30:00",
															"09:00:00" #default set morning late
													   )
												  )
											 )
										 )
									 )
							), #1st condition timestamdiff
							CONCAT(
								adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)," ",
								COALESCE(
									(SELECT time from edited_logs edited1 where
										edited1.userid = ID and
										edited1.event = "IN" and
										edited1.time < "12:00" and
										edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									), #edited logs
									0
								)
							) #2nd condition timetampdiff
						), #1st condition greatest
						0 #2nd condition greatest
					), #1st coalesce end greatest
					0 #2nd coalesce
				) +
				COALESCE(
					GREATEST(
						TIMESTAMPDIFF(MINUTE,
							CONCAT(adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)," ","13:00:00"), #1st condition timetamppdiff
							CONCAT(
								adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)," ",
								COALESCE(
									(SELECT time from edited_logs edited3 where
										edited3.userid = ID and
										edited3.event = "IN" and
										edited3.time >= "12:00" and
										edited3.time < "17:00" and
										edited3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									), #EDITED LOGS
									0
								)
							) #2nd condition timetampdiff
						), #1st condition greatest
						0 #2nd condition greatest
					), #1st coalesce
					0 #2nd coalesce
				)
			) #statement false
        ) late,
        IF(
			(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is not null or
            DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Saturday" or
            DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Sunday",
            " ",#STATEMENT IS TRUE
            COALESCE(
				GREATEST(
					TIMESTAMPDIFF(MINUTE,
						CONCAT(adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)," ",
							IF(
								COALESCE(
									(SELECT time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time >= "12:00:00" and
										dtr2.time < "17:00:00" and
										dtr2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME DESC
										LIMIT 1
									),
									(SELECT time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time > "08:00:00" and
										dtr2.time < "12:00:00" and
										dtr2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									),
									(SELECT time from edited_logs edited2 where
										edited2.userid = ID and
										edited2.event = "OUT" and
										edited2.time > "8:00:00" and
										edited2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									) #EDITED LOGS
								) #if first condition
								<
								IF(
									(SELECT time from dtr_file dtr3 where
										dtr3.userid = ID and
										dtr3.event = "IN" and
										dtr3.time >= "12:00" and
										dtr3.time < "17:00" and
										dtr3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									) #listed if - first condition
									<
									(SELECT time from dtr_file dtr4 where
										dtr4.userid = ID and
										dtr4.event = "OUT" and
										dtr4.event = "OUT" and
										dtr4.time > "13:00" and
										dtr4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME DESC
										LIMIT 1
									), #listed if = second condition
									(SELECT time from dtr_file dtr3 where
										dtr3.userid = ID and
										dtr3.event = "IN" and
										dtr3.time >= "12:00" and
										dtr3.time < "17:00" and
										dtr3.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									), #listed if = true dtr3
									"17:00:00" #2nd if false
								), #IF second condition
								COALESCE(
									(SELECT time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time >= "12:00:00" and
										dtr2.time < "17:00:00" and
										dtr2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									),
									(SELECT time from dtr_file dtr2 where
										dtr2.userid = ID and
										dtr2.event = "OUT" and
										dtr2.time > "08:00:00" and
										dtr2.time < "12:00:00" and
										dtr2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									),
									(SELECT time from edited_logs edited2 where
										edited2.userid = ID and
										edited2.event = "OUT" and
										edited2.time > "8:00:00" and
										edited2.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
										ORDER BY TIME ASC
										LIMIT 1
									) #EDITED LOGS
								), #if true
								"12:00:00" #if false
							) #end if
						), #1st condition timedifference
						CONCAT(
							adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)," ","12:00:00"
						) #2nd condition timedifference
					) #end time timedifference
				,0)
			,0) +
			COALESCE(
				GREATEST(
					TIMESTAMPDIFF(MINUTE,
						CONCAT(adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)," ",
							COALESCE(
								(SELECT time from dtr_file dtr4 where
								dtr4.userid = ID and
								dtr4.event = "OUT" and
								dtr4.time > "13:00" and
								dtr4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
								ORDER BY TIME DESC
								LIMIT 1
								), #NORMAL LOGS
								(SELECT time from edited_logs edited4 where
									edited4.userid = ID and
									edited4.event = "OUT" and
									edited4.time > "13:00" and
									edited4.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
									ORDER BY TIME ASC
									LIMIT 1
								) #EDITED LOGS
							)
						),
						CONCAT(
							adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i),
							" ",
							IF(
								DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Monday" and
								(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null,
								IF(
									(SELECT time from edited_logs edited1 where
									edited1.userid = ID and
									edited1.event = "IN" and
									edited1.time < "12:00:00" and
									edited1.edited = 1 and
									edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
									ORDER BY TIME ASC
									LIMIT 1
									) IS NULL,
									"17:00:00",
									ADDTIME(
										IF(
											(
												SELECT time from edited_logs edited1 where
												edited1.userid = ID and
												edited1.event = "IN" and
												edited1.time < "12:00:00" and
												edited1.edited = 1 and
												edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
												ORDER BY TIME ASC
												LIMIT 1
											)
											>=
											"08:30:00",
											"08:30:00",
											IF(
												(SELECT time from edited_logs edited1 where
												edited1.userid = ID and
												edited1.event = "IN" and
												edited1.time < "12:00:00" and
												edited1.edited = 1 and
												edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
												ORDER BY TIME ASC
												LIMIT 1
												)
												<=
												"07:00:00",
												"07:00:00",
												IF(
													(SELECT time from edited_logs edited1 where
													edited1.userid = ID and
													edited1.event = "IN" and
													edited1.time < "12:00:00" and
													edited1.edited = 1 and
													edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
													ORDER BY TIME ASC
													LIMIT 1
													) is null,
													"08:00:00",
													(SELECT time from edited_logs edited1 where
													edited1.userid = ID and
													edited1.event = "IN" and
													edited1.time < "12:00:00" and
													edited1.edited = 1 and
													edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
													ORDER BY TIME ASC
													LIMIT 1
													)
												)
											)
										),
										"09:00:00"
									) #end addtime
								),
								IF(
									DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Tuesday" and
									(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
									(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 1 DAY) limit 1) is not null, #holiday monday
									IF(
										(
											SELECT time from edited_logs edited1 where
											edited1.userid = ID and
											edited1.event = "IN" and
											edited1.time < "12:00:00" and
											edited1.edited = 1 and
											edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
											ORDER BY TIME ASC
											LIMIT 1
										) IS NULL,
										"17:00:00",
										ADDTIME(
											IF(
												(
													SELECT time from edited_logs edited1 where
													edited1.userid = ID and
													edited1.event = "IN" and
													edited1.time < "12:00:00" and
													edited1.edited = 1 and
													edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
													ORDER BY TIME ASC
													LIMIT 1
												)
												>=
												"08:30:00",
												"08:30:00",
												IF(
													(SELECT time from edited_logs edited1 where
													edited1.userid = ID and
													edited1.event = "IN" and
													edited1.time < "12:00:00" and
													edited1.edited = 1 and
													edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
													ORDER BY TIME ASC
													LIMIT 1
													)
													<=
													"07:00:00",
													"07:00:00",
													IF(
														(SELECT time from edited_logs edited1 where
														edited1.userid = ID and
														edited1.event = "IN" and
														edited1.time < "12:00:00" and
														edited1.edited = 1 and
														edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
														ORDER BY TIME ASC
														LIMIT 1
														) is null,
														"08:00:00",
														(SELECT time from edited_logs edited1 where
														edited1.userid = ID and
														edited1.event = "IN" and
														edited1.time < "12:00:00" and
														edited1.edited = 1 and
														edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
														ORDER BY TIME ASC
														LIMIT 1
														)
													)
												)
											),
											"09:00:00"
										) #end addtime
									), #endif
									IF(
										 DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) ) = "Wednesday" and
										 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
										 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 2 DAY) limit 1) is not null and #holiday monday
										 (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 1 DAY) limit 1) is not null, #holiday tuesday
										 IF(
												(
													SELECT time from edited_logs edited1 where
													edited1.userid = ID and
													edited1.event = "IN" and
													edited1.time < "12:00:00" and
													edited1.edited = 1 and
													edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
													ORDER BY TIME ASC
													LIMIT 1
												) IS NULL,
												"17:00:00",
												ADDTIME(
													IF(
														(SELECT time from edited_logs edited1 where
														edited1.userid = ID and
														edited1.event = "IN" and
														edited1.time < "12:00:00" and
														edited1.edited = 1 and
														edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
														ORDER BY TIME ASC
														LIMIT 1
														)
														>=
														"08:30:00",
														"08:30:00",
														IF(
															(SELECT time from edited_logs edited1 where
															edited1.userid = ID and
															edited1.event = "IN" and
															edited1.time < "12:00:00" and
															edited1.edited = 1 and
															edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
															ORDER BY TIME ASC
															LIMIT 1
															)
															<=
															"07:00:00",
															"07:00:00",
															IF(
																(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.edited = 1 and
																edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																ORDER BY TIME ASC
																LIMIT 1
																) is null,
																"08:00:00",
																(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.edited = 1 and
																edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																ORDER BY TIME ASC
																LIMIT 1
																)
															)
														)
													),
													"09:00:00"
												) #end addtime
											),
										  IF(
											  DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)) = "Thursday" and #HOT SEAT
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 3 DAY) limit 1) is not null and #holiday monday
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 2 DAY) limit 1) is not null and #holiday tuesday
											  (SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 1 DAY) limit 1) is not null, #holiday wednesday
											  IF(
													(
														SELECT time from edited_logs edited1 where
														edited1.userid = ID and
														edited1.event = "IN" and
														edited1.time < "12:00:00" and
														edited1.edited = 1 and
														edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
														ORDER BY TIME ASC
														LIMIT 1
													) IS NULL,
													"17:00:00",
													ADDTIME(
														IF(
															(SELECT time from edited_logs edited1 where
															edited1.userid = ID and
															edited1.event = "IN" and
															edited1.time < "12:00:00" and
															edited1.edited = 1 and
															edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
															ORDER BY TIME ASC
															LIMIT 1
															)
															>=
															"08:30:00",
															"08:30:00",
															IF(
																(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.edited = 1 and
																edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																ORDER BY TIME ASC
																LIMIT 1
																)
																<=
																"07:00:00",
																"07:00:00",
																IF(
																	(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.edited = 1 and
																	edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																	ORDER BY TIME ASC
																	LIMIT 1
																	) is null,
																	"08:00:00",
																	(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.edited = 1 and
																	edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																	ORDER BY TIME ASC
																	LIMIT 1
																	)
																)
															)
														),
														"09:00:00"
													) #end addtime
											   ),
											   IF(
													DAYNAME( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)) = "Friday" and
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) limit 1) is null and
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 4 DAY) limit 1) is not null and #holiday monday
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 3 DAY) limit 1) is not null and #holiday tuesday
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 2 DAY) limit 1) is not null and #holiday wednesday
													(SELECT "HOLIDAY" from edited_logs hol where hol.userid = "001" and hol.event = "IN" and hol.time = "08:00:00" and hol.datein = DATE_SUB( adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i), INTERVAL 1 DAY) limit 1) is not null, #holiday thursday
													IF(
														(
															SELECT time from edited_logs edited1 where
															edited1.userid = ID and
															edited1.event = "IN" and
															edited1.time < "12:00:00" and
															edited1.edited = 1 and
															edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
															ORDER BY TIME ASC
															LIMIT 1
														) IS NULL,
														"17:00:00",
														ADDTIME(
															IF(
																(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.edited = 1 and
																edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																ORDER BY TIME ASC
																LIMIT 1
																)
																>=
																"08:30:00",
																"08:30:00",
																IF(
																	(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.edited = 1 and
																	edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																	ORDER BY TIME ASC
																	LIMIT 1
																	)
																	<=
																	"07:00:00",
																	"07:00:00",
																	IF(
																		(SELECT time from edited_logs edited1 where
																		edited1.userid = ID and
																		edited1.event = "IN" and
																		edited1.time < "12:00:00" and
																		edited1.edited = 1 and
																		edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																		ORDER BY TIME ASC
																		LIMIT 1
																		) is null,
																		"08:00:00",
																		(SELECT time from edited_logs edited1 where
																		edited1.userid = ID and
																		edited1.event = "IN" and
																		edited1.time < "12:00:00" and
																		edited1.edited = 1 and
																		edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																		ORDER BY TIME ASC
																		LIMIT 1
																		)
																	)
																)
															),
															"09:00:00"
														) #end addtime
												   ),
													ADDTIME(
														IF(
															(SELECT time from edited_logs edited1 where
																edited1.userid = ID and
																edited1.event = "IN" and
																edited1.time < "12:00:00" and
																edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																ORDER BY TIME ASC
																LIMIT 1
															)
															<
															"09:00:00",
															IF(
																(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																	ORDER BY TIME ASC
																	LIMIT 1
																)
																>
																"07:00:00",
																(SELECT time from edited_logs edited1 where
																	edited1.userid = ID and
																	edited1.event = "IN" and
																	edited1.time < "12:00:00" and
																	edited1.datein = adddate('2010-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)
																	ORDER BY TIME ASC
																	LIMIT 1
																), #1st condition
																"07:00:00" #2nd condition
															), #1st condition
															"09:00:00" #2nd condition
														),
														"09:00:00" # interval 9 hours
													) # end addtime MORNING TIMEIN
											   )
										  )
									 )
								 )
							 )
						) #end concat
					)
				,0)
			,0) #STATEMENT IS FALSE IF HOLIDAY IS NOT NULL
        ) undertime
	from
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
	(select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) fetchDay
    where fetchDay.datein >= datein_from and fetchDay.datein <= datein_to


) logs
group by logs.datein
order by logs.datein asc;


END