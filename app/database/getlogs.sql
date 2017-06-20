call dohdtr.GETLOGS('08:00:00', '12:00:00', '13:00:00', '18:00:00', '0546', '2017-06-01', '2017-06-31');


IF((SELECT a.time FROM dtr_file a WHERE  userid = d.userid and datein = d.datein AND (a.time > (SELECT time from dtr_file where userid = d.userid and datein = d.datein and time < AMOUT ORDER BY time asc limit 1 )) AND a.time < PMOUT ORDER BY a.time ASC LIMIT 1),
		#IF TRUE
		(SELECT t2.time FROM dtr_file t2 WHERE  userid = d.userid and datein = d.datein AND (t2.time > (SELECT time from dtr_file where userid = d.userid and datein = d.datein and time < AMOUT ORDER BY time asc limit 1 )) AND t2.time < PMOUT ORDER BY t2.time ASC LIMIT 1),
		#IF FALSE
		()
	 )
     
     
     
	(SELECT CONCAT(t1.time,'_', t1.edited) FROM dtr_file t1 WHERE userid = d.userid and datein = d.datein and t1.time < AMOUT ORDER BY time ASC LIMIT 1) as am_in,

	(SELECT CONCAT(t2.time,'_',t2.edited)  FROM dtr_file t2 WHERE  userid = d.userid and datein = d.datein AND (t2.time > (SELECT time from dtr_file where userid = d.userid and datein = d.datein and time < AMOUT ORDER BY time asc limit 1 )) AND t2.time < PMOUT ORDER BY t2.time ASC LIMIT 1) as am_out,
	 
	 
	(SELECT CONCAT(t3.time,'_',t3.edited) FROM dtr_file t3 WHERE userid = d.userid and datein = d.datein AND t3.time > IF(TRUE,'','')

	
	 ORDER BY t3.time ASC LIMIT 1 ) as pm_in,
	
     (SELECT  CONCAT(MAX(t4.time),'_',t4.edited) FROM dtr_file t4 WHERE userid = d.userid AND datein = d.datein and t4.time > PMIN ORDER BY time DESC LIMIT 1) as pm_out