
<?php	
$dbParams=require(
	'db.php'
);
$db=new PDO ( 
	"mysql:host=localhost;dbname=".$dbParams['database'].";charset=utf8", //подключение к базе данных
	$dbParams['username'],
	$dbParams['password']
);
$markQuery =$db
	->prepare('
		SELECT `student`.`lastName`, `subject`.`name`, `mark`.`value` FROM `mark` 
		inner join `student`  on `student`.`id`=`mark`.`studentId`
		inner join `course`  on `mark`.`courseId`=`course`.`id`
		inner join `subject`  on `subject`.`id`=`course`.`subjectId`
	');
$markQuery
	->execute();
$marks=$markQuery
	->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
	<body>
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