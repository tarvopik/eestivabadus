<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Loomakliinik - Tarvo Pikkaro</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous"/>
	<link href='https://fonts.googleapis.com/css?family=Paprika' rel='stylesheet' type='text/css'/>
	<link href='https://fonts.googleapis.com/css?family=Palanquin+Dark' rel='stylesheet' type='text/css'/>
	<link rel="stylesheet" href="kuj/stiil.css">
	
</head>
<body>
    <header>
    <!-- fikseeritud menüü -->
    <div class="container">
        <nav class="fixed-nav-bar">
        <ul class="">
                    
                    <li class="">
                        <a>Kodutöö loomakliinik</a>
                    </li>
                    
                    <li class="">
                        <a href="login.php">Logi sisse</a>
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
    </header><center>
    <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Aadress: Looma 5<br />AVATUD:<br />E-R 10-18<br />L 10-16<br /></h1>
                </div>
            </div>
        </div></center>
    <section class="success" id="queries">
        <div class="container">
            <div class="row">
            <div class="col-lg-12 text-center">
  				<img id="klii" class="img-responsive" src="pildid/kliinik_db.png" alt="">
  				</div>
  				<div class="col-lg-12 text-center">
  				<img id="klii" class="img-responsive" src="pildid/skeem.png" alt="">
  				</div>
                <div class="col-lg-12">
                    <h3><u>Päring viiest tabelist:</u></h3>
	                <h4>
	                SELECT loomad.liik AS liik, CONCAT(omanikud.eesnimi, ' ', omanikud.perenimi) AS omanik, 
	                CONCAT(arstid.arstinimi, ' ', arstid.arstiperenimi) AS arst, ravi, rohi
FROM loomad<br> 
JOIN omanikud ON omanikud.id=loomad.omaniku_id<br>
JOIN kylastused ON kylastused.looma_id=loomad.id<br>
JOIN arstid ON arstid.id=kylastused.arsti_id<br>
JOIN (SELECT arstid.id AS arsti_id, protsetuurid.protsetuur AS ravi FROM 
protsloomad JOIN arstid ON arstid.id=protsloomad.arsti_id<br>
JOIN protsetuurid ON protsetuurid.id=protsloomad.protseduuri_id) O ON O.arsti_id=kylastused.arsti_id<br>
JOIN (SELECT kylastuse_id, rohud.nimetus AS rohi FROM valrohud JOIN rohud ON rohud.id=valrohud.rohu_id) K ON K.kylastuse_id=kylastused.id;<br>
					</h4>
					<table class='table table-hover' cellspacing="0" class="cell-border" width="100%">
        <!-- tabeli päis -->
        <thead><br>
            <tr>
                <th>Looma liik</th>
                <th>Looma omanik</th>
                <th>Arst</th>
                <th>Teostatud ravi</th>
                <th>Määratud ravimid</th>
            </tr>
        </thead>
        	<tbody>
		<?php 		
			$yhendus = new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
			global $yhendus;
			$yhendus->set_charset('utf8');
			$paring = $yhendus->prepare("SELECT loomad.liik AS liik, CONCAT(omanikud.eesnimi, ' ', omanikud.perenimi) AS omanik, CONCAT(arstid.arstinimi, ' ', arstid.arstiperenimi) AS arst, ravi, rohi
FROM loomad 
JOIN omanikud ON omanikud.id=loomad.omaniku_id
JOIN kylastused ON kylastused.looma_id=loomad.id
JOIN arstid ON arstid.id=kylastused.arsti_id
JOIN (SELECT arstid.id AS arsti_id, protsetuurid.protsetuur AS ravi FROM protsloomad JOIN arstid ON arstid.id=protsloomad.arsti_id JOIN protsetuurid ON protsetuurid.id=protsloomad.protseduuri_id) O ON O.arsti_id=kylastused.arsti_id
JOIN (SELECT kylastuse_id, rohud.nimetus AS rohi FROM valrohud JOIN rohud ON rohud.id=valrohud.rohu_id) K ON K.kylastuse_id=kylastused.id;
");
			//päringu tulemused tabelis
			$paring->bind_result($liik, $omanik, $arst, $ravi, $rohi);
			$paring->execute();
			while ($paring->fetch()) {
				echo '<tr><td>'.$liik.'</td><td>'.$omanik.'</td><td>'.$arst.'</td><td>'.$ravi.'</td><td>'.$rohi.'</td></tr>';
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