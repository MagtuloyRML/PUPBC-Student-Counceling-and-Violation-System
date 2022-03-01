<?php
    $title = 'Counseling Approval Schedule';
    $page = 'ca_appoint_sched_approve';
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
        echo "<script> window.location.href = '../Page 404/';</script>";
    }


?>
    <div class="body_container">
        <div class="content">
            <div class="approv_content">
                <div class="title">
                <?php if (isset($_GET['error'])) { ?>
                                    <p class="error"><?php echo $_GET['error']; ?></p>
                                <?php } ?>

                                <?php if (isset($_GET['success'])) { ?>
                                    <p class="success"><?php echo $_GET['success']; ?></p>
                                <?php } ?>
                    <h1>Appointment</h1>
                    <hr>
                </div>
                <div class="subcontent">
                    <?php
                        $sub_page = 'approval_app';
                        include '../includes/appoitment_sub_nav.php';
                    ?>
                    
                    <div class="list_approv">
                        <form method ="POST">
                    <h3 class="list_title">List</h3>
                    <table class="display_approv">
                        <tr> 
                        
                            <th class="approv_title" style="width: 13%;">Appointment ID
                            <input type="hidden" name="id" id="id" value="<?= $name ?>">
                            </th>
                            <th class="approv_title" style="width: auto;">Email</th>
                            <th class="approv_title">Ailment</th>
                            <th class="approv_title">Appointment Date</th>
                            <th class="approv_title" style="width: 10%;">Status</th>
                            <th class="approv_title" style="width: 10%;">Actions</th>
                        </tr>
                        <?php
                        include '../../assets/connection/DBconnection.php';
                        $sched = $conn->query("SELECT * FROM `schedules`
                        WHERE stat = 'Pending' AND remarks ='$name'");
                            while($row = $sched->fetch_array()){
                        ?>
                        <tr>
                            <td class="approv_data"><?php echo $row['id']?>
                            </td>
                            <td class="approv_data"><?php echo $row['email_add']?></td>
                            <td class="approv_data"><?php echo $row['reason']?></td>
                            <td class="approv_data"><?php 
                                $start_date = date("d/m/Y h:i A", strtotime($row['start_app']));
                                
                                $end_time = date("h:i A", strtotime($row['end_app']));
                                
                                $final = $start_date. ' - '. $end_time;
                                echo $final;
                                
                                ?></td>
                            <td class="approv_data"><?php echo $row['stat'] ?></td>
                            <td class="approv_data"><a href="confirm_sched_work.php?a_id=<?php echo $row['id']; ?>&id=<?= $name ?>&client_id=<?= $row['client_id'] ?>"><i class="fas fa-thumbs-up"></i></a>
                            <a href="../Counceling Apointment Cancel/index.php?a_id=<?php echo $row['id']; ?>&id=<?= $name ?>&client_id=<?= $row['client_id'] ?>"><i class="fas fa-times-circle"></i></a></td>
                        </tr>
                        <?php
                                        }
                    ?>
                    
                    </table>
                    </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/main.js"></script>

</body>

</html>