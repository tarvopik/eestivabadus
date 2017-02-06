<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Loomad</title>
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
                    <h2>Loomad</h2>
                </div>
            </div>
        </div>
    </header>
<!-- looma omaniku lisamine -->
<?php
  $yhendus=new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
  if(!empty($_REQUEST["omanik"])){
     $kask=$yhendus->prepare(
	  "INSERT INTO omanikud (eesnimi, perenimi) VALUES(?, ?)");
	 $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perenimi"]);
	 $kask->execute();
	 echo $yhendus->error;
	 header("Location: $_SERVER[PHP_SELF]");
	 $yhendus->close();
	 exit();
  }
  ?>
  <!-- looma lisamine -->
  <?php
  $yhendus=new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
  if (isset($_REQUEST['loom'])) {
	$kask = $yhendus->prepare("INSERT INTO loomad(omaniku_id, loomanimi, liik, synniaeg) VALUES (?,?,?,?)");
	$kask->bind_param("isss", $_REQUEST['omanikud'], $_REQUEST['loomanimi'], $_REQUEST['liik'],$_REQUEST['synniaeg']);
	$kask->execute();
	header("Location: $_SERVER[PHP_SELF]");
	exit();
	  }
?>

  <center>
  
    <h1>Kõigepealt lisa looma omanik</h1>
	<form action="?"> <!-- looma omaniku sisestamine -->

	   Eesnimi: 
	     <input type="text" name="eesnimi" /><br /><br />
	   Perenimi:
	   <input type="text" name="perenimi" /><br /><br />
		 <input type="submit" name="omanik" value="Lisa omanik" />
	</form>
<h1>Looma lisamine</h1>
	 
<form action="?">Looma omanik: 
	<select name="omanikud"> <!-- rippmenüüst looma omaniku valimine -->
	<?php 
	$paring = $yhendus->prepare("SELECT id, eesnimi, perenimi FROM omanikud");
	$paring->bind_result($id,$eesnimi,$perenimi);
	$paring->execute();
	while($paring->fetch()){
		echo "<option value='$id'>$eesnimi $perenimi<br /><br /></value>";
	}
	?>
	</select> <!-- uue looma andmete sisestamine -->
	
		Looma nimi: 
	     <input type="text" name="loomanimi" /><br /><br />
	   	Looma liik:
	   	 <input type="text" name="liik" /><br /><br />
	   	Looma sünniaeg (YYYY-MM-DD):
	   	 <input type="text" name="synniaeg" /><br /><br />
		 <input type="submit" name="loom" value="Lisa loom" />

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
            <tr> <!-- loomade tabeli päis -->
                <th>Looma omanik</th>
                <th>Looma liik</th>
                <th>Looma nimi</th>
                <th>Looma sünniaeg</th>
            </tr>
        </thead>
        	<tbody>
		<?php 
		//päring loomadest ja nende omanikest		
			$yhendus = new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
			global $yhendus;
			$yhendus->set_charset('utf8');
			$paring = $yhendus->prepare("SELECT CONCAT(omanikud.eesnimi, ' ', omanikud.perenimi) AS omanik, loomad.liik AS liik,  loomad.loomanimi AS loom, loomad.synniaeg AS synd
FROM loomad 
JOIN omanikud ON omanikud.id=loomad.omaniku_id
");
			//päringu kuvamine tabelis
			$paring->bind_result($omanik, $liik, $loom, $synd);
			$paring->execute();
			while ($paring->fetch()) {
				echo '<tr><td>'.$omanik.'</td><td>'.$liik.'</td><td>'.$loom.'</td><td>'.$synd.'</td></tr>';
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