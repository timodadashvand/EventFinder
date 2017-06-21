<?php
mysql_connect("localhost", "ab7675", "v*m9XPC8");
mysql_select_db("AB7675");

$return = new ArrayObject();

if(isset($_FILES['media']['tmp_name'])){
	// Vi försöker ladda upp en bild!
	$path = $_POST['type']."/";
	
	if(move_uploaded_file($_FILES['media']['tmp_name'], $path.$_FILES['media']['name'])){
		if(mysql_query("INSERT INTO media (title, type, path) VALUES ('".$_POST['title']."', '".$_POST['type']."', '".$path.$_FILES['media']['name']."')")){
			$return['success'] = true;
			$return['message'] = "Fil uppladdad & sparad i db";
			echo json_encode($return);
		}else{
			$return['success'] = false;
			$return['message'] = "Fil uppladdad men inte sparad i db";
			echo json_encode($return);
		}
		
	}else{
		$return['success'] = false;
		$return['message'] = "Kunde inte ladda upp filen";
		echo json_encode($return);
	}
}else{
	$return['success'] = false;
	$return['message'] = "Ingen bild skickad";
	//echo json_encode($return);
}

if(isset($_GET['action']) and $_GET['action'] == "getMedia"){
	if(isset($_GET['type'])){
		$res = mysql_query("SELECT * FROM media WHERE type = '".$_GET['type']."' ORDER BY id DESC");
	}else{
		$res = mysql_query("SELECT * FROM media ORDER BY id DESC");
	}
	$media = new ArrayObject();
	while($row = mysql_fetch_array($res)){
		$m = new ArrayObject();
		$m['path'] = $row['path'];
		$m['type'] = $row['type'];
		$m['title'] = $row['title'];
		$m['timestamp'] = $row['timestamp'];
		$m['id'] = $row['id'];
		$media['files'][] = $m;
	}
	echo json_encode($media);
}


?>