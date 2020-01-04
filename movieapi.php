<?php
    $con = new mysqli("localhost","root","","film");
    if($con->connect_error){
        die("Failed Connected to database");
    }

    $resp = array("error"=>false);
    $req = "";
    if (isset($_GET["req"])){
        $req = $_GET["req"];
    }

    if($req=="read"){
        $result = $con->query("SELECT * FROM productionhouse");
        $ph = array();
        while($row = $result->fetch_assoc()){
            array_push($ph, $row);
        }
        $resp["ph"]=$ph;
    }

    if($req=="readmv"){
        $result = $con->query("SELECT movie.id,movie.movie,movie.genre,productionhouse.id as idph,productionhouse.name from movie 
        INNER JOIN productionhouse 
        WHERE productionhouse.id = movie.productionhouseid");
        $movie = array();
        while($row = $result->fetch_assoc()){
            array_push($movie, $row);
        }
        $resp["movie"]=$movie;
    }

    if($req=="insert"){
        if(isset($_POST["id"]) && isset($_POST["name"])){
            $id = $_POST["id"];
            $name = $_POST["name"];
        }
        

        $result = $con->query("INSERT INTO `productionhouse` (`id`,`name`) VALUES ('$id','$name')");
        if($result){
            $resp["message"]="Production house has been added successfully";
        }
        else{
            $resp["error"] =true;
            $resp["message"]="Error insert new record!";
        }
    }

    if($req=="insertmv"){
        if(isset($_POST["id"]) && isset($_POST["movie"]) && isset($_POST["genre"]) && isset($_POST["movie"]) && isset($_POST["productionhouseid"])){
            $id = $_POST["id"];
            $movie = $_POST["movie"];
            $genre = $_POST["genre"];
            $pro = $_POST["productionhouseid"];
        }
        

        $result = $con->query("INSERT INTO `movie` (`id`,`movie`,`genre`,`productionhouseid`) VALUES ('$id','$movie','$genre','$pro')");
        if($result){
            $resp["message"]="Movie Data has been added successfully";
        }
        else{
            $resp["error"] =true;
            $resp["message"]="Error insert new record!";
        }
    }

    if($req=="update"){
        if(isset($_POST["id"]) && isset($_POST["name"])){
            $id = $_POST["id"];
            $name = $_POST["name"];
        }
        

        $result = $con->query("UPDATE `productionhouse` SET `name` = '$name' WHERE `id`='$id'");
        if($result){
            $resp["message"]="Production house has been update successfully";
        }
        else{
            $resp["error"] =true;
            $resp["message"]="Error update record!";
        }
    }

    if($req=="updatemv"){
        if(isset($_POST["id"]) && isset($_POST["movie"]) && isset($_POST["genre"]) && isset($_POST["movie"]) && isset($_POST["idph"])){
            $id = $_POST["id"];
            $movie = $_POST["movie"];
            $genre = $_POST["genre"];
            $idph = $_POST["idph"];
        }
        

        $result = $con->query("UPDATE `movie` SET `movie`='$movie',`genre`='$genre',`productionhouseid`='$idph' WHERE `id`='$id'");
        if($result){
            $resp["message"]="Movie data has been update successfully";
        }
        else{
            $resp["error"] =true;
            $resp["message"]="Error update record!";
        }
    }

    if($req=="delete"){
        if(isset($_POST["id"])){
            $id = $_POST["id"];
        }
        

        $result = $con->query("DELETE FROM `productionhouse` WHERE `id`='$id'");
        if($result){
            $resp["message"]="Production house has been delete successfully";
        }
        else{
            $resp["error"] =true;
            $resp["message"]="Error delete record!";
        }
    }

    if($req=="deletemv"){
        if(isset($_POST["id"])){
            $id = $_POST["id"];
        }
        

        $result = $con->query("DELETE FROM `movie` WHERE `id`='$id'");
        if($result){
            $resp["message"]="Movie Data has been delete successfully";
        }
        else{
            $resp["error"] =true;
            $resp["message"]="Error delete record!";
        }
    }

    $con->close();
    header('Content-Type:application/json');
    echo json_encode($resp);
    die();

?>