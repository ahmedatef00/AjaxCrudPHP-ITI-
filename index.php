<html>
	<head>
		<meta charset="utf-8">
		<title>All  products </title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" type="text/css" href="css/sticky-footer-navbar.css">
	</head>
	<body>
		<div class="jumbotron">
      <div class="container">
				<div class="container">
	        <h1>Cafteria Products</h1>
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Add</button>
				</div>
      </div>
    </div>

		<div class="container box">
			<div class="table-responsive">
				<table id="user_data" class="table table-striped">
					<thead>
						<tr>
							<th width="20%">Image</th>
							<th width="20%">Product Name</th>
							<th width="20%">category</th>
							<th width="10%">Price</th>
							<th width="10%">IsAvailable</th>

							<th width="10%">Edit</th>
							<th width="10%">Delete</th>
							
						</tr>
					</thead>
				</table>
			</div> <!-- class="table-responsive" -->
		</div> <!-- class="container box"-->

		<footer class="footer">
			<div class="container">
				<span class="text-muted">footer .</span>
			</div>
		</footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	</body>
</html>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Product</h4>
				</div>
				<div class="modal-body">
				<label>Enter Product Name</label>
					<input type="text" name="product_name" id="product_name" class="form-control" />
					<br />
					<label>Enter Category</label>
					<input type="category" name="category" id="category" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
					<br />
					<label>Select product Image</label>
					<input type="file" name="product_image" id="user_image" />
					<span id="user_uploaded_image"></span>
					<br />
					<label>Enter Price</label>
					<input type="number" name="price" id="price" class="form-control" />
					<br /><label>Enter Category</label>
					<input type="text" name="ext" id="ext" class="form-control" />
					<br />
				</div>
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript">
	;(function($) {
		$(document).ready(function(){
			$('#add_button').click(function(){
				$('#user_form')[0].reset();
				$('.modal-title').text("Add User");
				$('#action').val("Add");
				$('#operation').val("Add");
				$('#user_uploaded_image').html('');
			});

			var dataTable = $('#user_data').DataTable({
				"processing":true,
				"serverSide":true,
				"order":[],
				"ajax":{
					url:"fetch.php",
					type:"POST"
				},
				"columnDefs":[
					{
						"targets":[0, 3, 4],
						"orderable":false,
					},
				],

			});

			$(document).on('submit', '#user_form', function(event){
				event.preventDefault();
				var firstName = $('#product_name').val();
				var category = $('#category').val();
				var extension = $('#user_image').val().split('.').pop().toLowerCase();
				var password=$('#password').val();
				var price = $('#price').val();
				var ext = $('#ext').val();

				if(extension != '')
				{
					if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
					{
						alert("Invalid Image File");
						$('#user_image').val('');
						return false;
					}
				}
				if(firstName != '' && category != ''&& password != ''&& ext != ''&& price != '')
				{
					$.ajax({
						url:"insert.php",
						method:'POST',
						data:new FormData(this),
						contentType:false,
						processData:false,
						success:function(data)
						{
							alert(data);
							$('#user_form')[0].reset();
							$('#userModal').modal('hide');
							dataTable.ajax.reload();
						}
					});
				}
				else
				{
					alert("Fields are Required");
				}
			});

			$(document).on('click', '.update', function(){
				var user_id = $(this).attr("id");
				$.ajax({
					url:"fetch_single.php",
					method:"POST",
					data:{user_id:user_id},
					dataType:"json",
					success:function(data)
					{
						$('#userModal').modal('show');
						$('#product_name').val(data.product_name);
						$('#category').val(data.category);
						$('.modal-title').text("Edit User");
						$('#user_id').val(user_id);
						$('#user_uploaded_image').html(data.user_image);
						$('#password').val(data.password);
						$('#price').val(data.price);
						$('#ext').val(data.ext);
						$('#action').val("Edit");
						$('#operation').val("Edit");
					}
				})
			});

			$(document).on('click', '.delete', function(){
				var user_id = $(this).attr("id");
				if(confirm("Are you sure you want to delete this?"))
				{
					$.ajax({
						url:"delete.php",
						method:"POST",
						data:{user_id:user_id},
						success:function(data)
						{
							alert(data);
							dataTable.ajax.reload();
						}
					});
				}
				else
				{
					return false;
				}
			});


		});
	})(jQuery);
</script>
