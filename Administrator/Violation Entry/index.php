<?php
    $title = 'Violation Entry';
    $page = 'v_entry';
    include_once('../includes/header.php');
?>
    <div class="body_container">
        <div class="content">
            <div class="title">
                <h1>Violation Entry</h1>
                <hr>
            </div>
            <!-- SEARCH BOX -->
            <div class="searchBar">
                <form action="">
                    <input type="text" placeholder="Search" class="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <!-- STUDENT INFO -->
            <div class="studentInfo">
                <form action="" method="">
                    <div class="stud_content">
                        <div class="input_container">
                            <label for="#">Student Name: </label>
                            <br>
                            <input type="text" id="#" name="name" value="">
                        </div>
                        <div class="input_container">
                            <label for="#">Student Course: </label>
                            <br>
                            <input type="text" id="#" name="name" value="">
                        </div>
                        <div class="input_container">
                            <label for="#">Student Section: </label>
                            <br>
                            <input type="text" id="#" name="name" value="">
                        </div>
                        <div class="input_container">
                            <label for="#">Aycode: </label>
                            <br>
                            <input type="text" id="#" name="name" value="">
                        </div>
                        <div class="input_container">
                            <label for="#">Violation: </label>
                            <br>
                            <input type="text" id="#" name="name" value="">
                        </div>
                        <div class="input_container">
                            <label for="#">Sanction: </label>
                            <br>
                            <input type="text" id="#" name="name" value="">
                        </div>
                        <div class="input_container">
                            <label for="#">Date: </label>
                            <br>
                            <input type="text" id="#" name="name" value="">
                        </div>
                    </div>
                    <!-- DATA MANIPULATION BUTTONS -->
                    <div class="action_content">
                        <div class="action_bttn">
                            <input class="bttn" type="button" name="save" value="Create" id="bttnModalEntry">
                        </div>
                        <div class="action_bttn">
                            <input class="bttn" type="button" name="delete" value="Delete">
                        </div>
                        <div class="action_bttn">
                            <input class="bttn" type="button" name="update" value="Update">
                        </div>
                        <div class="action_bttn">
                            <input class="bttn" type="button" name="clear" value="Clear">
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- LIST / TABLE -->
            <div class="list_student_violation">
                <h3 class="list_title">List</h3>
                <table class="display_violation_record">
                    <tr> 
                        <th class="violation_title">Student Number</th>
                        <th class="violation_title">Name</th>
                        <th class="violation_title">Course</th>
                        <th class="violation_title">Section</th>
                        <th class="violation_title">A.Y Code</th>
                        <th class="violation_title">Violation</th>
                        <th class="violation_title">Sanction</th>
                        <th class="violation_title">Date</th>
                    </tr>
                    <?php
                        include_once 'assets/dbconnection.php';
                        
                        $SQL = $conn->query("SELECT 
                        `entry_id`,
                        t1.studNum,
                        `Date`,
                        t5.fullName as fullName,
                        t5.Section as Section,
                        t4.Violations as Violations,
                        t6.Sanctions as Sanctions,
                        t2.pDescription AS p_description,
                        t3.code AS a_code,
                        status FROM forviolationentries t1
                        INNER JOIN forprogram t2 ON t1.pCode = t2.pCode
                        INNER JOIN foracademicyear t3 ON t1.code = t3.code
                        INNER JOIN fortheviolations t4 ON t1.Violations = t4.v_code
                        INNER JOIN forstudents t5 ON t1.studNum = t5.studNum
                        INNER JOIN forthesanctions t6 ON t1.Sanctions = t6.s_id
                        WHERE
                        Date >= '2013-12-12'
                        ORDER BY entry_id DESC");

                        if ($SQL->num_rows > 0) {
                            while ($row = $SQL->fetch_assoc()) {
                        ?>
                        <tr>
                    <tr>
                        <td class="violation_data"><?php echo $row['studNum']; ?> </td>
                        <td class="violation_data"><?php echo $row['fullName']; ?> </td>
                        <td class="violation_data"><?php echo $row['p_description']; ?> </td>
                        <td class="violation_data"><?php echo $row['Section']; ?> </td>
                        <td class="violation_data"><?php echo $row['a_code']; ?> </td>
                        <td class="violation_data"><?php echo $row['Violations']; ?> </td>
                        <td class="violation_data"><?php echo $row['Sanctions']; ?> </td>
                        <td class="violation_data"><?php 
                       $date =  date("d/m/Y", strtotime($row['Date'])); 
                       echo $date; ?> 
                        </td>
                    </tr>
                    <?php
                            }
                        }
                        ?>
                </table>
            </div>
        </div>
    </div>
    
    <?php
        include_once('assets/modal_add_vio_entry.php');
    ?>


</body>

</html>