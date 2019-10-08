<?php


class account {
    protected $databaseInstance = "";
    
    public function __construct() {
        $this->databaseInstance = new db();
    }
    
    public function getTimeFormat($iDate){
        if (empty($iDate)){
            return;
        }
        
        $date = explode("/", $iDate);
        $dateString = $date[2] . "-" . $date[0] . "-" . $date[1];
        
        return $dateString;
    }
    
    public function getCurrentBalance(){
        $query = "select * from account_pettycash order by id desc limit 1";
        
        return $this->databaseInstance->getRow($query);
    }
    
    public function getPettyCashRecord($fromRange, $toRange){
        $fromRange = $fromRange == "--" ? "" : $fromRange;
        $toRange = $toRange == "--" ? "" : $toRange;
        
        $from = $this->getTimeFormat($fromRange);
        $to = $this->getTimeFormat($toRange);
        
        if (empty($fromRange) && !empty($toRange)){
            $query = "select * from account_pettycash where date <= ?";
            $values = array($to);
        } else if (!empty ($fromRange) && empty ($toRange)){
            $query = "select * from account_pettycash where date >= ?";
            $values = array($from);
        } else if (!empty ($fromRange) && !empty ($toRange)){
            $query = "select * from account_pettycash where date >= ? and date <= ?";
            $values = array($from, $to);
        } else {
            $query = "select * from account_pettycash";
            $values = array();
        }        
        
        return $this->databaseInstance->getRows($query, $values);
        
//        $from = $this->getTimeFormat($fromRange);
//        $to = $this->getTimeFormat($toRange);
//        
//        $query = "select * from account_pettycash where date >= ? and date <= ?";
//        $values = array($from, $to);
//        
//        return $this->databaseInstance->getRows($query, $values);
    }
    
    public function getPaymentRecordByPaymentID($paymentID){
        $query = "select * from account_payments where payment_id = ?";
        
        return $this->databaseInstance->getRow($query, array($paymentID));
    }

    public function getPettyCashRecordByID($paymentID){
        $query = "select * from account_pettycash where id = ?";

        return $this->databaseInstance->getRow($query, array($paymentID));
    }
    
    public function getPaymentRecord($fromRange, $toRange){
        $fromRange = $fromRange == "--" ? "" : $fromRange;
        $toRange = $toRange == "--" ? "" : $toRange;
        
        $from = $this->getTimeFormat($fromRange);
        $to = $this->getTimeFormat($toRange);
        
        if (empty($fromRange) && !empty($toRange)){
            $query = "select * from account_payments where date <= ?";
            $values = array($to);
        } else if (!empty ($fromRange) && empty ($toRange)){
            $query = "select * from account_payments where date >= ?";
            $values = array($from);
        } else if (!empty ($fromRange) && !empty ($toRange)){
            $query = "select * from account_payments where date >= ? and date <= ?";
            $values = array($from, $to);
        } else {
            $query = "select * from account_payments";
            $values = array();
        }        
        
        return $this->databaseInstance->getRows($query, $values);
    }

    public function getLastPettyCashRecord(){
        $query = "select * from account_pettycash order by id desc limit 1";

        return $this->databaseInstance->getRow($query);
    }

    public function editPettyCashRecord($recordID, $description, $date, $amount, $finalBalance, $amountChanged, $changeType){
        $lastRecord = $this->getLastPettyCashRecord();
        $lastRecordID = $lastRecord['id'];

        $dateString = $this->getTimeFormat($date);

        $query = "update account_pettycash set description = ?, date = ?, amount = ?, final_balance = ? where id = ?";
        $values = array($description, $dateString, $amount, $finalBalance, $recordID);

        $this->databaseInstance->updateRow($query, $values);

        $nextRecordID = $recordID + 1;

        while($nextRecordID <= $lastRecordID && $amountChanged != 0){
            if ($changeType == "positive"){
                $query = "update account_pettycash set initial_balance = initial_balance + ?, final_balance = final_balance + ? where id = ?";
            } else if ($changeType == "negative") {
                $query = "update account_pettycash set initial_balance = initial_balance - ?, final_balance = final_balance - ? where id = ?";
            }

            $this->databaseInstance->updateRow($query, array($amountChanged, $amountChanged, $nextRecordID));
            $nextRecordID++;
        }

        return true;
    }
    
