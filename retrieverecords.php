<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KITS | RESULTS</title>
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="header.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn&display=swap" rel="stylesheet">

    <style>
        main{
            margin:10px auto;
        }
        #links a{
            color:red;
        }
        table{
            margin:0 10px;
            width:min(95%,800px);
            background:rgba(255, 255, 255, 0.2);
            backdrop-filter:blur(5px);
        }
        th{
            color:red;
        }
        pre{
            margin:10px 0 30px 0;
            font-weight:800;
            text-align:center;
        }
        td{
            padding:2px;
            font-weight:600;
        }
        #reg{
            display:none;
        }
        select{
            height:30px;
        }
        #btn{
            height:30px;
        }
        form{
            width:250px;
            display:flex;
            justify-content:space-around;
            align-items:center;
        }
        @media(max-width:850px){
            table{
                font-size:12px;
            }
            .size{
                font-size:10px;
            }
            .internals{
                display:none;
            }
        }
        @media(max-width:400px){
            .size{
                font-size:8px;
            }
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
    <main >
        <?php
        try{
            $server="sql303.epizy.com";
            $user="epiz_32518067";
            $password="0LJssmwsfQRc9F";

            $batch=$_POST['batch'];
            $HTno=$_POST['reg'];
            $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_main",$user,$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql=$conn->prepare("SELECT * FROM BATCH WHERE BATCHNAME='".$batch."';");
            $sql->execute();
            $Sem=$sql->fetch(PDO::FETCH_ASSOC);
            $sum=0;
            $i=0;
            $bl=0;
            foreach($Sem as $k=>$v){
                if($v=='N'){
                    break;
                }
                if(preg_match("/....5...../i",$HTno) && ($k=="Sem1_1" || $k=="Sem1_2"))
                    continue;
                if($v=='Y'){
                    $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_batch2019_23",$user,$password);
                    $sql=$conn->prepare("SELECT * FROM ".$k." WHERE HT_NO='".$HTno."';");
                    $sql->execute();
                    $fixi=0;
                    $xi=0;
                    $G=array('O'=>10,'S'=>9,'A'=>8,'B'=>7,'C'=>6,'D'=>5,'F'=>0);
                    echo "<table border=1>";
                    echo "<tr>";
                    echo "<th>HT_NO</th>";
                    echo "<th>SUBCODE</th>";
                    echo "<th>SUBJECT NAME</th>";
                    echo "<th class='internals'>INTERNALS</th>";
                    echo "<th >GRADE</th>";
                    echo "<th >CREDITS</th>";
                    echo "</tr>";
                    while(($row=$sql->fetch(PDO::FETCH_ASSOC))!==false){
                        echo "<tr>";
                        echo "<td>$row[HT_NO]</td>";
                        echo "<td>$row[SUBCODE]</td>";
                        echo "<td class='size'>$row[SUBNAME]</td>";
                        echo "<td class='internals'>$row[INTERNAL]</td>";
                        $gd=$row['GRADE'];
                        if($gd=='K')
                            $gd='COMP..';
                        else if($gd=='T')
                            $gd="ABSENT";
                        else
                            $fixi+=$G[$gd]*$row['CREDITS'];
                        $xi+=$row['CREDITS'];
                        echo "<td>$gd</td>";
                        if($gd=='F'){
                            echo "<td>0</td>";
                            $bl++;
                        }
                        else
                            echo "<td>$row[CREDITS]</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    if($xi>0){
                        $sgpa=round($fixi/$xi,2);
                        echo "<pre>".$k."         SGPA = $sgpa</pre>";
                        $sum+=$sgpa;
                    }
                    $i++;
                }
            }
            $cgpa=round($sum/$i,2);
            $p=($cgpa-0.75)*10;
            echo "<p>HT_NO = ".$HTno."<br><pre>CGPA = ".$cgpa."    PRECENTAGE = ".$p."<br><br>BACKLOGS : $bl</pre></p>";
            
            echo '<form action="updatepage.php" method="POST">
                <input type="text" name="Regid" value="'.$HTno.'" id="reg" readonly>
                <select name="sem" id="Sem">
                    <option value="" disabled hidden selected>Select Sem</option>
                    <option value="Sem1_1">Sem1_1</option>
                    <option value="Sem1_2">Sem1_2</option>
                    <option value="Sem2_1">Sem2_1</option>
                    <option value="Sem2_2">Sem2_2</option>
                    <option value="Sem3_1">Sem3_1</option>
                </select>
                <input type="submit" value="Update Results" id="btn">
            </form>';
        }
        catch(PDOException $e){
            echo $e->getmessage();
        }
      
    ?>
    </main>
    <footer>
        <p>Developed by : <a href="https://samir1911.netlify.app/">Samir Abdul</a></p>
        <p>Special Thanks to Mr. Mahaboob Subhani.</p>
    </footer> 
</body>
</html>