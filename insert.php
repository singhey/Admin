<!DOCTYPE html>
<html>
<head>
    <title>Admin | Login</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/common.php'); ?>
   <link rel="stylesheet" type="text/css" href="/admin/assets/css/sql.css">
   <?php if(!isset($_SESSION['admin_name'])){header("Location:/admin");} ?>
</head>
<body>
    <?php
        if(!isset($_SESSION['admin_name'])){
           session_start();
        }
        if(!isset($_SESSION['admin_name'])){
           header('Location:/localhost/admin/');
        }
        require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/connection.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/functions.php');
            
    ?>
    <div class="all-wrapper">
        <h3>
            <a href="/admin/">Tables</a>
            <a href="/admin/sql.php?table=<?php echo $_GET['table']; ?>&pos=0">Return</a>
            <?php echo "Insert in ".$_GET['table']; ?>
        </h3>
        <?php
            #if a form is submitted then 
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $data = $_POST;
				$tableName = $_GET['table'];
				#make an sql command
				$i = 0;
				$sql = "INSERT INTO  $tableName  ";
				#echo count($data)."array size \n";
				foreach ($data as $key => $value) {
                    $value = addslashes($value);
                    if(strlen($value)==0){
                        continue;
                    }
					if($i == 0){
                        $columns = $key;
                        $datas = "'$value'";
                    }else{
                        $columns.=", $key";
                        $datas.= ", '$value'";
                    }
                    $i++;
				}
				$sql.=" ($columns) values($datas)";
				echo $sql;
				$result =   _query($sql);
                if(!$result){
                        echo "Error occured ".mysqli_error($con);
                        exit;
                    }
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        header("Location:/admin/sql.php?table=$tableName&pos=0");
                    }
	    }
        ?>
        <div class="content">
            <form method="POST" action="#">
            <table>
                <thead>
                    <tr>
                        <th>Column</th>
                        <th>Type</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    #get column data types
                    $tableName = $_GET['table'];
                    $sql = "DESC  $tableName";
                    $rows = _query($sql);
                    while($r = $rows->fetch_assoc()):
                ?>
                    <tr>
                        <?php
                            #col Name
                            $fieldName= $r['Field'];
                            echo "<td>$fieldName</td>";
                            echo "<td>".$r['Type']."</td>";

                            $_data = preg_split("/\(|\)|,/", $r['Type']);
                            $dataType = $_data[0];
                            $maxLength = isset($_data[1])?$_data[1]: '';
                            $el = ($maxLength<80)?'input':'textarea';
                            $attr = '';
                            switch ($dataType) {
                                case 'varchar':
                                    $dataType = "text";
                                    break;
                                case 'time':
                                    $attr = "step='1'";
                                    break;

                                case 'int':
                                    $dataType = "number";
                                    break;

                                case 'float':
                                    $dataType = "number";
                                    $attr = "step='0.01'";
                                default:
                                    
                                    break;
                            }
                            if($el=='input'){
                                $element = "<input type='$dataType' name='$fieldName' maxLength='$maxLength' class='input-field' $attr/>";
                            }else{
                                $element = "<textarea rows='5' name='$fieldName' maxLength='$maxLength'></textarea>";
                            }
                            echo "<td>$element</td>";
                        ?>
                    </tr>
                    <?php
                        endwhile;
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="submit" class="btn"/></td>
                    </tr>
                </tbody>
            </table>
            <form>
        </div>
    </div>
</body>
</html>