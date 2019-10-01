<html>
<head>
<title>Upload Image</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
 <body>
  <div id="content" class="container" style="margin-top:10px;height:100%;">
		<center><h1>Image Upload Using Imgur API</h1></center>
   
		<form action="index.php" enctype="multipart/form-data" method="POST">
		<div class="form-group">
			<label for="image">Select Image:</label>
			<input name="img" size="35" type="file"  class="form-control" required /><br/>
		</div>
		<div class="form-group">
			<label for="file">Width:</label>
			<input type="number" name="width" size="20"  class="form-control" required />
		</div>
		<div class="form-group">
			<label>Height:</label>
			<input type="number" name="height" size="20" class="form-control" required />
		</div>
		<input type="submit" name="submit" value="Upload" class=" btn btn-success" />
   </form>
   <?php
   if(isset($_POST['submit'])){
    $img=$_FILES['img'];
    if($img['name']==''){
     echo "<h2>An Image Please.</h2>";
    }else{
     $filename = $img['tmp_name'];
     $client_id="0d93f7697b9922d";//Your Client ID here
     $handle = fopen($filename, "r");
     $data = fread($handle, filesize($filename));
     $pvars   = array('image' => base64_encode($data));
     $timeout = 30;
     $curl    = curl_init();
     curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
     curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
     curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
     curl_setopt($curl, CURLOPT_POST, 1);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
     $out = curl_exec($curl);
     curl_close ($curl);
     $pms = json_decode($out,true);
     $url=$pms['data']['link'];
     if($url!=""){
      echo "<h2>Uploaded Without Any Problem</h2>";
      echo "<img src='$url'/>";
     }else{
      echo "<h2>There's a Problem</h2>";
      echo $pms['data']['error']['message'];
     }
    }
   }
   ?>
  </div>
  <style>
  input{
   border:none;
   padding:8px;
  }
  </style>
 </body>
</html>
