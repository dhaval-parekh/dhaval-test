<?php
function display($object){
		if(gettype($object)=="resource" && $object)
		{
			$No=mysql_num_fields($object)
			or
			die(mysql_error()."<br>");
			echo "<table class='table table-bordered' style='width:100%;text-align:center;' >";
			echo "<tr>";
			for($i=0;$i<$No;$i++)
			{
				$FieldName=mysql_field_name($object,$i)
				or
				die(mysql_error()."<br>");
				echo "<th><label>".$FieldName."</label></th>";
			}
			echo "</tr>";
			while($row=mysql_fetch_row($object))
			{
				echo "<tr>";
				for($i=0;$i<$No;$i++)
				{
					 echo "<td>".$row[$i]."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			
		}else{
			echo '<pre style="max-height:256px;overflow:auto;">';
				if(is_object($object) || is_array($object)){
					print_r($object); 
				}else{
					echo $object; 
				}
			echo '</pre>';	
		}
		return true;
	}
$db = new SQLite3('testdb.db');
//display($db);

$query = "
CREATE TABLE IF NOT EXISTS  `test` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`name`	TEXT NOT NULL
);
";
$results = $db->query($query);
//display($results);

$query = "INSERT INTO test (name) VALUES ('Dhaval');";
$query = "UPDATE test SET name = 'Nicolas Smith 1' WHERE id = 3; ";
$results = $db->query($query);
display($results);

$results = $db->query('SELECT * FROM test');
//display($results);
while ($row = $results->fetchArray()) {
    var_dump($row);
}