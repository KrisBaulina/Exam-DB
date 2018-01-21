
<?php	
$dbParams=require(
	'db.php'
);
$db=new PDO ( 
	"mysql:host=localhost;dbname=".$dbParams['database'].";charset=utf8", //подключение к базе данных
	$dbParams['username'],
	$dbParams['password']
);
$marksSql =('
	SELECT `student`.`lastName`, `subject`.`name`, `mark`.`value` FROM `mark` 
	inner join `student`  on `student`.`id`=`mark`.`studentId`
	inner join `course`  on `mark`.`courseId`=`course`.`id`
	inner join `subject`  on `subject`.`id`=`course`.`subjectId`
');
$values=[];
if(isset($_GET['name'])){
	$marksSql .= 'WHERE `lastName` LIKE :value';
	$values['value']='%'.$_GET['name'].'%';
}
$marksQuery=$db
	->prepare($marksSql);
$marksQuery	
	->execute($values);
$marks=$marksQuery
	->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
	<body>
		<form>
			<label>Оценка: <input type="text" name="name" value="
			<?php
			if(isset($_GET['name'])) {
				echo htmlspecialchars ($_GET['name']);
			}
			?>
			"></label>	
			<input type="submit" value="поиск">
			<a href="VesSpisok.php"> ВСЕ ОЦЕНКИ</a> 
		</form>
		<table>
			<tr>
				<th>Студент</th>
				<th>Дисциплина</th>
				<th>Оценка</th>
			<tr>
			<?php foreach ($marks as $mark) { ?>
			<tr>
				<td><?= htmlspecialchars ($mark['lastName'])?></td>
				<td><?= htmlspecialchars ($mark['name'])?></td>
				<td><?= htmlspecialchars ($mark['value'])?></td>
			<tr>
			<?php } ?>
		</table>
	</body>
</html>