<?php


require '../config.php';


$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
if (!$mysqli){
    header('HTTP/1.0 404 Not Found');
    echo "<h1>404 Not Found.</h1>";
    echo $mysqli->connect_error;
    echo "The page that you have requested could not be found.";
    exit();
}

if (isset($_POST['nombre'])){

	$nombre = $_POST['nombre'];
	$feed = $_POST['feed'];
	$categoria = $_POST['categoria'];
	$sql ="INSERT INTO medios (nombre, feed, categoria) VALUES ('$nombre', '$feed', $categoria)";
	echo $sql.'<br>';
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);

} else if (isset($_POST['categoria'])){

	$id = $_POST['id'];
	$feed = $_POST['feed'];
	$categoria = $_POST['categoria'];
	$sql = "UPDATE medios SET feed = '$feed', categoria = $categoria WHERE id = $id";
	echo $sql.'<br>';
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);

}
echo '<hr>';
echo 'Actualidad (0)
	Cultura (1)
	Tecnología (2)
	Depotes (3)
	Cine y Tele (4)
	Opinión (5)
	Humor (6)<br><br>';
$sql = "SELECT * FROM medios";
$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
echo '<div style="max-width:600px">';
echo '<h5 style="margin:0px">'.$p->nombre.'</h5>';
	echo '<form method="post">';
	echo 'Nombre:    <input type="text" name="nombre" style="width:70%" value=""><br>';
	echo 'Feed:      <input type="text" name="feed"  style="width:70%" value=""><br>';
	echo 'Categoria: <input type="text" name="categoria" style="width:70%" value=""><br>';
	echo '<input type="submit" style="width:10%" value="Submit"><br>';
	echo '</form>';
echo '<hr>';
while($p = $result->fetch_object()){
	echo '<h5 style="margin:0px">'.$p->nombre.'</h5>';
	echo '<form method="post">';
	echo '<input type="text" name="id" style="width:5%" value="'.$p->id.'">';
	echo '<input type="text" name="feed"  style="width:80%" value="'.$p->feed.'">';
	echo '<input type="text" name="categoria" style="width:5%" value="'.$p->categoria.'">';
	echo '<input type="submit" style="width:10%" value="Submit"><br>';
	echo '</form>';

}
echo '</div>';
	
?>
