<?php

class admin {

    public $databaseInstance = null;
    public $libraryInstance = null;

    public function __construct() {
        $this->databaseInstance = new db();
        $this->libraryInstance = new library();
    }

    public function getAllEmployees() {
        $query = "select * from employees";

        return $this->databaseInstance->getRows($query);
    }

    public function getEmployeeDetailsByEmail($email) {
        $query = "select * from employees where corporate_email = ?";

        return $this->databaseInstance->getRow($query, array($email));
    }

    public function getEmployeeDetailsByUsername($username) {
        $query = "select * from employees where username = ?";

        return $this->databaseInstance->getRow($query, array($username));
    }

    public function validateAdminChangePasswordRequest($oldPassword, $newPassword, $username) {
        if ($this->authenticateAdmin($username, $oldPassword, false) == false) {
            throw new Exception("Your old password entered does not match. Please check and rectify");
        }

        $this->updateAdminPassword($username, $newPassword);

        return true;
    }

    function validateAdminPasswordResetRequest($username, $password, $resetID) {
        $query = "select * from reset_passwords where username = ? and link = ? and valid = ?";
        $values = array($username, $resetID, "yes");

        $result = $this->databaseInstance->getRow($query, $values);

        if (empty($result['username'])) {
            throw new Exception("Request Failed. Problem with the link. Please try again");
        }

        $this->updateAdminPassword($username, $password);

        $query1 = "update reset_passwords set valid = ? where link = ?";
        $values1 = array("no", $resetID);

        $this->databaseInstance->updateRow($query1, $values1);

        return true;
    }
    
    private function getAdminPriviledges($emailAddress){
        $query = "select * from admin_priviledges where email_address = ?";
        
        return $this->databaseInstance->getRow($query, array($emailAddress));
    }
    
    public function getAdminAccessPriviledges($emailAddress){
        $priviledges = array();
        foreach ($this->getAdminPriviledges($emailAddress) as $key => $value) {
            if ($value  == "1"){
                $priviledges[] = $key;
            }
        }
        
        $_SESSION['priviledges'] = $priviledges;
    }

    public function loginAdmin($name, $username, $email, $role) {
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['emailAddress'] = $email;
        $_SESSION['role'] = $role;
        
        $priviledges = array();
        foreach ($this->getAdminPriviledges($email) as $key => $value) {
            if ($value  == "1"){
                $priviledges[] = $key;
            }
        }
        
        $_SESSION['priviledges'] = $priviledges;

        session_regenerate_id();

        return true;
    }

    function logoutAdmin() {
        session_start();

        unset($_SESSION['name']);
        unset($_SESSION['username']);
        unset($_SESSION['emailAddress']);
        unset($_SESSION['role']);

        return true;
    }

    function requestAdminPasswordReset($emailAddress) {
        $query = "select * from admins where email_address = ?";
        $values = array($emailAddress);

        $admin = $this->databaseInstance->getRow($query, $values);
        if (empty($admin['admin_id'])) {
            throw new Exception("No admin with that email address");
        }

        $username = $admin['username'];
        $passwordResetLink = $this->createPasswordResetLink($emailAddress, $username);

        mail($emailAddress, "Reset Password", "Click the following link to reset your password " . $passwordResetLink);

        return true;
    }

    function createPasswordResetLink($email, $username) {
        $programTimezone = $this->getProgramTimezone();
        date_default_timezone_set($programTimezone);
        $today = date("Y-m-d G-i-s");

        $resetID = md5($email . $today);

        $query = "insert into reset_passwords set link = ?, valid = ?, username = ?, date_created = ? ";
        $values = array($resetID, 'yes', $username, $today);

        $this->databaseInstance->insertRow($query, $values);

        $program = new program();
        $programDetails = $program->getProgramDetails();

        $resetPasswordLink = $programDetails['program_url'] . "/admin/reset-password.php?reset-id=" . $resetID;

        return $resetPasswordLink;
    }

    private function logAdminEvent() {
        
    }

    

    public function isValidEmail($email, $corporateOnly = false) {
        if (!empty($email)) {
            if ($corporateOnly) {
                if (strpos($email, '@diamondscripts.ng') === false) {
                    throw new Exception("Corporate email must be @diamondscripts.ng");
                }

                $employeeDetails = $this->getEmployeeDetailsByEmail($email);

                if (!empty($employeeDetails['id'])) {
                    throw new Exception("There already exist an employee with the email address - " . $email);
                }
            } else {
                if (strpos($email, '.') === false) {
                    throw new Exception($email . " does not contain .");
                }
                if (strpos($email, '@') === false) {
                    throw new Exception($email . " does not contain @");
                }
            }
        }

        return true;
    }

    function validateUsername($username) {
        if (strlen($username) < 4) {
            throw new Exception("Username must be more than 4 characters");
        }

        // Blacklist for bad characters (partially nicked from mediawiki)
        $blacklist = '/[' . '\x{0080}-\x{009f}' . # iso-8859-1 control chars
                '\x{00a0}' . # non-breaking space
                '\x{2000}-\x{200f}' . # various whitespace
                '\x{2028}-\x{202f}' . # breaks and control chars
                '\x{3000}' . # ideographic space
                '\x{e000}-\x{f8ff}' . # private use
                ']/u';

        if (preg_match($blacklist, $username)) {
            throw new Exception("Username contains some dissallowed characters");
        }

        // Belts and braces
        // @todo Tidy into main unicode
        $blacklist2 = '\'/\\"*& ?#%^(){}[]~?<>;|Â¬`@-+=';
        for ($n = 0; $n < strlen($blacklist2); $n++) {
            if (strpos($username, $blacklist2[$n]) !== false) {
                throw new Exception("Username contains invalid characters " . $blacklist2);
            }
        }

        $employeeDetails = $this->getEmployeeDetailsByUsername($username);

        if (!empty($employeeDetails['id'])) {
            throw new Exception("There already exist an employee with the username - " . $username);
        }

        return true;
    }

