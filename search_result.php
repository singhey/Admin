<!DOCTYPE html>
<html>
<head>
	<title>Admin | Table Display</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/common.php'); ?>
	<link rel="stylesheet" type="text/css" href="/admin/assets/css/sql.css">
	<script type="text/javascript" src="/admin/assets/js/sql.js"></script>
	<?php if(!isset($_SESSION['admin_name'])){header("Location:/admin");} ?>
</head>
<body>
	<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/connection.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/functions.php');
		if(!isset($_GET['table'])){
			echo "Table name not passed";
			exit;
		}
		$table_name = $_GET['table'];
		$table_heading = _query("DESC $table_name");
	?>
	<div class="all-wrapper">
		<h3>

			<a href="/admin/">Tables</a>
			<a href="/admin/insert.php?table=<?php echo $_GET['table']; ?>">Insert</a>
			<a href="/admin/search.php?table=<?php echo $_GET['table']; ?>">Search</a>
			<?php echo $_GET['table'] ?>
		</h3>
		<table>
			<thead>
				<tr>
					<th>Actions</th>
				<?php
					$table_name = $_GET['table'];
					$table_heading = _query("DESC $table_name");
					while($heading = $table_heading->fetch_assoc()):
				?>
					<th><?php echo $heading['Field']; ?></th>
				<?php
					endwhile;
				?>
				</tr>
			</thead>
			<tbody>
				<?php
					#make conditions
					$data = $_GET;
					$conditions = '';
					$i = 0;
					foreach ($data as $key => $value) {
						if(strlen($value)<1 || $key == 'table'){
							continue;
						}
						if($i == 0)
							$conditions.="$key LIKE '%$value%'";
						else
							$conditions.=" AND $key LIKE '%$value%'";
						$i++;
					}
					$data = _query("SELECT * FROM $table_name WHERE $conditions");
					while($d = $data->fetch_assoc()):
				?>
				<tr>
					<?php $i =0; 	foreach ($d as $key => $value) { ?>
						<td>
							<?php 
							if($i == 0){
								echo "<a href='/admin/update.php?tableName=$table_name&action=update&id=$key&value=$value'>update </a>";
								echo "<a href='/admin/delete.php?tableName=$table_name&action=update&id=$key&value=$value' class='delete'>delete </a>";
								echo "</td><td>";
								$i++;
							}
							if(strlen($value)<50)
								echo $value;
							else
								echo substr($value, 0, 50)."...";
							?>
						</td>	
					<?php } ?>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</body>
</html>