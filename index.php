<?php include 'dbconfig.php' ?>
<?php session_start(); ?>
<?php $msg=""; ?>
<?php
	//Insat data
	if ($conn->connect_error) {
		die("connection faild: ".$conn->connect_error);
	}
	else{
		if (isset($_GET["makeaction"])) {
			$your_name=$_GET["yourname"];
			$u_name=$_GET["uname"];

			$sql ="INSERT INTO faruque(name, username) VALUES ('".$your_name."','".$u_name."')";
			if ($conn ->query($sql)==true) {
				$msg ="data Insart sucess!!";
			} else {
				$msg ="data Insart Faild ):";
			}
		}
	}
?>

<?php
	//Edit data
	if ($conn->connect_error) {
		die("connection faild: ".$conn->connect_error);
	}
	else{
		if (isset($_GET["editaction"]) && isset($_GET['id'])) {
			$id = $_GET['id'];
			$your_name=$_GET["yourname"];
			$u_name=$_GET["uname"];
			$sqledit ="UPDATE faruque SET name=".$your_name.",username=".$u_name." WHERE id=$id";
			if ($conn ->query($sqledit)==true) {
				$msg ="data Insart sucess!!";
			} else {
				$msg ="data Insart Faild ):";
			}
		}
	}
?>


<?php
//Delete data
	if (isset($_GET['delete']) && isset($_GET['id']) ) {
		$id = $_GET['id'];
		$sqldel="DELETE FROM faruque WHERE id=$id";
		if ($conn ->query($sqldel)==true) {
				$msg ="data Delete sucess!!";
			} else {
				$msg ="data Delete Faild ):";
			}
	} else {
		# code...
	}
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<link rel="stylesheet" type="text/css" href="style.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>responsive crud</title>
  </head>
  <body>
    <div class="container">
    	<div class="row hading bg-info">
    		<div class="col-sm-6 py-3">
    			<h2>Data <b>Crud</b></h2>
    		</div>
    		<div class="col-sm-6 py-3">
	    			<!-- Button trigger modal -->
					<button type="button" class="btn btn-success float-right " data-toggle="modal" data-target="#addModal">
					  <i class="fa fa-plus p-1" aria-hidden="true"></i>Add New Data
					</button>

					<!-- Modal for insart -->
					<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form class="form-group" action="" method="get">
										<label for="">Name </label>
										<input  type="text" name="yourname" class="form-control my-2" required>
										<label for="">Username</label>
										<input  type="text" name="uname" class="form-control my-2" required>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
					        	<!-- <input type="submit" url='#' name="makeaction" class="btn btn-success" value=""> -->
										<input type="submit" name="makeaction" class="btn btn-success my-2 float-right" value="Add ">
					   		 </form>
					      </div>
					    </div>
					  </div>
					</div>
    		</div>
    	</div>
			<div class="col">
				<table class="table table-striped ">
				  <thead>
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Name</th>
				      <th scope="col">Username</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
						$sqlread ="SELECT * FROM faruque";
						$res = $conn->query($sqlread);
						if ($res->num_rows > 0) {
							while ($tbrow =$res->fetch_assoc()) {
					 	?>
				    <tr>
				      <th scope="row"><?php echo $tbrow['id']; ?></th>
				      <td><?php echo $tbrow['name']; ?></td>
				      <td><?php echo $tbrow['username']; ?></td>
				      <td><a class="text-info 2" data-toggle="modal" data-target="#editModal" href=""><i class="far fa-edit"></i></a>
				      	  <a class="text-danger ml-5" data-toggle="modal" data-target="#deleteModal" href="<?php  $_SESSION["sesionid"] = $tbrow['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
				    </tr>

					<?php
					}
					}
					else {
						# code...
					} ?>
				  </tbody>
				</table>
			</div>
    </div>

	<!-- Modal for delete-->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Delete row</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p class="font-weight-normal">Are you sure you want to delete these Records?</p>
	        <p class="text-muted ">This action cannot be undone.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <a class="btn btn-danger" href="?delete=ok&id=<?php echo $_SESSION["sesionid"]; ?>">Delete</a>
	      </div>
	    </div>
	  </div>
	</div>
					<!-- Modal for edit-->
					<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form class="form-group" action="" method="get">
								<label for="">Name </label>
								<input type="text" name="yourname" class="form-control my-2">
								<label for="">Username</label>
								<input type="text" name="uname" class="form-control my-2">
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <!-- <input type="submit" name="editaction" class="btn btn-success" value="Save"> -->
					        <a type="submit" name="editaction" class="btn btn-success my-2 float-right" href="?editaction=ok&id=<?php echo $tbrow['id']; ?>"></a>
							</form>
					      </div>
					    </div>
					  </div>
					</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- fa icon cdn-->
	<script src="https://kit.fontawesome.com/a37d31f4bc.js" crossorigin="anonymous"></script>
  </body>
</html>
<?php echo $msg ?>