    public function isValidPhoneNumber($phoneNumber) {
        if (!empty($phoneNumber) && !is_numeric($phoneNumber)) {
            throw new Exception("Phone number " . $phoneNumber . " is not a correct phone number format");
        }

        return true;
    }

    public function createEmployee($fullName, $username, $role, $address, $phoneNumber1, $phoneNumber2, $corporateEmail, $personalEmail, $birthDay, $birthMonth, $birthYear, $bank, $accountName, $accountNumber, $spouseName, $spouseNumber, $spouseEmployer, $nextName, $nextEmail, $nextAddress, $nextPhoneNumber1, $nextPhoneNumber2, $nextOccupation, $nextRelationship, $emergencyName, $emergencyEmail, $emergencyAddress, $emergencyPhoneNumber1, $emergencyPhoneNumber2, $emergencyOccupation, $emergencyRelationship) {

        $this->validateUsername($username);

        $this->isValidEmail($corporateEmail, true);
        $this->isValidEmail($personalEmail);
        $this->isValidEmail($nextEmail);
        $this->isValidEmail($emergencyEmail);

        //validate the phone numbers
        $this->isValidPhoneNumber($phoneNumber1);
        $this->isValidPhoneNumber($phoneNumber2);
        $this->isValidPhoneNumber($nextPhoneNumber1);
        $this->isValidPhoneNumber($nextPhoneNumber2);
        $this->isValidPhoneNumber($emergencyPhoneNumber1);
        $this->isValidPhoneNumber($emergencyPhoneNumber2);

        $creationDate = date("l jS F Y");
        $password = $this->generatePassword();

        $encryptedPassword = $this->encryptPassword($username, $password, $creationDate);

        $query = "insert into employees set name = ?, username = ?, role = ?, address = ?, phone_number_1 = ?, phone_number_2 = ?, "
                . "corporate_email = ?, personal_email = ?, birth_day = ?, birth_month = ?, birth_year = ?, bank = ?, "
                . "account_name = ?, account_number = ?, spouse_name = ?, spouse_number = ?, spouse_employer = ?, "
                . "next_kin_name = ?, next_kin_email = ?, next_kin_address = ?, next_kin_phone_1 = ?, next_kin_phone_2 = ?, "
                . "next_kin_occupation = ?, next_kin_relationship = ?, emergency_name = ?, emergency_email = ?, "
                . "emergency_address = ?, emergency_phone_1 = ?, emergency_phone_2 = ?, emergency_occupation = ?, "
                . "emergency_relationship = ?, password = ?, date_created = ?";

        $values = array($fullName, $username, $role, $address, $phoneNumber1, $phoneNumber2, $corporateEmail,
            $personalEmail, $birthDay, $birthMonth, $birthYear, $bank, $accountName, $accountNumber, $spouseName,
            $spouseNumber, $spouseEmployer, $nextName, $nextEmail, $nextAddress, $nextPhoneNumber1,
            $nextPhoneNumber2, $nextOccupation, $nextRelationship, $emergencyName, $emergencyEmail, $emergencyAddress,
            $emergencyPhoneNumber1, $emergencyPhoneNumber2, $emergencyOccupation, $emergencyRelationship, $encryptedPassword, $creationDate);

        $this->databaseInstance->insertRow($query, $values);

        $subject = "Admin Account Creation";
        $message = "Hi " . $fullName . ", you have created as an admin on admin.diamondscripts.ng . <br><br><br> To login use "
                . "" . $username . " as your username and " . $password . " as your password";

        $this->libraryInstance->sendEmail($corporateEmail, $subject, $message);

        return true;
    }

    public function createRole() {
        
    }

    function generatePassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function encryptPassword($adminUsername, $adminPassword, $creationDate) {
        $intermediateSalt = md5($creationDate, true);

        $salt = substr($intermediateSalt, 0, 10);

        return hash("sha256", $adminUsername . $salt . $adminPassword);
    }

    public function authenticateAdmin($username, $password, $loginAdmin = true) {
        $employeeDetails = $this->getEmployeeDetailsByUsername($username);

        $encryptedPassword = $this->encryptPassword($username, $password, $employeeDetails['date_created']);
        
        //throw new Exception("Encrypted password is " . $encryptedPassword);

        $query = "select * from employees where username = ? and password = ?";
        $values = array($username, $encryptedPassword);

        $employee = $this->databaseInstance->getRow($query, $values);

        if (!empty($employee['username'])) {
            if ($loginAdmin) {
                return $this->loginAdmin($employeeDetails['name'], $username, $employee['corporate_email'], $employee['role']);
            }
            return true;
        }

        return false;
    }

    public function updateEmployeePassword($username, $currentPassword, $newPassword) {
        $employeeDetails = $this->getEmployeeDetailsByUsername($username);

        $verifiedEmployee = $this->authenticateAdmin($username, $currentPassword, false);
        if ($verifiedEmployee == false) {
            throw new Exception("Your current password is wrong. Please enter current password currently. " . print_r($verifiedEmployee));
        }

        $encryptedPassword = $this->encryptPassword($username, $newPassword, $employeeDetails['date_created']);

        $query = "update employees set password = ? where username = ?";
        $values = array($encryptedPassword, $username);

        $this->databaseInstance->updateRow($query, $values);

        return true;
    }

}
