<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Check user type
$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID = u.TYPE_ID
          WHERE ID = ' . $_SESSION['MEMBER_ID'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $userType = $row['TYPE'];

    if ($userType == 'User') {
        ?>
        <script type="text/javascript">
            alert("Restricted Page! You will be redirected to POS");
            window.location = "pos.php";
        </script>
        <?php
        exit; // Terminate script execution for users with 'User' type
    }
}

// Check if 'id' is set in the URL
if (!isset($_GET['id'])) {
    echo "Error: Missing 'id' parameter.";
} else {
    // Safely handle 'id' parameter to prevent SQL injection
    $customerId = mysqli_real_escape_string($db, $_GET['id']);

    // Retrieve customer information
    $query = 'SELECT * FROM customer WHERE CUST_ID =' . $customerId;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    if ($row = mysqli_fetch_array($result)) {
        $zz = $row['CUST_ID'];
        $i = $row['FIRST_NAME'];
        $a = $row['LAST_NAME'];
        $b = $row['PHONE_NUMBER'];
    } else {
        echo "Error: Customer not found.";
    }
}
?>
            
            <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Edit Customer</h4>
            </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="customer.php?"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back </a>
            <div class="card-body">
         
            <form role="form" method="post" action="cust_edit1.php">
              <input type="hidden" name="id" value="<?php echo $zz; ?>" />
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 First Name:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="First Name" name="firstname" value="<?php echo $i; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Last Name:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $a; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Contact #:
                </div>
                <div class="col-sm-9">
                   <input class="form-control" placeholder="Phone Number" name="phone" value="<?php echo $b; ?>" required>
                </div>
              </div>
              <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button> 
              </form>  
          </div>
  </div>

  <?php
include '../includes/footer.php';
?>