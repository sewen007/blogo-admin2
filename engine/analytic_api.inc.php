<?php
/**
 * @author DiamondScript Limited
 * @version 1.0
 * @since July 7, 2018
 */

class KatloggGateway {
	protected $number = null;
	protected $type = null;
	protected $sDate = null;
	protected $eDate = null;
	
	const ACTIVITIESBYDATERANGE_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/activities-by-date-range.php';
	const ACTIVITY_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/all-activities.php';
	const ALL_USERS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-all-users.php';
	const DAILYACTIVEUSERS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-daily-active-users.php';
	const DAILYBOUNCEUSERS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-daily-bounce-users.php';
	const DAILYTRANSACTION_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-daily-transactions.php';
	const EMAIL_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/changed-email.php';
	const FACEBOOK_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/changed-facebook.php';
	const INSTAGRAM_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/changed-instagram.php';
	const MONTHLYACTIVEUSERS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-monthly-active-users.php';
	const MONTHLYBOUNCEUSERS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-monthly-bounce-users.php';
	const MONTHLYTRANSACTION_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-monthly-transactions.php';
	const NAME_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/changed-name.php';
	const PHONE_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/changed-phone.php';
	const IMAGE_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/changed-profile-image.php';
	const TWITTER_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/changed-twitter.php';
	const DELETED_COMMENT_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/deleted-comment.php';
	const DISLIKED_COMMENT_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/disliked-comment.php';
	const DISLIKED_NEWS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/disliked-news.php';
	const EDITED_COMMENT_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/edited-comment.php';
	const ITEMS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/items.php';
	const LIKED_COMMENT_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/liked-comment.php';
	const LIKED_NEWS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/liked-news.php';
	const NEWS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/news.php';
	const REPLY_COMMENT_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/replied-comment.php';
	const SINGLE_ITEM_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/single-items.php';
	const USERS_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/users.php';
	const TRANSACTION_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/all-transactions.php';
	const TYPES_URL = 'http://www.dstesting.com.ng/analytics/engine/actions/get-types.php';
	
	public function __construct() {

	}
	
