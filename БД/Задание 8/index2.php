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
		<form method="GET" action="index2.php">
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
						if (
							isset($_GET['group']) &&
							$_GET['group'] == $group['id']
						) {
							echo ' selected';
						}
					?>
				>
					<?= htmlspecialchars($group['number']) ?>
				</option>
				<?php } ?>
			</select>			
			<input type="submit" value="Найти">
		</form>
		<?php 
		if (isset($_GET['group'])) { 
			$sql = '
				SELECT `mark`.`value` FROM `mark`
				INNER JOIN `student` on `mark`.`studentId` = `student`.`id`
				INNER JOIN `group` on `group`.`id` = `student`.`groupId`
				WHERE `student`.`groupId` = :group
			';			
			$query = $db->prepare($sql);
			$query->execute(['group' => $_GET['group']]);
			$marks = $query->fetchAll();
			?>
			<?php 
			$five=0;
			$four=0;
			$three=0;
			$sum=0;
			foreach ($marks as $mark) { 
				if ($mark['value']==3) {
					$three=$three+1;
				} elseif ($mark['value']==4) {
					$four=$four+1;
				} elseif ($mark['value']==5) {
					$five=$five+1;
				}
				?>
			<?php }
			$sum = $three+$four+$five;
			echo '<p>'."Выставлено оценок 3 - ".htmlspecialchars($three).'<p>';
			echo '<p>'."Выставлено оценок 4 - ".htmlspecialchars($four).'<p>';
			echo '<p>'."Выставлено оценок 5 - ".htmlspecialchars($five).'<p>';
			echo '<p>'."Всего оценок - ".htmlspecialchars($sum).'<p>';
		}
		?>
	</body>
</html>