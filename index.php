<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL lấy truyện join chương
$sql_truyen_luotxem_desc = "select truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH, MAX(CHUONG_STT) as SOCHUONG, SUM(CHUONG_LUOTXEM) as 'TRUYEN_LUOTXEM'
							from truyen join chuong on truyen.TRUYEN_ID=chuong.TRUYEN_ID
							GROUP BY truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH
							ORDER BY TRUYEN_LUOTXEM DESC LIMIT 10 OFFSET 1";
$result_truyen_luotxem_desc = $conn->query($sql_truyen_luotxem_desc);
$sql_truyen_moicapnhat = "select truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH, MAX(CHUONG_NGAYDANG) as MAXNGAYDANG, MAX(CHUONG_STT) as 'SOCHUONG'
						  	from truyen join chuong on truyen.TRUYEN_ID=chuong.TRUYEN_ID
							GROUP BY truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH
							ORDER BY MAXNGAYDANG DESC LIMIT 19";
$result_truyen_moicapnhat = $conn->query($sql_truyen_moicapnhat);
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
					echo "<a onclick='page_truyen(" . $row_truyen_moicapnhat['TRUYEN_ID'] . ")' href='#'><img src='admin/" . $row_truyen_moicapnhat['TRUYEN_HINHANH'] . "'>
				<p>Chapter " . $row_truyen_moicapnhat['SOCHUONG'] . "</p>		
				<p>" . $row_truyen_moicapnhat['TRUYEN_NAME'] . "</p>
				</a>";
				}
				?>
			</div>
			<div id="div02b2"></div>
		</div>
		<div id="div02c">
			<p class="title_p">TRUYỆN ĐÃ XEM</p>
		</div>
	</div>
	<div id="div03"></div>
	<div id="div04"></div>
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
					document.getElementById("div04").style.visibility = "hidden";
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
					document.getElementById("div02").style.visibility = "hidden";
					document.getElementById("div03").style.visibility = "hidden";
					document.getElementById("div04").style.visibility = "visible";
					document.getElementById("div04").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "page_chuong.php?truyen_id=" + truyen_id_c + "&chuong_stt=" + chuong_stt, true);
			xmlhttp.send();
		}
		function baoloi(truyen_id_c, chuong_stt){
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