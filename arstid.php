<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Arstid</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous"/>
	<link href='https://fonts.googleapis.com/css?family=Paprika' rel='stylesheet' type='text/css'/>
	<link href='https://fonts.googleapis.com/css?family=Palanquin+Dark' rel='stylesheet' type='text/css'/>
	<link rel="stylesheet" href="kuj/arstid.css">
</head>
<body>
    <header>
    <div class="container">
        <nav class="fixed-nav-bar">
        <ul class="">
                    <li class="">
                        <a href="logout.php">Logi välja</a>
                    </li>
                </ul>           
        </nav>
    </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Arstid</h2>
                </div>
            </div>
        </div>
    </header>
<?php
  $yhendus=new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
  global $yhendus;
			$yhendus->set_charset('utf8');
  if(!empty($_REQUEST["andmed"])){
     $kask=$yhendus->prepare(
	  "INSERT INTO protsetuurid(protsetuur) VALUES(?)");
	 $kask->bind_param("s", $_REQUEST["protseduur"]);
	 $kask->execute();
	 $kask2=$yhendus->prepare(
	  "INSERT INTO kylastused(looma_id, arsti_id) VALUES(?,?)");
	 $kask2->bind_param("ii", $_REQUEST["loom"], $_REQUEST["arst"]);
	 $kask2->execute();
  	$arstID = $_REQUEST["arst"];

	 $kylastusID = mysqli_insert_id($yhendus); //küsime viimati sisestatud protseduuri id
	 //var_dump($lastID);
	 //var_dump($arstID);

	 $kask3=$yhendus->prepare("INSERT INTO protsloomad(arsti_id, protseduuri_id) VALUES (?, ?)");
	$kask3->bind_param("ii", $arstID, $lastID);
	$kask3->execute();

	$lastID = mysqli_insert_id($yhendus);
	//var_dump($kylastusID);
	//var_dump("kogus");
	$kask4=$yhendus->prepare("INSERT INTO valrohud(rohu_id, kylastuse_id, kogus, valrohudcol) VALUES (?,?,?,?)");
	$kask4->bind_param("iiis", $_REQUEST["ravim"], $kylastusID, $_REQUEST["kogus"], $_REQUEST["yhik"]);
	$kask4->execute();

	 echo $yhendus->error;
	 header("Location: $_SERVER[PHP_SELF]");
	 $yhendus->close();
	 exit();
  }
  ?>
  <center>
<h1>Loomaga teostatud protseduuri lisamine ja ravimi väljastamine</h1>
<form action="?">
Arst: 
	<select name="arst">
	<?php 
	$paring = $yhendus->prepare("SELECT id, arstinimi, arstiperenimi FROM arstid order by id");
	$paring->bind_result($id,$arstinimi,$arstiperenimi);
	$paring->execute();
	while($paring->fetch()){
		echo "<option value='$id'>$arstinimi $arstiperenimi<br /><br /></value>";
	}
	?>
	</select>
Loom: 
	<select name="loom">
	<?php 
	$paring = $yhendus->prepare("SELECT id, liik, loomanimi FROM loomad");
	$paring->bind_result($id,$liik,$loomanimi);
	$paring->execute();
	while($paring->fetch()){
		echo "<option value='$id'>$liik $loomanimi<br /><br /></value>";
	}
	?>
	</select>

		Protseduur: 
	    
	     <input type="text" name="protseduur" />
Ravim: 
	<select name="ravim">
	<?php 
	$paring = $yhendus->prepare("SELECT id, nimetus, yhik, yhikuhind FROM rohud");
	$paring->bind_result($id, $nimetus,$yhik,$yhikuhind);
	$paring->execute();
	while($paring->fetch()){
		echo "<option value='$id'>$nimetus $yhik<br /><br /></value>";
	}
	?>
	</select>	
	Kogus: 
	    
	     <select type="number" name="kogus" />
			<option>1</option>
		    <option>2</option>
		    <option>3</option>
		    <option>4</option>
		    <option>5</option>
		    <option>6</option>
		    <option>7</option>
		    <option>8</option>
		    <option>9</option>
		    <option>10</option>
	     <br /><br /></select>
	   
	Ühik:
	<input type="text" name="yhik" /><br /><br />

		 <input type="submit" name="andmed" value="Sisesta andmed" /><br /><br />
  </form>
</center>

<?php
  $yhendus->close();
?>

    <section class="success" id="queries">
        <div class="container">
            <div class="row">
            
                <div class="col-lg-12">
                    
					<table class='table table-hover' cellspacing="0" class="cell-border" width="100%">
        <thead><br>
            <tr>
                <th>Loom</th>
                <th>Arst</th>
                <th>Teostatud protseduur</th>
                <th>Määratud ravimid</th>
            </tr>
        </thead>
        	<tbody>
		<?php 		
			$yhendus = new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
			global $yhendus;
			$yhendus->set_charset('utf8');
			$paring = $yhendus->prepare("SELECT CONCAT(loomad.liik, ' ', loomad.loomanimi) AS loom, CONCAT(arstid.arstinimi, ' ', arstid.arstiperenimi) AS arst, ravi, rohi 
FROM loomad 
JOIN kylastused ON kylastused.looma_id=loomad.id
JOIN arstid ON arstid.id=kylastused.arsti_id
JOIN (SELECT arstid.id AS arsti_id, protsetuurid.protsetuur AS ravi FROM protsloomad JOIN arstid ON arstid.id=protsloomad.arsti_id JOIN protsetuurid ON protsetuurid.id=protsloomad.protseduuri_id) O ON O.arsti_id=kylastused.arsti_id
JOIN (SELECT kylastuse_id, rohud.nimetus AS rohi FROM valrohud JOIN rohud ON rohud.id=valrohud.rohu_id) K ON K.kylastuse_id=kylastused.id;");
			$paring->bind_result($loom, $arst, $ravi, $rohi);
			$paring->execute();
			while ($paring->fetch()) {
				echo '<tr><td>'.$loom.'</td><td>'.$arst.'</td><td>'.$ravi.'</td><td>'.$rohi.'</td></tr>';
			}
		?>
			</tbody>
    	</table>
            </div>
        </div>
    </section>
    <center>
    <footer>2016 tarvopik@tlu.ee</footer>    
  </center>
</body>
</html>