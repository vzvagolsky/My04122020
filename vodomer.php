<?php if(!is_user_logged_in()) {
  wp_safe_redirect(home_url('/login01')); exit; } ?>

<?php

/**
    Template Name: vodomer
 * The template: User info pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Vodokanal
 */

// проверим возможность


 $uacc = 0;
if( current_user_can('view_as_proxy') ){
	$user_role = 'operator';
	$uacc = get_uacc();
	if ($uacc > 0) { $is_proxy = 1; } else { $is_proxy = 0; }
	list($now_user,$now_obj) = get_dogovor_info($uacc);
	$code=$now_user['code'];
} else {
	$user_role = 'user';
	$is_proxy = 0;
	
	$current_user = wp_get_current_user();
	$code=$current_user->user_login;
    	
	list($now_user,$now_obj)=get_dogovor_info($code);
	$code=$now_user['code'];
}







get_header('auth01'); ?>

<?php
//Установть на c 25 числа
//$dizable="";  
$dizable="disabled";

$indicate=0;
$control=1;

$message=Array();
 

 $now_date = date('Y-m-d');

$day=substr($now_date,8,2);
 if(( $day>24) and ($day<31)){
$dizable="";
 }else{
	 $dizable="disabled";
 } 

if (isset($_POST['button1'])){


	
	$i=0;
	
	foreach ($_POST['indicate'] as $value) {
	
	$indicate = floatval($value);
    $code =  htmlentities($_POST['code'][$i]);
	
	//echo $code."  -".$indicate."<br>";
	
	//echo $code." ".$indicate."<br>";
	

	
	
	
	
	/*
     
	$last_value = get_last_value_yu($code);
			
		if($last_value['val'] > $indicate){
			
        $control=0;
		$message[$i]="<span style='color : red'>Помилка!</span>";
	
		
		}else{
			$message[$i]="<span style='color : green'>Добре!</span>";
			
		}
$i++;
	}		

	*/
	
	
	$last_value = get_last_value_yu($code);
			
		if($last_value['val'] > $indicate){
			
        $control=1;
		//$message[$i]="<span style='color : red'>Помилка!</span>";
	   	$message[$i]="<span style='color : green'>Добре!</span>";
		
		}else{
			$message[$i]="<span style='color : green'>Добре!</span>";
			
		}
$i++;
	}		

	
	
	
	
	
	
	
	$i=0;
	
if($control==1){
	
	foreach ($_POST['indicate'] as $value) {
	
	$indicate = floatval($value);
    $code =  $_POST['code'][$i];
	
	
	
		$now_date = date('Ymd');
		
		$value_data['date']=$now_date;
		$value_data['code'] = $code;
		$value_data['val'] =  $indicate;
		$value_data['src'] = "особистий кабінет";
		
	
		
	 $result = add_value_foryuric($value_data);
	 
	 $i++;
	
	}
	
	
echo '<span style="color : green"><h4>Ваші показники  прийняті!!</h4><br></span>';	



}else{
		echo '<span style="color : red"><h4>Показання повинні бути більше попередніх!!</h4><br></span>';
	}


	
	
	

}

?>
	

  <div id="heading"></div>
  <aside></aside>
  <section>
    
		<div class="user-page">
			
      <div class="uinfo">
     
      	    <p>
         
		  <h2> <?php echo  $now_user["name"];?></h2><br/>
		   <h4> <?php $kontroler=get_kontroler($code);
			echo  "<span style='color : blue'>Показники за послуги водоспоживання надаються споживачами з 25 по 30 число кожного місяця.</span>";
		  /* if(!empty($kontroler["fio"]))
		   { 
	        
		   echo  "Контролер"." ".$kontroler["fio"]."-".$kontroler["phone"];
		   }*/
		   ?>
		   </h4><br>
		</p>

	
	
<?php 
		   

$rows = count($now_obj); // количество строк, tr



echo '<form action="#" method="post">';

echo "<table id='MyTable'>";
echo '
<tr>
<th style="background-color: #229fff; color: #fff; border-bottom: none; border-top: none;">
</th>
<th style="background-color: #229fff; color: #fff; border-bottom: none;">
 </th>
 <th style="background-color: #229fff; color: #fff ;border-bottom: none;">
 </th>
<th colspan=2 style="background-color: #229fff; color: #fff">
Попередні показники
</th>
<th colspan=2 style="background-color: #229fff; color: #fff">
Останні показники
</th>
<th style="background-color: #229fff; color: #fff;border-bottom: none;">
</th>

