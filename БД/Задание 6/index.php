<?php
$dbParams=require(
	'db.php'
);
$db=new PDO ( 
	"mysql:host=localhost;dbname=".$dbParams['database'].";charset=utf8", //подключение к базе данных
	$dbParams['username'],
	$dbParams['password']
);

?>
<html>
	<body>
		<form method="GET" action="index.php">
			<?php
				$subjects = $db->query('
					SELECT * FROM `subject`
				')->fetchAll();
			?>
			<select name="subject">
				<?php foreach ($subjects as $subject) { ?>
				<option
					value="<?= htmlspecialchars($subject['id']) ?>"
					<?php
						if (
							isset($_GET['subject']) &&
							$_GET['subject'] == $subject['id']
						) {
							echo ' selected';
						}
					?>
				>
					<?= htmlspecialchars($subject['name']) ?>
				</option>
				<?php } ?>
			</select>
			<br><br>
			<label>
				Отображать только учащихся студентов
				<input type="checkbox" name="status"<?php
					if (isset($_GET['status'])) {
						echo " checked";
					}
				?>>				
			</label>
			<br><br>
			<input type="submit" value="Показать">
		</form>
		<?php 
		if (isset($_GET['subject'])) { 
			$sql = '
				SELECT student.lastName FROM Student
				INNER JOIN `group` on `group`.`id`=`student`.`groupId`
				INNER JOIN `course` ON `course`.`groupId`=`group`.`id`
				INNER JOIN subject on `course`.`subjectId`=`subject`.`id`
				WHERE course.subjectId = :subject
			';
			if (isset($_GET['status'])) {
				$sql .= ' and student.status >0';
			}
			$sql .= ' ORDER BY student.lastName ASC';
			$query = $db->prepare($sql);
			$query->execute(['subject' => $_GET['subject']]);
			$students = $query->fetchAll();
			if (count($students) > 0) {
			?>
			Фамилии студентов:
			<ul>
				<?php foreach ($students as $student) { ?>
					<li>
						<?= htmlspecialchars($student['lastName']) ?>											
					</li>
				<?php } ?>	
			<ul>	
			<?php
			} else {
				?><div>Студентов не найдено</div><?php
			}
		}
		?>
	</body>
</html>