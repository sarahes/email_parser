<?php 

/**
  * inbox class
  * passes in the rawemails directory (where raw text e-mail files are) and reads through the directory for .email.txt extensions
  * then adds those files to the fileNames array to be used in inbox.php
  * when added files to rawemails folder name them <your_file_name>.email 
  *
  * @package  emailparser
  * @author   Sarah Sheehan 
  * @date     9/20/11
 */
 
class inbox {
    
    
    public function __construct($directory)
    {
    /* set up the inbox
       the rawemails directory is passed in (current working directory + /rawemails) 
    */
    
        if ($handle = opendir($directory)) // open directory
        {			
            while (false !== ($file = readdir($handle)))  // while readdir is able to read files from the handle
            {
                
                if(strstr($file, '.email.txt')){ 
                    // if file has .email.txt extension, add to array fileNames - these will be the emails in your inbox
                    $this->fileNames[] = $directory. '\\' . $file;
                }		
                
            }
            closedir($handle);
        }

    }
}
?>