<?php session_start(); 

   $link=mysqli_connect("localhost","root","");
   mysqli_select_db($link,"intercambios");

   $usu=$_REQUEST['login']; 
   $pas=$_REQUEST['password'];
   

   echo "$usu $pas ";

   $result = mysqli_query($link,"SELECT password,id_usuario,login,tipo FROM usuario WHERE login='$usu'");
   if($row = mysqli_fetch_array($result))
      {
        if($row["password"] == $pas)
           {
            $_SESSION["k_username"] = $row['login'];           
            $tip=$row["tipo"];
			
            $idCC= $row['id_usuario'];
            $_SESSION["id_usuario"] = $idCC;

            $NombreUsuario= $row['usuario'];
            $_SESSION["usuario"] = $NombreUsuario;
			
            $_SESSION["k_tipo"] = $tip; 
			          
            echo "usuario valido";
            if ($tip==1) header("Location: UsuariosEnLaRed.php");
            if ($tip==0) header("Location: index_ADM.php");
           }
        else header("Location: Error_Password.php");
      }
   else header("Location: Error_Login.php");

?> 