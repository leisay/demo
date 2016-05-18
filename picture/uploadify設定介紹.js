// JavaScript Document
$(function() {
    $("#file_upload").uploadify({
        'auto'     : false,
        'buttonClass' : 'aandd-class',
        'buttonCursor' : 'arrow',
        'buttonImage' : '/uploadify/browse-btn.png',
        'buttonText' : 'BROWSE...',
        'checkExisting' : '/uploadify/check-exists.php',
        'debug'    : true,
        'fileObjName' : 'the_files',
        'fileSizeLimit' : '100KB',
        'fileTypeDesc' : 'Any old file you want...',
        'fileTypeExts' : '*.gif; *.jpg; *.png',
        'formData'      : {'someKey' : 'someValue', 'someOtherKey' : 1},
        'method'   : 'post',
        'multi'    : false,
        'queueSizeLimit' : 1,
        'removeCompleted' : false,
        'removeTimeout' : 10,
        'height'   : 50,
        'width'    : 300,
        'onSelect' : function(file) {
            alert('檔案名稱 ' + file.name + '將要加入上傳佇列');
        },
        'onUploadComplete' : function(file) {
            alert('檔案： ' + file.name + ' 已經上傳完畢');
        },
        'onUploadStart' : function(file) {
            alert('開始上傳檔案 ' + file.name);
        },
        'onUploadSuccess' : function(file, data, response) {
            alert('檔案' + file.name + ' 上傳狀態： ' + response + '其他資訊:' + data);
        },
        'onCancel' : function(file) {
            alert('檔案： ' + file.name + ' 已被取消上傳');
        },
        'onDialogOpen' : function() {
            $('#message_box').html('提示您可以選擇多個檔案');
        },
        'onDialogClose'  : function(queueData) {
            alert(queueData.filesQueued + ' 個檔案會排入佇列。目前共選擇了 ' + queueData.filesSelected + '個檔案。 一共有' + queueData.queueLength + '個檔案在佇列中。');
        },
        'onUploadProgress' : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
            $('#progress').html(totalBytesUploaded + ' bytes 容量上傳完畢。一共有' + totalBytesTotal + ' bytes的容量要上傳.');
        },  
        'onQueueComplete' : function(queueData) {
            alert('總共有' + queueData.uploadsSuccessful + '個檔案成功的被上傳');
        }    
        'swf'      : '/uploadify/uploadify.swf',
        'uploader' : '/uploadify/uploadify.php'
    });
});

