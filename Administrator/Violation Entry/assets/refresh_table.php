<thead>
                    <tr> 
                        <th class="violation_title">Student Number</th>
                        <th class="violation_title">Name</th>
                        <th class="violation_title">Course</th>
                        <th class="violation_title" style="width: 7%;">Section</th>
                        <th class="violation_title">A.Y Code</th>
                        <th class="violation_title">Violation</th>
                        <th class="violation_title">Sanction</th>
                        <th class="violation_title">Date</th>
                        <th class="violation_title" style="width: 50px;">Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        include_once 'dbconnection.php';
                        
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
                        INNER JOIN forprogram t2 ON t1.pCode = t2.pID
                        INNER JOIN foracademicyear t3 ON t1.code = t3.code
                        INNER JOIN fortheviolations t4 ON t1.Violations = t4.v_code
                        INNER JOIN forstudents t5 ON t1.studNum = t5.studNum
                        INNER JOIN forthesanctions t6 ON t1.Sanctions = t6.s_id
                        WHERE
                        Date >= '2013-12-12'
                        ORDER BY entry_id DESC
                        ");

                        if ($SQL->num_rows > 0) {
                            while ($row = $SQL->fetch_assoc()) {
                        ?>
                        <tr>

                        <td class="violation_data studNum<?php echo $row['entry_id']; ?>" id="<?php echo $row['studNum']; ?>"><?php echo $row['studNum']; ?> </td>
                        <td class="violation_data"><?php echo $row['fullName']; ?> </td>
                        <td class="violation_data"><?php echo $row['p_description']; ?> </td>
                        <td class="violation_data"><?php echo $row['Section']; ?> </td>
                        <td class="violation_data"><?php echo $row['a_code']; ?> </td>
                        <td class="violation_data Violations<?php echo $row['entry_id']; ?>" id="<?php echo $row['Violations']; ?>"><?php echo $row['Violations']; ?> </td>
                        <td class="violation_data Sanctions<?php echo $row['entry_id']; ?>" id="<?php echo $row['Sanctions']; ?>"><?php echo $row['Sanctions']; ?> </td>
                        <td class="violation_data Date<?php echo $row['entry_id']; ?>" id="<?php echo $row['Date']; ?>"><?php $date =  date("d/m/Y", strtotime($row['Date'])); echo $date; ?> </td>
                        <td class="violation_data">
                            <button class="viol_data editBttn" id="<?php echo $row['entry_id']; ?>">
                            <i class="fa-solid fa-pen-to-square"></i></button> 
                        </td>
                    </tr>
                            </tbody>

                            <script src="js/main.js"></script>
    <?php
            }
        }
    ?>

    
