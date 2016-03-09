<?php
	$html_attr = array(
					//'before_label' =>'<div class="col-sm-3">',
					//'after_label' => '</div>',
					'before_control' =>'<div class="">',
					'after_control' => '</div><div class="clear"></div>',
				);
?>

<div class="container margin-top-lg" ng-app="sync" ng-controller="home">
	<?php echo $this->Form->Open('','POST','frmUser'); ?>
	<table class="table ">
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Action</th>
		</tr>
		<tr ng-repeat="x in users">
			<td>{{ x.id }}</td>
			<td>{{ x.name }}</td>
			<td>{{ x.email }}</td>
			<td>{{ x.phone }}</td>
			<td>
				<a href="javascript:" class="btn btn-small btn-info"><i class="glyphicon glyphicon-edit" ng-click="updateUser(x.id)"></i></a> 
				<?php /*?><a href="javascript:" class="btn btn-small btn-danger"><i class="glyphicon glyphicon-trash"></i></a><?php */?>
			</td>
		</tr>
		<tr>
			<td><input type="text" id="id" name="id"  value="" class="form-control" placeholder="User Id" ng-model="form.id"></td>
			<td><?php echo $this->Form->Input('text','name',false,'','',array('placeholder'=>'Enter Name','ng-model'=>'form.name'),$html_attr); ?></td>
			<td><?php echo $this->Form->Input('text','email',false,'','',array('placeholder'=>'Enter Email','ng-model'=>'form.email'),$html_attr); ?></td>
			<td><?php echo $this->Form->Input('text','phone',false,'','',array('placeholder'=>'Enter Phone','ng-model'=>'form.phone'),$html_attr); ?></td>
			<td><button type="button" class="btn btn-primary btn-block" ng-click="submitForm();">Submit</button></td>
		</tr>
	</table>
	<div class="text-right margin-top-md">
		<?php /*?><button class="btn btn-info" data-toggle="modal" data-target="#UserModal">Add User</button><?php */?>
	</div>
	<?php echo $this->Form->Close(); ?>
	
</div>

<?php /*?><div id="UserModal" class="modal fade" tabindex="-1" role="dialog">
	<?php echo $this->Form->Open(); ?>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add/Update User</h4>
			</div>
			<div class="modal-body">
				<?php
					echo $this->Form->Input('text','name',false,'','Name',array('placeholder'=>'Enter Name','ng-model'=>'form'),$html_attr);
					echo $this->Form->Input('email','email',false,'','Email',array('placeholder'=>'Enter email'),$html_attr);
					echo $this->Form->Input('tel','phone',false,'','Phone',array('placeholder'=>'Enter phone'),$html_attr);
				?>
				<div class="clear"></div>
			</div>
			<div class="modal-footer">
				<input type="hidden" id="id" name="id" value="">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
		<!-- /.modal-content --> 
	</div>
	<?php echo $this->Form->Close(); ?>
	<!-- /.modal-dialog --> 
</div><?php */?>
<!-- /.modal -->
<?php
$this->Template->setCallback(function(){
?>
	<script type="text/javascript">
		angular.module('sync',[]).controller('home',function($scope,$http){
			$scope.form = new Object();
			//var wsUri = "ws://localhost:9000/work/test/chat/websocket-example/server.php"; 	
			var wsUri = "ws://localhost:9000/work/test/sync/api/socket.php"
			websocket = new WebSocket(wsUri); 
			
			
			websocket.onopen = function(ev) { // connection is open 
				console.log('websocket Open');
			}
			websocket.onerror	= function(ev){ 
				console.log('on Error'); 
			}; 
			websocket.onclose 	= function(ev){ 
				console.log('on Close'); 
			}; 
			websocket.onmessage = function(ev) {
				console.log('On Message');
				console.log(ev.data);
				var msg = {
					message: 'Hey !',
					name: 'Dumbler',
					color:'#00sa45'
				}
				//websocket.send(JSON.stringify(msg));
			}
			$scope.users = [ ];

			// init 
			
			$scope.updateUserList = function(){
				$http.post(api_url+'getuser/',{key:'1'})
					.success(function(data){
						if(data.status != 200){ alert(data.message); return false; }
						$scope.users = data.payload;
					});
			}
			
			$scope.submitForm = function(){
				/*$http.post(api_url+'addupdateuser/',$scope.form)
					.success(function(data){
						if(data.status != 200){ alert(data.message); return false; }
						$scope.users = data.payload;
					});
				*/
				var msg = {
					message: $scope.form.email,
					name: $scope.form.name,
					color:'#000'
				}
				websocket.send(JSON.stringify(msg));
				$scope.updateUserList();
				
			}
			
			$scope.updateUser = function(id){
				$scope.form.id = id;
			}
			$scope.updateUserList();
		});
		
	</script>
<?php	
});
?>
