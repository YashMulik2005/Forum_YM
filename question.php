<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">
    <style>
   
    body{
        background-color:#e3f1f1 !important;
        margin: 0px 70px !important;
    }
    .jumbotron {
     
        /* background: rgba(243, 245, 247, 0.3)!important; */
        padding: 15px;
        background-color:#DEFCFC;
        border-radius: 4px;
        margin: 18px 0px;
    }

   .main{
        padding: 15px;
        background-color: #DEFCFC;
        margin: 10px 0px;
   }

    .form_p {
       
    }

    h2 {
      
    }
    .qdiv {
       /* margin: 10px 80px;*/
        padding: 10px;
        display: flex;
        width: 100%;
        border: 1px solid rgb(144, 143, 143);
        border-radius: 3px;
        margin: 14px 0px;
    }
    .img{
        width: 10%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .text{
        width: 90%;
    }
    .qimg {
        width: 60px;
        height: 60px;
    }

    .qdiv a {
        font-weight: bolder;
        text-decoration: none;
        color: black;
    }

    .qdiv a:hover {
        color: black;
    }
    .ques{
        display: flex;
        padding: 10px;
       /* margin: 10px 80px;*/
        border: 1px solid rgb(93, 91, 91);
        border-radius: 7px;
        background-color: rgba(215, 216, 218, 0.778);
        box-shadow: 2px;
    }
    .qimgdiv{
        width: 10%;
    }
  
    .user{
        width: 15%;
    }
    @media(max-width:900px) {
        body{
            margin: 0px 5px;
        }
    }
    </style>
    <title>Hello, world!</title>
</head>

<body>
    <?php include 'navbar.php';?>
    <?php include 'dbconnect.php';?>
    <?php
   // session_start();
   // echo $_SESSION['user_id'];
   $cat_id=$_GET['cat_id'];
   $sql="select * from `categeries` where `categeries_id`=$cat_id";
   $result=mysqli_query($connect,$sql);
   $row=mysqli_fetch_assoc($result);
   $cat_title=$row['tittle'];
   $cat_des=$row['description'];
   echo' <div class="jumbotron">
        <h1 class="display-4">'. $cat_title. '</h1>
        <p class="lead">'. $cat_des . '</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
    </div>';
    ?>
    <?php
    //include 'dbconnect.php';
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $qtittle=$_POST['qtittle'];
        $cat_id=$_GET['cat_id'];
        $qdescription=$_POST['qdescription'];
        $user_id=$_SESSION['user_id'];
        $sql="INSERT INTO `questions` (`qtittle`, `qdescription`, `cat_id`,`user_id`) VALUES ('$qtittle', '$qdescription','$cat_id','$user_id')";
        $result=mysqli_query($connect,$sql);
        if(!$result){
            echo 'Something went wrong please try again';
        }
    }
?>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
       echo' <div class="main">
            <form action=" '. $_SERVER["REQUEST_URI"] .' " method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1"><b>Question tittle</b></label>
                    <input type="text" class="form-control" id="qtittle" aria-describedby="emailHelp" name="qtittle">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label"><b>Question discription</B></label>
                    <textarea class="form-control" id="qdescription" rows="3" name="qdescription"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>';
    }
    else{
        echo'<p class="form_p">For posting a question you have to login first.</p>';
    }
    ?>

    <?php
        $sql="SELECT * FROM `questions` WHERE `cat_id` = $cat_id";
        $result=mysqli_query($connect,$sql);
        $num=mysqli_num_rows($result);
        //echo $_SESSION['user_id'];
        if($num>0){
        echo' 
            <h2>Questions on '.$cat_title .'</h2>';
        while($row=mysqli_fetch_assoc($result)){
            $que_id=$row['qes_id'];
            $tittle=$row['qtittle'];
            $description=$row['qdescription'];
            $time=$row['time'];
            $user_id=$row['user_id'];

            $sql1="SELECT * FROM `login_system` WHERE `user_id` = $user_id";
            $result1=mysqli_query($connect,$sql1);
            $row1=mysqli_fetch_assoc($result1);
            $name=$row1['username'];

            echo '<div class="qdiv">
            <div class="img">
              <img src="user_logo.png" class="qimg" alt="...">
              <p>'.$name.'</p>
            </div>
            <div class="text">
                <p>'.$time.'</p>
              <a href="answres.php?qus_id='. $que_id .' "><p>'. $tittle .'</p></a>
              <p>'. $description .'</p>
            </div>

          </div>';
        }
    }
    else{
        echo '<p class="form_p">Post a question and start a conversation</p>';
    }
    ?>
   <!-- <div class="ques">
        <div class="qimgdiv">
            <img src="user_logo.png" class="qimg" alt="">
        </div>
        <div class="text">
            <p>tittle</p>
            <p>descriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescription</p>
        </div>
        <div class="user">
            <p>66758r86476</p>
            <p>64657t8t98y9887r7997986764</p>
        </div>
    </div>-->

    <?php
        include 'footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>