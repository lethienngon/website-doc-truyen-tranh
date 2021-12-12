<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL lấy truyện join chương
$sql_truyen_luotxem_desc = "select truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH, MAX(CHUONG_STT) as SOCHUONG, SUM(CHUONG_LUOTXEM) as 'TRUYEN_LUOTXEM'
							from truyen join chuong on truyen.TRUYEN_ID=chuong.TRUYEN_ID
							WHERE chuong.CHUONG_TRANGTHAI!=0
							GROUP BY truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH
							ORDER BY TRUYEN_LUOTXEM DESC LIMIT 10";
$result_truyen_luotxem_desc = $conn->query($sql_truyen_luotxem_desc);
$sql_truyen_moicapnhat = "select truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH, MAX(CHUONG_NGAYDANG) as MAXNGAYDANG, MAX(CHUONG_STT) as 'SOCHUONG'
						  	from truyen join chuong on truyen.TRUYEN_ID=chuong.TRUYEN_ID
							WHERE chuong.CHUONG_TRANGTHAI!=0
							GROUP BY truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH
							ORDER BY MAXNGAYDANG DESC LIMIT 19";
$result_truyen_moicapnhat = $conn->query($sql_truyen_moicapnhat);
$sql_theloai = "SELECT DISTINCT truyen_theloai.THELOAI_ID, THELOAI_NAME
				FROM theloai join truyen_theloai on theloai.THELOAI_ID=truyen_theloai.THELOAI_ID";
$result_theloai = $conn->query($sql_theloai);
$sql_tacgia = "SELECT DISTINCT truyen_tacgia.TACGIA_ID, TACGIA_HOTEN
				FROM tacgia join truyen_tacgia on tacgia.TACGIA_ID=truyen_tacgia.TACGIA_ID";
$result_tacgia = $conn->query($sql_tacgia);
?>
<html>

<head>
	<title>Truyện tranh</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="icon" href="icon.ico" size="64x64">
	<link rel="stylesheet" href="index.css">
	<link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="owlcarousel/assets/owl.theme.default.min.css">
	<script src="owlcarousel/jquery-3.6.0.min.js"></script>
	<script src="owlcarousel/owl.carousel.min.js"></script>
</head>

