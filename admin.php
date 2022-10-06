<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KITS_RESULTS | ADMIN</title>
    <link rel="stylesheet" href="header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn&display=swap" rel="stylesheet">
    <style>
        form{
            background:rgb(255, 255, 255,0.3);
            backdrop-filter: blur(10px);
            display:grid;
            place-items:center;
            padding:30px;
            margin-top:100px;
        }
        #create >*{
            margin:5px 0;
            width:300px;
            height:30px;
        }
        input[type=text]{
            padding-left:20px;
            box-sizing: border-box;
        }
        #create{
            display:none;
        }

        .sc{
            width:120px;
            height:30px;
            margin:0 10px;
        }
        #rbtns{
            width:300px;
            height:fit-content;
        }
        #rbtns,#upload div{
            display:flex;
            justify-content:space-around;
            align-items:center;
        }
        #upload >*{
            margin:10px 0;
        }
        .file{
            width:180px;
        }
        button{
            padding:5px 10px;
            background-color:rgb(255, 115, 0);
            border-radius: 10px;
            border:0;
            color:white;
            font-weight: 600;
        }
        #close{
            width:20px;
            height:20px;
            margin:-5px 0 0 320px;
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
            <a href="admin.php" id="admin">ADMIN</a>
        </div>
    </header>
    <main>
        <p>Create DataBase of New Batch : <button>Click Here</button></p>
        <form action="createbatch.php" method="post" id="create">
            <img id="close" src="Assets/close.svg" alt="close">
            <P>CREATE NEW BATCH</P>
            <input type="text" class="N_ip" name="batchname" placeholder="ex: BATCH2019_23">
            <input type="text" class="N_ip" value="Regular"readonly>
            <input type="text" class="N_ip" value="Sem1_1" readonly>
            <input type="file" name="csv" class="file" accept="text/csv"><p>* upload csv file with only results fields.</p>
            <input type="submit" value="submit">
        </form>

        

        <form action="uploadresults.php" method="post" id="upload">
            <p>UPLOAD RESULTS</p>
            <div>
                <select name="batch" class="sc">
                    <?php
                        $server="sql303.epizy.com";
                        $user="epiz_32518067";
                        $password="0LJssmwsfQRc9F";
                        $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_main",$user,$password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                        $count=$conn->prepare("SELECT count(BATCHNAME) FROM BATCH;");
                        $count->execute();
                        if($count->fetchColumn()==0)
                            echo "<option value='No BATCH'>No BATCH </option>";
                        else{
                            $sql=$conn->prepare("SELECT BATCHNAME FROM BATCH");
                            $sql->execute();
                            while(($b=$sql->fetchColumn())!=false){
                                echo "<option value='".$b."'>".$b."</option>";
                            }
                        }
                    ?>
                </select>
                <select name="sem" class="sc">
                    <option value="Sem1_1">Sem1_1</option>
                    <option value="Sem1_2">Sem1_2</option>
                    <option value="Sem2_1">Sem2_1</option>
                    <option value="Sem2_2">Sem2_2</option>
                    <option value="Sem3_1">Sem3_1</option>
                    <option value="Sem3_2">Sem3_2</option>
                    <option value="Sem4_1">Sem4_1</option>
                    <option value="Sem4_2">Sem4_2</option>
                </select>
            </div>
            <div id="rbtns">
                <div><input type="radio" name="exam"  value="Regular">Regular</div>
                <div><input type="radio" name="exam"  value="Supply">Supply</div>
            </div>
            <input type="file" name="csvfile" class="file">
            <p>*upload .csv file only.</p>
            <input type="submit" value="Upload">
        </form>
    </main>
    <footer>
        <p>Developed by : <a href="samir1911.netlify.com">Samir Abdul</a></p>
    </footer>
    <script>
        var btn=document.querySelector("button");
        var up=document.querySelector("#upload");
        var c=document.querySelector("#create");
        var cl=document.querySelector("#close");
        btn.addEventListener("click",function(){
            up.style.display="none";
            c.style.display="grid";
        })
        cl.addEventListener("click",function(){
            c.style.display="none";
            up.style.display="grid";
        })
    </script>
</body>
</html>