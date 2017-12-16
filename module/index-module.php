<?php
if (!defined("ROOT"))
{
	echo "You don't have permission to access this page!"; exit;	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../css/bangcongviec.css">
	 <script>
        function tai_lai_trang(){
            location.reload();
        }
    </script>
</head>
<body>
	<?php 
	include "config/connect.php";
	include "classes/db.class.php";
	include "classes/congviec.class.php";
	include "classes/duan.class.php";
	//include "index.php";
	$duan = new duan();
	$da_cv_tv = new Db();
	$congviec = new congviec();
	$db = new Db();
	$maduan_selected = postIndex('chonduan');
  	$username = $_SESSION['username'];
  	$row_matv = $db->select("select mathanhvien from taikhoan where tentaikhoan = '$username'");
  	foreach ($row_matv as $row) {
  		# code...
  		$mathanhvien = $row['mathanhvien'];
  	}

  	$row_todo = $congviec->select("select * from dacvtv 
  		join duan on dacvtv.maduan = duan.maduan
  		join congviec on dacvtv.macongviec = congviec.macongviec
  		where dacvtv.mathanhvien= '$mathanhvien' 
  		and congviec.matrangthai = '1' 
  		and duan.maduan='$maduan_selected'");
  	$row_doing = $congviec->select("select * from dacvtv 
  		join duan on dacvtv.maduan = duan.maduan
  		join congviec on dacvtv.macongviec = congviec.macongviec
  		where dacvtv.mathanhvien= '$mathanhvien' and congviec.matrangthai = '2' and duan.maduan='$maduan_selected'");
  	$row_done = $congviec->select("select * from dacvtv 
  		join duan on dacvtv.maduan = duan.maduan
  		join congviec on dacvtv.macongviec = congviec.macongviec
  		where dacvtv.mathanhvien= '$mathanhvien' and congviec.matrangthai = '3' and duan.maduan='$maduan_selected'");
  	$row_da_cv_tv = $da_cv_tv->select("select * from dacvtv 
  		join duan on dacvtv.maduan = duan.maduan
  		join congviec on dacvtv.macongviec = congviec.macongviec
  		where dacvtv.mathanhvien= '$mathanhvien' ");

  	$row_duan = $duan->select("select * from duan ");
	?>
	<!-- --------------------------------------------------------------------------- -->
	<!-- Xử lý xóa -->
		<?php 
		if(isset($_POST['xoa'])){ ?>
		<div style="background-color: #20A5C3; color: white;"><h3>Messeger :
		<?php
			if(isset($_POST['cmacongviec'])){
				$sql ="delete from congviec where macongviec = :macongviec";
				$arr = array(":macongviec"=>$_POST['cmacongviec']);
				$xoa = $db->delete($sql,$arr); 

				echo "Xóa thành công !";

			} else  echo "Vui lòng chọn công việc cần xóa !"; 
			?>
		</h3></div>
			<?php
		}
	?>
	<!-- ------------------------------------------------------------------------ -->
	<!-- Xử lý chuyển trạng thái todo -> doing -->
	<?php 
		if(isset($_POST['chuyentrangthai1'])){ ?>
		<div style="background-color: #20A5C3; color: white;"><h3>Messeger :
		<?php
			if(isset($_POST['cmacongviec'])){
				$sql ="UPDATE congviec SET matrangthai=2 where macongviec = :macongviec";
				$arr = array(":macongviec"=>$_POST['cmacongviec']);
				$xoa = $db->update($sql,$arr); 

				echo "Chuyển thành công !"; ?> <button type="button" onclick="tai_lai_trang()">Tải lại trang</button><?php

			} else  echo "Vui lòng chọn công việc cần chuyển !"; 
			?>
		</h3></div>
			<?php
		}
	 ?>
	<!-- ------------------------------------------------------------------------ -->
	<!-- Xử lý chuyển trạng thái doing -> done -->
	<?php 
		if(isset($_POST['chuyentrangthai2'])){ ?>
		<div style="background-color: #20A5C3; color: white;"><h3>Messeger :
		<?php
			if(isset($_POST['cmacongviec'])){
				$sql ="UPDATE congviec SET matrangthai=3 where macongviec = :macongviec";
				$arr = array(":macongviec"=>$_POST['cmacongviec']);
				$xoa = $db->update($sql,$arr); 

				echo "Chuyển thành công !"; ?> <button type="button" onclick="tai_lai_trang()">Tải lại trang</button><?php

			} else  echo "Vui lòng chọn công việc cần chuyển !"; 
			?>
		</h3></div>
			<?php
		}
	 	?>
	 	<!-- ------------------------------------------------------------------------ -->
		<!-- Xử lý cập nhật tiến độ -->
		<?php 
		if(isset($_POST['capnhat'])){ ?>
		<div style="background-color: #20A5C3; color: white;"><h3>Messeger :
		<?php
			if(isset($_POST['cmacongviec'])){
				$tiendo =$_POST['tiendo'];
				$sql ="UPDATE congviec SET tiendo=$tiendo where macongviec = :macongviec";
				$arr = array(":macongviec"=>$_POST['cmacongviec']);
				$xoa = $db->update($sql,$arr); 
				echo "Cập nhật thành công !"; ?> <button type="button" onclick="tai_lai_trang()">Tải lại trang</button><?php

			} else  echo "Vui lòng chọn công việc cần cập nhật !"; 
			?>
		</h3></div>
			<?php
		}
	 	?>

	<br>
	Chọn dự án : 
	<form method="post" enctype="multipart/form-data" id="chonduan">
	<select name="chonduan" >
		<option value="deafault">Chọn dự án</option>
		<?php 
		foreach ($row_duan as $row) {
		?>
		<option value="<?php echo $row['maduan']?>"><?php echo $row['tenduan']?></option>
		<?php 
		} 
		?>
	</select>
	
	<input type="submit" name="submit" value="Xác nhận">
		
	</form>
	<br>
	<br>
	<div align="center"><h3>Bảng công việc </h3>Mã dự án hiện tại
		<?php print_r($maduan_selected); ?></div>
	
	<hr>
	<?php if(isset($_POST['chonduan'])){ ?>
	<table id="bangcv" width="1000px">
		<tr>
			<td class="table-title" width="400px" style="text-align: center;">Công việc mới</td>
			<td width="3px;" style="background-color: black"></td>
			<td class="table-title" width="400px" style="text-align: center;">Đang thực hiện</td>
			<td width="3px;" style="background-color: black"></td>
			<td class="table-title" width="400px" style="text-align: center;">Hoàn thành</td>
		</tr>
		<tr></tr>
		<tr>


			<td width="300px" color: white">
				<form method="post">
				<?php
						foreach($row_todo as $row){ ?>
						<div style="background-color:  #6CAE44; border: solid; color: white;"> 
							<?php  ?>
							<div>
							<input type="checkbox" name="cmacongviec" value="<?php echo $row['macongviec']?>"><?php echo $row['tencongviec']?><hr>
							</div>
							<?php
							echo 'Người tạo 	: '.$row['manguoitao'].'<br>';
							echo 'Ngày tạo 		: '.$row['ngaytao'].'<br>';
							echo 'Ngày bắt đầu 	:'.$row['ngaybatdau'].'<br>';
							echo 'Ngày kết thúc :'.$row['ngayketthuc'].'<br>';
							?>
							<input type="submit" name="xoa"  value="Xóa">
							<input type="submit" name="chuyentrangthai1" value="Chuyển trạng thái">
						</div>
				<?php } ?>
			</form>
			</td>

			<td width="3px;"></td>

			<td width="300px" color: white">
				<form method="post">
				<?php
						foreach($row_doing as $row){ ?>
						<div style="background-color:  #295077; border: solid; color: white;"> 
							<?php  ?>
							<div>
							<input type="checkbox" name="cmacongviec" value="<?php echo $row['macongviec']?>"><?php echo $row['tencongviec']?><hr>
							</div>
							<?php
							echo 'Người tạo 	: '.$row['manguoitao'].'<br>';
							echo 'Ngày tạo 		: '.$row['ngaytao'].'<br>';
							echo 'Ngày bắt đầu 	:'.$row['ngaybatdau'].'<br>';
							echo 'Ngày kết thúc :'.$row['ngayketthuc'].'<br>';
							?>
							<div>Tiến độ hiện tại :<input type="number" name="tiendo" min="1" max="99" value="<?php echo $row['tiendo'] ?>">%</div>
							
							<input type="submit" name="capnhat" value="Cập nhật tiến độ">
							<input type="submit" name="xoa"  value="Xóa">
							<input type="submit" name="chuyentrangthai2" value="Chuyển trạng thái">
						</div>
				<?php } ?>
			</form>
			</td>
			<td width="3px;"></td>

			<td width="300px" color: white">
				<form method="post">
				<?php
						foreach($row_done as $row){ ?>
						<div style="background-color:  #A03B36; border: solid; color: white;"> 
							<?php 
							echo $row['tencongviec'].'<hr>';
							echo 'Người tạo 	: '.$row['manguoitao'].'<br>';
							echo 'Ngày tạo 		: '.$row['ngaytao'].'<br>';
							echo 'Ngày bắt đầu 	:'.$row['ngaybatdau'].'<br>';
							echo 'Ngày kết thúc :'.$row['ngayketthuc'].'<br>';
							?>
						</div>
				<?php } ?>
			</form>
			</td>
		</tr>
		<tr></tr>
	</table>
	<?php } ?>
	<hr>
	</body>
</html>