<?php 

/**
  * inbox class
  * 
  *
  * @package  emailparser
  * @author   Sarah Sheehan 
  * @date     9/20/11
 */
 
require_once('parseMail.class.php');

class inbox extends emailParser{
//inbox now has the all the functionality of emailParser - lets add more functionality!
	public $parseEmail;	
	public $fileNames;
	public $to;
	public $from;
	public $subject;
	public $date;
	public $message;
	
	public function __construct($directory)
	{
		
		//echo getcwd().'\rawemails';
		if ($handle = opendir($directory)) 
		{			
			while (false !== ($file = readdir($handle))) 
			{
				if(strstr($file, '.txt')){
					$this->fileNames[] = $directory. '\\' . $file;
				}		
				
			}
			closedir($handle);
		}
		
		$fileName = $this->fileNames[0];		
		$fileExists = file_exists($fileName);
	
		if(!$fileExists){
			die ('Sorry, that file does not exist.');		
		}
		$fp = fopen($fileName, "r");
		$email = fgets($fp);
		
		$parseEmail = new emailParser($fp);
		
		
		$this->subject = $parseEmail->subject;
		$this->from = $parseEmail->from;
		$this->to = $parseEmail->to;
		$this->date = $parseEmail->date;
		
		$this->message = $parseEmail->extractHTMLBody();
		
		

	}
}
?>