<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KITS RESULTS | UPDATE</title>
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="header.css">
    <style>
        main{
            height:80vh;
        }
        main >div{
            display:grid;
            place-items:center;
        }
        main a{
            text-decoration:none;
            padding:5px 10px;
            margin:20px 0;
            BORDER-STYLE:solid;
            background:rgb(255, 119, 0);
            color:white;
            border-radius:10px;
            font-weight:600;
            text-align:center;
        }
        #reg,.reg2{
            display:none;
        }
        input[type="submit"]{
            width:fit-content;
            height:30px;
        }
        select{
            height:30px;
        }
        form{
            margin:10px 0;
            text-align:center;
        }
        #index{
            margin-top:30px;
        }

    </style>
</head>
<body>
    <header id="Kits_logo">
      <!-- <div>
        <h1>K<span>IT</span>S</h1>
        <p>[Autonomous]</p>
      </div> -->
      <img src="logo.png" alt="logo">
      <h1 id="clg">
        KKR AND KSR <span>INSTITUTE OF TECHNOLOGY</span> AND SCIENCES
      </h1>
      <div id="links">
        <a href="index.php">HOME</a>
        <a href="#" id="admin">ADMIN</a>
      </div>
    </header>
    <main>
        <?php

            $sem=$_POST['sem'];
            $sub=$_POST['sub'];
            $G=strtoupper($_POST['grade']);
            $H=$_POST['RegId'];
            $server="sql303.epizy.com";
            $user="epiz_32518067";
            $password="0LJssmwsfQRc9F";
            $db="epiz_32518067_batch2019_23";
            echo '<div><form action="updatepage.php" method="POST">
                <input type="text" name="Regid" value="'.$H.'" id="reg" readonly>
                <select name="sem" id="Sem" required >
                    <option value="" hidden selected >Select Sem</option>
                    <option value="Sem1_1">Sem1_1</option>
                    <option value="Sem1_2">Sem1_2</option>
                    <option value="Sem2_1">Sem2_1</option>
                    <option value="Sem2_2">Sem2_2</option>
                    <option value="Sem3_1">Sem3_1</option>
                </select>
                <input type="submit" value="Update Another Subject" id="btn">
            </form>';
            echo '<form action="retrieverecords.php" method="post" id="studquery">
                <select name="batch" class="reg2" >';
              
              $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_main",$user,$password);
              $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
              $count=$conn->prepare("SELECT count(BATCHNAME) FROM BATCH;");
              $count->execute();
              if($count->fetchColumn()==false)
                  echo "<option value='No'>No DATABASE </option>";
              else{
                  $sql=$conn->prepare("SELECT BATCHNAME FROM BATCH");
                  $sql->execute();
                  while(($b=$sql->fetchColumn())!=false){
                      echo "<option value='".$b."'>".$b."</option>";
                  }
              }
    
            echo '</select>
                <input type="text" name="reg" class="reg2" value="'.$H.'" ><br>
                <input type="submit" value="Check Results" >
            </form>';
            $conn= new PDO("mysql:host=$server;dbname=$db",$user,$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql="UPDATE ".$sem." SET GRADE = '".$G."' WHERE HT_NO ='".$H."' AND SUBCODE ='".$sub."' ;";
            $conn->exec($sql);

        ?> 
    </main>
</body>
</html>