<body>
	<div id="head"></div>
	<div id="div01">
		<a id="atrang" href="index.php">
			<img src="home.ico" style="width:50px;height:50px;">
			<img src="nezuko.gif" style="width:50px;height:50px;">
		</a>
		<div id="menu">
			<ul id="menu_ul">
				<li><a href="#">THỂ LOẠI</a>
					<ul class="sub_menu_ul">
						<?php
						while ($row_theloai = $result_theloai->fetch_assoc()) {
							echo "<li>";
							echo "<a onclick=list(".$row_theloai['THELOAI_ID'].",'') href='#'>" . $row_theloai['THELOAI_NAME'] . "</a>";
							echo "</li>";
						}
						?>
					</ul>
				</li>
				<li><a href="#">TÁC GIẢ</a>
					<ul class="sub_menu_ul">
						<?php
						while ($row_tacgia = $result_tacgia->fetch_assoc()) {
							echo "<li>";
							echo "<a onclick=list('',".$row_tacgia['TACGIA_ID'].") href='#'>" . $row_tacgia['TACGIA_HOTEN'] . "</a>";
							echo "</li>";
						}
						?>
					</ul>
				</li>
			</ul>
		</div>
		<form id="search">
			<img id="searchimg" src="search.ico" style="width:20px;height:20px;">
			<input id="truyen_search_input" type="text" name="truyen_name" onkeyup=truyen_search(this.value) placeholder="Search...">
		</form>
		<div id="truyen_search_kq"></div>
	</div>
	<div id="div02">
		<p class="title_p">TRUYỆN ĐỀ XUẤT</p>
		<div id="div02a" class="owl-carousel owl-theme">
			<?php
			while ($row_truyen_luotxem_desc = $result_truyen_luotxem_desc->fetch_assoc()) {
				echo "<a onclick='page_truyen(" . $row_truyen_luotxem_desc['TRUYEN_ID'] . ")' href='#'><img src='admin/" . $row_truyen_luotxem_desc['TRUYEN_HINHANH'] . "'>
				<p>Chapter " . $row_truyen_luotxem_desc['SOCHUONG'] . "</p>		
				<p>" . $row_truyen_luotxem_desc['TRUYEN_NAME'] . "</p>
				</a>";
			}
			?>
		</div>
		<p class="title_p">TRUYỆN MỚI CẬP NHẬT</p>
		<div id="div02b">
			<div id="div02b1">
				<?php
				while ($row_truyen_moicapnhat = $result_truyen_moicapnhat->fetch_assoc()) {
					echo "<a class='div02b1_a' onclick='page_truyen(" . $row_truyen_moicapnhat['TRUYEN_ID'] . ")' href='#'><img class='div02b1_img' src='admin/" . $row_truyen_moicapnhat['TRUYEN_HINHANH'] . "'>
				<p>Chapter " . $row_truyen_moicapnhat['SOCHUONG'] . "</p>		
				<p>" . $row_truyen_moicapnhat['TRUYEN_NAME'] . "</p>
				</a>";
				}
				?>
				<a class='div02b1_a' onclick='list("","")' href='#'><img class='div02b1_img' src='next.ico'>
					<p>XEM THÊM</p>
				</a>
			</div>
			<div id="div02b2">
				<p>Người thực hiện: Lê Thiện Ngôn MSSV: B1809157</p>
			</div>
		</div>
		<div id="div02c">
			<p class="title_p" style="margin-left: 10px;">TRUYỆN ĐÃ XEM GẦN ĐÂY</p>
			<div id="div02c_truyendaxem">
				<?php
				if (isset($_COOKIE['truyendaxem'])) {
					$truyendaxem = explode(":", $_COOKIE['truyendaxem']);
					foreach ($truyendaxem as $value) {
						$result_truyen_daxem = mysqli_query($conn, "SELECT TRUYEN_NAME, TRUYEN_HINHANH FROM truyen WHERE TRUYEN_ID='$value' ");
						if ($result_truyen_daxem->num_rows > 0) {
							echo "<ul style='list-style-type: none;'>";
							while ($row_truyen_daxem = $result_truyen_daxem->fetch_assoc()) {
								echo "<li>
								<a href='#' onclick='page_truyen(" . $value . ")'>
								<img src='admin/" . $row_truyen_daxem['TRUYEN_HINHANH'] . "'><p>" . $row_truyen_daxem['TRUYEN_NAME'] . "</p>
								</a>
								</li>";
							}
							echo "</ul>";
						}
					}
				}
				?>
			</div>
		</div>
	</div>
	<div id="div03"></div>
	<div id="div_list"></div>
	<div id="divreport">
		<p>Cám ơn bạn, chúng tôi sẽ sớm sửa lại.</p>
		<img src="thanks.ico">
	</div>
	<div class="button_scroll2top" onclick="page_scroll2top()">
		<i class="fa fa-chevron-up" />Top
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			var owl = $('.owl-carousel');
			owl.owlCarousel({
				items: 5,
				loop: true,
				margin: 10,
				autoplay: true,
				autoplayTimeout: 2000,
				autoplayHoverPause: true
			});
		});

		function list(theloai_id, tacgia_id) {
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("div02").style.visibility = "hidden";
					document.getElementById("div03").style.visibility = "hidden";
					document.getElementById("div_list").style.visibility = "visible";
					document.getElementById("div_list").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "list.php?theloai_id=" + theloai_id + "&tacgia_id=" + tacgia_id, true);
			xmlhttp.send();
		}

		function xem(truyen_id_c, chuong_stt) {
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {}
			}
			xmlhttp.open("GET", "xem.php?truyen_id=" + truyen_id_c + "&chuong_stt=" + chuong_stt, true);
			xmlhttp.send();
		}

		function page_truyen(truyen_id) {
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("div02").style.visibility = "hidden";
					document.getElementById("div_list").style.visibility = "hidden";
					document.getElementById("div03").style.visibility = "visible";
					document.getElementById("div03").innerHTML = xmlhttp.responseText;
					$("#div01").load(" #div01 > *");
				}
			}
			xmlhttp.open("GET", "page_truyen.php?truyen_id=" + truyen_id, true);
			xmlhttp.send();
		}

		function page_chuong(truyen_id_c, chuong_stt) {
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					xem(truyen_id_c, chuong_stt);
					document.getElementById("div02").style.visibility = "hidden";
					document.getElementById("div03").style.visibility = "visible";
					document.getElementById("div_list").style.visibility = "hidden";
					document.getElementById("div03").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "page_chuong.php?truyen_id=" + truyen_id_c + "&chuong_stt=" + chuong_stt, true);
			xmlhttp.send();
		}

		function baoloi(truyen_id_c, chuong_stt) {
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					divreport_camon();
				}
			}
			xmlhttp.open("GET", "baoloi.php?truyen_id=" + truyen_id_c + "&chuong_stt=" + chuong_stt, true);
			xmlhttp.send();
		}
		// Hiện thông báo cám ơn
		function divreport_camon() {
			document.getElementById('divreport').style.visibility = "visible";
			document.getElementById('divreport').style.transition = "0.5s";
			document.getElementById('divreport').style.top = "10%";
			setTimeout("divreport_camon_timeout()", 2000);
		}
		// Ẩn thông báo cảm ơn
		function divreport_camon_timeout() {
			document.getElementById('divreport').style.visibility = "hidden";
			document.getElementById('divreport').style.transition = "0.5s";
			document.getElementById('divreport').style.top = "-20%";
		}

		function truyen_search(truyen_name) {
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("truyen_search_kq").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "truyen_search.php?truyen_name=" + truyen_name, true);
			xmlhttp.send();
		}
		$(window).scroll(function() {
			if ($(window).scrollTop() >= 10) {
				$('.button_scroll2top').show();
			} else {
				$('.button_scroll2top').hide();
			}
		});

		function page_scroll2top() {
			$('html,body').animate({
				scrollTop: 0
			}, 'fast');
		}
	</script>
</body>

</html>