    public function addPettyCashRecord($username, $description, $date, $amount, $currentBalance, $finalBalance){
        $dateString = $this->getTimeFormat($date);
        
        if ($amount > $currentBalance){
            throw new Exception("Can't add a new record. Insufficient balance. Replenish your account");
        }
        
        $query = "insert into account_pettycash set username = ?, description = ?, "
                . "date = ?, amount = ?, initial_balance = ?, final_balance = ?";
        $values = array($username, $description, $dateString, $amount, $currentBalance, $finalBalance);
        
        $this->databaseInstance->insertRow($query, $values);
        
        return true;
    }
    
    
    public function replenishPettyCashBalance($username, $description, $date, $amount, $currentBalance, $finalBalance){
        $dateString = $this->getTimeFormat($date);
        
        $query = "insert into account_pettycash set username = ?, description = ?, "
                . "date = ?, amount = ?, initial_balance = ?, final_balance = ?";
        $values = array($username, $description, $dateString, $amount, $currentBalance, $finalBalance);
        
        $this->databaseInstance->insertRow($query, $values);
        
        return true;
    }
    
    public function addPayment($paymentType, $merchant, $productNumber, $paymentDate, $subtotal, $total, $receiptImageURL, $remark) {
        $paymentID = $this->generatePaymentID(10);

        $query = "insert into account_payments set payment_id = ?, type = ?, merchant = ?, product_number = ?, "
                . "date = ?, subtotal = ?, total = ?, receipt_image_url = ?, remark = ?";

        $values = array($paymentID, $paymentType, $merchant, $productNumber, $paymentDate, $subtotal, $total, $receiptImageURL, $remark);

        $this->databaseInstance->insertRow($query, $values);

        return $paymentID;
    }
    
    public function editPayment($paymentID, $paymentType, $merchant, $productNumber, $paymentDate, $subtotal, $total, $remark) {
        $query = "update account_payments set type = ?, merchant = ?, product_number = ?, "
                . "date = ?, subtotal = ?, total = ?, remark = ? where payment_id = ?";

        $values = array($paymentType, $merchant, $productNumber, $paymentDate, $subtotal, $total, $remark, $paymentID);

        $this->databaseInstance->insertRow($query, $values);

        return $paymentID;
    }

    private function generatePaymentID($length, $prefix = "") {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        //$codeAlphabet .= "@!_+){^-#&*=><?";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
        }
        return $prefix . $token;
    }

    function cryptoRandSecure($min, $max) {
        $range = $max - $min;
        if ($range < 1)
            return $min;
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);
        return $min + $rnd;
    }
    
    public function editProducts($paymentID, $productArray){
        $query = "delete from account_products where payment_id = ?";
        $values = array($paymentID);
        
        $this->databaseInstance->deleteRow($query, $values);
        
        foreach ($productArray as $iproduct) {
            $name = $iproduct["name"];
            $quantity = $iproduct["quantity"];
            $unitPrice = $iproduct["unit-price"];
            $total = $iproduct["total"];

            $query1 = "insert into account_products set payment_id = ?, name = ?, quantity = ?, unit_price = ?, total = ?";
            $values1 = array($paymentID, $name, $quantity, $unitPrice, $total);

            $this->databaseInstance->insertRow($query1, $values1);
        }

        return true;
    }

    public function addProducts($paymentID, $productArray) {
        //print_r($productArray);exit;
        foreach ($productArray as $iproduct) {
            $name = $iproduct["name"];
            $quantity = $iproduct["quantity"];
            $unitPrice = $iproduct["unit-price"];
            $total = $iproduct["total"];

            $query = "insert into account_products set payment_id = ?, name = ?, quantity = ?, unit_price = ?, total = ?";
            $values = array($paymentID, $name, $quantity, $unitPrice, $total);

            $this->databaseInstance->insertRow($query, $values);
        }

        return true;
    }
    
    public function getAllProductsByPaymentID($paymentID){
        $query = "select * from account_products where payment_id = ?";
        
        return $this->databaseInstance->getRows($query, array($paymentID));
    }
}
