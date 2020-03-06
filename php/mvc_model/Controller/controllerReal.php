<?php 
require_once ('../Controller/controllerAdmin.php');
require_once ('../model/model.php');
require_once ('../block/block.php');

$model = new Model();
$block = new Block($model);
$controller = new controllerAdmin($block);

if(isset($_POST['addRequest'])){
	$block->render_layout_add();
}
if(isset($_POST['addProduct'])){
	$productName = $_POST['productName'];
	$productStatus = $_POST['productStatus'];
	$img = $_FILES['image']['name'];
	$controller->add("product(productName, productStatus, productimg)","'$productName', '$productStatus', '$img'", "admin");
	$controller->displayAll("product", "admin");
}
if(isset($_POST['displayAll'])){
	$controller->displayall("product", "admin");
}

if(isset($_POST['editThis'])){
	$productId = $_POST['productid'];
	$controller->displayedit($productId);
}

if(isset($_POST['saveEdit'])){
	$name = $_POST['newname'];
	$status = $_POST['newstatus'];
	$img = $_FILES['newimage']['name'];
	$editid = $_POST['editid'];

	$controller->saveAfterEdit("product", "productName = '$name', productStatus = '$status', productimg = '$img'", "productID = $editid", "admin");
	$controller->displayAll("product", "admin");
}
if(isset($_POST['deleteThis'])){
	$deleteid = $_POST['productid'];
	$controller->delete( "product", " productID = $deleteid", "admin");
	$controller->displayAll("product", "admin");
}
if(isset($_POST['searchRequest'])){
	$block->render_layout_search();
}

if(isset($_POST['searchProduct'])){
	$searchname = $_POST['namesearch'];
	$result = $controller->search($searchname, "productName", "product", "admin");
	echo "result found :" . $result;
}

if(isset($_POST['displayfrontend'])){
	$controller->display_frontend("product", "admin");
}


?>