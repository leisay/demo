<?php
$main="
<script type='text/javascript' src='http://code.jquery.com/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='jquery.uploadify-3.1.min.js'></script>
<input type='file' name='file_upload' id='file_upload' />

<link rel='stylesheet' type='text/css' href='uploadify.css' />
	

<script type='text/javascript'>
$(function() {
    $('#file_upload').uploadify({
        'swf'      : 'uploadify.swf',
        'uploader' : 'uploadify.php',
        'onUploadSuccess' : function(file, data, response) {
        if(data == 'Invalid file type.'){
            alert('The file was saved to: ' + data);
        }

        }
        // Put your options here
    });
});
</script>
";
echo "
<!DOCTYPE html>
<html>
<head>
</head>
<body>
$main
</body></html>
";

?>                  