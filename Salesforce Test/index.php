<?php
	session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Salesforce Test</title>
<style type="text/css">
	body,html{ font-size:16px; line-height:1.1; margin:0; padding:0; font-family:verdana;}
	*{ box-sizing:border-box; }
	.container { width:1180px; margin:24px auto; }
	label{ min-width:64px;display:inline-block; }
	fieldset{ border-radius:5px;padding:20px ; }
	pre{line-height:1;font-size:14px;}
	table{width:100%;text-align:left;}
</style>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
	<?php
		require_once ('soapclient/SforcePartnerClient.php');
		require_once ('soapclient/SforceEnterpriseClient.php');
		
		//define("USERNAME", "dmparekh007@gmail.com");
  		//define("PASSWORD", "Apollo007");
  		//define("SECURITY_TOKEN", "WoyB0DRSHLOesYQG23PMY7xv");
		
		define("USERNAME", "o.mund@turtle-box.de");
  		define("PASSWORD", "Turtleorange1!");
  		define("SECURITY_TOKEN", "f80rEWCCDzHunVCiiWNDayCKM");
		try{
			
			$mySforceConnection = new SforceEnterpriseClient();
			$mySoapClient = $mySforceConnection->createConnection('soapclient/enterprise.wsdl.xml');
			//echo "Connection<pre>"; print_r($mySforceConnection); echo "</pre>";
			
			// Connection
			$mylogin = $mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);
			//echo "Login<pre>"; print_r($mylogin); echo "</pre>";
			// Select Statment
			
			$Customer = array();
				$Customer[0] = new stdclass();
     	          $Customer[0]->Customer_Name__c = 'Tusal';
          	     $Customer[0]->Customer_Email__c = 'Tusal304@gmail.com';
			
			/**** Master-Deatil Relation Inserts ****/
			/*echo "<pre>";
			$query = "SELECT ID , Customer_Name__c FROM CustomerMaster__c WHERE Customer_Name__c='".$Customer[0]->Customer_Name__c."'";
			$response = $mySforceConnection->query($query);
			echo "SELECT STATEMENT <br>";
			
			if($response->size != 0){
				echo "Customer Already Existes<br>";
				//print_r($response->records);
				$customerId = $response->records[0]->Id;
				echo "Customer Id : ".$customerId."<br>";
			}else{
				echo 'Customer Not Found<br>';
				$customerInsert = $mySforceConnection->create($Customer, 'CustomerMaster__c');
				if(isset($customerInsert[0]->success)){
					//echo "<pre>"; print_r($customerInsert); echo "</pre>";
					$customerId =$customerInsert[0]->id;
					echo "Customer Inserted<br>";
				}else{
					$flagCustomer= false;	
				}
			}
			$Order = array();
			
				$Order[0] = new stdclass();
				$Order[0]->CustomerId__c = $customerId;
				$Order[0]->OrderTotal__c = '2500.00';
			$orderInsert = $mySforceConnection->create($Order,'OrderMaster__c');
			echo "Order Insert Statement<br>";
			print_r($orderInsert);*/
		
		
			/**** Look-Up Relation Inserts ****/
			/*$Product = array();
			$Product[0] = new stdclass();
			if(isset($orderInsert[0]) && $orderInsert[0]->success==1){
				$Product[0]->OrderId__c = $orderInsert[0]->id;
				$Product[0]->ProductName__c = 'Product 1';
				$Product[0]->PurchaseAmount__c = '2000.00';
				$Product[0]->Tax__c = '500.00';
				$ProductInsert = $mySforceConnection->create($Product,'OrderDetail__c');
				echo "Order Insert<br>";
				print_r($ProductInsert);
			}*/
			$query = "SELECT Id, FirstName, LastName, Phone from Contact";
               $response = $mySforceConnection->query($query);
			echo '<pre>';
			//print_r( $response );
			echo '</pre>';
			echo "Turtalbox Testing <br><pre>";
			//$qryGetZip = " SELECT ID FROM Zipcode__c";
			$qryGetProd = "SELECT Choose_Your_Product__c  FROM Product__c WHERE Number_of_Boxes__c = 3"; //Choose_Your_Product__c = 'a05b0000007rm9j'";
			//$qryGetProd = 'select id, IsAllDayEvent, Description from Event';
			$rsPro = $mySforceConnection->query($qryGetProd);
			print_r($rsPro->records );
			
			$pid = $rsPro->records[0]->Id;
			
			// GET Product From Warehouse_Products Table
			$ProductName = 'Kleiderbox';
			$qryGetWarProd = " SELECT ID FROM Warehouse_Product__c WHERE Name = '".$ProductName."' ";
			$rsWarPro = $mySforceConnection->query($qryGetWarProd);
			echo 'Ware House Product<br>';
			print_r($rsWarPro->records[0]->Id);
			
			//
		
		}catch(Exeption $e){
			echo "Exception ".$e->faultstring."<br/><br/>\n";
			echo "Last Request:<br/><br/>\n";
			echo $mySforceConnection->getLastRequestHeaders();
			echo "<br/><br/>\n";
			echo $mySforceConnection->getLastRequest();
			echo "<br/><br/>\n";
			echo "Last Response:<br/><br/>\n";
			echo $mySforceConnection->getLastResponseHeaders();
			echo "<br/><br/>\n";
			echo $mySforceConnection->getLastResponse();
		}
		
	
		if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Submit'):
			//echo '<pre>'; print_r($_POST);  echo '</pre>';
		endif;
		
	?>
	<fieldset>
		<legend>Salesforce</legend>
		<form method="post">
			<table>
				<tr>
					<td><label>Name</label></td>
					<td><input type="text" name="txtName" required ></td>
				</tr>
				<tr>
					<td><label>Email</label></td>
					<td><input type="email" name="txtEmail" required ></td>
				</tr>
				<tr>
					<td><label>Date Time</label></td>
					<td><input type="date" name="txtDate" required ></td>
				</tr>
				<tr>
					<td><label>Url</label></td>
					<td><input type="url" name="txtUrl" required ></td>
				</tr>
				<tr>
					<td><label>Amount</label></td>
					<td><input type="number" name="txtAmount" required ></td>
				</tr>
				<tr>
					<td><label>Country</label></td>
					<td>
						<select name="drpCountry" required >
							<option value="india" >India</option>
							<option value="usa" >USA</option>
							<option value="uk" >U.K.</option>
							<option value="japan" >Japan</option>
							<option value="china" >China</option>
							<option value="uae" >U.A.E.</option>
							<option value="russia" >Russia</option>
							<option value="germany" >Germany</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><label></label></td>
					<td><input type="reset"><input type="submit" name="btnSubmit" value="Submit" ></td>
				</tr>
				
			</table>
		</form>
	</fieldset>
</div>

</body>
</html>