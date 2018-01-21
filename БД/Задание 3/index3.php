<html>
	<head>
		<title>Задание 3</title>
	</head>
	<body>
		<?php	
		$Months=require('month.php');
		if (isset($_GET['value'])) {
			$myDate=DateTime::createFromFormat('Y-m-d', $_GET['value']);
		}
		?>
		<form method="GET" action="index3.php" >
			<input type="date" name="value" value="<?php 
			if (isset($myDate)){
				echo htmlspecialchars($myDate->format('Y-m-d'));
			}
			else{
				echo date('Y-m-d');
			}
			?>">
			<input type="submit" value="Рассчитать">
		</form>
		<table>
			<tr>	
				<th>Месяц</th>
				<th>Число</th>
			<tr>		
		<?php
		
		if (isset($myDate)){
			$month = $myDate -> format('m');			
			$year = $myDate -> format('Y');	
			$day = $myDate -> Format('d');	
					
			for ($i=1; $i<=12; $i++) {
				
				if ($month+1 >13) {
					$year=$year+1;
				}
				
				$nextMonth =$month+1;
				$date=$myDate -> setDate((int)$year,(int)$nextMonth,1-1);
				
				$days = $date -> Format('d');
				$month = $date -> Format('m');
				$dayInWeek = $date -> Format('D');
				
				if ($dayInWeek == 'Sat'){
					$days=$days+2;	
				}
				else if ($dayInWeek == 'Sun'){
					$days=$days+1;	
				}
				$currentDate=$date -> setDate((int)$year,(int)$month,$days);				
		?>
			<tr>				
				<td><?Echo htmlspecialchars($Months[$month]).' ';?></td>
				<td><?Echo htmlspecialchars($currentDate->format('d.m.Y')).'<br>';?></td>		
				<? $month=$month+1;
			}
		}	
				?>
		</table>
	</body>
</html>
