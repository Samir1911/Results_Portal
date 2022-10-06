<?php
    try{
        $conn=new PDO("mysql:host=sql303.epizy.com;dbname=epiz_32518067_main","epiz_32518067","0LJssmwsfQRc9F");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $USER=$_POST["uname"];
        $PASS=$_POST["pass"];
        $sql=$conn->prepare("select * from ADMIN;");
        $sql->execute();
        while(($row=$sql->fetch(PDO::FETCH_ASSOC))!=false){
            if($row['USERNAME']==$USER && $row['PASSWORD']==$PASS){
                echo "<script type='text/javascript'>
                    window.location='admin.php';
                </script>";
            }
        }
        echo "<script type='text/javascript'>
                alert('Wrong userId or Password')
              </script>";
        echo "<script type='text/javascript'>
                    window.location='index.php';
                </script>";
    }
    catch(PDOException $e){
        echo $e->getmessage();
    }
    
?>