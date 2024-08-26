<!-- footer content -->
<footer>
  <div class="pull-right">
    Hak Cipta © Pengadilan Agama Ternate 2023 <span class="ml-3">ver. 1.2.0</span>
  </div>
  <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
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
<script src="<?php echo base_url() ?>resources/moment/min/locales.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo base_url() ?>resources/js/custom.js"></script>
<script src="<?php echo base_url() ?>resources/js/helper.js"></script>
<script src="<?php echo base_url() ?>resources/autocomplete/jquery-ui.js"></script>

<!-- shards datepicker-->
<script src="<?php echo base_url() ?>resources/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>resources/js/shards.min.js"></script>
<script src="<?php echo base_url() ?>resources/js/bootstrap-datepicker.id.js"></script>

<!-- jquery autocomplete -->
<!-- <script src="<?php echo base_url() ?>resources/jquery-autocomplete/jquery.autocomplete.js"></script> -->
<!-- Select 2 -->
<script src="<?php echo base_url() ?>resources/select2/dist/js/select2.min.js"></script>
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

  $(document).ready(function() {
    //bootsrap-datepicker
    var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
    $.fn.bootstrapDP = datepicker;
    $('.tanggal').bootstrapDP({
      format: "dd/mm/yyyy",
      autoclose: true,
      todayHighlight: true,
      language: 'id',
      orientation: "bottom left",
    });
    $('#tgl_start').bootstrapDP({
      format: "dd/mm/yyyy",
      autoclose: true,
      todayHighlight: true,
      language: 'id',
      orientation: "bottom left",
      endDate: '<?php echo date('d/m/Y'); ?>'
    }).on('changeDate', function(e) {
      $('#tgl_finish').bootstrapDP('update', this.value);
      $('#tgl_finish').bootstrapDP('setStartDate', this.value);
      console.log(this.value);
    });
    $('#tgl_finish').bootstrapDP({
      format: "dd/mm/yyyy",
      autoclose: true,
      orientation: "bottom left",
      todayHighlight: true,
      language: 'id',
      endDate: '<?php echo date('d/m/Y'); ?>'
    });
  });
</script>