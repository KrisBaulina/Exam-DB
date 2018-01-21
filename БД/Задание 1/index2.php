<?php
$db = new PDO(
  "mysql:host=localhost;dbname=faculty;charset=utf8", 
  "root",
  ""
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
			<label>
				Только хорошие оценки
				<input type="checkbox" name="good"<?php
					if (isset($_GET['good'])) {
						echo " checked";
					}
				?>>
			</label>
			<input type="submit" value="Найти">
		</form>
		<?php 
		if (isset($_GET['subject'])) { 
			$sql = '
				SELECT student.lastName, mark.markDate, mark.value FROM Student
				INNER JOIN mark on mark.studentId = student.id
				INNER JOIN course ON mark.courseId = course.id
				WHERE course.subjectId = :subject
			';
			if (isset($_GET['good'])) {
				$sql .= ' and mark.value >= 4';
			}
			$sql .= ' ORDER BY student.lastName ASC';
			$query = $db->prepare($sql);
			$query->execute(['subject' => $_GET['subject']]);
			$students = $query->fetchAll();
			if (count($students) > 0) {
			?>
			<ul>
				<?php foreach ($students as $student) { ?>
					<ul>
						<?= htmlspecialchars($student['lastName']) ?>
						<?= htmlspecialchars($student['value']) ?>
						<?php
							$date = DateTime::createFromFormat('Y-m-d', $student['markDate']);
							// echo $date->format('l');
						?>
					</ul>
				<?php } ?>
			</ul>
			<?php
			} else {
				?><div>Студентов не найдено</div><?php
			}
		}
		?>
	</body>
</html>