<tr>
			  
			    <th style="background-color: #229fff; color: #fff;border-top: none;">Рахунок</th>
	          	<th style="background-color: #229fff; color: #fff;border-top: none;">Місце встановлення</th>
				<th style="background-color: #229fff; color: #fff;border-top: none;">Вид послуги</th>
	           
	            <th  style="background-color: #229fff; color: #fff">Дата </th>
				<th  style="background-color: #229fff; color: #fff">Показники</th>
				<th  style="background-color: #229fff; color: #fff">Дата </th>
				<th  style="background-color: #229fff; color: #fff">Показники</th>
				<th  style="background-color: #229fff; color: #fff">Результат</th>
				
                
				</tr>';					
			  
	       $m=0;

for ($i=0; $i < $rows; $i++){ 

  if($now_obj[$i]['vdmr']=='1'){
	 echo "<tr>";
	 $template_url = get_template_directory_uri();
	 
	 $obj=$now_obj[$i]['code'];
	
	echo"<td>".$now_obj[$i]['code']."<br>";
    echo"<a href='/tochka-vvoda?code={$obj}'>".Інформація."</a><br>";
	echo"<a href='/yucount?code={$obj}'>".Історія."</a><br></td>";
	 
	 echo"<td>".$now_obj[$i]['adr']."</td>";
	 echo"<td>".$now_obj[$i]['usluga']."</td>";
	 
	
       
                   
						
							  $code=$now_obj[$i]['code'];
							  $last_value= get_last_value_yu($code);
							   echo"<td >".$last_value['date_val']."</td>";
							   
							   echo"<td>".number_format($last_value['val'], 0, ',', ' ')."</td>";
							   
							  
							    echo"<td >".$now_date. " </td>";
								
								$monthInd=substr($now_date,5,2);
								
								$month=['01'=>'Січень','02'=>'Лютий','03'=>'Березень','04'=>'Квітень','05'=>'Травень','06'=>'Червень','07'=>'Липень','08'=>'Серпень','09'=>'Вересень',10=>'Жовтень',11=>'Листопад',12=>'Грудень'];
		
								


							  
							   
							    
							      
  						   
						
                             
							  						 //  if($now_obj[$i]['d_raspl']> $now_obj[$i]['d_ust']){
							                         //  	   if($now_obj[$i]['priz']==1){
							   if(2==1){
							  echo "<td><br/><input class='Myinp' type='text' name ='indicate[]'  size='10'  disabled ></td>";//disable не снимать
							  
							  echo "<td></td>";
							  $m=$m-1;
							 
							 
						   }else{
							   echo "<input type='hidden' name ='code[]'  value=".$code .">";
							   
							   $val_input=get_input($code);
							 //echo "<td><br/><input class='Myinp' type='text' name ='indicate[]'  size='10'" . " ".$dizable." ". "value='". $_POST['indicate'][$m]."'</td>"; //disabled снять с 25 
							 
							 echo "<td><br/><input class='Myinp' type='text' name ='indicate[]'  size='10'" . " ".$dizable." ". "value='". intval($val_input)."'</td>"; //disabled снять с 25 
							  
							  
							    echo "<td>".$message[$m]."</td>";
								
						   }

									
							 
						
							  
							  
							  $m++;
								
						 					   
           			   
						   
						   	
               				echo "</tr>";					
	
           }
		
    }
	
	 
    echo "</table>";


	
	if(get_last_value_yu_acc($code)==true){
   echo '<button id="target" style="width:160px;height:80px;margin:5px" 
									          type="submit" name="button1"'.' '. $dizable.' '. 'value="send"  >Внести покази</button>';//disable снять с 25
		
	
	}else{
	
	 echo '<button id="target" style="width:160px;height:80px;margin:5px" 
									          type="submit" name="button1" disabled value="send"  >Внести покази</button>';//disable не снимать
											   
    }					   
	
	 ?>
	 
	  
	 
	 </form>
	 





	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		</main><!-- #main -->
	</div><!-- #primary -->

		
<div id="modal_form2"><!-- Сaмo oкнo --> 
	<span id="modal_close2">X</span> <!-- Кнoпкa зaкрыть --> 
	
	  
	  <p style="text-align: center;"><span style="text-align: center; color: #1881d2;">Інформація про спожиті послуги за <?php echo $month[$monthInd] ?>__місяць станом на _______<?php echo $now_date ?></span></p>


   <table id="MyModal">

<tr>
<th style="background-color: #229fff; color: #fff; border-bottom: none; border-top: none;">
</th>
<th style="background-color: #229fff; color: #fff; border-bottom: none;">
 </th>
 <th style="background-color: #229fff; color: #fff ;border-bottom: none;">
 </th>
<th colspan=2 style="background-color: #229fff; color: #fff">
Показники
засобів обліку, куб.м.
</th>
<th style="background-color: #229fff; color: #fff; border-bottom: none;">
 </th>


</tr>