	/**
	 * @param string $apiurl
	 * @param string $params
	 * @return string
	 */
	protected function doBroadcast($apiurl, $params) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $apiurl );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$response = curl_exec ( $ch );
		return $response;
	}

	/**
	 * $myType value must be any of the following:
	 * (email, facebook, instagram, name, phone, image, twitter, delete-news-comment, 
	 *  dislike-news-comment, dislike-news, edit-news-comment, items, like-news-comment, 
	 *  like-news, news, reply-news-comment, single-item)
	 * @param $myType
	 * @return array
	*/
	public function getTransaction($myType) {
		$parameter = $this->setOneParameter($myType);
		$responseArray = $this->doBroadcast ( self::TRANSACTION_URL, $parameter );
		return $responseArray;
	}

	/**
	 * @param datetime $myStartDate
	 * @param datetime $myEndDate
	 * @param string $myType
	 * @return array
	*/
	public function getByDateRange($myStartDate, $myEndDate, $myType) {
		
		$parameters = $this->setParameter($myStartDate, $myEndDate, $myType);

		$responseArray = $this->doBroadcast ( self::ACTIVITIESBYDATERANGE_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param date $myStartDate
	 * @param date $myEndDate
	 * @return array
	*/
	public function getDailyActiveUsers($myStartDate, $myEndDate) {
		
		$parameters = $this->setParameter($myStartDate, $myEndDate, 'null');

		$responseArray = $this->doBroadcast ( self::DAILYACTIVEUSERS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param date $myStartDate
	 * @param date $myEndDate
	 * @return array
	*/
	public function getDailyBounceUsers($myStartDate, $myEndDate) {
		
		$parameters = $this->setParameter($myStartDate, $myEndDate, 'null');

		$responseArray = $this->doBroadcast ( self::DAILYBOUNCEUSERS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param date $myStartDate
	 * @param date $myEndDate
	 * @return array
	*/
	public function getDailyTransactions($myStartDate, $myEndDate) {
		
		$parameters = $this->setParameter($myStartDate, $myEndDate, 'null');

		$responseArray = $this->doBroadcast ( self::DAILYTRANSACTION_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param date $myStartDate
	 * @param date $myEndDate
	 * @return array
	*/
	public function getMonthlyActiveUsers($myStartDate, $myEndDate) {
		
		$parameters = $this->setParameter($myStartDate, $myEndDate, 'null');

		$responseArray = $this->doBroadcast ( self::MONTHLYACTIVEUSERS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param date $myStartDate
	 * @param date $myEndDate
	 * @return array
	*/
	public function getMonthlyBounceUsers($myStartDate, $myEndDate) {
		
		$parameters = $this->setParameter($myStartDate, $myEndDate, 'null');

		$responseArray = $this->doBroadcast ( self::MONTHLYBOUNCEUSERS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param date $myStartDate
	 * @param date $myEndDate
	 * @return array
	*/
	public function getMonthlyTransactions($myStartDate, $myEndDate) {
		
		$parameters = $this->setParameter($myStartDate, $myEndDate, 'null');

		$responseArray = $this->doBroadcast ( self::MONTHLYTRANSACTION_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getActivityNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);

		$responseArray = $this->doBroadcast ( self::ACTIVITY_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getChangedEmailNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);

		$responseArray = $this->doBroadcast ( self::EMAIL_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getChangedFacebookAccountNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::FACEBOOK_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getChangedInstagramAccountNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::INSTAGRAM_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getChangedNameNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::NAME_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getChangedPhoneNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::PHONE_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getChangedProfileImageNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::IMAGE_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getChangedTwitterHandleNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::TWITTER_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getDeletedCommentNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::DELETED_COMMENT_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getDislikedCommentNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::DISLIKED_COMMENT_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getDislikedNewsNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::DISLIKED_NEWS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getEditedCommentNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::EDITED_COMMENT_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getViewedItemsNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::ITEMS_URL, $parameters );
		return $responseArray;
	}		
	
	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getLikedCommentNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::LIKED_COMMENT_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getLikedNewsNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::LIKED_NEWS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getViewedNewsNumberOfTimes($myNumber, $myType) {
		
		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::NEWS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getRepliedCommentNumberOfTimes($myNumber, $myType) {

		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::REPLY_COMMENT_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getViewedSingleItemNumberOfTimes($myNumber, $myType) {

		$parameters = $this->setParameters($myNumber, $myType);
		
		$responseArray = $this->doBroadcast ( self::SINGLE_ITEM_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getUsers($myNumber, $myType) {
		$parameters = $this->setParameters($myNumber, $myType);

		$responseArray = $this->doBroadcast ( self::USERS_URL, $parameters );
		return $responseArray;
	}

	/**
	 * @return array
	 */
	public function getAllUsers() {
		$responseArray = $this->doBroadcast ( self::ALL_USERS_URL, null );
		return $responseArray;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function getRequestTypes() {
		$responseArray = $this->doBroadcast ( self::TYPES_URL, null );
		return $responseArray;
	}

	/**
	 * @param string $myType
	 * @return array
	 */
	public function setOneParameter($myType) {
		$this->type = ( string ) htmlentities ( $myType );

		$params = sprintf ( "type=%s", urlencode ( $this->type ) );

		return $params;
	}

	/**
	 * @param string $myNumber
	 * @param string $myType
	 * @return array
	 */
	public function setParameters($myNumber, $myType) {
		$this->number = ( string ) htmlentities ( $myNumber );
		$this->type = ( string ) htmlentities ( $myType );

		$params = sprintf ( "number=%s&type=%s", urlencode ( $this->number ), urlencode ( $this->type ) );

		return $params;
	}

	/**
	 * @param datetime $myStartDate
	 * @param datetime $myEndDate
	 * @param string $myType
	 * @return array
	 */
	public function setParameter($myStartDate, $myEndDate, $myType) {
		$this->sDate = ( string ) htmlentities ( $myStartDate );
		$this->eDate = ( string ) htmlentities ( $myEndDate );
		$this->type = ( string ) htmlentities ( $myType );

		$params = sprintf ( "from=%s&to=%s&type=%s", urlencode ( $this->sDate ), urlencode ( $this->eDate ), urlencode ( $this->type ) );

		return $params;
	}

	
}