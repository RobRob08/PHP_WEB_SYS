<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-login">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Log In</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <div class="row">
                <form action="" method="POST">
                        <div class="col-12">
                           <div class="form-floating mb-3">
                            <input type="email" class="form-control border-0 border-bottom rounded-pill" name="email" id="email" placeholder="name@example.com" required>
                            <label for="email" class="form-label">Email</label>
                           </div> 
                        </div>

                        <div class="col-12">
                           <div class="form-floating mb-3">
                            <input type="password" class="form-control border-0 border-bottom rounded-pill" name="password" id="password"  value="" placeholder="Password" required>
                            <label for="password" class="form-label">Password</label>
                           </div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid">
                               <button class="btn btn-secondary btn-lg rounded-pill" type="submit" name="login">Log In</button> 
                            </div>
                    </div>
            </form>
                </div>
    </div>
    <?php if($error) include 'theme_components/alert.php';?>
    <div class="modal-footer">Don't have an account? <a href="#myModal2" class="trigger-btn" data-bs-toggle="modal">Sign Up</a></div>
  </div>
</div>
</div>

<div class="modal fade" id="myModal2" aria-hidden="true">
      <div class="modal-dialog modal-login">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Sign Up</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="" method="POST">

<div class="col-12">
   <div class="form-floating mb-3">
    <input type="email" class="form-control border-0 border-bottom rounded-pill" name="email" id="email" placeholder="name@example.com" required>
    <label for="email" class="form-label text-dark">Email</label>
   </div> 
</div>


    <div class="col-12">
   <div class="form-floating mb-3">
    <input type="password" class="form-control border-0 border-bottom rounded-pill" name="password" id="password"  value="" placeholder="Password" required>
    <label for="password" class="form-label text-dark">Password</label>
   </div>
</div>

<div class="col-12">
   <div class="form-floating mb-3">
    <input type="password" class="form-control border-0 border-bottom rounded-pill" name="cpassword" id="cpassword"  value="" placeholder="Confirm Password" required>
    <label for="cpassword" class="form-label text-dark">Confirm Password</label>
   </div>
</div>

<div class="col-12">
    <div class="d-grid">
       <button class="text-light btn btn-warning btn-lg rounded-pill" type="submit" name="register">Register</button> 
</div>


</div>
</form>
          </div>
          <?php if($error) include 'theme_components/alert.php';?>
          <div class="modal-footer text-light">Already have an account? <a href="#myModal" class="trigger-btn" data-bs-toggle="modal">Log In</a></div>
        </div>
      </div>
    </div>

    <script>

  document.querySelector('.trigger-btn').addEventListener('click', function() {
    var myModal = new bootstrap.Modal(document.getElementById('myModal'));

  });


  document.getElementById('myModal2').addEventListener('hidden.bs.modal', function () {

    var backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
  });

  document.getElementById('myModal').addEventListener('hidden.bs.modal', function () {

var backdrop = document.querySelector('.modal-backdrop');
if (backdrop) {
    backdrop.remove();
}
});
</script>
