<?php
    $title = 'Maintenance';
    $page = 'v_maintenance';
    include_once('../includes/header.php');
?>

<?php
    $sub_page = 'vmain_stud_main';
    include('../includes/sub_nav.php');
?>

<?php 
    include 'assets/dbconnection.php';
    $enrolled = 'Enrolled';
    $disabled = 'Disabled';
    $sched = $conn->query("SELECT 
    `id`,
    `studNum`,
    `lastName`,
    `firstName`,
    `middleName`,
    `Section`,
    `Address`,
    `Gender`,
    t2.pCode AS p_description,
    t3.code AS a_code,
    status FROM forstudents t1
    INNER JOIN forprogram t2 ON t1.progCode = t2.pCode
    INNER JOIN foracademicyear t3 ON t1.ayCode = t3.code WHERE `status` = '$enrolled' OR `status` = '$disabled'");
    
    
    if (isset($_POST['but_update'])){
        if(isset($_POST['update'])){
            foreach ($_POST['update'] as $updateid){
                
                $name = $_POST['status_'.$updateid];
                
                

                if($name !=''){

                    $updateUser = "UPDATE forstudents SET status = '$enrolled'
                    WHERE id =$updateid";
                    mysqli_query($conn, $updateUser);
                    $sched = $conn->query("SELECT * from forstudents WHERE `status` = '$enrolled' OR `status` = '$disabled'");
                }

            }
            
        }
    }

    if (isset($_POST['but_disable'])){
        if(isset($_POST['update'])){
            foreach ($_POST['update'] as $updateid){
                
                $name = $_POST['status_'.$updateid];
                $selected = 'Disabled';

                if($name !=''){

                    $updateUser = "UPDATE forstudents SET status = '$selected'
                    WHERE id =$updateid";
                    mysqli_query($conn, $updateUser);
                    $sched = $conn->query("SELECT * from forstudents WHERE `status` = '$enrolled' OR `status` = '$disabled'");
                }

            }
            
        }
    }

    if (isset($_POST['but_delete'])){
        $disable = 'Disabled';
        $deleted = 'Deleted';
        $deleteUsers = "UPDATE forstudents SET `status` = '$deleted' WHERE `status` ='$disable'";
        mysqli_query($conn, $deleteUsers);
        $sched = $conn->query("SELECT * from forstudents WHERE `status` = '$enrolled' OR `status` = '$disabled'");
                
           
    }
        

    if(isset($_POST['submit'])){
        $searched = $_POST['curri'];
        $searched2 = $_POST['section'];

        $sched = $conn->query("SELECT `id`,
        `studNum`,
        `lastName`,
        `firstName`,
        `middleName`,
        `Section`,
        `Address`,
        `Gender`,
        t2.pCode AS p_description,
        t3.code AS a_code,
        status FROM forstudents t1
        INNER JOIN forprogram t2 ON t1.progCode = t2.pCode
        INNER JOIN foracademicyear t3 ON t1.ayCode = t3.code

        WHERE ayCode ='{$searched2}'
        AND pCode ='{$searched}'");
        
            
    }
?>

            <div class="subcontent">
                <div class="sub_nav">
                    <a href="../Violation Maintenance Student Maintenance/" class="sub_nav_bttn">
                        Update Student
                    </a>
                    <a href="../Violation Maintenance Student Maintenance Section Year/" class="sub_nav_bttn">
                        Update Section/Year
                    </a>
                    <a href="../Violation Maintenance Student Maintenance Status/" class="sub_nav_bttn_active">
                        Update Status
                    </a>
                </div>


                <div class="sub_top_content">
                    <div class="student_input_group">

                    <form action = "" method = "POST">
                        <div class="student_select">
                            <label for="#" class="label">Year and Section: </label>
                            <select class="curri_selection" name = "section" id="section">
                            
                            <option disabled value="" selected ="selected">Year and Section</option>
                                <?php 
                                
                                $query1 = "SELECT * from foracademicyear";
                                $result2 = mysqli_query($conn, $query1);
                                while($row1 = mysqli_fetch_assoc($result2))
                                {?>
                                <option value="<?php echo $row1["code"];?>">
                                <?php 
                                $output = $row1['yearFrom'] ." - ". $row1['yearTo'].",". $row1['Semester'] ."Semester";
                                echo $output; ?>
                                </option>
                                <?php } ?>
                                
                            </select>
                        </div>
                        
                        <div class="student_select">
                            <label for="#" class="label">Curriculum: </label>
                            <select class="curri_selection" name = "curri" id="curri">
                            
                            <option disabled value="" selected ="selected">Curriculum</option>
                                <?php 
                                
                                $query = "SELECT * from forprogram";
                                $result1 = mysqli_query($conn, $query);
                                while($row2 = mysqli_fetch_assoc($result1))
                                {?>
                                <option value="<?php echo $row2["pCode"];?>"
                                ><?php echo $row2['pCode']; ?></option>
                                <?php } ?>
                                
                            </select>
                            <button type="submit" name="submit" value=">>"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <!-- </form> -->

                    <div class="stud_left_group">
                        <!--    <form action ="index.php" method = "POST"> 
                        <div class="student_select">
                            <label for="#" class="label">Status: </label>
                            <select class="curri_selection" name="stat" id="stat">
                                <option value="Enrolled">Enable</option>
                                <option value="Disabled">Disable</option>
                            </select>
                        </div>
                         -->
                        <div class="student_main_bttn_group">
                            
                            <button type ="submit" id="but_delete" name = "but_delete" class="stud_bttn">
                                <i class="fas fa-save"></i>
                                Delete all Disable
                                </button>
                            <button type ="submit" id="but_disable" name = "but_disable" class="stud_bttn">
                                <i class="fas fa-save"></i>
                                Disable
                                </button>
                            <button type ="submit" id="but_update" name = "but_update" class="stud_bttn">
                                <i class="fas fa-save"></i>
                                Enable
                                </button>
                        </div>
                    </div>
                            
                </div>
                
                
                <div class="stud_table_content">
                    <table class="stud_table">
                    <tr> 
    
                            <th class="stud_title"><input type='checkbox' id='checkAll'>All</th>
                            <th class="stud_title">Student #</th>
                            <th class="stud_title">Curriculum</th>
                            <th class="stud_title">Section</th>
                            <th class="stud_title"> Status</th>
                        </tr>
                        <?php
                            
                            while($row = $sched->fetch_array()){
                                $id = $row['id'];
                                $studNum = $row['studNum'];
                                $progCode = $row['pCode'];
                                $section = $row['Section'];
                                $status = $row['status'];
				        ?>
                        <tr>
                            <td class="stud_data"> <input type ='checkbox' name ='update[]' value='<?= $id ?>'></td>
                            <td class="stud_data"> <?php echo $studNum ?>  </td>
                            <td class="stud_data"> <?php echo $progCode ?> </td>
                            <td class="stud_data"> <?php echo $section ?> </td>
                            <td class="stud_data"> <input type ='text' name ='status_<?= $id ?>' value='<?= $status ?>' readonly></td>
                        </tr>
                        <?php
							}
				        ?>
                    </table>
                    </form>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        // Check/Uncheck ALl
                        $('#checkAll').change(function(){
                            if($(this).is(':checked')){
                                $('input[name="update[]"]').prop('checked',true);
                            }else{
                                $('input[name="update[]"]').each(function(){
                                    $(this).prop('checked',false);
                                }); 
                            }
                        });
                        // Checkbox click
                        $('input[name="update[]"]').click(function(){
                            var total_checkboxes = $('input[name="update[]"]').length;
                            var total_checkboxes_checked = $('input[name="update[]"]:checked').length;
        
                            if(total_checkboxes_checked == total_checkboxes){
                                $('#checkAll').prop('checked',true);
                            }else{
                                $('#checkAll').prop('checked',false);
                            }
                        });
                    });
                </script>
            </div>
      
        </div>
    </div>


</body>

</html>