
<!DOCTYPE html>
<html>
<head>
	<title>Du an</title>
		<link rel="stylesheet" type="text/css" href="../../css/duan.css">
</head>
<body>
<?php 
	include "config/connect.php";
	include "classes/db.class.php";
	include "classes/duan.class.php";
  	$duan = new duan();
  	$db = new Db();
  	$rows = $duan->select("select * from duan");

  	$maduan_selected = "";
  	if(isset($_POST['chitiet'])){
  		$maduan_selected = $_POST['cmaduan'];
  		$row_ctda = $duan->select("select * from duan 
  			join thanhvien on duan.matruongduan = thanhvien.mathanhvien
  			join trangthai on duan.matrangthai = trangthai.matrangthai
  			join capdo on duan.macapdo = capdo.macapdo
  			where maduan = $maduan_selected"); ?>
  	<fieldset>
	<legend>Chi ti?t d? �n</legend>
	<form method="post">
		<table align="center">
			<?php foreach ($row_ctda as $row) {
					# code...
			 ?>
			<tr>
				<td>M� d? �n</td><td><?php echo $row['maduan'] ;?></td>
			</tr>
			<tr>
				<td>T�n d? �n</td><td><input type="text" name="tenda" value="<?php echo $row['tenduan'] ?>"></td>
			</tr>
			<tr>
				<td>Tru?ng d? �n</td><td><input type="text" name="truongda" value="<?php echo $row['tenthanhvien'] ?>"></td>
			</tr>
			<tr>
				<td>Ti?n d? hi?n t?i</td><td><input type="text" name="tiendo" value="<?php echo $row['tiendo'] ?>"> %</td>
			</tr>
			<tr>
				<td>Tr?ng th�i hi?n t?i</td><td><input type="text" name="trangthai" value="<?php echo $row['tentrangthai'] ?>"></td>
			</tr>
			<tr>
				<td>C?p d? hi?n t?i</td><td><input type="text" name="capdo" value="<?php echo $row['tencapdo'] ?>"></td>
			</tr>
			<tr>
				<td></td><td><input type="submit" name="capnhat" value="C?p nh?t"></td>
			</tr>
			<?php } ?>
		</table>
	</form>
</fieldset>
  	<?php }


  	if(isset($_POST['xoa']))
  	{
  		if(isset($_POST['cmaduan'])){
			$sql ="delete from duan where maduan = :maduan";
			$arr = array(":maduan"=>$_POST['cmaduan']);
			$xoa = $db->delete($sql,$arr);
			echo "X�a th�nh c�ng !";
		}
		else
			echo "Vui l�ng ch?n d? �n c?n x�a !";

	}


 ?>
 <fieldset>
 	<legend><h3>Danh s�ch d? �n tr�n h? th?ng</h3></legend>
 	<a href="trangchu_truongduan.php?mod=taoduan">T?o d? �n</a>
 	<form method="post">
 	<table border="1" style="width: 970px;"><tr bgcolor="#004A5B" style="color: white"><td>M� d? �n</td><td>T�n d? �n </td><td>H�nh d?ng</td></tr>
	<?php
	foreach($rows as $row)
	{
		?>
	    <tr><td><input type="checkbox" name="cmaduan" value="<?php echo $row["maduan"];?>"><?php echo $row["maduan"];?></td>
	    	<td><?php echo $row["tenduan"];?></td>
	    	<td><input type="submit" name="xoa" value="X�a"> | <input type="submit" name="chitiet" value="Chi ti?t"></td>
	        </tr>
	    <?php
	}
	?>
</table>
</form>
</fieldset>

</body>
</html>