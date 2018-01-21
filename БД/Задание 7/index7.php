<?php	
$dbParams=require(
	'db.php'
);
$db=new PDO ( 
	"mysql:host=localhost;dbname=".$dbParams['database'].";charset=utf8", //подключение к базе данных
	$dbParams['username'],
	$dbParams['password']
);
$groupsSQL=('
	SELECT `student`.`lastName`,`student`.`firstName`,`student`.`patronymicName`,`subject`.`name`, `mark`.`value`, `mark`.`markDate` FROM `mark`	
	INNER JOIN `student` on `student`.`Id`=`mark`.`studentId`
	INNER JOIN `course` on `mark`.`courseId`=`course`.`Id`
	INNER JOIN `subject` on `subject`.`Id`=`course`.`subjectId`
	ORDER BY `markDate` ASC
	');
	
$groupsQuery=$db
	->prepare($groupsSQL);
$groupsQuery
	->execute();
$groups=$groupsQuery
	->fetchAll(PDO::FETCH_ASSOC);

	
/* $daysOfWeek=require('day.php');	
foreach ($groups as $group) { 
	$myDate=DateTime::createFromFormat('Y-m-d', $group['markDate']);
	$day=$myDate -> format('D');
	echo $daysOfWeek[$day]; */

?>

<html>
	<body>
		<table>
			<tr>
				<th>ФИО</th>				
				<th>Дисциплина</th>
				<th>Оценка</th>
				<th>Дата выставления оценки</th>
			<tr>
			<?php 
			$daysOfWeek=require('day.php');
			foreach ($groups as $group) { 
				$myDate=DateTime::createFromFormat('Y-m-d', $group['markDate']);
				$day=$myDate -> format('D');
				$selectedDate= $myDate -> format('d.m.Y');
				
			?>
			<tr>
				<td><?= htmlspecialchars($group['lastName'].' '.$group['firstName'].' '.$group['patronymicName'])?></td>			
				<td><?= htmlspecialchars ($group['name'])?></td>
				<td><?= htmlspecialchars ($group['value'])?></td>
				<td><?= htmlspecialchars ($selectedDate) . " (" . htmlspecialchars ($daysOfWeek[$day]) . ") "  ?></td>					
			<tr>
			<?php } ?>
		</table>
	</body>
</html>