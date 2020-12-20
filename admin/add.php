<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id'] ) && empty($_SESSION['logged_in'] )){
  header ('location:login.php');
}
if ($_POST) {
    $file='images/'. ($_FILES['image']['name']);
    $imageType = pathinfo ($file,PATHINFO_EXTENSION);
    if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert ('image must be png , jpg or jpeg')</script>";
    }else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file );
        $stmt = $pdo->prepare("INSERT INTO posts (title,content,author_id,image) VALUES (:title,:content,:author_id,:image) ");
        $result = $stmt->execute(
            array (':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image)
        );
        if ($result) {
            echo "<script>alert('successfuly added');window.location.href='index.php';</script>";
            // header('location:index.php');
        }
    }
}
?>

<?php include('header.html'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
              <form action="add.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="">Title</label>
                  <input required type="text" name="title" value="" class="form-control">
              </div>
              <div class="form-group">
                  <label for="">Content</label><br>
                  <textarea class="form-control" name="content" id="" cols="80" rows="10"></textarea>
              </div>
              <div class="form-group">
                  <label for="">Image</label><br>
                  <input required type="file" name="image">
              </div>
              <div class="form-group">
                  <input class="btn btn-success" type="submit" name="" value="SUBMIT">
                  <a href="index.php" class="btn btn-primary">Back</a>
              </div>
            </form>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html'); ?>
