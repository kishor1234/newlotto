<?php
$jsonData = json_decode($_POST["data"], true);
$data = $jsonData["data"];
//print_r($data);
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=Report.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
?>

<table>
    <tr>
        <th></th>
      
        <th><h1>Poolcampus</h1></th>
    </tr>
    <tr>
        
        <td><?=$_SESSION["address"]."<br>"?></td>
    </tr>
    <tr>
       
        <td>Email: <?=$_SESSION["email"]?></td>
        <td></td>
        <td>Mobile: <?=$_SESSION["mobile"]?></td>
    </tr>
</tr>
</table>
<table border='1'>
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Location</th>
        <th>Obtain Mark</th>
        <th>Positive Mark</th>
        <th>Negative Mark</th>
        <th>Result</th>        
    </tr>
    <?php
    foreach ($data as $key => $val) {
        ?>
        <tr>
            <td><?= $val["userid"]["id"] ?></td>
            <td><?= $val["userid"]["name"] ?></td>
            <td><?= $val["userid"]["email"] ?></td>
            <td><?= $val["userid"]["mobile"] ?></td>
            <td><?= $val["userid"]["location"] ?></td>

            <td><?= $val["obtainmarks"] ?></td>
            <td><?= $val["positive"] ?></td>
            <td><?= $val["negative"] ?></td>
            <td><?= $val["result"] ?></td>
        </tr>
        <?php
    }
    ?>
</table>