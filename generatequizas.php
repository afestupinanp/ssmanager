<?php require_once 'fix_mysql.php'; ?>
<?php require_once 'session_validation.php'; ?>
<?php
	mysql_connect("db", "root", "") or die(mysql_error());
	mysql_select_db("ssmanager");
	mysql_set_charset("utf8");
	$result = mysql_query("SELECT * FROM `observator` WHERE `cod_student` = {$_GET['userid']};") or die(mysql_error());
	$result2 = mysql_query("SELECT * FROM `students` WHERE `cod_student` = {$_GET['userid']}") or die(mysql_error());
	if(mysql_num_rows($result) >= 1 ) {
		$rows2 = mysql_fetch_array($result2, MYSQL_ASSOC);

		require("PDFs/fpdf.php");
		$pdfito = new FPDF("L");
		$pdfito->AddPage();
		$pdfito->Image("http://localhost/ssmanager/img/cosfa2.jpg", 10, 10, 25, 25, 'jpeg');
		if(file_exists("../img/students/{$_GET['userid']}.jpg")) {
			$pdfito->Image("http://localhost/ssmanager/img/students/{$_GET['userid']}.jpg", 250, 10, 25, 25, 'jpeg');
		}
		else {
			$pdfito->Image("http://localhost/ssmanager/img/students/default.png", 250, 10, 25, 25, 'png');
		}
		$pdfito->Setfont("Arial", "", 0);
		$pdfito->Setfontsize(17.0);
		$pdfito->Cell(0, 20, utf8_decode("COLEGIO SAN FRANCISCO DE ASÍS"), 0, 0, 'C');
		$pdfito->Ln(10);
		$pdfito->Cell(0, 20, utf8_decode("Lista de observaciones de"), 0, 0, 'C');
		$pdfito->Ln(7);
		$pdfito->Cell(0, 20, utf8_decode("{$rows2['student']}"), 0, 0, 'C');
		$pdfito->Ln(35);
		$pdfito->Setfontsize(14.0);
		$pdfito->MultiCell(0, 10, utf8_decode("En el siguiente listado, se muestran las observaciones realizadas a el(la) estudiante {$rows2['student']} en el transcurso del año lectivo actual. Estas fueron realizadas por los profesores listados en la misma."), 0, 'J');
		$pdfito->Ln(10);
		//$pdfito->Cell(0, 20, utf8_decode(""), 0, 0, 'L');
		//$pdfito->Ln(30);
		$pdfito->Cell(60, 20, utf8_decode("Fecha de observación"), 1, 0, 'C');
		$pdfito->Cell(80, 20, utf8_decode("Docente"), 1, 0, 'C');

		$pdfito->Cell(0, 20, utf8_decode("Observación"), 1, 0, 'C');
		$pdfito->Ln(20);
		while($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$pdfito->Cell(60, 20, utf8_decode("{$rows['observationdate']}"), 1, 0, 'C');
			$pdfito->Cell(80, 20, utf8_decode("{$rows['observationteacher']}"), 1, 0, 'C');
			$pdfito->MultiCell(0, 20, utf8_decode("{$rows['observations']}"), 1, 'C');
			$pdfito->Ln(20);
		}
		$pdfito->Output("I", "Listado de observaciones - {$rows2['student']}.pdf", true);
	}
	else {
		header("Location: observacion?userid={$_GET['userid']}");
	}

?>