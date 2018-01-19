<?php
if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$sourcePath = $_FILES['userImage']['tmp_name'];
$targetPath = "../../img/location_map_pic/".$_FILES['userImage']['name'];
$imagePath  = "img/location_map_pic/".$_FILES['userImage']['name'];


if(move_uploaded_file($sourcePath,$targetPath)) {
?>
<img src="<?php echo $imagePath; ?>" width="150px" height="150px" class="upload-preview" />
<?php
}
}
}
?>