<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KITS | Results</title>
    <link rel="stylesheet" href="header.css" />
    <link rel="icon" href="logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn&display=swap" rel="stylesheet">

    <style>
      main {
        margin: 0 auto;
        display: grid;
        place-items: center;
        margin-top: 200px;
      }
      form {
        padding: 30px;
      }
      form,
      #adminlogin {
        display: grid;
        place-items: center;
        height: fit-content;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
      }
      input {
        height: 30px;
        font-size: 20px;
        border-radius: 5px;
        border: 0;
        margin: 10px 0;
      }
      input[type="text"],
      input[type="password"] {
        padding-left: 20px;
      }
      #adminlogin {
        display: none;
        margin-top: -10px;
        padding-right: 0;
      }
      select{
        height:30px;
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
      <form action="retrieverecords.php" method="post" id="studquery">
        <select name="batch" >
            <?php
              $server="sql303.epizy.com";
              $user="epiz_32518067";
              $password="0LJssmwsfQRc9F";  
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
            ?>
        </select>
        <input type="text" name="reg" placeholder="Enter Registration Number" /><br>
        <input type="submit" value="submit" />
      </form>

      <div id="adminlogin">
        <img class="close" src="Assets/close.svg" alt="close" />
        <form action="validate.php" method="post">
          <input type="text" name="uname" placeholder="Enter Username" />
          <input type="password" name="pass" placeholder="Enter Passsword" />
          <input type="submit" value="submit" />
        </form>
      </div>
    </main>
    <footer>
        <p>Developed by : <a href="https://samir1911.netlify.app/">Samir Abdul</a></p>
        <p>Special Thanks to Mr. Shaik Mahaboob Subhani.</p>
    </footer>

    <script>
      var a = document.querySelector("#admin");
      var admin = document.querySelector("#adminlogin");
      var stud = document.querySelector("#studquery");
      var close = document.querySelector("#adminlogin img");
      a.addEventListener("click", function () {
        admin.style.display = "block";
        stud.style.display = "none";
      });
      close.addEventListener("click", function () {
        stud.style.display = "grid";
        admin.style.display = "none";
      });
    </script>
  </body>
</html>
