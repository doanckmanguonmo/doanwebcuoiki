<?php
if (!defined("ROOT"))
{
	echo "You don't have permission to access this page!"; exit;	
}
	include "config/connect.php";
	include "classes/db.class.php";
	$db = new Db();
	$username = $_SESSION['username'];
	$row_matv = $db->select("select mathanhvien from taikhoan where tentaikhoan = '$username'");
  	foreach ($row_matv as $row) {
  		# code...
  		$mathanhvien = $row['mathanhvien'];
  	}
  	$row_thongtin = $db->select("SELECT * from thanhvien 
  		join chucvu on thanhvien.machucvu = chucvu.machucvu
  		where mathanhvien = $mathanhvien");
  	?>
  	<div align="center"><img src="img/user.png"><hr>
  	<?php
		foreach ($row_thongtin as $row) {
	# code...
		echo "Tên thành viên : ".$row['tenthanhvien'].'<br>';
		echo "Mã nhân viên : ".$row['mathanhvien'].'<br>';
		echo "Chức vụ : ".$row['tenchucvu'].'<br>';
		echo "Số điện thoại : ".$row['sdt'].'<br>';
		echo "Email : ".$row['email'].'<br>';
		}

?>
</div>
