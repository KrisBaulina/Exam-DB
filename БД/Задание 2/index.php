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
			
			<input type="submit" value="Найти">
		</form>
		<?php 
		if (isset($_GET['subject'])) { 
			$sql = '
				SELECT DISTINCT `group`.`number` FROM `group`
				INNER JOIN course ON `course`.`groupId`=`group`.`id`
				INNER JOIN subject ON `course`.`subjectId`=`subject`.`id`
				INNER JOIN mark ON course.id = mark.courseId
				WHERE course.subjectId = :subject
			';
			
			$query = $db->prepare($sql);
			$query->execute(['subject' => $_GET['subject']]);
			$groups = $query->fetchAll();
			if (count($groups) > 0) {
			?>
			Номера групп:
			<ul>
				<?php foreach ($groups as $group) { ?>
					<ul>
						<?= htmlspecialchars($group['number']) ?>											
					</ul>
				<?php } ?>
			</ul>
			<?php
			} else {
				?><div>Групп не найдено</div><?php
			}
		}
		?>
	</body>
</html>