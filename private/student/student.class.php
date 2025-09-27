<?php
require_once __DIR__ . '/../includes/databaseconnection.php';

class Student extends DatabaseConnection
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function registerNewStudent($student_id, $student_name, $student_password, $student_email, $student_birthday, $student_departman, $student_contact, $student_gender, $student_address)
    {
        $check_query = "SELECT `st_id` FROM `st_info` WHERE `st_id`=:student_id OR `email`=:student_email";
        try {
            $check_connection = parent::getConnection()->prepare($check_query);
            $check_connection->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $check_connection->bindParam(':student_email', $student_email, PDO::PARAM_STR);
            if ($check_connection->execute()) {
                if ($check_connection->rowCount() > 0) {
                    return false;
                }
                $hashed_password = md5($student_password);
                $add_new_student_query = "INSERT INTO `st_info` (`st_id`,`name`,`password`,`email`,`bday`,`program`,`contact`,`gender`,`address`) 
                                          VALUES (:student_id,:student_name,:student_password,:student_email,:student_birthday,:student_departman,:student_contact,:student_gender,:student_address)";
                $add_new_student = parent::getConnection()->prepare($add_new_student_query);
                $add_new_student->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_name', $student_name, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_password', $hashed_password, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_email', $student_email, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_birthday', $student_birthday, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_departman', $student_departman, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_contact', $student_contact, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_gender', $student_gender, PDO::PARAM_STR);
                $add_new_student->bindParam(':student_address', $student_address, PDO::PARAM_STR);
                if ($add_new_student->execute()) {
                    return true;
                }
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }

    public function loginStudent($student_id, $student_password)
    {
        $hashed_password = md5($student_password);
        $sql = "SELECT `st_id`, `name` FROM `st_info` WHERE `st_id`=:student_id AND `password`=:student_password";
        try {
            $connection = parent::getConnection()->prepare($sql);
            $connection->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $connection->bindParam(':student_password', $hashed_password, PDO::PARAM_STR);
            if ($connection->execute()) {
                $userdata = $connection->fetch(PDO::FETCH_ASSOC);
                if ($userdata) {
                    $_SESSION['student_logged_in'] = true;
                    $_SESSION['student_id'] = $userdata['st_id'];
                    $_SESSION['student_name'] = $userdata['name'];
                    return true;
                }
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }

    public function getStudentName($student_id)
    {
        $query = "SELECT `name` FROM `st_info` WHERE `st_id`=:student_id";
        try {
            $connection = parent::getConnection()->prepare($query);
            $connection->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            if ($connection->execute()) {
                $result = $connection->fetch(PDO::FETCH_ASSOC);
                return isset($result['name']) ? $result['name'] : null;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return null;
    }

    public function getStudentById($student_id)
    {
        $query = "SELECT * FROM `st_info` WHERE `st_id`=:student_id";
        try {
            $connection = parent::getConnection()->prepare($query);
            $connection->bindParam(":student_id", $student_id, PDO::PARAM_STR);
            if ($connection->execute()) {
                $student_data = $connection->fetch(PDO::FETCH_ASSOC);
                return $student_data;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }

    public function updateStudentProfile($student_id, $student_name, $student_email, $student_dept, $student_gender, $student_contact, $student_address)
    {
        $query = "UPDATE `st_info` SET `name`=:student_name, `email`=:student_email, `program`=:student_dept, 
                  `gender`=:student_gender, `contact`=:student_contact, `address`=:student_address 
                  WHERE st_id=:student_id";
        try {
            $connection = parent::getConnection()->prepare($query);
            $connection->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $connection->bindParam(':student_name', $student_name, PDO::PARAM_STR);
            $connection->bindParam(':student_email', $student_email, PDO::PARAM_STR);
            $connection->bindParam(':student_dept', $student_dept, PDO::PARAM_STR);
            $connection->bindParam(':student_gender', $student_gender, PDO::PARAM_STR);
            $connection->bindParam(':student_contact', $student_contact, PDO::PARAM_STR);
            $connection->bindParam(':student_address', $student_address, PDO::PARAM_STR);
            if ($connection->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }

    public function changePassword($student_id, $currentPassword, $newPassword)
    {
        $checkOldPasswordQuery = "SELECT `st_id` FROM `st_info` WHERE `st_id`=:student_id AND `password`=:student_old_password";
        try {
            $checkOldPasswordStatement = parent::getConnection()->prepare($checkOldPasswordQuery);
            $checkOldPasswordStatement->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $hashedOldPassword = md5($currentPassword);
            $checkOldPasswordStatement->bindParam(':student_old_password', $hashedOldPassword, PDO::PARAM_STR);
            if ($checkOldPasswordStatement->execute()) {
                $rowCount = $checkOldPasswordStatement->rowCount();
                if ($rowCount == 0) {
                    return false;
                } else {
                    $updatePasswordQuery = "UPDATE `st_info` SET `password`=:student_new_password WHERE st_id=:student_id";
                    $updatePasswordStatement = parent::getConnection()->prepare($updatePasswordQuery);
                    $hashedNewPassword = md5($newPassword);
                    $updatePasswordStatement->bindParam(':student_new_password', $hashedNewPassword, PDO::PARAM_STR);
                    $updatePasswordStatement->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                    $updatePasswordStatement->execute();
                    return true;
                }
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }

    public function logoutStudent()
    {
        if ($_SESSION['st_login']) {
            $_SESSION['st_login'] = false;
            unset($_SESSION['sid']);
            unset($_SESSION['st_name']);
            return true;
        } else {
            return false;
        }
    }

    public function isStudentLoggedIn()
    {
        return isset($_SESSION['st_login']) ? $_SESSION['st_login'] : false;
    }

    public function fetchAllStudents()
    {
        $query = "SELECT * FROM `st_info` ORDER BY `st_id` ASC";
        try {
            $databaseConnection = parent::getConnection();
            $statement = $databaseConnection->prepare($query);
            if ($statement->execute()) {
                return $statement;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return null;
    }

    public function searchStudents($searchParam) 
    {
        $searchTerm = '%' . $searchParam . '%';
        $query = "SELECT * FROM `st_info` WHERE (`st_id` LIKE :parameter1 OR `name` LIKE :parameter2 OR `contact` LIKE :parameter3 OR `email` LIKE :parameter4) ORDER BY `st_id` ASC";
        try {
            $databaseConnection = parent::getConnection();
            $statement = $databaseConnection->prepare($query);
            if ($statement) {
                $statement->bindParam(':parameter1', $searchTerm, PDO::PARAM_STR);
                $statement->bindParam(':parameter2', $searchTerm, PDO::PARAM_STR);
                $statement->bindParam(':parameter3', $searchTerm, PDO::PARAM_STR);
                $statement->bindParam(':parameter4', $searchTerm, PDO::PARAM_STR);
                $result = $statement->execute();
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }

    public function deleteStudent($studentID)
    {
        $query = "DELETE FROM `st_info` WHERE `st_id` = :studentID";
        try {
            $connection = parent::getConnection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":studentID", $studentID, PDO::PARAM_INT);
            $result = $statement->execute();
            return $result;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }

    public function changePasswordNew($student_id, $currentPassword, $newPassword)
    {
        $verifyQuery = "SELECT `password` FROM `st_info` WHERE `st_id` = :student_id";
        try {
            $connection = parent::getConnection();
            $statement = $connection->prepare($verifyQuery);
            $statement->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            if ($statement->execute()) {
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                if ($result && md5($currentPassword) === $result['password']) {
                    $updateQuery = "UPDATE `st_info` SET `password` = :new_password WHERE `st_id` = :student_id";
                    $updateStatement = $connection->prepare($updateQuery);
                    $hashedNewPassword = md5($newPassword);
                    $updateStatement->bindParam(':new_password', $hashedNewPassword, PDO::PARAM_STR);
                    $updateStatement->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                    return $updateStatement->execute();
                }
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
        return false;
    }
}
?>