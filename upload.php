<?php
 
 	function clean_frames($frames_dir){
		$files = glob($frames_dir.'/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
		    unlink($file); // delete file
		}
 	}

 

	function execute_commands($uploads_dir, $video_name){
		$output   = exec("./ffmpeg -i ".$video_name." -vf scale=574:-1 -r 18 ".$uploads_dir."frames/%04d.png && montage -border 0 -geometry 574x -tile 6x -quality 100% ".$uploads_dir."frames/*.png myvideo.jpg 2>&1");

		return $output;

	// $output  = exec("montage -border 0 -geometry 574x -tile 6x -quality 100% /home/lifeware/webapps/muravideo/uploads/frames/*.png myvideo.jpg");
	 

	} 
	 


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
 
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

		
		$directorio = "/home/lifeware/webapps/muravideo/uploads/";
		//Clean all the previous frames
		clean_frames($directorio."frames");
	    
	    //Rename FIle 
	    // echo "=>". basename( $_FILES["fileToUpload"]["name"])."";
		$video_name = rename ($directorio.basename($_FILES["fileToUpload"]["name"]),$directorio."video.mp4");

		$result =  execute_commands($directorio, $directorio."video.mp4");        
	 
 
		

        echo '<a download class="button success button_padded_top" href="http://mura.lifeware.webfactional.com/myvideo.jpg">Download</a>';



    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>