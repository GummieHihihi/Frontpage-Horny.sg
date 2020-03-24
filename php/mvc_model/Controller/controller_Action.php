<?php 
require_once ('../Controller/controllerAdmin.php');
require_once ('../model/model.php');
require_once ('../block/block.php');

/**
 * 
 */
class controllerAction
{
	public $model;
	public $block;
	public $controller;
	public $dbname;
	function __construct($model, $block,$controller,$dbname){
		$this->model = $model;
		$this->block = $block;
		$this->controller = $controller;
		$this->dbname = $dbname;
	}

	function actionhandler($action){
		if($action =='addrequest' || $action == 'editrequest'){
			$productId = $_POST['id'];
			$this->controller->displayedit($productId);
		}
		else if($action =='add' || $action =='editthis'){
			$editid = $_POST['id'];
			$productName = $_POST['productName'];
			$productStatus = $_POST['productStatus'];
			$imagename = $_POST['image'];
			// truong hop id khac rong, chi edit
			if($editid!=""){
				$this->controller->addoredit("product", "productName = '$productName', productStatus = '$productStatus', productimg = '$imagename'", "productID = $editid", $this->dbname);
				$return_arr = array();
				$return_arr[] = array("id" => $editid,
					"name" => $productName,
					"price" => $productStatus,
					"image" => $imagename);
				echo json_encode($return_arr);
			}
			// truong hop id = rong, tuc la add
			else if($editid == ""){
				$this->controller->addoredit("product(productName, productStatus, productimg)","'$productName', '$productStatus', '$imagename'","",$this->dbname);
				$return_arr = array();
				$select = $this->controller->selectlatest("product","productID",$this->dbname);
				while($row = mysqli_fetch_array($select)){
						//ve dau la ten cua array, ve sau la ten bien truyen vao
					$id = $row['productID'];
					$name = $row['productName'];
					$price = $row['productStatus'];
					$image = $row['productimg'];

					$return_arr[] = array("id" => $id,
						"name" => $name,
						"price" => $price,
						"image" => $image);
				}
				echo json_encode($return_arr);
			}
		}

		else if($action =='display'){
			$this->controller->displayall("product", $this->dbname);
		}
		else if ($action =='delete'){
			$deleteid = $_POST['id'];
			$this->controller->delete( "product", " productID = $deleteid", $this->dbname);
			$this->controller->displayAll("product", $this->dbname);
		}
		else if($action=='displayFrontend'){
			if(isset($_POST['displayFrontend'])){
				$this->controller->display_frontend("product", $this->dbname);
			}
			else{
				echo "not right";
			}
		}
	}
}

?>