<?php
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
class DBConnectException extends Exception {

  public function __construct($error, $errno = 0){
    parent::__construct($error, $errno);
  }
}
class DBQueryException extends Exception {

  public function __construct($error, $errno = 0){
    parent::__construct($error, $errno);
  }
}
class DB extends mysqli {

  public function __construct($host = host, $user = user, $pass = password, $db = database, $port = null, $socket = null){
    @parent::__construct($host, $user, $pass, $db, $port, $socket);
    if ($this->connect_errno != 0){
      throw new DBConnectException($this->connect_error, $this->connect_errno);
    }
  }
  
  public function query($sql){
    $result = @parent::query($sql);
    if ($this->errno != 0){
      throw new DBQueryException($this->error, $this->errno);
    }
    return $result;
  }
    public function prepare($sql){
    $result = @parent::prepare($sql);
    if ($this->errno != 0){
      throw new DBQueryException($this->error, $this->errno);
    }
    return $result;
  }
}
class TwitterRunner {
	
	public static $connection;
	public static $sessionreturn;
	public static $errors = array(); 
	public static $clear;
	
public function __construct(){
	@session_start();
date_default_timezone_set('Europe/Amsterdam');
$access_token = $_SESSION['access_token'];
	$this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$this->connection->host = "https://api.twitter.com/1.1/";
}

public function ratelimet (){
	$rate = $this->connection->get('account/rate_limit_status');
	return $rate->remaining_hits;
	
}

public function posttweet($tweet){
	if(strlen($tweet) <= 140){
		    $this->connection->post('statuses/update', array('status' => $tweet));
			echo '<div class="alert alert-success">
  tweet is gepost.
</div>';
}else{
	self::$errors[] = "tweet is te lang";	
	}
}
public function userdata (){
	$statuses = $this->connection->get('users/show', array('screen_name' => twitter_name));
	
	return $statuses;
	
}

public function timeline() {
	
	$timeline = $this->connection->get('statuses/home_timeline', array('screen_name' => twitter_name, 'count' => tweetcount));
	return $timeline;
}

public function clear($input){
	self::$clear = htmlspecialchars(strip_tags(stripslashes(trim($input))));
	return self::$clear;
	}
	
	public function login($username, $password){
	  $db = new DB();
try {
	if (empty($username)){
	self::$errors[] = "geen username ingevuld";	
	}if (empty($password)){
		self::$errors[] = "geen password ingevuld";
	}else{
  if ($stmt = $db->prepare("SELECT username FROM `admin_login` WHERE `username` = ? AND `password` = ?")){
	  $stmt->bind_param('ss', $username, $password);
	  if ($stmt->execute()){
		  $stmt->store_result();
			if ($stmt->num_rows == 0){
				self::$errors[] = "username of password worden niet herkend door onze database.";
				}else{
		  $stmt->bind_result($username);
		  while($stmt->fetch()) 
        { 
			$_SESSION['login'] = 1;
			if (CONSUMER_KEY == '' || CONSUMER_SECRET == '') {
  self::$errors[] = 'You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
			}elseif (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
			echo '<a href="./redirect.php" class="btn btn-info"><i class="icon-twitter"></i> Sign in with Twitter</a>
    <div class=" clearfix"></div>';
			}else{
				
			header("location: ./index.php");	
			}
        }//end while
				}//end else
	  }//execute
  }//prepaire
  $db->close();
	}//end else
} catch (DBConnectException $e){
  self::$errors[] = "ERROR WHILE CONNECTING: " . $e->getMessage() . " (" . $e->getCode() . ")\n";
} catch (DBQueryException $e){
  self::$errors[] = "ERROR IN QUERY: " . $e->getMessage() . " (" . $e->getCode() . ")\n";
}
  }
  
  public function sessionlogin(){
		if (isset($_SESSION['login'])){
			self::$sessionreturn = true;
		}else{
			self::$sessionreturn = false;
		}
		return self::$sessionreturn;
	}
	public function action($values){
		switch($values['action']){
			case 'login':
		return self::login(self::clear($values['username']), self::clear($values['password']));
		break;
		case 'tweet':
		return self::posttweet(self::clear($values['new_message']));
		break;
		}
	}
	
		public function __destruct(){
	if (self::$errors){
		$errortext = "";
		foreach(self::$errors as $error) {
		$errortext .= "<li>".$error."</li>";
  }
	die('<div class="alert alert-error">
                <a class="close" data-dismiss="alert" href="#">x</a> Dit is er fout:<ul>'. $errortext .'</ul></div>');
	}
	}
}
$twitter = new TwitterRunner();
if (isset($_POST['submit'])){
echo $twitter->action($_POST);
}
?>