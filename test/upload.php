<?php
require_once 'init.php';
$data['post']=$_POST;
$data['files']=$_FILES;
//for db insertion of file
$pname = rand(1000,10000)."-".$_FILES["file"]["name"];
$tname = $_FILES["file"]["tmp_name"];
$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];
$filename=$_FILES['file']['name'];

$actual_link = "http://$_SERVER[HTTP_HOST]"; // to get the server url for storing in the table

if (($file_type == 'image/jpg') || ($file_type == 'image/jpeg') || ($file_type == 'image/png')){
      $location = $actual_link.'/test/uploads/images/'.$filename;
}
else if (($file_type == 'video/mp4') || ($file_type == 'video/avi') || ($file_type == 'video/gif')|| ($file_type == 'video/mov')){
      $location = $actual_link.'/test/uploads/video/'.$filename;
}
      $sql= " INSERT into fileuploads (file,size,type,loc) values ( '$pname','$file_size','$file_type','$location') ";
    if (mysqli_query($conn,$sql)){
          echo "File Successfully uploaded!". "\n";
          echo $location ."\n";
    }
    else {
    echo "Error";
    }
    // for moving files into respective folders

   $imgpath = 'uploads\images';
   $ds = DIRECTORY_SEPARATOR;
   $tname = $_FILES["file"]["tmp_name"];
   $vidpath = 'uploads\video';
   $vidtargetfolder = dirname( __FILE__) . $ds . $vidpath .$ds;
   $imgtargetfolder = dirname( __FILE__) . $ds . $imgpath .$ds;
  // to validate the image extensions and to move images to image folder
  
   if (($_FILES["file"]["type"] == "image/png") 
            || ($_FILES["file"]["type"] == "image/jpg") 
            || ($_FILES["file"]["type"] == "image/jpeg")) 
         {
                if (file_exists($imgtargetfolder . $_FILES["file"]["name"]))
                {
                echo $_FILES["file"]["name"] . " already exists. "; // checking if the file already exists
                }
              else{
             move_uploaded_file($_FILES["file"]["tmp_name"],
             $imgtargetfolder . $_FILES["file"]["name"]
         );
             echo "Stored in: " . $imgtargetfolder . $_FILES["file"]["name"];
         }}
       //validating video files and moving them to video folder

        else if  (($_FILES["file"]["type"] == "video/mp4") || ($_FILES["file"]["type"] == "video/mov") || 
        ($_FILES["file"]["type"] == "video/avi") || ($_FILES["file"]["type"] == "video/gif")
        ) {                 
                if (file_exists($vidtargetfolder . $_FILES["file"]["name"]))
                {
                echo $_FILES["file"]["name"] . " already exists. ";
                }
            else {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                 $vidtargetfolder . $_FILES["file"]["name"]
             );
             echo "Stored in: " . $vidtargetfolder . $_FILES["file"]["name"];
            }
        }
echo json_encode($data);
?>
