<?php
    set_time_limit(0);
    $server="sql303.epizy.com";
    $user="epiz_32518067";
    $password="0LJssmwsfQRc9F";
    try{
        $batch=$_POST["batchname"];
        

        $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_main",$user,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql=$conn->prepare("SELECT BATCHNAME FROM BATCH;");
        $sql->execute();

        while(($b=$sql->fetchColumn())!=false){
            if($b==$batch){
                echo "<script type='text/javascript'>
                alert('Batch Already Exists.')
                </script>";
                echo "<script type='text/javascript'>
                    window.location='admin.php';
                </script>";
            }
        }
        $sem="sem1_1";
        // $conn=new PDO("mysql:host=$server",$user,$password);
        // $sql="CREATE DATABASE ".$batch.";";
        // $conn->exec($sql);

        //CREATING TABLE 
        
        $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_batch2019_23",$user,$password);
        $sql="CREATE TABLE ".$sem."(
            HT_NO VARCHAR(10),
            SUBCODE VARCHAR(10),
            SUBNAME VARCHAR(50),
            INTERNAL INT,
            GRADE CHAR,
            CREDITS FLOAT
        );";
        $conn->exec($sql);

        //INSERTING SEM1-1 DATA 
        $sql=$conn->prepare("INSERT INTO ".$sem." VALUES(:H,:SC,:SN,:I,:G,:C);");
        $sql->bindParam(':H',$H);
        $sql->bindParam(':SC',$SC);
        $sql->bindParam(':SN',$SN);
        $sql->bindParam(':I',$I);
        $sql->bindParam(':G',$G);
        $sql->bindParam(':C',$C);

        $file = fopen($_POST["csv"],"r");


        while(($data=fgetcsv($file))!==false){
            foreach($data as $i){
                $record=preg_split('/\s+/', $i, -1, PREG_SPLIT_NO_EMPTY);
                if(!$record){
                    continue;
                }
                $num=count($record);
                $H=$record[0];
                $SC=$record[1];
                $I=$record[$num-3];
                $G=$record[$num-2];
                if($G=="COMPLETED"){
                    $G='K';
                }
                $C=$record[$num-1];
                $slice=array_slice($record,2,$num-5);
                $SN="";
                foreach($slice as $s){
                    $SN.=" ".$s;
                }
                $sql->execute();
            }
        }
        //setting credits of failed subjects 
        $sql=$conn->prepare("SELECT DISTINCT(SUBCODE) FROM ".$sem.";");
        $sql->execute();
        while(($sub=$sql->fetchColumn())!=false){
            echo "<br>".$sub;
            $max=$conn->prepare("SELECT CREDITS FROM ".$sem." WHERE SUBCODE=:sub AND CREDITS>0 LIMIT 1 ;");
            $max->bindParam(":sub",$sub);
            $max->execute();
            $C=$max->fetchColumn();
            echo "found max";
            $cred=$conn->prepare("UPDATE ".$sem." SET CREDITS=:C WHERE SUBCODE=:sub AND CREDITS=0;");
            $cred->bindParam(":sub",$sub);
            $cred->bindParam(":C",$C);
            $cred->execute();
            echo "updated";
        }

        $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_main",$user,$password);
        $sql="INSERT INTO BATCH(BATCHNAME,Sem1_1) VALUES('".$batch."',"."'Y');";
        $conn->exec($sql);
        
        

        echo "<script type='text/javascript'>
                alert('Batch created successfully')
              </script>";
        echo "<script type='text/javascript'>
                    window.location='admin.php';
                </script>";
    }
    catch(PDOException $e){
        echo $e->getmessage();
    }

?>