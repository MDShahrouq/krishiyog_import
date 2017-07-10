<html>
<head>
 <link rel="stylesheet" type="text/css" href="autocomplete-Files/styles.css">

</head>
<body>

<?php 
session_start();
if($_SESSION['krishi_login']==1){
}else{
 echo "<script>location='index.php'</script>";	
}
?>

<script type="text/javascript">
    
function set1(){
    document.getElementById("import_remove").value = "Import";
};
    
function set2(){
	document.getElementById("import_remove").value = "Remove";
};


</script>
<a href="logout.php">Logout</a>

<form enctype="multipart/form-data" action="upload.php" method="post" >
  
  <!-- <label style="margin-left:2%" class="form-label span3" for="file">Import Students</label><br><br>
   -->
   <input style="margin-top:2%" type="file" name="file" id="file" required />
   <input name="import_remove" id="import_remove" type="hidden"></input>
  
  
  <br><br>
  <button onClick="set1()" id="imp_btn" class="btn btn-success" style="color:white;background-color:green;width:100px;height:40px" type="submit">
    Import
    </button>

  <button onClick="set2()" id="rem_btn" class="btn btn-success" style="color:white;background-color:green;width:100px;height:40px" type="submit">
    Remove
    </button>

</form>

<?php
  /*echo $_POST['pk_value'];*/
  $url = 'https://krishi-udyog.herokuapp.com/fetch_category_subcategory/';
  $options = array(
    'http' => array(
      'method'  => 'GET',
    ),
  );
  $context = stream_context_create($options);
  $output = file_get_contents($url, false,$context);
  $arr = json_decode($output,true);
  /*echo count($arr);*/
  
?>

<form enctype="multipart/form-data" action="produce.php" method="post" >
  
  <!-- <label style="margin-left:2%" class="form-label span3" for="file">Import Students</label><br><br>
   -->
   <!-- <label>User</label> -->
   <input style="margin-top:2%" type="text" placeholder="Select User" name="search" id="search" required></input><br>
   <input type="text" name="id_field" id="id_field"></input>
   <!-- <label>Sub Category</label> -->
   <br>
   <select name="sub_category" id="sub_category" placeholder="Select Sub Category" required>
    <?php for($i=0;$i<count($arr);$i++){ ?>
     <option disabled="true"><?php echo $arr[$i]['Category']['c_type']; ?></option>
     <?php for($j=0;$i<count($arr[$j]['Sub_categories']);$j++){ ?>
      <?php if($arr[$j]['Sub_categories'][$j]['pk'] != ""){?>
      <option value="<?php echo $arr[$j]['Sub_categories'][$j]['pk']; ?>"><?php echo $arr[$j]['Sub_categories'][$j]['sc_type']; ?></option>
      <?php } ?>
     <?php } ?>
    <?php } ?>
   </select>
   <br>
   <input style="margin-top:2%" type="file" name="file" id="file" required />
  
  
  <br><br>
  <button id="post_produce" class="btn btn-success" style="color:white;background-color:green;width:100px;height:40px" type="submit">
    Post Produce
    </button>

</form>

<?php

session_start();

fopen('autocomplete-Files/users.js', 'w');

$db = pg_connect("host=ec2-50-17-220-223.compute-1.amazonaws.com port=5432 dbname=d78v66su68v3a9 user=rrmuwqbkpwcldy password=d6be3e788e178b0c4e3843d1f8c466f79c277d31cfbfe8b3b0ba7947c5d31177");
 pg_select($db, 'post_log', $_POST);


 $query=pg_query("SELECT id,name FROM userregistration_userregistration WHERE name IS NOT NULL");

/*echo $query;*/

 $json=array();
while ($student = pg_fetch_array($query)) {
    $json[$student["id"]] = $student["name"];
}

$textval = json_encode($json);
$foo = "var peoplenames=" . $textval;

file_put_contents('autocomplete-Files/users.js', $foo);

?>


 

    <!-- AutoSearch Script files don't move -->
     <script type="text/javascript" src="autocomplete-Files/jquery-1.8.2.min.js"></script>
     <script type="text/javascript" src="autocomplete-Files/jquery.mockjax.js"></script>
     <script type="text/javascript" src="autocomplete-Files/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="autocomplete-Files/Logic_Search.js"></script>
        <script type="text/javascript" src="autocomplete-Files/users.js"></script> 


</body>
</html>