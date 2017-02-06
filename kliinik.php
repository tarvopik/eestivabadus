<?php 
session_start();
    $yhendus = new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
 ?>
<?php
session_start();
if (!isset($_SESSION['tuvastamine']) && !isset($_COOKIE['user'])) {
  header('Location: login.php');
  echo "<a href='login.php'>Logi sisse!</a>";
  exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Loomakliinik - Tarvo Pikkaro</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous"/>
	<link href='https://fonts.googleapis.com/css?family=Paprika' rel='stylesheet' type='text/css'/>
	<link href='https://fonts.googleapis.com/css?family=Palanquin+Dark' rel='stylesheet' type='text/css'/>
	<link rel="stylesheet" href="kuj/kliinik.css">
	
</head>
<body>
    <header>
    <div class="container">
        <nav class="fixed-nav-bar">
        <ul class="">
                    
                    <li class="">
                        <a href="loomad.php">Loomad</a>
                    </li>
                    <li class="">
                        <a href="arstid.php">Arstid</a>
                    </li>
                    
                    <li class="">
                        <a href="logout.php">Logi välja</a>
                    </li>
                </ul>           
        </nav>
        
    </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="pildid/kliinik.png" alt="">
                </div>
            </div>
        </div>
    </header>
<?php
  $yhendus=new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
  if(!empty($_REQUEST["arst"])){
     $kask=$yhendus->prepare(
	  "INSERT INTO arstid (arstinimi, arstiperenimi) VALUES(?, ?)");
	 $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perenimi"]);
	 $kask->execute();
	 echo $yhendus->error;
	 header("Location: $_SERVER[PHP_SELF]");
	 $yhendus->close();
	 exit();
  }
  ?>
  <?php
  $yhendus=new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
  if (isset($_REQUEST['rohi'])) {
	$kask = $yhendus->prepare("INSERT INTO rohud(nimetus, yhik, yhikuhind) VALUES (?,?,?)");
	$kask->bind_param("ssi", $_REQUEST['nimetus'], $_REQUEST['yhik'], $_REQUEST['hind']);
	$kask->execute();
	header("Location: $_SERVER[PHP_SELF]");
	exit();
	  }
?>

  <center>
  
    <h1>Lisa Arst</h1>
	<form action="?">

	   Eesnimi: 
	     <input type="text" name="eesnimi" /><br /><br />
	   Perenimi:
	   <input type="text" name="perenimi" /><br /><br />
		 <input type="submit" name="arst" value="Lisa arst" />
	</form>
<h1>Ravimi lisamine</h1>
	 
<form action="?">Ravim: 
	
	<input type="text" name="nimetus" /><br /><br />
	Ühik:
	<input type="text" name="yhik" /><br /><br />
Ühiku hind:
	<input type="text" name="hind" /><br /><br />
	<input type="submit" name="rohi" value="Lisa ravim" />
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
                <th>Arstid</th>
            </tr>
        </thead>
        	<tbody>
		<?php 		
			$yhendus = new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
			global $yhendus;
			$yhendus->set_charset('utf8');
			$paring = $yhendus->prepare("SELECT CONCAT(arstid.arstinimi, ' ', arstid.arstiperenimi) AS arst FROM arstid;");
			$paring->bind_result($arst);
			$paring->execute();
			while ($paring->fetch()) {
				echo '<tr><td>'.$arst.'</td></tr>';
			}
		?>
			</tbody>
    	</table>
            </div>
        </div>
    </section>
    <section class="success" id="queries">
        <div class="container">
            <div class="row">
            
                <div class="col-lg-12">
                    
					<table class='table table-hover' cellspacing="0" class="cell-border" width="100%">
        <thead><br>
            <tr>
                <th>Ravimid</th>
                <th>Ühik</th>
                <th>Hind €</th>

            </tr>
        </thead>
        	<tbody>
		<?php 		
			$yhendus = new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
			global $yhendus;
			$yhendus->set_charset('utf8');
			$paring = $yhendus->prepare("SELECT rohud.nimetus AS rohi, rohud.yhik AS yhik, rohud.yhikuhind AS hind FROM rohud;");
			$paring->bind_result($rohi, $yhik, $hind);
			$paring->execute();
			while ($paring->fetch()) {
				echo '<tr><td>'.$rohi.'</td><td>'.$yhik.'</td><td>'.$hind.'</td></tr>';
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