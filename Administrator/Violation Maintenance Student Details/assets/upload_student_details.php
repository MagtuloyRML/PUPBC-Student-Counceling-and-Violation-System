<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Text;

include ("../../../assets/PHPSpreedsheet/vendor/autoload.php");

$connect = new PDO("mysql:host=localhost;dbname=studentviolation_db", "root", "");

    $location = "localhost";
    $name = "root";
    $password = "";
    $database = "studentviolation_db";

    $conn = new mysqli($location, $name, $password, $database);

    if($conn->connect_error){
        echo "Connection Error";
    }


if($_FILES["file_path"]["name"] != '')
{
    $allowed_extension = array('xls', 'xlsx');
    $file_array = explode(".", $_FILES["file_path"]["name"]);
    $file_extension = end($file_array);

    if(in_array($file_extension, $allowed_extension)){

        $file_name = time() . '.' . $file_extension;
        move_uploaded_file($_FILES['file_path']['tmp_name'], $file_name);
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

        $spreadsheet = $reader->load($file_name);

        unlink($file_name);

        $data = $spreadsheet->getActiveSheet()->toArray();
        unset($data[0]);
        
        foreach($data as $row)
        {
            $pprogIDGet  = $row[7];
            $checkExistingpprog = "SELECT pID FROM forprogram WHERE pCode = '$pprogIDGet' ";
            $query_resultProg = $connect->prepare($checkExistingpprog);
            $query_resultProg->execute();
            $rowResultProg = $query_resultProg->fetch(PDO::FETCH_ASSOC);

            $newProgID = $rowResultProg['pID'];

            $fullname = $row[1].', '.$row[2].' '.$row[3];

            $insert_data = array(
                ':studNUM'  => $row[0],
                ':fullName'  => $fullname,
                ':lastNAME'  => $row[1],
                ':firstNAME'  => $row[2],
                ':midNAME'  => $row[3],
                ':sec'  => $row[4],
                ':add'  => $row[5],
                ':gen'  => $row[6],
                ':progID'  => $newProgID,
                ':ayCode'  => $row[8]
            );
            $pstudNUM = $row[0];
            $plastNAME  = $row[1];
            $pfirstNAME  = $row[2];
            $pmidNAME  = $row[3];
            $psec  = $row[4];
            $padd  = $row[5];
            $pgen  = $row[6];
            $pprogID  = $row[7];
            $payCode  = $row[8];


            $checkExistingCode = "SELECT studNum, lastName, firstName, middleName, Section, Address, Gender , progCode FROM forstudents WHERE studNum = :studNUM ";
            $query_result = $connect->prepare($checkExistingCode);
            $query_result->bindValue(':studNUM', $pstudNUM);
            $query_result->execute();
            $rowResult = $query_result->fetch(PDO::FETCH_ASSOC);


            if ($rowResult) {
               
                //Update data if Existing na yung studentNumber
                $update_data = "
                UPDATE forstudents SET studNum =:studNUM, fullName = :fullName,
                lastName = :lastNAME, firstName = :firstNAME, middleName = :midNAME,
                Section = :sec , Address = :add, Gender = :gen, progCode = :progID, ayCode = :ayCode, status = 'Enrolled'
                WHERE studNum =:studNUM";
                $updatestatement = $connect->prepare($update_data);
                $updatestatement->execute($insert_data);
            }
            else{
                //Para makapag generate ng auto incremented id
                
                $query9 = "SELECT * FROM forstudents order by id desc limit 1";
                $res = mysqli_query($conn, $query9);
                $row = mysqli_fetch_array($res);
                
                $count = mysqli_num_rows($res);
                if ($count > 0){
                    $lastid = $row['id'];
                    $stud_id = ($lastid + 1);
                }
                else{
                    $stud_id = 1;
                }

                //inserting data if walang kaparehas na studentnumber
                $query = "
                INSERT INTO forstudents
                (studNum, fullName, lastName, firstName, middleName, Section, Address, Gender , progCode, ayCode, id, status) 
                VALUES (:studNUM, :fullName, :lastNAME, :firstNAME, :midNAME, :sec , :add, :gen, :progID, :ayCode, '$stud_id', 'Enrolled')
                ";

                $statement = $connect->prepare($query);
                $statement->execute($insert_data);
            }
            
        }
        $message = '<span class="alert_icon green">
                        <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="alert_text">
                            Data Upload Successfully
                        </span>';

        }
        else{
            $message = '<span class="alert_icon orange">
                            <i class="fa-solid fa-exclamation"></i>
                        </span>
                        <span class="alert_text">
                            Select xlxs file only
                        </span>';
        }
    }
    else
    {
    $message = '<span class="alert_icon orange">
                    <i class="fa-solid fa-exclamation"></i>
                </span>
                <span class="alert_text">
                    Please select a file
                </span>';
                
    }

    echo $message;

?>