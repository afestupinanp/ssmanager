<?php require_once 'fix_mysql.php'; ?>
<?php 
	require_once('session_validation.php');
	$target_dir = "img/profiles/";
	$target_file = $target_dir . basename($_FILES["foto"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if($_FILES['foto']) {
	    $check = getimagesize($_FILES["foto"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check file size
	if ($_FILES["foto"]["size"] > 100000) {
	    echo "<script>alert('Tu imagen no puede ser subida. Es demasiado grande. El límite máximo de tamaño de imagen es de 1MB.');</script>";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg") {
	    echo "<script>alert('Tu imagen no puede ser subida. Solo se acepta el formato/extensión JPG.');</script>";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "<script>
			alert('Tu imagen no puede ser subida. Intentalo de nuevo.');
		</script>";
	// if everything is ok, try to upload file
	} else {
		//$target_filenew = $target_dir . "{$_SESSION['userid']}";
		$target_filenew = $target_dir . "{$_SESSION['userid']}" . ".jpg";
	    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_filenew)) {
	        echo "<script>function ReLoad() {
				window.location.replace('profile?userid={$_SESSION['userid']}');
            }
			alert('Imagen subida. Redirigiendo a tu perfil.');
            window.setTimeout(ReLoad, 1000);</script>";
	    } else {
	        echo "<script>alert('Lo lamentamos, tu imagen tuvo un error al ser subida.');</script>";
	    }
	}
?>