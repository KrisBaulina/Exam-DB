<?php
$db = new PDO(
  "mysql:host=localhost;dbname=faculty;charset=utf8", 
  "root",
  ""
);
?>
<html>
	<body>
		<form method="GET" action="exx8.php">
			<?php
				$groups = $db->query('
					SELECT * FROM `group`
				')->fetchAll();
			?>
			<select name="group">
				<?php foreach ($groups as $group) { ?>
				<option
					value="<?= htmlspecialchars($group['id']) ?>"
					<?php
						if (isset($_GET['group']) && $_GET['group'] == $group['id']) {
							echo ' selected';
						}
					?>>
					<?= htmlspecialchars($group['number']) ?>
				</option>
				<?php } ?>
			</select>
			
			<input type="submit" value="Найти">
		</form>
		<?php 
		if (isset($_GET['group'])) { 
			$sql = '
				SELECT `group`.`number`, count(mark.value) as count FROM `group`
				INNER JOIN course ON `group`.Id = course.groupId
				INNER JOIN mark ON mark.courseId = course.id
				WHERE course.groupId = :group 
			';
			
			$query = $db->prepare($sql);
			$query->execute(['group' => $_GET['group']]);
			$groups = $query->fetchAll();
		
		
		
		$sql .= ' and mark.value = 3';
				
				
		$query = $db->prepare($sql);
	    $query->execute(['group' => $_GET['group']]);
		$groups = $query->fetchAll();
			foreach ($groups as $group){
				echo 'Выставлено оценок 3 ', htmlspecialchars($group['count']) . '<br>';
			}
			
		 
			$sql = '
				SELECT `group`.`number`, count(mark.value) as count FROM `group`
				INNER JOIN course ON `group`.Id = course.groupId
				INNER JOIN mark ON mark.courseId = course.id
				WHERE course.groupId = :group 
			';
			
			$query = $db->prepare($sql);
			$query->execute(['group' => $_GET['group']]);
			$groups = $query->fetchAll();
		
		
		
		$sql .= ' and mark.value = 4';
				
				
		$query = $db->prepare($sql);
	    $query->execute(['group' => $_GET['group']]);
		$groups = $query->fetchAll();
			foreach ($groups as $group){
				echo 'Выставлено оценок 4 ', htmlspecialchars($group['count']) . '<br>';
			}
			
		 
			$sql = '
				SELECT `group`.`number`, count(mark.value) as count FROM `group`
				INNER JOIN course ON `group`.Id = course.groupId
				INNER JOIN mark ON mark.courseId = course.id
				WHERE course.groupId = :group 
			';
			
			$query = $db->prepare($sql);
			$query->execute(['group' => $_GET['group']]);
			$groups = $query->fetchAll();
			
		
		
		$sql .= ' and mark.value = 5';
				
				
		$query = $db->prepare($sql);
	    $query->execute(['group' => $_GET['group']]);
		$groups = $query->fetchAll();
			foreach ($groups as $group){
				echo 'Выставлено оценок 5 ', htmlspecialchars($group['count']) . '<br>';
			}	
			
		
			$sql = '
				SELECT `group`.`number`, count(mark.value) as count FROM `group`
				INNER JOIN course ON `group`.Id = course.groupId
				INNER JOIN mark ON mark.courseId = course.id
				WHERE course.groupId = :group 
			';
			
			$query = $db->prepare($sql);
			$query->execute(['group' => $_GET['group']]);
			$groups = $query->fetchAll();
			
			
			foreach ($groups as $group){
				echo 'Всего оценок ', htmlspecialchars($group['count']);
			}	
		}
		?>
	</body>
</html>