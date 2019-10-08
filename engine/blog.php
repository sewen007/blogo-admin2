<?php

class blog {

	protected $databaseInstance = "";

	public function __construct() {
		$this->databaseInstance = new db();
	}

	public function getAllBlogPosts(){
		$query = "select * from blogposts" ;

		return $this->databaseInstance->getRows($query,array());
	}

	public function createNewBlogPost($username,$title,$content,$image_url,$tags){
		$today = date("F j, Y g:i a");

		$query = "insert into blogposts set author = ?, title = ?, content = ?, image_url = ?, tags = ?";
		$values = array($username, $title, $content, $image_url,$tags);

		$this->databaseInstance->insertRow($query,$values);

		return true;

	}

	public function editBlogPost($blogID,$username,$title, $content,$image_url){
		
		$query = "update blogposts set author = ? title = ?, content = ?, image_url = ? where blog_id = ?";
		$values = array ($title, $content, $image_url, $blogID);

		$this->databaseInstance->updateRow($query, $values);

		return true;
	}

	public function deleteBlogPost($blogID){

		$query = "delete from blogposts where blog_id = ?";

		$response = $this->databaseInstance->deleteRow($query, array($blogID));

		return true;
	}

}