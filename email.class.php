<?php		

/**
  * email class
  * extends base class parse_email
  * passes in the file name as specified in the get param (not the best practice, but works for now)
  * then checks if file exists; if yes, open and pass file pointer to parse_email - return the relevant parsed fields and store in variables to be used in the view
  *
  * @package  emailparser
  * @author   Sarah Sheehan 
  * @date     9/20/11
 */
 
require_once('parse_email.class.php');

class email extends emailParser{

        private $file;
        
        public function __construct($fileName)
        {
            
            $this->file = $fileName;			
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