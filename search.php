<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
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
            <?php echo "Search in ".$_GET['table']; ?>
        </h3>
        <style type="text/css">
            th:nth-child(2){
                width:80%;
            }
        </style>
        <table>
            <form action="/admin/search_result.php" method="GET">
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Search value</th>
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
                            <td><input type="text" name="table" style="display: none;" value="<?php echo $_GET['table']; ?>"></td>
                            <td><input type="submit" class="btn"/></td>
                        </tr>
                    </tbody>
            </form>
        </table>
    </div>
</body>
</html>