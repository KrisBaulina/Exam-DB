<?php
$db = new PDO(
  "mysql:host=localhost;dbname=faculty;charset=utf8", 
  "faculty",
  "faculty"
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
		$query = $db->prepare('
			SELECT teacher.lastName, `group`.number from teacher
            INNER JOIN course on course.teacherId=teacher.id
            INNER JOIN `group` on `group`.`id`=course.groupId
			WHERE course.subjectId = :subject 
		
		');
			
		$query->execute(['subject' => $_GET['subject']]);
		$informations = $query->fetchAll();
		
		if (count($informations) > 0) {
		?>
	
			<?php echo 'Номера групп:';
			foreach ($informations as $group) {		
			?>
				<ul><li>
					<?= htmlspecialchars($group['number']) ?></li></ul>
			<?php } ?>
			<?php echo 'Преподаватели:';
			foreach ($informations as $teacher) { ?>
				<ul><li>
					<?= htmlspecialchars($teacher['lastName']) ?></li></ul>
			<?php } ?>
			<?php	
				} else {
					?><div>На данном факультете данная дисциплина не преподается</div><?php
				}
			}
			?>
	</body>
</html>