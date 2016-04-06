<?php
	$s = new SaeStorage();
ob_start();
readfile("http://img.baidu.com/img/baike/logo-baike.png");
$img = ob_get_contents();
	ob_end_clean();
	$size = strlen($img);
file_put_contents(SAE_TMP_PATH .'/bd.jpg' , $img );
 
	if( $s->upload( "4wp" , "test.jpg" ,SAE_TMP_PATH .'/bd.jpg') ){
	    echo "上传成功";
	}else{
	    echo "上传失败";
	}