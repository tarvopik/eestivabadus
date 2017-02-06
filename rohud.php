<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Ravimid</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous"/>
	<link href='https://fonts.googleapis.com/css?family=Paprika' rel='stylesheet' type='text/css'/>
	<link href='https://fonts.googleapis.com/css?family=Palanquin+Dark' rel='stylesheet' type='text/css'/>
	<style>
	body {
        background: #F0F9DB;    
	}
	li, li a {display: inline; 
    /*text-decoration: none;*/}
		header {
    		box-shadow: 1px 1px 1px 2px #3A4323;
		    text-align: center;
		    color: #3a3315;
		    background: #ABC569;
		}
		header .container {
		    padding-top: 10px;
		    padding-bottom: 15px;
		}
		header img {
		    display: block;
		    margin: 0 auto;
		    margin: 20px 0 0 0;
		}
		header .intro-text .name {
		    display: block;
		    text-transform: uppercase;
		    font-family: 'Paprika', cursive;
		    font-size: 2em;
		    font-weight: 700;
		}
		header .intro-text .description {
		    font-size: 1.25em;
		    font-weight: 300;
		}
		footer {
			margin: 10px 0 20px 0;
    		box-shadow: 1px 1px 1px 3px darkgrey;
		}
		h1, h2, h3, h5, footer {
			font-family: 'Paprika', cursive;
		}
		h4 {
			font-family: 'Palanquin Dark', sans-serif;
		}
		table {
			font-family: 'Paprika', cursive;
    		width: 100%;
    		text-align: left;  
    		box-shadow: 1px 2px 2px 2px darkgrey; 
		}
		#klii {
			width: 100%;
    		float: center;
    		box-shadow: 1px 2px 2px 2px darkgrey;
		    margin: 10px 0 0 0;
		}
		.fixed-nav-bar {
			font-family: 'Paprika', cursive;
    		box-shadow: 1px 1px 1px 2px #3A4323;
    		text-align: center;
    		font-size: 2em;
    		position: fixed;
    		top: 0;
    		left: 0;
    		z-index: 9999;
    		height: 40px;
    		background-color: #ABC569;
    		float: clear;
    		margin: 0 auto; left:0px; right:0px;
		}
		@media(max-width:768px) {
		    header .container {
		        padding-top: 10px;
		        padding-bottom: 10px;
		    }
		    header img {
		    	margin: 10px 0 0 0;
			}
		    header .intro-text .name {
		        font-size: 4.75em;
		    }
		    header .intro-text .description {
		        font-size: 1.75em;
		    }
		    .fixed-nav-bar {
    			font-size: 1.5em;
    			height: 30px;
			}
		}
	</style>
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
                    <h2>Ravimid</h2>
                </div>
            </div>
        </div>
    </header>
    <section class="success" id="queries">
        <div class="container">
            <div class="row">
            
                <div class="col-lg-12">
                    
					<table class='table table-hover' cellspacing="0" class="cell-border" width="100%">
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