<tr>
			     <th style="background-color: #229fff; color: #fff;border-top: none;">№ за/п</th>
				 <th style="background-color: #229fff; color: #fff;border-top: none;">Адреса об'єкта</th>
			    <th style="background-color: #229fff; color: #fff;border-top: none;">№ засобу обліку </th>
	          
	           
	           
				<th  style="background-color: #229fff; color: #fff">попередні</th>
				<th  style="background-color: #229fff; color: #fff">поточні</th>
				
				<th  style="background-color: #229fff; color: #fff">Обсяг спожитих послуг, куб.м.</th>
				
                
</tr>					
	
<?php
	
	       $m=1;

for ($i=0; $i < $rows; $i++){ 

  if($now_obj[$i]['vdmr']=='1'){
	 echo "<tr>";
	 
	 echo"<td>".$m."</td>";
	 
	 echo"<td>".$now_obj[$i]['adr']."</td>";
	
	 $obj=$now_obj[$i]['code'];
	
	echo"<td>".$now_obj[$i]['code']."</td>";
    
	 
	 
	
       
                   
						
							  $code=$now_obj[$i]['code'];
							  $last_value= get_last_value_yu($code);
	
							   
							   echo"<td>".$last_value['val']."</td>";
							   
							    
							      
  						   
							  echo "<td>"."0"."</td>";
							  
							  
							  
							  echo "<td>"."0"."</td>";
							  
							  
							  $m++;
								
						 					   
           			   
						   
						   	
               				echo "</tr>";					
	
           }
		
    }
	
	
	?>
	
	<tr>
	<td>
	Всього
	</td>
	
	<td>
	
	</td>
	
	<td>
	
	</td>
	
	<td>
	
	</td>
	
	<td>
	
	</td>
	
	<td >
	
	</td>
	
	
	</tr>
	 
 </table>

	  
	
				
		<div id="div_left"><button id="modal_but" type="submit" value="Підтвердити ">Підтвердити</button>
		<div id="div_right"><button id="modal_bu_ex" type="submit" value="Відміна">Відміна</button></div>
		</div></div>
	
		

	</div>
	<div id="overlay"></div><!-- Пoдлoжкa -->	
	 
	<script type="text/javascript">

	
	
jQuery(function ($){
	var isDone=false;
	
	
	
	$(document).ready(function() { 
	
/*	$(".Myinp").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
*/
	
	
	
	
				
		$("#target").click( function(event){ // лoвим клик пo ссылки с id="target"
		
		
      var values = $("input[name='indicate[]']")
              .map(function(){return $(this).val();}).get();		
			  
		
		
		
		  
		 //  var  myTab  = document.getElementById('MyTab');
		   var  myTab2  = document.getElementById('MyModal');
		  
		  
		  var predPokazn=new Array();
		  var nastPokazn=new Array();
		  
		  var rizn=0;
		  var SumW=0;
		  var k=0;
		   for (i = 2; i < myTab2.rows.length-1; i++) {
		  
		  
		  
		   myTab2.rows.item(i).cells[4].innerText=values[k];
		   predPokazn[i]=myTab2.rows.item(i).cells[3].innerText;
		   if((values[k]=='0') || (values[k]=='')){
			rizn=0;   
		   }else{
		   rizn= Number.parseInt(values[k])- Number.parseInt(predPokazn[i]);
		   }
		   myTab2.rows.item(i).cells[5].innerText=rizn;
		   SumW=SumW+rizn;
		   
		   k++;
		
	     
		
		   }
		
	
		myTab2.rows.item(i).cells[5].innerText=SumW;
		
		if(isDone===false){
			
		
				
			
				
				
				event.preventDefault(); // выключaем стaндaртную рoль элементa
				$('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
					function(){ // пoсле выпoлнения предъидущей aнимaции
						$('#modal_form2') 
							.css('display', 'block') // убирaем у мoдaльнoгo oкнa display: none;
							.animate({opacity: 1, top: '25%'}, 200); // плaвнo прибaвляем прoзрaчнoсть oднoвременнo сo съезжaнием вниз
				});///продолжить event.currentTarget.submit();
			
		}
		});
		//var value =0;
		

		$('#modal_close2, #overlay, #modal_bu_ex').click( function(){ // лoвим клик пo крестику или пoдлoжке
			$('#modal_form2')
				.animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
					function(){ // пoсле aнимaции
						$(this).css('display', 'none'); // делaем ему display: none;
						$('#overlay').fadeOut(400); // скрывaем пoдлoжку
					}
				);
		});
		$('#modal_but').click( function(){ // лoвим клик пo крестику или пoдлoжке
			$('#modal_form2')
				.animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
					function(){ // пoсле aнимaции
						$(this).css('display', 'none'); // делaем ему display: none;
						$('#overlay').fadeOut(400); // скрывaем пoдлoжку
					}
				);
				isDone=true;
				$("#target").click();
		});
			
	});
});


</script>
		
	
	
<?php
get_sidebar();
get_footer('auth');
