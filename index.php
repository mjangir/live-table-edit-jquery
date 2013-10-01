<?php 
$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action']))?$_REQUEST['action']: NULL;
if(empty($action)) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Jquery Ajax Live Table Edit</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>
<body>
<div id="outer_container">
<div id="loader" ><img src="loader.gif"></div>
<div id="data" style="position:relative;">
<?php } ?>

<?php if(empty($action)) {?>
</div>
</div>
</body>
</html>
<?php }

if($action == 'ajax' || $action == 'update' || $action == 'delete') {
	require_once 'database.php';
	$db = new Database;
	function getTable() {
		GLOBAL $db;
		$data = '<button class="delall">Delete Selected</button>
		<form><table width="90%" cellspacing="0" cellpadding="2" align="center" border="0" id="data_tbl">
			<thead>
			  <tr>
			    <th width="5%"><input type="checkbox" class="selall"/></th>
			    <th width="25%">Name</th>
			    <th width="25%">Email</th>
			    <th width="17%">Country</th>
			    <th width="18%">Mobile</th>
				<th width="10%">Action</th>
			  </tr>
			 </thead>
			 <tbody>';
		$i = 1;
		$cls = false;
		foreach ($db->get_users() as $value) {
			$bg = ($cls = !$cls) ? '#ECEEF4' : '#FFFFFF';
			$data .='<tr style="background:'.$bg.'">
			    <td><input type="checkbox" class="selrow" value="'.$value['id'].'"/>
					<input type="hidden" value="'.$value['id'].'" name="id" />
				</td>
			    <td><span class="name">'.$value['name'].' </span></td>
			    <td><span class="email">'.$value['email'].'</span></td>
			    <td><span class="country">'.$value['country'].'</span></td>
			    <td><span class="mobile">'.$value['mobile'].'</span></td>
				<td align="center">
					<img src="edit.png" class="updrow" title="Update"/>&nbsp;
					<img src="delete.png" class="delrow" title="Delete"/>
				</td>
			  </tr>';
			$i++;
		}
		$data .='</tbody>
			</table></form>
			<div id="paginator">'.$db->paginate().'</div>';
		return $data;
	}

	if($action == 'ajax') {
		echo getTable();
	} else if($action == 'delete') {
			$db->delete($_REQUEST['id']);
			echo getTable();
	} else if($action == 'update') {
			unset($_REQUEST['action']);
			$db->update($_REQUEST);
	}
}
?>
