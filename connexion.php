<html>
<head>
<meta charset="utf8">
</head>
<body>
<?php 
include 'User.php';
//$log="admin";
//$pwd="admin";
/*$servername="localhost";
	$username="root";
	$password="";
	$dbname="dblogin";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
	$username, $password);
	$req="select * from users where user_name='$login' && user_pass='$pwd'";
	$rep=$conn->query($req);
	$res=$rep->fetchAll();
	*/
$c=new Database();
$conn=$c->connexion();
$user=new User($_POST['login'],$_POST['pwd'],$conn);
$u=$user->Logedin($conn,$_POST['login'],$_POST['pwd']);

	//var_dump($u);
//$logR=$_POST['login'];
//$pwdR=$_POST['pwd'];






$vide=false;
if (!empty($_POST['login']) && !empty($_POST['pwd'])){



    //  $conn = new PDO("mysql:host=localhost;dbname=dblogin", 'root', '');
        $pdoStat = $conn->prepare('INSERT INTO users (user_name, user_pass)VALUES (:nom, :pass)');
        $pdoStat->bindValue(':nom',$_POST['login'],PDO::PARAM_STR);
        $pdoStat->bindValue(':pass',$_POST['pwd'],PDO::PARAM_STR);
        $insertisok =$pdoStat->execute();
       // $insertisok =  $pdoStat->execute();
        if($insertisok)
        {
          echo "le contact a ete enregistrer";
        }
        else
        {
          echo "echec";
        }




	
	foreach($u as $t){
		$vide=true;
	if ($t['user_name']==$_POST['login'] && $t['user_pass']==$_POST['pwd']){
		
		session_start();
		$_SESSION['l']=$_POST['login'];
		$_SESSION['p']=$_POST['pwd'];
		$_SESSION['r']=$t['role'];
		header("location:page_membre.php");
		
		}
	
}
if ($vide==false) { 
         // Le visiteur n'a pas été reconnu comme étant membre de notre site. On utilise alors un petit javascript lui signalant ce fait
         echo '<body onLoad="alert(\'Membre non reconnu...\')">'; 
         // puis on le redirige vers la page d'accueil
         echo '<meta http-equiv="refresh" content="0;URL=auth.html">'; 
      } 
}	  
 
else { 
      echo "Les variables du formulaire ne sont pas déclarées.<br> Vous devez remplir le formulaire"; 
     ?> <a href="auth.html">Retour au formulaire</a>	 <?php 
}  

?> 
</body>
</html>