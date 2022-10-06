<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KITS RESULTS | UPDATE</title>
    <link rel="stylesheet" href="header.css">
    <link rel="icon" href="logo.png">
    <style>
        main{
            display:flex;
            justify-content:center;
            align-items:center;
            height:70vh;
            flex-wrap:wrap;
        }
        main > div{
            display:grid;
            place-items:center;
        }
        form{
            padding:30px;
            display: grid;
            place-items: center;
            height: fit-content;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            width:300px;
        }
        form div{
            text-align: center;
        }
        input,select {
            height:30px;
        }
        input[type="text"]{
            width:50px;
            height:23px;
        }
        select{
            width:150px;
        }
        #Sem{
            width:80px;
        }
        
        #RegId{
            width:100px;
            margin-bottom:20px;
            text-align:center;
        }
        #s{
            margin-top:20px;
        }
        p{
            text-align:center;
            width:min(550px,95%);
        }
        #se{
            display:none;
        }
    </style>
</head>
<body>
    <header id="Kits_logo">
        <!-- <div>
                <h1>K<span>IT</span>S</h1>
                <P>[Autonomous]</P>
        </div> -->
        <img src="logo.png" alt="logo">
        <h1 id="clg">KKR AND KSR <span>INSTITUTE OF TECHNOLOGY</span> AND SCIENCES </h1>
        <div id="links">
            <a href="index.php">HOME</a>
            <a href="#">ADMIN</a>
        </div>
    </header>
    <main>
        <div>
            <p>Note: This results will not be reflected in any PlaceMent process. So, Please update your results genuinely.This is just like a CGPA Calculator.</p>
            <?php
                
                $h=$_POST['Regid'];
                $sem=$_POST['sem'];
                $server="sql303.epizy.com";
                $user="epiz_32518067";
                $password="0LJssmwsfQRc9F";
                $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_batch2019_23",$user,$password);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                        $sql=$conn->prepare("SELECT SUBCODE,SUBNAME FROM ".$sem." WHERE HT_NO='".$h."';");
                        $sql->execute();
                echo '<form action="update.php" method="post">
                    <input type="text" name="RegId" id="RegId" READONLY value="'.$h.'">
                    <input type="text" name="sem" id="se" readonly value="'.$sem.'">
                    <div>
                    <select name="sub" id="Sub" required>';
                        while(($row=$sql->fetch(PDO::FETCH_ASSOC))!==false){
                            echo "<option value=".$row['SUBCODE'].">".$row['SUBNAME']."</option>";
                        }
                        
                echo '  </select>
                    <input type="text" name="grade" placeholder="Grade" required>
                    </div>
                    <input type="submit" id="s" value="Submit">
                </form>';
                $sql=$conn->prepare("INSERT INTO VISITED VALUES('".$h."','".$sem."');");
                $sql->execute();

            ?>
        </div>
    </main>
    
</body>
</html>