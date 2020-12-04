function  get_dogovor_info($code)
{

	$current_user = wp_get_current_user();
	$login= $current_user -> user_login;
	
	
	
	
	$mySQL_connect_info = get_connect_info();
		
		// Попытка установить соединение с MySQL:
		$db_connect = mysql_connect($mySQL_connect_info['host'], $mySQL_connect_info['user'], $mySQL_connect_info['pass']);
		if (!$db_connect) {
			echo "Помилка підключення до серверу БД"."\n";
			echo "ERROR ".mysql_errno()." ".mysql_error()."\n";
			exit;
		}
		
		$charset = mysql_client_encoding($db_connect);
		//echo "Code name: $charset\n";
		
		if (!mysql_set_charset('utf8', $db_connect)) {
		    echo "Error: Unable to set the character set.\n";
		    exit;
		}
		
		$charset = mysql_client_encoding($db_connect);
		//echo "Now code name: $charset\n";
			
		// Соединились, теперь выбираем базу данных:
		mysql_select_db($mySQL_connect_info['db']);
	
	 
	 
	
	
$result  = mysql_query("select * from factory where CODE = '{$code}'");
				if (mysql_error()) {
					echo "Помилка роботи з БД. Деталі:", mysql_error();
				}

				while ($row  = mysql_fetch_array($result, MYSQL_ASSOC)){
						$now_user['code'] = $row['CODE'];
						$now_user['bill'] = $row['BILL'];
						$now_user['mfo']  = $row['MFO'];
						$now_user['okpo']  = $row['OKPO'];
						$now_user['name']  = $row['NAME'];
						$now_user['adr']  = $row['ADR'];
						$now_user['telr']  = $row['TELR'];
						$now_user['telb']  = $row['TELB'];
						$now_user['ruk']  = $row['RUK'];
						$now_user['dogov']  = $row['DOGOV'];
						$now_user['dogov_ok']  = $row['DOGOV_OK'];
						$now_user['ipn']  = $row['IPN'];
				        $now_user['ns']  = $row['NS'];
						$now_user['flag']  = $row['FLAG'];
						$now_user['penya']  = $row['PENYA'];
						
						$now_user['kontr']  = $row['KONTR'];
						$now_user['email']= $current_user ->user_email;
	                    
                     
                }
				
				mysql_free_result ($result);
				
				
				
				
				
				
				
               $result  = mysql_query("select * from spr_org where SUBSTRING(CODE,1,4) = '{$code}'");
			   
			   
			   
			   
			   
				if (mysql_error()) {
					echo "Помилка роботи з БД. Деталі:", mysql_error();
				}
				$i=0;
				while ($row  = mysql_fetch_array($result, MYSQL_ASSOC)){
					     $code=$row['CODE'];
						$now_obj[$i]['code'] = $row['CODE'];
						$now_obj[$i]['name'] = $row['NAME'];
						$now_obj[$i]['adr'] = $row['ADR'];
						$now_obj[$i]['tariff']  = $row['TARIFF'];
						$now_obj[$i]['vdmr']  = $row['VDMR'];
						$now_obj[$i]['vdo']  = $row['VDO'];
						if(mb_substr($row['TARIFF'],0,1)=='1'){
							$now_obj[$i]['usluga']  = "Водопостачання";
						}elseif(mb_substr($row['TARIFF'],0,1)=='2'){
						     $now_obj[$i]['usluga']  =  "Водопостачання та водовідведення"	;
						}elseif(mb_substr($row['TARIFF'],0,1)=='3'){
						   $now_obj[$i]['usluga']  = "Водовідведення";
						}
						$now_obj[$i]['vdmr']  = $row['VDMR'];
						$now_obj[$i]['d_raspl']  = $row['D_RASPL'];
						$now_obj[$i]['d_ust']  = $row['D_UST'];
						$now_obj[$i]['priz']  = $row['PRIZ'];
						
						
				
		
        $i++;
		}				
						
						
					
				
				
				
				
		mysql_close($db_connect);
		
		
		return array($now_user,$now_obj);
}
endif;
