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
	SELECT `group`.`number`,`student`.`lastName`,`student`.`firstName`,`student`.`patronymicName` 
	FROM `student` inner join `group`  on `group`.`id`=`student`.`groupId`
	');
	
$values=[];	

if(isset($_GET['Search'])){
	$groupsSQL .= '
	WHERE `lastName` LIKE :value or `firstName` LIKE :value or `patronymicName` LIKE :value
	ORDER BY `number`,`lastName`
	';
	$values['value']='%'.$_GET['Search'].'%';
}
$groupsQuery=$db
	->prepare($groupsSQL);
$groupsQuery
	->execute($values);
$groups=$groupsQuery
	->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
	<body>
		<form action="index4.php" method="GET">
			<label>ФИО: 
				<input type="text" name="Search" value="<?php
				if(isset($_GET['Search'])) {
					echo htmlspecialchars($_GET['Search']);
				}?>">
			</label>	
			<input type="submit" value="Поиск">
			<a href="index4.php">Сбросить параметр</a> 
		</form>
		<table>
			<tr>
				<th>ФИО</th>
				<th>Номер группы</th>	
			<tr>
			<?php foreach ($groups as $group) { ?>
				<tr>
					<td><?= htmlspecialchars($group['lastName'].' '.$group['firstName'].' '.$group['patronymicName'])?></td>
					<td><?= htmlspecialchars($group['number'])?></td>
				<tr>
			<?php } ?>
			
		</table>
	</body>
</html>