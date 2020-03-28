
      </div>
      <!-- /.content-wrapper (Opened at view/classic/header.php)-->

      <!-- Main Footer -->
      <footer class="main-footer text-sm">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          <span class="mx-5"> 
            <a href="<?= site_url($this->uri->uri_string().'?set_theme='.($this->h_theme == 'classic' ? 'modern' : 'classic'))?>" class="text-danger">
              <i class="fas fa-lg fa-tint"></i>
            </a> 
            <span class="text-info">Theme: <?=ucwords($this->h_theme)?></span> 
          </span>

          Hoolicon Tech HMS 1.0.0
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; <?= date('Y'); ?> <a href="https://adminlte.io"><?= HOTEL_NAME; ?></a>.</strong> All rights reserved.
      </footer>

    </div>
    <!-- ./wrapper (Opened at view/classic/header.php) -->

    <!-- REQUIRED SCRIPTS -->
    <!-- Placed at the end of the document so the pages load faster --> 
    <!-- =============================================== -->
    <!-- jQuery -->
    <script src="<?= base_url('backend/modern/plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('backend/modern/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('backend/modern/dist/js/adminlte.min.js'); ?>"></script>

    <!-- Tooltips and toggle Initialization -->
    <script type="text/javascript"> 
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });
       
      $(function () {
        $('[data-toggle="popover"]').popover()
      })
    </script>

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
    <script language="javascript" type="text/javascript" src="<?= base_url('backend/js/full-calendar/fullcalendar.min.js'); ?>"></script>
    <script src="<?= base_url('backend/js/base.js'); ?>"></script> 

    <script src="<?= base_url('backend/js/hhms.js'); ?>"></script>
    
    <?php if (isset($has_calendar)): ?>  
    <script>
      function date2string(date) {
        var d = date.getDate(); 
        var m = date.getMonth()+1;
        var y = date.getFullYear();
        if(d<10)d='0'+d;
        if(m<10)m='0'+m;
        return y+'-'+m+'-'+d;
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
          /*{
              fillColor: "rgba(220,220,220,0.5)",
              strokeColor: "rgba(220,220,220,1)",
              pointColor: "rgba(220,220,220,1)",
              pointStrokeColor: "#fff",
              data: [65, 59, 90, 81, 56, 55, 40]
          },*/
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
        <script src="<?= base_url('backend/js/guidely/guidely.min.js'); ?>"></script>

        <script>
          $(function () {
            
            guidely.add ({
              attachTo: '#target-1', 
              anchor: 'top-left', 
              title: 'Today \'s Stats', 
              text: 'You can see how many services are registered today. We used stored procedure here.'
            });
            
            guidely.add ({
              attachTo: '#target-2', 
              anchor: 'top-left', 
              title: 'Next Week Reservations Chart', 
              text: 'You can see next week\'s hotel situation. It shows how many customers will be hosted next week.'
            });

            guidely.add ({
              attachTo: '#target-3', 
              anchor: 'top-left', 
              title: 'Top Customer', 
              text: 'Here, you can see the customer who spend most money to our hotel. We used MAX, SUM, GROUP BY functions on our database.'
            });
            
            
            guidely.add ({
              attachTo: '#target-4', 
              anchor: 'top-left', 
              title: 'Most Frequent Customers', 
              text: 'Here, you can see most visited customers. We used GROUP BY, ORDER functions here.'
            });
            
            guidely.init ({ welcome: true, startTrigger: true });
          });
        </script>
      <?php endif; ?>
        <!--/Welcome Guide-->

    <?php endif; ?>

    <style type="text/css">
      .calendar {
        -webkit-user-select: none; -moz-user-select: none;
      }
    </style>

    <script type="text/javascript">
      function open_form()
      {
        console.log("Opening Form...");
        $('#form').slideToggle();
      }

    </script>
  </body>
</html>  
