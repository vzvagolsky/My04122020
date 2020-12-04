<?php
require_once('funcdb.php');

//////////////////////////////////////////////////////////////////////////////////////
///////////////////////Дополнительные функции/////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
function XmlToArray($inXmlset){ 
        $resource    =    xml_parser_create(); 
        xml_parse_into_struct($resource, $inXmlset, $outArray);
        xml_parser_free($resource);
        return $outArray;
        }
function getValueByTag($xmlArray,$needle){
        foreach ($xmlArray as $i){
        if($i['tag']==strtoupper($needle))
        return $i['value'];  
        } 
        }   
function datetime(){return date('Y-m-d\TH:i:s', time());}

function Date11(){return date('Y-m-d', time());}
    
function Loger($msg){        
        $fd = fopen("EasySoft_LOG/EasySoft_Log_".date('Y-m-d', time()).".txt", "a");
        fwrite($fd, "\r\n\r\n--------------------------".datetime()."-------------------------------\r\n\r\n".$msg);
        fclose($fd);
        }
//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////Основные функции///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////    
function createOperation($inXmlset){ // 
        $xmlArr=XmlToArray($inXmlset);
        foreach ($xmlArr as $i)
         switch ($i['tag']) {
          case 'CHECK': Check(getValueByTag($xmlArr,'SERVICEID'),getValueByTag($xmlArr,'ACCOUNT'));
          return;
          case 'PAYMENT': Payment(getValueByTag($xmlArr,'SERVICEID'),getValueByTag($xmlArr,'ACCOUNT'),getValueByTag($xmlArr,'AMOUNT'),getValueByTag($xmlArr,'ORDERID'));           
          return;
          case 'CONFIRM':Confirm(getValueByTag($xmlArr,'SERVICEID'),getValueByTag($xmlArr,'PAYMENTID'));   
          return;
          }}
function sendResponse($status_code, $status_detail, $params){
$response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<Response>
<StatusCode>$status_code</StatusCode>
<StatusDetail>$status_detail</StatusDetail>
<DateTime>".datetime()."</DateTime>
<Sign></Sign>$params
</Response>"; 
Loger($response);
print($response);
} 
    

	
	
	
function Check($service_id,$account){
	
	 $user_info = @get_account_info($account);
	// $value=get_last_value($user_info['account']);
	
	
	
	 
	 $OldValue= $user_info['last_count']+$user_info['cubavans'];;
	 
	
	 
	  if(empty($user_info['account'])){
		  $account_info='';
		  $status_code = -1;
		   $status_detail='SOME_ERROR';  
	  }else{
		 $status_code = 0; 
         $status_detail='OK';  
		 $user_name=$user_info['lastname']." ". $user_info['firstname']." ".$user_info['surname'];
		 $adres=$now_user['addr'];
		 $balance=get_balance($account);
		 
		 $b1=$balance['Debt'];
		 $b2=$balance['Amount'];
		 $b3=$balance['PaymentAmount'];
		 
		
		 
		 $tarif=$user_info['tarif'];
		 $account_info = "<AccountInfo><UserName>$user_name</UserName></AccountInfo><Products><Product><ServiceId>10520</ServiceId><ProductId>1</ProductId><Address>$adres</Address><Account>$account</Account>
		 <UserName>$user_name</UserName>
		 <Name lang='ru'>Централизованное водоснабжение и централизованное водоотведение</Name>
		 <Name lang='uk'>Централізоване водопостачання та централізоване водовідведення</Name>
		 <Date>".Date11()."</Date><Debt>$b1</Debt>
		 <Amount>$b2</Amount><PaymentAmount>$b3</PaymentAmount>
		 <Meters><Meter><Id>1</Id><Name></Name><Tariff>$tarif</Tariff><Unit>куб</Unit><OldValue>$OldValue</OldValue>
		 </Meter></Meters>
		 </Product>
		 </Products>";
		 
	  }
	  
	
	  
	  sendResponse($status_code,$status_detail,$account_info);
}
		  

function Payment($service_id,$account,$amount,$order_id){
//Проверяем возможность платежа, и вносим платеж в систему
//Это только предварительный платеж. Без подтверждения функцией Confirm - недействителен.


$vodata['account']=$account;
$vodata['data']=$amount;


$vodata['transactionId']= $order_id;


$paimentID = $account."_".date('Ymd-His');

$vodata['docId']=$paimentID ;







$result=add_data($vodata);


if($result>0)
{
 $status_code = 0; 
 $status_detail='OK'; 
 $payment_id =$paimentID;
 $param = "<PaymentId>$payment_id</PaymentId>";
}
else{
$status_code = -1; 
$status_detail='SOME_ERROR';
$param = "";
}
sendResponse($status_code,$status_detail,$param);
}

function Confirm($service_id,$payment_id){
//Проверяем в БД наличие предварительного платежа Payment,
//если все хорошо - подтверждаем платеж




if(get_paimantID($payment_id))
	
{
 $status_code = 0; 
 $status_detail='OK'; 
 $param = "<OrderDate>".datetime()."</OrderDate>";// дата, которая фиксируется у вас как дата совершения платежа (списание денег), 
 //она же проходит по бухгалтерии и финансовым документам.
}
else{
$status_code = -1; 
$status_detail='SOME_ERROR';
$param = "";
}
sendResponse($status_code,$status_detail,$param);
}

CreateOperation($GLOBALS['HTTP_RAW_POST_DATA']);

?>
