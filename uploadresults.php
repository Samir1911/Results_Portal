<?php
    set_time_limit(0);
    $server="sql303.epizy.com";
    $user="epiz_32518067";
    $password="0LJssmwsfQRc9F";
    $batch="BATCH2019_23";
    // $sem="Sem1_2";
    // $exam="Regular";
    // $file="sem1_2.csv";
    $sem=$_POST['sem'];
    $exam=$_POST['exam'];
    $file=$_POST['csvfile'];
    try{
        $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_batch2019_23","$user",$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if($exam=="Regular"){
            $sql="CREATE TABLE ".$sem."(
                HT_NO VARCHAR(10),
                SUBCODE VARCHAR(10),
                SUBNAME VARCHAR(50),
                INTERNAL INT,
                GRADE CHAR,
                CREDITS FLOAT
            );";
            $conn->exec($sql);
            $sql=$conn->prepare("INSERT INTO ".$sem." VALUES(:H,:SC,:SN,:I,:G,:C);");
            $sql->bindParam(':H',$H);
            $sql->bindParam(':SC',$SC);
            $sql->bindParam(':SN',$SN);
            $sql->bindParam(':I',$I);
            $sql->bindParam(':G',$G);
            $sql->bindParam(':C',$C);
        }
        else{
            $sql=$conn->prepare("UPDATE ".$sem." SET GRADE=:G WHERE HT_NO=:H AND SUBCODE=:SC;");
            $sql->bindParam(':H',$H);
            $sql->bindParam(':SC',$SC);
            $sql->bindParam(':G',$G);
        }        
        $file = fopen($file,"r");

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
                if($G=="No"){
                    break;
                }
                if($G=="ABSENT" and $exam=="Regular"){
                    $G='T';
                }
                if($G=="ABSENT" and $exam=="Supply"){
                    break;
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

        $sql=$conn->prepare("SELECT DISTINCT(SUBCODE) FROM ".$sem.";");
        $sql->execute();
        while(($sub=$sql->fetchColumn())!=false){
            $max=$conn->prepare("SELECT CREDITS FROM ".$sem." WHERE SUBCODE=:sub AND CREDITS>0 LIMIT 1 ;");
            $max->bindParam(":sub",$sub);
            $max->execute();
            $C=$max->fetchColumn();
            $cred=$conn->prepare("UPDATE ".$sem." SET CREDITS=:C WHERE SUBCODE=:sub AND CREDITS=0;");
            $cred->bindParam(":sub",$sub);
            $cred->bindParam(":C",$C);
            $cred->execute();
        }

        $conn=new PDO("mysql:host=$server;dbname=epiz_32518067_main","$user",$password);
        $sql="UPDATE BATCH SET ".$sem."='Y' WHERE BATCHNAME='".$batch."';";
        $conn->exec($sql);

        echo "<script type='text/javascript'>
                alert('Results Uploaded successfully')
              </script>";
        // echo "<script type='text/javascript'>
        //             window.location='admin.php';
        //         </script>";
    }
    catch(PDOException $e){
        echo $sql . $e->getmessage();
    }
?>