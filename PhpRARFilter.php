<!DOCTYPE html>
<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
<?php
	$iname = "fileToUpload";//Input Name
	$msize = 20000000;//Max File Size
	$fdict = "Upload";//Dictionary For The Uploaded File
	if(isset($_POST['submit']))
	{
		$errors= array();
	    $file_name = $_FILES[$iname]['name'];
	    $file_size =$_FILES[$iname]['size'];
	    $file_tmp =$_FILES[$iname]['tmp_name'];
	    $file_type=$_FILES[$iname]['type'];
	    $file_ext=strtolower(end(explode('.',$_FILES[$iname]['name'])));
	    
	    $expensions= array("rar","zip","7zip");//Allowed Extension
	    
	    if(in_array($file_ext,$expensions)=== false)
	    {
	       $errors[]="extension not allowed, please choose a RAR or zip file.";
	    }
	    if($file_size > $msize)
	    {
	       $errors[]='File size cannot be more than ' . $msize/1024 . ' MB';//Error MSG For Extending Size
	    }
	    
	    if(empty($errors)==true)
	    {
	    	//APATISFON(Advance PHP Alghorithme To dIfferentiate Safe File Or Not) Start Here

			putenv("PATH=D:/Program Files/7-Zip");//7-Zip Location

			$out = array();
			exec("7z l $file_tmp", $out);
			$RAW = implode("<br>", $out);
			$test = explode(".php", $RAW);
			if(sizeof($test) == 1)
			{
				move_uploaded_file($file_tmp,$fdict . "/". $file_name);	
				echo "File Safe Sending.....";
			}
			else
			{
				echo "File Containig Malicious Data Rejected";
			}																					
	    }
	    else
	    {
	       echo $errors[0];
	    }
	}	
?>