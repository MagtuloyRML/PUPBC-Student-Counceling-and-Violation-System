<?php
    $title = 'Counseling Apointment Dashboard';
    $page = 'ca_home';
    include_once('../includes/header.php');

    $id = $_SESSION['AdminID'];
    $sql_fetch = mysqli_query($conn, "SELECT * from adminaccountinfo WHERE AdminAccountID = '$id'");
    $name = "";
    while($row = mysqli_fetch_assoc($sql_fetch))
    {
        $name = $row['AdminAccountID'];
    }

    $sql_fetchid = mysqli_query($conn, 
    "SELECT adminAccount.AdminFirstName, adminAccount.AdminUserRoleID, userRole.AdminPageStudentCounceling, 
    userRole.AdminPageViolation, userRole.AdminMaintenance, userRole.StatusID
    FROM adminaccountinfo AS adminAccount 
    INNER JOIN adminuserrole AS userRole 
    ON adminAccount.AdminUserRoleID = userRole.AdminUserRoleID WHERE adminAccount.AdminAccountID = '$id' ");
    
    while($row = mysqli_fetch_assoc($sql_fetchid))
    {
        $userRoleID = $row['AdminUserRoleID']; 
        $studCounceling = $row['AdminPageStudentCounceling']; $studViol = $row['AdminPageViolation']; 
        $systemMaintenance = $row['AdminMaintenance']; $roleStatus = $row['StatusID']; 
    }
    if ($studCounceling != '1'){
        header('Location: ../Violation Dashboard/');
    }
?> 
<?php 

$conn = new mysqli('localhost', 'root','','test_db');
if ($conn->connect_error){
    die(
       'Error : ('. $conn->connect_errno.') '.$conn->connect_error
    );
}

//weekly dates
date_default_timezone_set("Asia/Manila");
$monday = date('Y-m-d',strtotime('monday this week'));
$tuesday = date('Y-m-d',strtotime('tuesday this week'));
$wednesday = date('Y-m-d',strtotime('wednesday this week'));
$thursday = date('Y-m-d',strtotime('thursday this week'));
$friday = date('Y-m-d',strtotime('friday this week'));
$saturday = date('Y-m-d',strtotime('saturday this week'));
$sunday = date('Y-m-d',strtotime('sunday this week'));


//week 2
$wdate = date('Y-m-d',strtotime('monday this week'));
$wdate_to = $wdate;
$wdate_to = strtotime("+6 days", strtotime($wdate_to)); //-7 days for last week. -30 for last week
$wdate_to = date("Y-m-d", $wdate_to);

//monthly date
$mdate = date('Y-m-d',strtotime('first day of this month'));
$mdate_to = $mdate;
$mdate_to = strtotime("+30 days", strtotime($mdate_to)); //+30 days for 1 whole Month
$mdate_to = date("Y-m-d", $mdate_to);

//yearly date
$ydate = date('Y-m-d',strtotime('first day of this year'));
$ydate_to = $ydate;
$ydate_to = strtotime("+364 days", strtotime($ydate_to)); //+364 days for 1 whole year
$ydate_to = date("Y-m-d", $ydate_to);



//monday
$mon_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$monday'");
$row_mon = mysqli_fetch_array($mon_get);

$total_Mon = $row_mon[0];



//tuesday
$tue_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$tuesday'");
$row_tue = mysqli_fetch_array($tue_get);

$total_tue = $row_tue[0];


//wednesday
$wed_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$wednesday'");
$row_wed = mysqli_fetch_array($wed_get);

$total_wed = $row_wed[0];


//thursday
$thur_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$thursday'");
$row_thur = mysqli_fetch_array($thur_get);

$total_thur = $row_thur[0];


//friday
$fri_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$friday'");
$row_fri = mysqli_fetch_array($fri_get);

$total_fri = $row_fri[0];



//saturday
$sat_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$saturday'");
$row_sat = mysqli_fetch_array($sat_get);

$total_sat = $row_sat[0];



//sunday
$sun_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$sunday'");
$row_sun = mysqli_fetch_array($sun_get);

$total_sun = $row_sun[0];

//For confirmed appointments
$confirmed = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Confirmed' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
$row_confirmed = mysqli_fetch_array($confirmed);

$total_confirmed = $row_confirmed[0];

//For Evaluated Appointments
$evaluated = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
$row_eval = mysqli_fetch_array($evaluated);

$total_evaluated = $row_eval[0];

//For to be evaluated appointments
$done = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
$row_done = mysqli_fetch_array($done);

$total_done = $row_done[0];

//For Pending Appointments
$pending = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Pending' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
$row_pending = mysqli_fetch_array($pending);

$total_pending = $row_pending[0];

//For Cancelled appointments
$cancelled = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Cancelled' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
$row_cancelled = mysqli_fetch_array($cancelled);

$total_cancelled = $row_cancelled[0];


//For Known Clients
$known = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'No' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
$row_known = mysqli_fetch_array($known);

$total_known = $row_known[0];

//For Anonymous Clients
$anonymous = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'Yes' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
$row_anonymous = mysqli_fetch_array($anonymous);

$total_anonymous = $row_anonymous[0];

// IF NAGPRESS NG SUBMIT SI USER
if(isset($_POST['submit'])){
    $range = $_POST['range'];
    
    //kung weekly pa rin ang nakaselect
    if($range == 'weekly'){
        //monday
        $mon_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$monday'");
        $row_mon = mysqli_fetch_array($mon_get);

        $total_Mon = $row_mon[0];



        //tuesday
        $tue_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$tuesday'");
        $row_tue = mysqli_fetch_array($tue_get);

        $total_tue = $row_tue[0];


        //wednesday
        $wed_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$wednesday'");
        $row_wed = mysqli_fetch_array($wed_get);

        $total_wed = $row_wed[0];


        //thursday
        $thur_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$thursday'");
        $row_thur = mysqli_fetch_array($thur_get);

        $total_thur = $row_thur[0];


        //friday
        $fri_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$friday'");
        $row_fri = mysqli_fetch_array($fri_get);

        $total_fri = $row_fri[0];



        //saturday
        $sat_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$saturday'");
        $row_sat = mysqli_fetch_array($sat_get);

        $total_sat = $row_sat[0];



        //sunday
        $sun_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$sunday'");
        $row_sun = mysqli_fetch_array($sun_get);

        $total_sun = $row_sun[0];

        //For confirmed appointments
        $confirmed = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Confirmed' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_confirmed = mysqli_fetch_array($confirmed);

        $total_confirmed = $row_confirmed[0];

        //For Evaluated Appointments
        $evaluated = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_eval = mysqli_fetch_array($evaluated);

        $total_evaluated = $row_eval[0];

        //For to be evaluated appointments
        $done = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_done = mysqli_fetch_array($done);

        $total_done = $row_done[0];

        //For Pending Appointments
        $pending = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Pending' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_pending = mysqli_fetch_array($pending);

        $total_pending = $row_pending[0];

        //For Cancelled appointments
        $cancelled = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Cancelled' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_cancelled = mysqli_fetch_array($cancelled);

        $total_cancelled = $row_cancelled[0];

        //For confirmed appointments
        $confirmed = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Confirmed' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_confirmed = mysqli_fetch_array($confirmed);

        $total_confirmed = $row_confirmed[0];

        //For Evaluated Appointments
        $evaluated = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_eval = mysqli_fetch_array($evaluated);

        $total_evaluated = $row_eval[0];

        //For to be evaluated appointments
        $done = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_done = mysqli_fetch_array($done);

        $total_done = $row_done[0];

        //For Pending Appointments
        $pending = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Pending' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_pending = mysqli_fetch_array($pending);

        $total_pending = $row_pending[0];

        //For Cancelled appointments
        $cancelled = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Cancelled' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_cancelled = mysqli_fetch_array($cancelled);

        $total_cancelled = $row_cancelled[0];

        //For Known Clients
        $known = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'No' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_known = mysqli_fetch_array($known);

        $total_known = $row_known[0];

        //For Anonymous Clients
        $anonymous = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'Yes' AND app_date BETWEEN '$wdate' AND '$wdate_to'");
        $row_anonymous = mysqli_fetch_array($anonymous);

        $total_anonymous = $row_anonymous[0];
    }

    //kung monthly ang nakaselect
    elseif($range == 'monthly'){
        //monday
        $mon_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$monday'");
        $row_mon = mysqli_fetch_array($mon_get);

        $total_Mon = $row_mon[0];



        //tuesday
        $tue_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$tuesday'");
        $row_tue = mysqli_fetch_array($tue_get);

        $total_tue = $row_tue[0];


        //wednesday
        $wed_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$wednesday'");
        $row_wed = mysqli_fetch_array($wed_get);

        $total_wed = $row_wed[0];


        //thursday
        $thur_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$thursday'");
        $row_thur = mysqli_fetch_array($thur_get);

        $total_thur = $row_thur[0];


        //friday
        $fri_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$friday'");
        $row_fri = mysqli_fetch_array($fri_get);

        $total_fri = $row_fri[0];



        //saturday
        $sat_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$saturday'");
        $row_sat = mysqli_fetch_array($sat_get);

        $total_sat = $row_sat[0];



        //sunday
        $sun_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$sunday'");
        $row_sun = mysqli_fetch_array($sun_get);

        $total_sun = $row_sun[0];

        //For confirmed appointments
        $confirmed = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Confirmed' AND app_date BETWEEN '$mdate' AND '$mdate_to'");
        $row_confirmed = mysqli_fetch_array($confirmed);

        $total_confirmed = $row_confirmed[0];

        //For Evaluated Appointments
        $evaluated = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$mdate' AND '$mdate_to'");
        $row_eval = mysqli_fetch_array($evaluated);

        $total_evaluated = $row_eval[0];

        //For to be evaluated appointments
        $done = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '$mdate' AND '$mdate_to'");
        $row_done = mysqli_fetch_array($done);

        $total_done = $row_done[0];

        //For Pending Appointments
        $pending = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Pending' AND app_date BETWEEN '$mdate' AND '$mdate_to'");
        $row_pending = mysqli_fetch_array($pending);

        $total_pending = $row_pending[0];

        //For Cancelled appointments
        $cancelled = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Cancelled' AND app_date BETWEEN '$mdate' AND '$mdate_to'");
        $row_cancelled = mysqli_fetch_array($cancelled);

        $total_cancelled = $row_cancelled[0];


        //For Known Clients
        $known = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'No' AND app_date BETWEEN '$mdate' AND '$mdate_to'");
        $row_known = mysqli_fetch_array($known);

        $total_known = $row_known[0];

        //For Anonymous Clients
        $anonymous = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'Yes' AND app_date BETWEEN '$mdate' AND '$mdate_to'");
        $row_anonymous = mysqli_fetch_array($anonymous);

        $total_anonymous = $row_anonymous[0];

    }

    //Kung yearly naman ang nakaselect
    elseif($range == 'yearly'){
        //monday
        $mon_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$monday'");
        $row_mon = mysqli_fetch_array($mon_get);

        $total_Mon = $row_mon[0];



        //tuesday
        $tue_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$tuesday'");
        $row_tue = mysqli_fetch_array($tue_get);

        $total_tue = $row_tue[0];


        //wednesday
        $wed_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$wednesday'");
        $row_wed = mysqli_fetch_array($wed_get);

        $total_wed = $row_wed[0];


        //thursday
        $thur_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$thursday'");
        $row_thur = mysqli_fetch_array($thur_get);

        $total_thur = $row_thur[0];


        //friday
        $fri_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$friday'");
        $row_fri = mysqli_fetch_array($fri_get);

        $total_fri = $row_fri[0];



        //saturday
        $sat_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$saturday'");
        $row_sat = mysqli_fetch_array($sat_get);

        $total_sat = $row_sat[0];



        //sunday
        $sun_get= $conn->query("SELECT COUNT(*) FROM `schedules` WHERE remarks = '$name' AND `app_date` = '$sunday'");
        $row_sun = mysqli_fetch_array($sun_get);

        $total_sun = $row_sun[0];

        //For confirmed appointments
        $confirmed = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Confirmed' AND app_date BETWEEN '2022-01-01' AND '2022-12-31'");
        $row_confirmed = mysqli_fetch_array($confirmed);

        $total_confirmed = $row_confirmed[0];

        //For Evaluated Appointments
        $evaluated = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '2022-01-01' AND '2022-12-31'");
        $row_eval = mysqli_fetch_array($evaluated);

        $total_evaluated = $row_eval[0];

        //For to be evaluated appointments
        $done = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Evaluated' AND app_date BETWEEN '2022-01-01' AND '2022-12-31'");
        $row_done = mysqli_fetch_array($done);

        $total_done = $row_done[0];

        //For Pending Appointments
        $pending = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Pending' AND app_date BETWEEN '2022-01-01' AND '2022-12-31'");
        $row_pending = mysqli_fetch_array($pending);

        $total_pending = $row_pending[0];

        //For Cancelled appointments
        $cancelled = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND stat = 'Cancelled' AND app_date BETWEEN '2022-01-01' AND '2022-12-31'");
        $row_cancelled = mysqli_fetch_array($cancelled);

        $total_cancelled = $row_cancelled[0];


        //For Known Clients
        $known = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'No' AND app_date BETWEEN '2022-01-01' AND '2022-12-31'");
        $row_known = mysqli_fetch_array($known);

        $total_known = $row_known[0];

        //For Anonymous Clients
        $anonymous = $conn->query("SELECT COUNT(*) FROM schedules WHERE remarks = '$name' AND anonymity = 'Yes' AND app_date BETWEEN '2022-01-01' AND '2022-12-31'");
        $row_anonymous = mysqli_fetch_array($anonymous);

        $total_anonymous = $row_anonymous[0];

    }


}

    $sched = $conn->query("SELECT 
    `id`,
    `ClientFirstName` as firstName,
    `ClientMiddleName` as middleName,
    `ClientLastName` as lastName,
    `ClientStudentNo` as studNum,
    `ClientAddress` as c_address,
    `ClientContactNo` as c_contact_num,
    `ClientGuardian` as guardian_name,
    `ClientGuardianNo` as guardian_num,
    `end_app`,
    `app_date`,
    `start_app`,
    `stat`,
    `anonymity`,
    `AdminFirstName` as a_firstName,
    `AdminLastName` as a_lastName
    FROM schedules
    INNER JOIN clientaccountinfo ON schedules.client_id = clientaccountinfo.ClientAccountID
    INNER JOIN adminaccountinfo ON schedules.remarks = adminaccountinfo.AdminAccountID 
    WHERE `stat` = 'Done' AND `remarks` = '$name' ORDER BY start_app DESC LIMIT 6");
?>
    <div class="body_container">
        <div class="content">
            <div class="approv_content">

                <div class="title">
                    <h1>Counseling Dashboard</h1>
                    <hr>
                </div>
                <div class="dash_content time_date">
                    <div class="datetime">
                        <div class="date">
                            <span id="dayname">Day</span>,
                            <span id="month">Month</span>
                            <span id="daynum">00</span>,
                            <span id="year">Year</span>
                        </div>
                        <div class="time">
                            <span id="hour">00</span>:
                            <span id="minutes">00</span>:
                            <span id="seconds">00</span>
                            <span id="period">AM</span>
                        </div>
                    </div>
                </div>
                
                <div class="charts_container">
                    
                    <div class="chart_content ">

                        <div class="student_select">
                            <form method="POST">
                                <label for="#" class="label">Range: </label>
                                <select class="range_selection" name = "range" id="range">
                                    <option value="weekly" selected>Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option> 
                                </select>
                                <button type="submit" name="submit" value=">>" class="srch_bttn"><i class="fas fa-search"></i></button><br>
                                <p class="reminder"><i>This will apply to Bar and Pie chart only</i></p>
                            </form>
                        </div>
                        
                        <p class="chart_label">Transaction's Count</p>
                        <div class="canvas_holder ">
                            <canvas class="graph" id="Bar"></canvas>
                        </div>
                    </div>

                    <div class="chart_content donut">

                        <!-- FOR UPCOMING APPOINTMENTS, NEED DESIGN-->
                        <?php 
                        //$upcoming = $conn->query("SELECT * FROM schedules WHERE remarks = '$name' AND start_app > NOW() AND stat = 'Confirmed' ORDER BY start_app ASC");
                        //$row_upcoming = mysqli_fetch_array($upcoming);

                        //for the day
                        //$day = date("l", strtotime($row_upcoming['start_app']));

                        //for the month
                        //$month = date("F", strtotime($row_upcoming['start_app']));

                        //for the date num
                        //$dateNum = date("j", strtotime($row_upcoming['start_app']));
                        
                        //for the year
                        //$year = date("Y", strtotime($row_upcoming['start_app']));

                        //for the hour
                        //$hour = date("g", strtotime($row_upcoming['start_app']));

                        //for the minute
                        //$minute = date("i", strtotime($row_upcoming['start_app']));
                        ?>

                        <p class="chart_label">Anonymity Count</p>
                        <div class="canvas_holder ">
                            <canvas class="graph" id="doughnutGraph"></canvas>
                        </div>
                    </div>
                    <p class="reminder"><i>Note: The data will reset weekly, the Line Graph are only showing weekly reports</i></p>

                    <div class="chart_content">
                        <p class="chart_label">Rate of Appointment</p>
                        <div class="canvas_holder">
                            <canvas class="graph" id="lineGraph"></canvas>
                        </div>
                    </div>
                </div>

                <div class="list_client">
                    <h3 class="list_title">Previous Clients</h3>
                    <table class="display_client">
                        <tr> 
                            <th class="client_title" style="width: 12%;">Appointment ID</th>
                            <th class="client_title" style="width: 12%;">Date of Appointment</th>
                            <th class="client_title" style="width: 8%;"></th>
                        </tr>
                        <?php while($row = $sched->fetch_array()){
                            $c_nameFormat = $row['lastName'].', '.$row['firstName'].' '.$row['middleName'];
                            $studNum = $row['studNum'];
                            $address = $row['c_address'];
                            $contactNum = $row['c_contact_num'];
                            $guardianName = $row['guardian_name'];
                            $guardianNum = $row['guardian_num'];
                            $app_date = $row['app_date'];
                            $start_app = $row['start_app'];
                            $nstart_app = date("g:i a", strtotime($start_app));
                            $end_app = $row['end_app'];
                            $nend_app = date("g:i a", strtotime($end_app));
                            $status = $row['stat'];
                            $a_nameFormat = $row['a_lastName'].', '.$row['a_firstName'];
                            $id = $row['id'];
                            
                            ?>
                        <tr>
                            <td class="client_data"><?= $id ?></td>
                            <td class="client_data"><?= $app_date.' '.$nstart_app.' - '.$nend_app  ?></td>
                            <td class="client_data"><a href="../Counceling Client Evaulation Form/?a_id=<?php echo $row['id']; ?>" class="bttn_table"><i class="fas fa-thumbs-up"></i>Evaluate</a></td>
                        </tr>
                        <?php } ?>
                    </table>
                    <a class="down_bttn_table" href="../Counceling Client Page/">See More</a>
                </div>

                
                

            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
    <script>
        const ctxdonut = document.getElementById('doughnutGraph').getContext('2d');
        const doughnutGraph = new Chart(ctxdonut, {
            type: 'doughnut',
            data: {
                labels: ['Known Clients', 'Anonymous Clients'],
                datasets: [{
                    label: '# of Appointments',
                    data: [<?= $total_known ?>, <?= $total_anonymous?>],
                    backgroundColor: [
                        'rgb(136, 136, 136)',
                        '#810000'
                    ],
                    borderColor: [
                        'rgb(136, 136, 136)',
                        '#810000'
                    ],
                    borderWidth: 1
                   
                }]
            },
            
        });

        const ctxline = document.getElementById('lineGraph').getContext('2d');
        const lineGraph = new Chart(ctxline, {
            type: 'line',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Rate of appointments daily',
                    data: [<?= $total_Mon ?>, <?= $total_tue ?>, <?= $total_wed ?>, <?= $total_thur ?>, <?= $total_fri ?>, <?= $total_sat ?>, <?= $total_sun ?> ],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ]
                   
                }]
            },
            
        });

        const ctx = document.getElementById('Bar').getContext('2d');
        const Bar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Cancelled', 'Evaluated', 'Pending', 'Confirmed', 'To Be Evaluated'],
                datasets: [{
                    label: '# of Votes',
                    data: [<?= $total_cancelled?>, <?= $total_evaluated?>, <?= $total_pending?>, <?= $total_confirmed?>, <?= $total_done?>],
                    backgroundColor: [
                        'rgb(220,20,60)',
                        'rgb(178,34,34)',
                        'rgb(165,42,42)',
                        'rgb(139,0,0)',
                        'rgb(128,0,0)'
                    ],
                    borderColor: [
                        'rgb(220,20,60)',
                        'rgb(178,34,34)',
                        'rgb(165,42,42)',
                        'rgb(139,0,0)',
                        'rgb(128,0,0)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        
    </script>
    
</body>

</html>