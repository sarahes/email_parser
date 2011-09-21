<?php

/**
  * emailParser class
  * passes in a file pointer (to a raw e-mail) file and parses the relevant header fields and body from that file
  *
  * @package  emailparser
  * @author   Sarah Sheehan 
  * @date     9/20/11
 */

class emailParser{
	private $rawEmail;	
	private $bodyLines;
	private $boundary;
	public $to;
	public $from;
	public $subject;
	public $date;
	
	
	//when a new instance of emailParser is created, the file pointer to raw e-mail file is passed into constructor method and initialized
	public function __construct($email)
	{		
		$this->rawEmail = $email;		
		$this->extractHeaders();		
	}
	
	
	//this method uses fgets to get each line from the file pointer and parse the relevant header fields (to, from, subject and date)
	public function extractHeaders()
	{			
		if ($this->rawEmail) 
		{	
			$endHeaderFlag = true;	
			
			while (($lines = fgets($this->rawEmail)) !== false) 
			{									
				if($endHeaderFlag)
				{
					$this->headers .= $lines;
					if (preg_match("/^To: (.*)/", $lines)) 
					{
						$p = strpos($lines, ":");
						$this->to = substr($lines, $p+1);						
					}
					if (preg_match("/^From: (.*)/", $lines)) {
						$p = strpos($lines, ":");
						$this->from = substr($lines, $p+1);
					}
					if (preg_match("/^Subject: (.*)/", $lines)) {
						$p = strpos($lines, ":");
						$this->subject = substr($lines, $p+1);
					}
					if (preg_match("/^Date: (.*)/", $lines)) {
						$p = strpos($lines, ":");
						$this->date = substr($lines, $p+1);
					}
					if (preg_match("/boundary=/", $lines)) {
						//get the field - use this later as a delimiter to split up the different MIME types in the body 
						$p = strpos($lines, "=");
						$this->boundary = trim(substr($lines, $p+1));
					}
				}
				else
				{
					//concatenate the remaining lines into a body string to be parsed according to MIME type later
					$this->body .= $lines;
					
				}
				
				//headers end started at the first empty line
				if($endHeaderFlag && trim($lines) == ""){					
					$endHeaderFlag = false;
				}				
			}			
		}			
		if (!feof($this->rawEmail)) {
			echo "Could not read lines from the file.\n";
		}
	}
	
	//gets the MIME type text/plain from the body
	public function extractPlainBody()
	{			
		$bodyLine = explode("\n", $this->body);		
        $delimiter = $this->boundary;      
        $foundTypeFlag = false;
        $startMessageFlag = true;
		
		foreach ($bodyLine as $line) {
			//start looping through the body content - first look for the content-type; one we get that, move on
            if (!$foundTypeFlag) {
                if (strstr($line, 'Content-Type: text/plain')) {
					//store Content-Type, in case we need that later
					$contentType = "";
                    $foundTypeFlag = true;                    
                }
            } 
			else if ($startMessageFlag) {
					//now remove carriage returns ('\r') and new lines ('\n')
					$line = str_replace("\r", '', $line);					
					$line = str_replace("\n", '', $line);	
					
					//now that there are no more crlf line terminators, check for the empty line - this is where the message begins			
					if (strlen($line) == 0){
						$startMessageFlag = false;
					}
                
            } 
			else { 
				//if we reach the delimiter (the boundary), this is the end of the message
				if(strstr($line, $delimiter)){
					break;
				}		
				
                $plainBody .= $line . "\n";
            }
            
        }		
        return quoted_printable_decode($plainBody);
		
	}	 
	
	//gets the MIME type text/html from the body - same exact functionality as the extractPlainBody method, just looks for Content-Type: text/html
	public function extractHTMLBody()
	{
		$bodyLine = explode("\n", $this->body);		
        $delimiter = $this->boundary;      
        $foundTypeFlag = false;
        $startMessageFlag = true;
		
		foreach ($bodyLine as $line) {			
            if (!$foundTypeFlag) {
                if (strstr($line, 'Content-Type: text/html')) {					
					$contentType = "";
                    $foundTypeFlag = true;                    
                }
            } 
			else if ($startMessageFlag) {					
					$line = str_replace("\r", '', $line);					
					$line = str_replace("\n", '', $line);						
							
					if (strlen($line) == 0){
						$startMessageFlag = false;
					}                
            } 
			else { 				
				if(strstr($line, $delimiter)){
					break;
				}		
				
                $htmlBody .= $line . "\n";
            }
            
        }		
        return quoted_printable_decode($htmlBody);
		
	}
	
	
}
?>

