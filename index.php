<?php
  $insert=false;
  $update=false;
  $delete=false;
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "notes";
  
  // Create a connection
  $conn = mysqli_connect($servername, $username, $password, $database);
  
  // Die if connection was not successful
  if (!$conn){
      die("Sorry we failed to connect: ". mysqli_connect_error());
  }


  if(isset($_GET['delete'])){
    $sno=$_GET['delete'];
    $delete = true;
    $sql="DELETE FROM `notes` WHERE `notes`.`sno` = $sno ";
    $result=mysqli_query($conn,$sql);

    
  }

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['snoEdit'])){
            $title=$_POST['titleEdit'];
            $description=$_POST['descriptionEdit'];
            $sno=$_POST['snoEdit'];

            $sql="UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno";
            $result=mysqli_query($conn,$sql);
                if($result){
                  $update=true;
                }
                else{
                  echo "note has not been updated--->".mysqli_error($conn);
                }
                
    }
    else{
            $title=$_POST["title"];
            $description=$_POST["description"];

            $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
            $result=mysqli_query($conn,$sql);

            if($result){
              $insert=true;
            }
            else{
              echo "note has not been submitted--->". mysqli_error($conn);
            }
  }
  }


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
      body{
        /* background-image: url("bgbg.jpg");
        background-repeat: no-repeat;
        background-size: cover; */
        /* filter: opacity(90%); */
        color: cornflowerblue;
      }
    </style>

    <title>iNotes- adding notes is easy</title>
  </head>
  <body>

    <!-- edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="editmodal" data-bs-target="#editModal">
  edit modal
</button> -->

<!--edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/crud/index.php" method="POST">
          <input type="hidden" name="snoEdit" id="snoEdit" >
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            
          </div>
          
          <div class="form-group">
                      <label for="desc">Note Description</label>
                      <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                    </div> 
          <button type="submit" class="btn btn-primary my-4">Update note</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    

<!-- nav bar is here........  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">about</a>
        </li>  
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<!-- nav bar ended over here..........  -->


<?php
if($insert){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> your note has been submitted.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
<?php
if($update){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> your note has been updated.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
<?php
if($delete){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> your note has been deleted.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<!-- form starts from  here.......   -->
<div class="container">
  <h1>Add note </h1>
<form action="/crud/index.php" method="POST">
  <div class="mb-3">
    <label for="title" class="form-label"><h3>Title</h3></label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
    
  </div>
  
  <div class="form-group">
              <label for="desc"><h3>Note Description</h3></label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div> 
  <button type="submit" class="btn btn-primary my-4">Add note</button>
</form>
</div>
<!-- form ends here......  -->


<!-- table starts from here.....   -->
<div class="container">
<table class="table table-dark table-striped" id="mytable">
  <thead>
    <tr>
      <th scope="col">sno</th>
      <th scope="col">title</th>
      <th scope="col">description</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
<?php
    $sql="SELECT *FROM `notes`";
    $result=mysqli_query($conn,$sql);
    
    $sno=0;
    while($row=mysqli_fetch_assoc($result)){
      $sno=$sno+1;
     echo  "<tr>
      <th>".$sno ."</th>
      <td>" .$row['title'] ."</td>
      <td>" .$row['description'] ."</td>
      <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>   <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
    </tr>";
    }

    

  
  
?>

</tbody>
</table>
  </div>

<!-- table ends from here....   -->


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->


    <!-- this js is for  pagination...   -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>

    <!-- js ends here for  pagination.....   -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script> $(document).ready( function () {
          $('#mytable').DataTable();
      } );
      </script>
      <script>
        edits=document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
          element.addEventListener("click",(e)=>{
            console.log("edit");
            tr=e.target.parentNode.parentNode;
            title=tr.getElementsByTagName("td")[0].innerText;
            description=tr.getElementsByTagName("td")[1].innerText;
            console.log(title,description);
            titleEdit.value=title;
            descriptionEdit.value=description;
            snoEdit.value=e.target.id;
            console.log(e.target.id);
            $('#editModal').modal('toggle');
          })
        })

        deletes=document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
          element.addEventListener("click",(e)=>{
            console.log("edit");
            sno=e.target.id.substr(1);
            console.log(sno);
         


           
            if(confirm("do you really want to delete this note..?")){
              console.log("yes");
              window.location= `/crud/index.php?delete=${sno}`;
            }
            else{
              console.log("no");
            }

          })
        })
        // deletes = document.getElementsByClassName('delete');
        // Array.from(deletes).forEach((element) => {
        // element.addEventListener("click", (e) => {
        // console.log("edit ");
        // sno = e.target.id.substr(1);
        //   })
        // })
      </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>