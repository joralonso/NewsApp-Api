<?php

// http://flightphp.com/

	/* 	
	CATEGORIAS:
	0: Actualidad
	1: Cultura
	2: Tecnología
	3: Depotes
	4: Cine y Tele
	5; Opinión
	*/

require 'flight/Flight.php';
require '../config.php';


Flight::route('/hora', function(
	){
	
	$mil = 1227643821310;
$seconds = $mil / 1000;
echo date("Y-m-d H:i:s", $seconds);
});

Flight::route('/noticia/@id:[0-9]+', function($id){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}
	$mysqli->set_charset("utf8");
    $sql = "SELECT * FROM noticias WHERE id = $id LIMIT 1";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		$json = $p;		
	}
	echo json_encode($json);
});

Flight::route('/noticias/categoria/@id:[-0-9]+', function($id){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}
	$mysqli->set_charset("utf8");
	if ($id == -1)
		$sql = "SELECT n.id, n.medioId, n.titulo, n.thumb, n.visual, n.categoria, n.published, m.nombre FROM noticias AS n LEFT JOIN medios m ON m.id = n.medioid WHERE n.fecha >= (CURDATE()) ORDER BY n.engagement DESC LIMIT 50";
	else
    	$sql = "SELECT n.id, n.medioId, n.titulo, n.thumb, n.visual, n.categoria, n.published, m.nombre FROM noticias AS n LEFT JOIN medios m ON m.id = n.medioid WHERE n.categoria = $id ORDER BY n.published DESC LIMIT 50";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		$json[] = $p;		
	}
	echo json_encode($json);
});

Flight::route('/popular', function(){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}
	$mysqli->set_charset("utf8");
    $sql = "SELECT n.id, n.medioId, n.titulo, n.thumb, n.visual, n.categoria, n.published, m.nombre FROM noticias AS n LEFT JOIN medios m ON m.id = n.medioid ORDER BY n.engagement DESC LIMIT 50";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		$json[] = $p;		
	}
	echo json_encode($json);
});

Flight::route('/noticias/@id:[0-9]+', function($id){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}
	$mysqli->set_charset("utf8");
    $sql = "SELECT n.* FROM noticias AS n WHERE n.medioId = $id ORDER BY fecha DESC LIMIT 50";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		$json[] = $p;		
	}
	echo json_encode($json);
});

Flight::route('/medios/@id:[0-9]+', function($id){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}
	$mysqli->set_charset("utf8");
    $sql = "SELECT * FROM medios WHERE categoria = $id";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		$json[] = $p;		
	}
	echo json_encode($json);
});


Flight::route('/medios', function(){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}
	$mysqli->set_charset("utf8");
    $sql = "SELECT * FROM medios";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		$json[] = $p;		
	}
	echo json_encode($json);
});


Flight::route('/mediosxml', function(){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}
	$mysqli->set_charset("utf8");
    $sql = "SELECT * FROM medios ORDER BY categoria ASC";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		$titulos[] = "<item>$p->nombre</item>\n";
		$ids[] = "<item>$p->id</item>\n";
	}
	foreach ($titulos as $t) echo $t;
	echo "\n\n";
	foreach ($ids as $t) echo $t;
});



Flight::route('/actualizar', function(){
	$mysqli = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
	if (!$mysqli){
	    header('HTTP/1.0 404 Not Found');
	    echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
	}

	$mysqli->set_charset("utf8");
	
    $sql = "SELECT * FROM medios ORDER BY fecha ASC LIMIT 10";
	$result = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli).' SQL:'.$sql);
	while($p = $result->fetch_object()){
		echo $p->feed;
		$json = json_decode(file_get_contents('http://cloud.feedly.com/v3/streams/contents?streamId=feed/'.$p->feed));
		foreach ($json->items as $r){

			$sql = "SELECT id, engagement FROM noticias WHERE url = '$r->originId'";
			$result2 = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli).' SQL:'.$sql);
			if($k = $result2->fetch_object()){

				if (isset($r->engagement))
					$engagement = $r->engagement;
				else
					$engagement = 0;

				if (isset($r->engagementRate))
					$engagementRate = $r->engagementRate;
				else
					$engagementRate = 0;

				if ($engagement != 0 && $engagement != $k->engagement){
					$sql = "UPDATE noticias SET engagement = $engagement, engagementRate = $engagementRate WHERE url = '$r->originId'";
					mysqli_query($mysqli, $sql);
					echo 'update';
				}

			}else{

				$visual = $r->visual->url;
				if ($visual == null | $visual == ''){
					preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $r->summary->content, $imagen);
					$visual = $imagen['src'];
				}

				$thumb = $r->thumbnail[0]->url;

				if (isset($r->engagement))
					$engagement = $r->engagement;
				else
					$engagement = 0;

				if (isset($r->engagementRate))
					$engagementRate = $r->engagementRate;
				else
					$engagementRate = 0;

				$sql3 = "INSERT INTO noticias(medioId, titulo, url, texto, thumb, categoria, fecha, engagement ,engagementRate, visual, published) VALUES ($p->id, '".addslashes($r->title)."', '$r->originId', '".addslashes($r->summary->content)."', '$thumb', '$p->categoria', '".date("Y-m-d H:i:s", $r->published/1000)."', $engagement, $engagementRate, '$visual', $r->published)";

				mysqli_query($mysqli, $sql3);
			}
		}
		$sql = "UPDATE medios SET fecha = NOW() WHERE id = $p->id";
		mysqli_query($mysqli, $sql);


	}
});

Flight::route('/hola', function(){
    echo 'hello world!';
});
Flight::route('/export', function(){
    //$mysqli =  mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);	
    //$mysqli->select_db($name); 
    $mysqli = new mysqli($GLOBALS['db_server'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']); 
        $mysqli->select_db($GLOBALS['db_name']); 
    $mysqli->query("SET NAMES 'utf8'");

    $queryTables    = $mysqli->query('SHOW TABLES'); 
    while($row = $queryTables->fetch_row()) 
    { 
        $target_tables[] = $row[0]; 
        echo $row[0];
    } 
    $target_tables = array();
    $target_tables[] = 'noticias';
    foreach($target_tables as $table)
    {
        $result         =   $mysqli->query('SELECT * FROM '.$table);  
        $fields_amount  =   $result->field_count;  
        $rows_num=$mysqli->affected_rows;     
        $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
        $TableMLine     =   $res->fetch_row();
        $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";
        echo $content;
        break;

        for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
        {
            while($row = $result->fetch_row())  
            { //when started (and every after 100 command cycle):
                if ($st_counter%100 == 0 || $st_counter == 0 )  
                {
                        $content .= "\nINSERT INTO ".$table." VALUES";
                }
                $content .= "\n(";
                for($j=0; $j<$fields_amount; $j++)  
                { 
                    $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                    if (isset($row[$j]))
                    {
                        $content .= '"'.$row[$j].'"' ; 
                    }
                    else 
                    {   
                        $content .= '""';
                    }     
                    if ($j<($fields_amount-1))
                    {
                            $content.= ',';
                    }      
                }
                $content .=")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                {   
                    $content .= ";";
                } 
                else 
                {
                    $content .= ",";
                } 
                $st_counter=$st_counter+1;
            }
        } $content .="\n\n\n";
        echo $content;
        $content = array();
    }
    //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
    $backup_name = $backup_name ? $backup_name : $name.".sql";
    //header('Content-Type: application/octet-stream');   
    //header("Content-Transfer-Encoding: Binary"); 
    //header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
    //echo var_dump($content);
});


Flight::start();
?>