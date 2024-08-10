<?php
include ("db.php");
$sql = "SELECT * FROM tih";
$result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <title>TIH- CRUD</title>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
          <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    </head>
    <body>
    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#adduser">AddUser</button>
    <table class="table" id="user">
        <thead>
          <tr>
            <th scope="col">S.No</th>
            <th scope="col">Name</th>
            <th scope="col">Department</th>
            <th scope="col">Action</th>

          </tr>
        </thead>
        <tbody>
            <?php
            $s=1;
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
         <tr>
            <td><?php echo $s;?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['dept'];?></td>
            <td>
            <button type="button" value="<?php echo $row['id']; ?>"
            class="btn btn-danger btnuserdelete">Delete</button>

            </td>
         </tr>
         <?php
           $s++;
            }
          
        ?>
        </tbody>
      </table>

      <!-- Add User Modal -->
<div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addnewuser">
      <div class="modal-body">
        <input type="text" name="name" placeholder="enter name" required>
        <input type="text" name="dept" placeholder="enter Department" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <script>
          $(document).ready(function () {
      $('#user').DataTable();
    });

    $(document).on('submit', '#addnewuser', function (e) {
      e.preventDefault();
      var formData = new FormData(this);
      console.log(formData);
      formData.append("save_newuser", true);
      $.ajax({
        type: "POST",
        url: "backend.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

          var res = jQuery.parseJSON(response);
          console.log(res)
          if (res.status == 200) {
            $('#adduser').modal('hide');
            $('#addnewuser')[0].reset();
           $('#user').load(location.href + " #user");
            alert(res.message)

          }
          else if (res.status == 500) {
            $('#adduser').modal('hide');
            $('#addnewuser')[0].reset();
            console.error("Error:", res.message);
            alert("Something Went wrong.! try again")
          }
        }
      });

    });

    $(document).on('click', '.btnuserdelete', function (e) {
      e.preventDefault();

      if (confirm('Are you sure you want to delete this data?')) {
        var user_id = $(this).val();
        $.ajax({
          type: "POST",
          url: "backend.php",
          data: {
            'delete_user': true,
            'user_id': user_id
          },
          success: function (response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 500) {
              alert(res.message);
            }
            else {
              $('#user').load(location.href + " #user");
            }
          }
        });
      }
    });


    </script>
    </body>
</html>