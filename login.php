<?php 
session_start();
	$yhendus = new mysqli("localhost", "tarvopikkaro", "pFfVriSF", "tarvopikkaro");
	$teade = "";
	session_start();
	if (isset($_SESSION['tuvastamine'])) {
	  header('Location: kliinik.php');
	  exit();
	  }
	if (!empty($_POST['login']) && !empty($_POST['pass'])) {
		$kask=$yhendus->prepare("SELECT kasutaja, parool FROM admin WHERE kasutaja=? AND parool=?");
		$login = htmlspecialchars(trim($_REQUEST['login']));
		$pass = htmlspecialchars(trim($_REQUEST['pass']));
		$kask->bind_param("ss", $login, $pass); 
		$kask->bind_result($kasutaja, $parool);
		$kask->execute();
		if($kask->fetch()){
			$_SESSION['tuvastamine'] = 'login';
			header('Location: kliinik.php');
			if($_POST['remember']==1){
				setcookie("user", $login, time() + 86400, "/"); //24h
			}
		} else {
             $teade = '<br><div class="alert alert-danger">Sisesta uuesti</div>';
		}
	} 
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
	
    <title>Sisse logimine</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous"/>
	<link href='https://fonts.googleapis.com/css?family=Paprika' rel='stylesheet' type='text/css'/>
	<link href='https://fonts.googleapis.com/css?family=Palanquin+Dark' rel='stylesheet' type='text/css'/>
	<style>
	body {
        background: #F0F9DB;    
	}
	li, li a {display: inline; padding: 20px;}
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
				
		h3 {padding: 30px; font-family: 'Paprika', cursive;}
		
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
</head>
<body>
<header>
    <div class="container">
        <nav class="fixed-nav-bar">
         <li class="">
                        <a>Kodutöö loomakliinik</a>
                    </li>
                    
                    <li class="">
                        <a>Sisselogimine</a>
                    </li>      
        </nav>
        
    </div>
        
    </header>

	<center>
   	<div>
      	<h3>Logi sisse</h3>
   	</div>
   	<div>
        <form action="" method="post">
        <div>
		<input type="text" name="login"  placeholder="kasutaja" required>
        </div>
        <div>
		<input placeholder="parool" type="password" name="pass" required>
        </div>
		<input type="submit" value="Logi sisse">
        </form>
		<?php echo $teade; ?>
        </div>
         </div>
        
  
    
</body>
</html>