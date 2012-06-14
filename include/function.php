<?php

 function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

function genrandpass() {
	$code="";
	for ($i = 0; $i < 8; $i ++) {
		switch (rand(0, 3)) {
			case 0://numeri
				$code.=rand(0, 9);
			break;
			case 1://maiuscole
				$code.=chr(rand(65, 90));
			break;
			case 2://minuscole
				$code.=chr(rand(97, 122));
			break;
		}
	}
	return $code;
}
?>

