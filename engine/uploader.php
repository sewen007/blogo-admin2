<?php

class Uploader {

    protected $uploadedFile = array();
    protected $destination = "";
    protected $maximum_size = "51200";
    protected $message = array();
    protected $allFiles = array("image/gif", "image/jpeg", "image/png", "application/pdf", 
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
    protected $image_title = "";
    protected $fileType = "";
    protected $file_name = "";
    protected $file_extension = "";
    protected $permittedFileTypes = array();
    protected $nameSuffix = "";

    public function __construct($path, $file, $title, $permittedFiles = array(), $nameSuffix = "") {
        if (!is_dir($path)) {
            throw new Exception("File path is not a directory. Check and rectify");
        }
        if (!is_writable($path)) {
            throw new Exception("File path can't be written to. Check and rectify");
        }
        $this->destination = $path;
        $this->uploadedFile = $file;
        $this->image_title = $title;
        $this->permittedFileTypes = $permittedFiles;
        $this->nameSuffix = $nameSuffix;
        if (empty($permittedFiles)) {
            $this->permittedFileTypes = $this->allFiles;
        }
    }

    public function moveUploadedFile() {
        $field = $this->uploadedFile;
        
        $this->checkError($field['error']);
        
        $this->checkSize($field['size']);
        
        $this->checkType($field['type']);
        
        $fileName = $this->checkName($this->image_title);
        if ($fileName == null) {
            throw new Exception("The name of the file is null");
        }
        
        $success = move_uploaded_file($field['tmp_name'], $this->destination . "/" . $fileName);

        if ($success) {
            return $fileName;
        } else {
            throw new Exception("Unable to store image");
        }
    }

    public function moveUploadedImage() {
        $field = $this->uploadedFile;
        $no_error = $this->checkError($field['error']);

        if ($no_error) {
            $size_ok = $this->checkSize($field['size']);
            $type_ok = $this->checkType($field['type']);

            if ($size_ok && $type_ok) {
                $file_name = $this->checkName($this->image_title);
                if ($file_name == null) {
                    throw new Exception("The name of the file is null");
                }
                $success = move_uploaded_file($field['tmp_name'], $this->destination . "/" . $file_name);

                if ($success) {
                    return $file_name;
                } else {
                    throw new Exception("Unable to store image");
                }
            }
        }
    }

    protected function checkName($name) {
        $file_name = md5($name . date("d F Y G:i:s"));
        if ($this->fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
            $this->file_name = $name;
            $this->file_extension = ".docx";
            $file_name = $name . " " . $this->nameSuffix . ".docx";
        } else if ($this->fileType == "image/gif") {
            $this->file_name = $file_name;
            $this->file_extension = ".gif";
            $file_name = $file_name . ".gif";
        } else if ($this->fileType == "image/jpg") {
            $this->file_name = $file_name;
            $this->file_extension = ".jpg";
            $file_name = $file_name . ".jpg";
        } else if ($this->fileType == "image/png") {
            $this->file_name = $file_name;
            $this->file_extension = ".png";
            $file_name = $file_name . ".png";
        }

        return $file_name;
    }

    protected function checkError($error) {
        switch ($error) {
            case 0 :
                return true;
            case 1 :
            case 2 :
                //$this->message[] = "file exceeds maximum size." . $this->getMaxSize();
                return true;
            case 3 :
                $this->message[] = "Error uploading file. Please try again.";
                return false;
            case 4 :
                $this->message[] = 'No file selected.';
                return false;
            default :
                $this->message[] = "System error uploading. Contact Admin.";
                return false;
        }
    }

    protected function checkType($type) {
        //throw new Exception("The file uploaded is not ot the permitted type. The type is " . $type);
        if (!in_array($type, $this->permittedFileTypes)) {
            throw new Exception("The file uploaded is not of the permitted type.");
        } else {
            $this->fileType = $type;
            return true;
        }
    }

    protected function checkSize($size) {
        if ($size == 0) {
            throw new Exception("The image uploaded has a size of 0kb");
        } else {
            return true;
        }
    }

    public function getMaxSize() {
        return number_format($this->maximum_size / 1024, 1) . 'kB';
    }

}

?>
