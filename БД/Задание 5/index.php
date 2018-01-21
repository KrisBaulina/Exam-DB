<?php
$dbParams = require (
	'db.php'
);

$db=new PDO(
	"mysql: host=localhost; dbname=".
	$dbParams['database'].
	"; charset=utf8",
	$dbParams['username'],
	$dbParams['password']
); 
$marksSql = '
	SELECT `student`.`lastName`, `student`.`firstName`, `student`.`patronymicName`,`subject`.`name`,`mark`.`value` FROM `mark`
	INNER JOIN `student` ON `student`.`id` = `mark`.`studentId`
	INNER JOIN `course` ON `mark`.`courseId` = `course`.`id`
	INNER JOIN `subject` ON `course`.`subjectId` = `subject`.`id`
';

$values=[];
if(isset($_GET['name'])) {
	$marksSql.='WHERE `mark`.`value` LIKE :value';
	$values['value']= '%' . $_GET['name'] . '%';
}
$marksQuery= $db
	-> prepare($marksSql);

$marksQuery
	-> execute($values);
$marks = $marksQuery
	-> fetchAll (PDO :: FETCH_ASSOC);
?>
<html>
	<body>
		<form>
			<label>Оценка:</label>
			<input type="radio" name="name" value="<?php 3 or 4 or 5 ?>" <?php
					if (isset($_GET['name'])) {
						echo " checked";
					}
				?>>Любая
			<input type="radio" name="name" value="3" <?php
					if (isset($_GET['name']) && $_GET['name'] == 3) {
						echo " checked";
					}
				?>>3
			<input type="radio" name="name" value="4" <?php
					if (isset($_GET['name']) && $_GET['name'] == 4) {
						echo " checked";
					}
				?>>4
			<input type="radio" name="name" value="5" <?php
					if (isset($_GET['name']) && $_GET['name'] == 5) {
						echo " checked";
					}
				?>>5
			<input type="submit" value="Отобразить">
			<a href="index.php">Сбросить параметры</a>
		</form>
		<table border=1 cellspacing=0>
			<tr>
				<th>Студент</th>
				<th>Дисциплина</th>
				<th>Оценка</th>
			</tr>
			<?php
			foreach ($marks as $mark) {
				?>
				<tr>
					<td>
					<?php
					echo htmlspecialchars ($mark ['lastName'].' '.$mark ['firstName'].' '.$mark ['patronymicName']);
					?>
					</td>
					<td>
					<?php
					echo htmlspecialchars ($mark ['name']);
					?>
					</td>
					<td>
					<?php
					echo '<center>'.htmlspecialchars ($mark ['value']).'</center>';
					?>
				</tr>
				<?php
			}
			?>
		</table>
	</body>
</html>

	