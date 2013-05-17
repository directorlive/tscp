<?
include_once('library/Config.php');
include_once("library/checkSession.php");
include_once("library/commonFunctions.php");
include_once("library/constants.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>TSCP</title>
		<link rel="stylesheet" type="text/css" href="css/theme.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.10.2.custom.min.css" />
		<link rel="stylesheet" type="text/css" href="css/demo_table.css" />
        <!--[if IE]>
            <link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
        <![endif]-->
		<script type="text/javascript" src="JS/jquery-1.7.2.min.js" ></script>
        <script type="text/javascript" src="JS/jquery-ui-1.10.2.custom.min.js"></script>  
        <script type="text/javascript" src="JS/jquery.dataTables.js" ></script>
        <script type="text/javascript" src="JS/modal-pop.js" ></script> 
        <script type="text/javascript" src="JS/ajaxHandler.js"></script> 
        <script type="text/javascript" src="JS/ajaxfileupload.js"></script>
        
        <script type="text/javascript" src="JS/main.js" ></script>
       	<script type="text/javascript" src="JS/userManagement.js" ></script>
	</head>
    <body>
    	<form name="mainForm" id="mainForm" action="" method="post" enctype="multipart/form-data">
        <div id="container">
            <div id="header">