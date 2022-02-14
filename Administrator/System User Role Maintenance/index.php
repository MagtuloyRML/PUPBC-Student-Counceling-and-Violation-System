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
                    $sub_page = 'role_admin';
                    include '../includes/main_sub_nav.php';

                ?>
                <h3 class="subtitle">User's Role</h3>

                <form id="addRole"  method = "POST">
                    <div class="input_group">
                        <div class="input_container">
                            <label for="#" class="label">Role Name: </label>
                            <div class="input " id="input_roleName">
                                <input class="input-field" type="text" placeholder="Insert Role Name" name="roleNameCheck" id="roleNameCheck">
                                <i class="fa-solid fa-asterisk"></i>
                                <i id="i_roleName" class="fa-solid "></i>
                            </div>
                        </div>
                        <div class="input_container">
                            <label for="studCouncheck" class="labelcheck">Student Counceling </label>
                            <select class="input_fieldselectAdd" name="studCouncheck" id="studCouncheck">
                                <option value = '' >Status</option>
                                    <?php 
                                    $statuscheck = mysqli_query($conn, "SELECT AccountStatusID, StatusDescription FROM `accountstatus`");
                                    while($row3 = mysqli_fetch_assoc($statuscheck)){
                                        $statsID = $row3['AccountStatusID']; $statsName = $row3['StatusDescription'];
                                        ?>
                                    <option value = "<?php echo $statsID ?>" > <?php echo $statsName?>  </option>
                                <?php }?>
                            </select>
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_studCouncheck" class="fa-solid "></i>
                        </div>
                        <div class="input_container">
                            <label for="studViolationcheck" class="labelcheck">Student Violation </label>
                            <select class="input_fieldselectAdd" name="studViolationcheck" id="studViolationcheck">
                                <option value = '' >Status</option>
                                    <?php 
                                    $statuscheck = mysqli_query($conn, "SELECT AccountStatusID, StatusDescription FROM `accountstatus`");
                                    while($row3 = mysqli_fetch_assoc($statuscheck)){
                                        $statsID = $row3['AccountStatusID']; $statsName = $row3['StatusDescription'];
                                        ?>
                                    <option value = "<?php echo $statsID ?>" > <?php echo $statsName?>  </option>
                                <?php }?>
                            </select>
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_studViolationcheck" class="fa-solid "></i>
                        </div>
                        <div class="input_container">
                            <label for="sysMainsCheck" class="labelcheck">System Maintenance </label>
                            <select class="input_fieldselectAdd" name="sysMainsCheck" id="sysMainsCheck">
                                <option value = '' >Status</option>
                                    <?php 
                                    $statuscheck = mysqli_query($conn, "SELECT AccountStatusID, StatusDescription FROM `accountstatus`");
                                    while($row3 = mysqli_fetch_assoc($statuscheck)){
                                        $statsID = $row3['AccountStatusID']; $statsName = $row3['StatusDescription'];
                                        ?>
                                    <option value = "<?php echo $statsID ?>" > <?php echo $statsName?>  </option>
                                <?php }?>
                            </select>
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_sysMainsCheck" class="fa-solid "></i>
                        </div>
                    </div> 

                    <div class="action_content">
                        <button class= "bttn" type="submit" name="submit" id="submitRole">
                        <i class="fa-solid fa-check-to-slot"></i>  Add Role</button>
                    </div>
                </form>

                <div class="list" id="tableRoles">
                    <form method ="POST" id="updateRoles">
                    <h3 class="list_title">Role List</h3>
                        <table class="display">
                            <tr> 
                                <th class="table_title" style="width: 50px;">ID</th>
                                <th class="table_title" >Role Name</th>
                                <th class="table_title" style="width: 15%;">Student Counceling</th>
                                <th class="table_title" style="width: 15%;">Student Violation</th>
                                <th class="table_title" style="width: 15%;">System Maintenance</th>
                                <th class="table_title" style="width: 15%;">Status</th>
                            </tr>
                            <?php
                                
                                $userRole = $conn->query("SELECT * FROM adminuserrole");
                                while($row = $userRole->fetch_assoc()){
                                    $id = $row['AdminUserRoleID']; $roleName = $row['AdminUserRole']; $studentCounc = $row['AdminPageStudentCounceling']; $studentViolation = $row['AdminPageViolation'];
                                    $sysMain = $row['AdminMaintenance']; $status = $row['StatusID'];
                            ?>
                            <tr>
                                <td class="data"><?php echo $id?></td>
                                <td class="data"><?php echo $roleName ?></td>
                                <td class="data">
                                    <select class="input_fieldselect" name="studentCounc" id="studentCounc">
                                        <option value = '' >Status</option>
                                        <?php 
                                            $statuscheck = mysqli_query($conn, "SELECT AccountStatusID, StatusDescription FROM `accountstatus`");
                                            while($row3 = mysqli_fetch_assoc($statuscheck)){
                                                $statsID = $row3['AccountStatusID']; $statsName = $row3['StatusDescription'];
                                                ?>
                                            <option value = "<?php echo $statsID ?>" <?php if($statsID == $studentCounc )echo "selected" ?>> <?php echo $statsName?>  </option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td class="data">
                                    <select class="input_fieldselect" name="studentViolation" id="studentViolation">
                                        <option value = '' >Status</option>
                                        <?php 
                                            $statuscheck = mysqli_query($conn, "SELECT AccountStatusID, StatusDescription FROM `accountstatus`");
                                            while($row3 = mysqli_fetch_assoc($statuscheck)){
                                                $statsID = $row3['AccountStatusID']; $statsName = $row3['StatusDescription'];
                                                ?>
                                            <option value = "<?php echo $statsID ?>" <?php if($statsID == $studentViolation )echo "selected" ?>> <?php echo $statsName?>  </option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td class="data">
                                    <select class="input_fieldselect" name="sysMain" id="sysMain">
                                        <option value = '' >Status</option>
                                        <?php 
                                            $statuscheck = mysqli_query($conn, "SELECT AccountStatusID, StatusDescription FROM `accountstatus`");
                                            while($row3 = mysqli_fetch_assoc($statuscheck)){
                                                $statsID = $row3['AccountStatusID']; $statsName = $row3['StatusDescription'];
                                                ?>
                                            <option value = "<?php echo $statsID ?>" <?php if($statsID == $sysMain )echo "selected" ?>> <?php echo $statsName?>  </option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td class="data">
                                    <select class="input_fieldselect" name="status" id="status">
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

                        <div class="table_content">
                            <button class= "bttn" type="submit" name="submit" id="submit">
                            <i class="fa-solid fa-floppy-disk"></i> Save Status</button>
                        </div>
                    </form>
                </div>
                
                
            </div>

        </div>
    </div>

    <script src="assets/js/main.js"></script>

</body>
</html>