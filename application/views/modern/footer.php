      <?php if(!isset($hide_this_div)):?>
      </div> 
      <?php endif;?>
      <!-- /.content-wrapper (Opened at view/classic/header.php)-->
      
      <!-- Load the actions modal here -->
      <?php
        $param = array(
          'modal_target' => 'actionModal',
          'modal_title' => 'Action Modal',
          'modal_size' => 'modal-sm',
          'modal_content' => ' 
            <div class="m-0 p-0 text-center" id="upload_loader1">
                <div class="loader"><div class="spinner-grow text-warning"></div></div> 
            </div>'
        );
        $this->load->view($this->h_theme.'/modal', $param);
      ?> 
      <!-- Main Footer -->
      <footer class="main-footer text-sm">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
      <!--     <span class="mx-5"> 
            <a href="<?= site_url($this->uri->uri_string().'?set_theme='.($this->h_theme == 'classic' ? 'modern' : 'classic'))?>" class="text-danger">
              <i class="fas fa-lg fa-tint"></i>
            </a> 
            <span class="text-info">Theme: <?=ucwords($this->h_theme)?></span> 
          </span> -->

          <?php echo HMS_NAME . ' ' . HMS_VERSION ?> <?php echo  (ENVIRONMENT === 'development') ?  ' | Page rendered in <strong>{elapsed_time}</strong> seconds. CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
        </div>
        <!-- Default to the left -->
        <strong>
          Copyright &copy; <?= date('Y'); ?> <a href="https://adminlte.io"><?= my_config('site_name'); ?></a>.
        </strong> All rights reserved.
      </footer>

    </div>
    <!-- ./wrapper (Opened at view/classic/header.php) -->

    <!-- REQUIRED SCRIPTS -->
    <!-- Placed at the end of the document so the pages load faster --> 
    <!-- =============================================== -->
    <!-- jQuery -->
    <script src="<?= base_url('backend/modern/plugins/jquery/jquery.js'); ?>"></script>
    <!-- Croppie -->
    <script src="<?= base_url('backend/js/plugins/croppie.js'); ?>"></script>
    <!-- jQuery UI -->
    <script src="<?= base_url('backend/modern/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('backend/modern/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('backend/modern/dist/js/adminlte.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('backend/modern/plugins/bootbox/bootbox.all.js'); ?>"></script>
    <!-- DateTimePicker -->
    <script src="<?= base_url('backend/modern/plugins/datetimepicker/build/jquery.datetimepicker.full.js'); ?>"></script> 
    <!-- Summernote -->
    <script src="<?= base_url('backend/modern/plugins/jodit/jodit.js'); ?>"></script> 
    <!-- Hotel Management System -->
    <script src="<?= base_url('backend/js/hhms.js?time='.strtotime('NOW')); ?>"></script>  

    <!-- fullCalendar -->
    <?php if (isset($has_calendar)): ?>  
    <script src="<?= base_url('backend/modern/plugins/moment/moment.min.js');?>"></script>
    <script src="<?= base_url('backend/modern/plugins/fullcalendar/main.min.js');?>"></script>
    <script src="<?= base_url('backend/modern/plugins/fullcalendar-daygrid/main.min.js');?>"></script>
    <script src="<?= base_url('backend/modern/plugins/fullcalendar-timegrid/main.min.js');?>"></script>
    <script src="<?= base_url('backend/modern/plugins/fullcalendar-bootstrap/main.min.js');?>"></script>
    <script src="<?= base_url('backend/modern/plugins/fullcalendar-interaction/main.min.js'); ?>"></script> 
    <?php endif; ?>
    <!-- =============================================== -->

    <script src="<?= base_url('backend/js/excanvas.min.js'); ?>"></script> 
    <script src="<?= base_url('backend/js/chart.min.js'); ?>" type="text/javascript"></script> 
    <script src="<?= base_url('backend/js/full-calendar/fullcalendar.min.js'); ?>"></script>
    <script src="<?= base_url('backend/js/base.js'); ?>"></script> 

    <!-- Notifications and more -->
    <?php if ($this->account_data->logged_in()): ?>
      <script>

        responsiveFileManager = function (modal_id = '') { 
          $.ajax({
              url: site_url('backend/RFileManager/dialog.php?type=1&editor=ckeditor&fldr='),
              type: 'GET',
              dataType: 'html'
          })
          .done(function(data) {
            $('.modal-dialog').addClass('modal-xl').removeClass('modal-sm');
            $('.modal-title').html('Responsive File Manager');
            $('.modal-body').html('');
            $(modal_id).modal('show');
          });
        } 
                    
           
        jQuery(document).ready(function($) {

            $("#get-notifications").click(function(event) {
                var notf_list = $("#notifications__list");
                var preloader = notf_list.next('.preloader').clone().removeClass('d-none');
                notf_list.html(preloader);
                get_notifications();console.log(notf_list.children('.preloader'));
                delay(function(){
                
                },400); 
            });  

           // Jodit
            $('.textarea').each(function () { 
                var editor = new Jodit(this);
            });
        });
      </script>
    <?php endif ?>

    <!-- Datatables -->
    <?php if (isset($use_table) && $use_table): ?>
      <script src="<?php echo base_url(); ?>backend/modern/plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url(); ?>backend/modern/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
      <!-- page script -->
      <script>
        $(function () {
          $('#datatables_table').DataTable({  
              "scrollX": true,    
            "pageLength" : 10,
            "serverSide": true,
            "order": [[0, "asc" ]],
            "ajax":{
                  url :  '<?= site_url('ajax/datatables/'.$table_method); ?>',
                  type : 'POST'
              },
              rowId: 20
          }) 
        })
      </script>
    <?php endif ?>

    <?php if (isset($has_calendar)): ?>  
    <script>
      function date2string(date) {
        var d  = date.getDate(); 
        var m  = date.getMonth()+1;
        var y  = date.getFullYear();
        var H  = date.getHours();
        var mn = date.getMinutes();
        var s  = date.getSeconds();
        if(d<10) d  ='0'+d;
        if(m<10) m  ='0'+m;
        if(H<10) H  ='0'+H;
        if(mn<10)mn ='0'+mn;
        if(s<10) s  ='0'+s;
        return y+'-'+m+'-'+d+' '+H+':'+mn+':'+s;
      }
      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      var date = new Date()
      var d    = date.getDate(),
          m    = date.getMonth(),
          y    = date.getFullYear()

      var Calendar = FullCalendar.Calendar; 
      var calendarEl = document.getElementById('calendar');

      var calendar = new Calendar(calendarEl, {
        plugins: [ 'interaction', 'bootstrap', 'dayGrid', 'timeGrid' ],
        header  : {
          left  : 'prev,next today',
          center: 'title',
          right : 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        selectHelper: true,
        select: function(date_obj) {
          var start = date_obj.start;

          var ends = new Date(date_obj.end);
          var end = new Date(ends.getFullYear(), ends.getMonth(), ends.getDate()-1);

          console.log(typeof start);
          var dd = new Date(start);
          console.log(dd.getDate());
          console.log(date2string(start));console.log(date2string(end));
          $('#checkin_date').val(date2string(start));
          $('#checkout_date').val(date2string(end));
  //        window.location.href="/reservation/make/" + year + "/" + month + "/" + day;
          return;
          calendar.unselects();
        },
        //Random default events
        events : [  
          <?=$this->hms_parser->reservations()?>
        ]    
      });

      calendar.render();
    </script>
    <?php endif; ?>

    <!-- =========================================================== -->
    <?php if($page == "dashboard"): ?>

      <script>      

        var lineChartData = {
          labels: <?= json_encode($next_week_freq['dates']);?>,
          datasets: [ 
            {
              fillColor: "rgba(151,187,205,0.5)",
              strokeColor: "rgba(151,187,205,1)",
              pointColor: "rgba(151,187,205,1)",
              pointStrokeColor: "#fff",
              data: <?= json_encode($next_week_freq['freq_counts']);?>
            }
          ]

        }
        
        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);

        var barChartData = {
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [
            {
              fillColor: "rgba(220,220,220,0.5)",
              strokeColor: "rgba(220,220,220,1)",
              data: [65, 59, 90, 81, 56, 55, 40]
            },
            {
              fillColor: "rgba(151,187,205,0.5)",
              strokeColor: "rgba(151,187,205,1)",
              data: [28, 48, 40, 19, 96, 27, 100]
            }
          ]
        }    

      </script><!-- /Calendar -->
      <!-- Welcome Guide -->
      <?php if(SHOW_GUIDE): ?>
        <!-- <script src="<?= base_url('backend/js/guidely/guidely.min.js'); ?>"></script> -->

        <script>
          // $(function () {
            
          //   guidely.add ({
          //     attachTo: '#target-1', 
          //     anchor: 'top-left', 
          //     title: 'Today \'s Stats', 
          //     text: 'You can see how many services are registered today. We used stored procedure here.'
          //   });

          //   guidely.add ({
          //     attachTo: '#target-2', 
          //     anchor: 'top-left', 
          //     title: 'Next Week Reservations Chart', 
          //     text: 'You can see next week\'s hotel situation. It shows how many customers will be hosted next week.'
          //   });

          //   guidely.add ({
          //     attachTo: '#target-3', 
          //     anchor: 'top-left', 
          //     title: 'Top Customer', 
          //     text: 'Here, you can see the customer who spend most money to our hotel. We used MAX, SUM, GROUP BY functions on our database.'
          //   });
            
          //   guidely.add ({
          //     attachTo: '#target-4', 
          //     anchor: 'top-left', 
          //     title: 'Most Frequent Customers', 
          //     text: 'Here, you can see most visited customers. We used GROUP BY, ORDER functions here.'
          //   });
            
          //   guidely.init ({ welcome: true, startTrigger: true });
          // });
        </script>
      <?php endif; ?>
      <!--/Welcome Guide-->

    <?php endif; ?>
  </body>
</html>  
