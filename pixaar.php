<?php

	include('ChromePhp.php');
	const IMG_DIR_PATH = 'pixaar/img/';

	
	$mode 			= (isset($_POST['mode'])) ? $_POST['mode'] : 'bw';   // bwpixel, blr, bwblr, clrpix, bw

	if(isset($_POST['src'])){
		$thisURL = $_POST['src'];
	}else{
		return;
	}
	$picName        = basename($thisURL); // gives myPic.jpg
	$picDir         = dirname($thisURL);  // gives img
	list($fileName,$extension) = explode('.',$picName);
	switch($mode){
		case 'clrpix':
			$modesuffix = "_clrpix";
			break;
		case 'bwpix':
			$modesuffix = "_bwpix";
			break;
		case 'bwblr':
			$modesuffix = "_bwblr";
			break;
		case 'bwblrx':
			$modesuffix = "_bwblrx";
			break;
		case 'clrblr':
			$modesuffix = "_clrblr";
			break;
		case 'bw':
			$modesuffix = "_bw";
			break;
		default:
			$modesuffix = "_bw";
			break;
	}
	$newFileName    = $fileName . $modesuffix . "." . $extension;  // ok
	$pathToPHPFile  = dirname(__FILE__);
	$arrayToPHPFile = explode('/', $pathToPHPFile);
	array_pop($arrayToPHPFile);
	array_pop($arrayToPHPFile);
	array_pop($arrayToPHPFile);
	$dynPathToDomain= implode('/', $arrayToPHPFile) . '/';
	$dirPath     = $dynPathToDomain . IMG_DIR_PATH; 
	$newFilePath    = $dirPath . $newFileName; 

	if(!file_exists($newFilePath)){
		$oldFilePath  = $dirPath . $picName;  // ok
		$picSize      = getimagesize($oldFilePath);
		$picWidth     = $picSize[0]; //ok
		$picHeight    = $picSize[1];  //ok
		$copyResource = imagecreatetruecolor($picHeight, $picWidth);
		$origResource = imagecreatefromjpeg($oldFilePath); // is resource
		switch($mode){
			case 'clrpix':
				imagejpeg($origResource, $newFilePath, 01);
				break;
			case 'bwpix':
				imagefilter($origResource, IMG_FILTER_GRAYSCALE);
				imagejpeg($origResource, $newFilePath, 01);
				break;
			case 'bwblr':
				imagefilter($origResource, IMG_FILTER_GRAYSCALE);
				for ($x=1; $x<=10; $x++){
					imagefilter($origResource, IMG_FILTER_GAUSSIAN_BLUR);
				}
				imagejpeg($origResource, $newFilePath, 60);
				break;
			case 'bwblrx':
				imagefilter($origResource, IMG_FILTER_GRAYSCALE);
				for ($x=1; $x<=25; $x++){
					imagefilter($origResource, IMG_FILTER_GAUSSIAN_BLUR);
				}
				imagejpeg($origResource, $newFilePath, 01);
				break;
			case 'clrblr':
				for ($x=1; $x<=10; $x++){
					imagefilter($origResource, IMG_FILTER_GAUSSIAN_BLUR);
				}
				imagejpeg($origResource, $newFilePath, 60);
				break;
			case 'bw':
				imagefilter($origResource, IMG_FILTER_GRAYSCALE);
				imagejpeg($origResource, $newFilePath, 60);
				break;
		}
	}
	
	$URLstart = strpos($newFilePath,'/pixaar/');
	$returnURL = substr($newFilePath, $URLstart);
	echo($returnURL);
	// function get_host() {
	//     if ($host = $_SERVER['HTTP_X_FORWARDED_HOST'])
	//     {
	//         $elements = explode(',', $host);

	//         $host = trim(end($elements));
	//     }
	//     else
	//     {
	//         if (!$host = $_SERVER['HTTP_HOST'])
	//         {
	//             if (!$host = $_SERVER['SERVER_NAME'])
	//             {
	//                 $host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
	//             }
	//         }
	//     }
	    // Remove port number from host
	    // $host = preg_replace('/:\d+$/', '', $host);
	    // return trim($host);
	// }
?>
	