<?php
    $title = 'User Maintenance';
    $page = 'maintenance';
    include_once('../includes/header.php');

    $result1 = mysqli_query($conn, "SELECT * from genderrole");
    $options = "";
    while($row2 = mysqli_fetch_array($result1))
    {
        $options = $options."<option value='$row2[0]'>$row2[1]</option>";
    }

    $result2 = mysqli_query($conn, "SELECT AdminUserRoleID, AdminUserRole from adminuserrole");
    $role = "";
    while($row3 = mysqli_fetch_array($result2))
    {
        $role = $role."<option value='$row3[0]'>$row3[1]</option>";
    }
?>
    <div class="body_container">
        <div class="content">
            <div class="title">
                <h1>System Maintenance</h1>
                <hr>
            </div>
            <div class="subcontent">
                <?php
                    $sub_page = 'main_admin';
                    include '../includes/main_sub_nav.php';

                    $sub_content = 'admin_userPage';
                    include '../includes/sub_content_navadd.php';
                ?>
                <h3 class="subtitle">Users</h3>

                <div class="list">
                    <form method ="POST">
                    <h3 class="list_title">List</h3>
                        <table class="display">
                            <tr> 
                                <th class="table_title" style="width: 50px;">ID</th>
                                <th class="table_title" >Name</th>
                                <th class="table_title" style="width: 25%;">Role</th>
                                <th class="table_title" style="width: 25%;">Status</th>
                            </tr>
                            <?php
                                
                                $acc = $conn->query("SELECT AdminAccountID, AdminFirstName, AdminMiddleName, AdminLastName, AdminSufifx,
                                AdminUserRoleID, AccountStatusID FROM `adminaccountinfo`");
                                while($row = $acc->fetch_assoc()){
                                    $id = $row['AdminAccountID']; $fname = $row['AdminFirstName']; $mname = $row['AdminMiddleName']; $lname = $row['AdminLastName'];
                                    $sname = $row['AdminSufifx']; $role = $row['AdminUserRoleID']; $status = $row['AccountStatusID'];
                                
                            ?>
                            <tr>
                                <td class="data"><?php echo $id?></td>
                                <td class="data"><?php echo $lname.', '.$fname.' '.$mname.' '.$sname ?></td>
                                <td class="data">
                                    <select class="input_fieldselect" name="gender" id="gender">
                                        <option value = '' >Role User</option>
                                        <?php 
                                            $userRole = mysqli_query($conn, "SELECT AdminUserRoleID, AdminUserRole FROM `adminuserrole`");
                                            while($row2 = mysqli_fetch_assoc($userRole)){
                                                $roleID = $row2['AdminUserRoleID']; $roleName = $row2['AdminUserRole'];
                                                ?>
                                            <option value = "<?php echo $roleID ?>" <?php if($roleID == $role )echo "selected" ?>> <?php echo $roleName?>  </option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td class="data">
                                    <select class="input_fieldselect" name="gender" id="gender">
                                        <option value = '' >Status</option>
                                        <?php 
                                            $statuscheck = mysqli_query($conn, "SELECT AccountStatusID, StatusDescription FROM `accountstatus`");
                                            while($row3 = mysqli_fetch_assoc($statuscheck)){
                                                $statsID = $row3['AccountStatusID']; $statsName = $row3['StatusDescription'];
                                                ?>
                                            <option value = "<?php echo $statsID ?>" <?php if($statsID == $status )echo "selected" ?>> <?php echo $statsName?>  </option>
                                        <?php }?>
                                    </select>
                                </td>
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

    <script src="assets/js/main.js"></script>

</body>
</html>