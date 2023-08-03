<!-- footer content -->
<footer>
  <div class="pull-right">
    Hak Cipta © Pengadilan Tinggi Agama Maluku Utara 2023
  </div>
  <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url() ?>resources/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<!-- <script src="<?php echo base_url() ?>resources/Chart.js/dist/Chart.min.js"></script> -->
<!-- iziToast -->
<script src="<?php echo base_url() ?>resources/iziToast/dist/js/iziToast.min.js"></script>
<!-- Page level plugins -->
<script src="<?php echo base_url() ?>resources/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>resources/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>resources/datatables-responsive/js/dataTables.responsive.min.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url() ?>resources/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>resources/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo base_url() ?>resources/js/custom.js"></script>

<script>
  //Function that using bootstrap validator
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>