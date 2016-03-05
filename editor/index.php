<?php
session_start();
//if NOT LOGGED IN! mind the !
if(!isset($_SESSION['user'])) {
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
<body>
  <h1>Login</h1>
<?php
if (isset($_GET['msg'])) {
  echo $_GET['msg'].'<br />';
}
?>
<form action="login.php" method="post">
  <label for="username">Username:</label>
  <input id="username" name="username" type="text">
  <label for="password">Password:</label>
  <input id="password" name="password" type="password">
  <input type="submit" value="Login">
</form>
<p>First time using the software? <a href="reg.php">Create a user</a></p>
</body>
</html>
<?php
exit();
}

if(isset($_GET['file']) && $_GET['file'] != '') {
require_once 'lib/Twig/Autoloader.php';
require 'conn.php';
$template_path = 'templates';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem($template_path);
$twig = new Twig_Environment($loader, array('autoescape' => false));


/*$twig = new Twig_Environment($loader, array(
    'cache' => 'cache',
));*/
$table = preg_replace("/[^A-Za-z0-9]/", '', $_GET['file']);

$sql1 = "SELECT * FROM " . $table;
$result = $conn->query($sql1);  
while($row = mysqli_fetch_array($result)){
    $tag[] = $row['elementId'];
    $content[] = $row['content'];
}
$data = array_combine($tag, $content);
if (isset($_GET['editable'])) {
$edit = 'editable';
$content_editable = 'contenteditable="true"';
$large_editor = 'large-text';
$path ='';
$editable_image = "featherlight-img";
$editor_head = '<!--editor head-->
<link href="globaljs/featherlight.min.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="globaljs/quill.snow.css">
<link rel="stylesheet" href="globaljs/editor.css">
<style>
#toolbar {
  border-bottom: 1px solid #ccc;
}
#editor { 
  height: 300px;
}
#lightbox-editor {
  border: 1px solid #ccc;
}
</style>
<!--end editor head-->';
$editor_scripts = '<!--editor-->
<!-- editor buttons -->
<section class="editor-buttons">
<input type="text" placeholder="File Name" id="file" onkeydown="if (event.keyCode == 13) { document.getElementById(\'edits\').click(); }"> <button id="edits" onclick="window.location.href = \'index.php?file=\' + document.getElementById(\'file\').value + \'&editable\';" style="cursor:pointer">Change file</button>
    <div style="cursor:pointer" onclick="save();" class="editor-button raised blue">
      <div style="text-align: center;" fit>SAVE</div>
    </div>
    
    <div style="cursor:pointer" onclick="publish();" class="editor-button raised green">
      <div style="text-align: center;" fit>PUBLISH</div>
    </div>
</section>
<!--quill editor-->
<div style="display: none;" class="editor-largetext" id="lightbox-editor">
<input id="text-id" type="hidden">
<div id="toolbar" class="toolbar">
<span class="ql-format-group">
<span title="Bold" class="ql-format-button ql-bold"></span>
<span class="ql-format-separator"></span>
<span title="Italic" class="ql-format-button ql-italic"></span>
<span class="ql-format-separator"></span>
<span title="Underline" class="ql-format-button ql-underline"></span>
<span class="ql-format-separator"></span>
<span title="Strikethrough" class="ql-format-button ql-strike"></span>
</span>
<span class="ql-format-group">
<select title="Text Color" class="ql-color">
<option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)" selected=""></option>
<option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
<option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
<option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
<option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
<option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
<option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
<option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)"></option>
<option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
<option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
<option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
<option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
<option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
<option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
 <option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
<option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
<option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
<option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
<option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
<option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
<option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
<option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
<option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
<option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
<option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
<option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
<option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
<option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
<option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
<option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
<option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
<option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
<option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
<option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
<option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
</select>
<span class="ql-format-separator"></span>
<select title="Background Color" class="ql-background">
<option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)"></option>
<option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
<option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
<option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
<option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
<option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
<option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
<option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)" selected=""></option>
<option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
<option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
<option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
<option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
<option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
<option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
<option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
<option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
<option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
<option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
<option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
<option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
<option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
<option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
<option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
<option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
<option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
<option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
<option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
<option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
<option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
<option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
<option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
<option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
<option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
<option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
<option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
</select>
</span>
<span class="ql-format-group">
<span title="List" class="ql-format-button ql-list"></span>
<span class="ql-format-separator"></span>
<span title="Bullet" class="ql-format-button ql-bullet"></span>
<span class="ql-format-separator"></span>
<select title="Text Alignment" class="ql-align">
<option value="left" label="Left" selected=""></option>
<option value="center" label="Center"></option>
<option value="right" label="Right"></option>
<option value="justify" label="Justify"></option>
</select>
</span>
</div>
    <div id="editor">
      <p>Hello World!</p>
      <p>This is just some sample text you can <b>delete</b>.</p>
</div>
<button style="margin: 5px;" onclick="textSave()">Update</button>
</div>
<script src="globaljs/quill.min.js"></script>
<script src="globaljs/jquery-2.1.4.min.js"></script>
<script src="globaljs/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
function pageSwitch() {
    
}
function save() {
var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      alert(xhttp.responseText);
    }
  };
  xhttp.open("POST", "save.php?file='.$_GET['file'].'", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var query = \'\';
  var elements = document.getElementsByClassName("editable");
  for (var i = 0; i < elements.length; i++) {
    var combinator = elements[i].id + \'=\' + encodeURIComponent(document.getElementById(elements[i].id).innerHTML);
    if (query == \'\') {
    	query = combinator;
    } else {
    	query += \'&\' + combinator;
    }
  }
  var images = document.getElementsByClassName("featherlight-img");
  for (var i = 0; i < images.length; i++) {
    var combinator = images[i].id + \'=\' + encodeURIComponent(document.getElementById(images[i].id).src);
    if (query == \'\') {
    	query = combinator;
    } else {
    	query += \'&\' + combinator;
    }
  }
  xhttp.send(query);
}
function publish() {
    save();
var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      alert(xhttp.responseText);
    }
  };
  xhttp.open("POST", "index.php?file='.$_GET['file'].'", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var query = \'\';
  xhttp.send(query);
}
var current;
var editor;
function textSave(id) {
document.getElementById(document.querySelector(\'.featherlight-inner #text-id\').value).innerHTML = editor.getHTML();
current.close();
}
$(\'.large-text\').featherlight(\'#lightbox-editor\', {
	beforeOpen: function(event){
        document.getElementById(\'editor\').innerHTML = document.getElementById(this.$currentTarget[0].id).innerHTML;
        document.getElementById(\'text-id\').value = this.$currentTarget[0].id;
	},
    afterContent: function(event){
        $(\'.featherlight-inner\').show();
        editor = new Quill(document.querySelector(\'.featherlight-inner #editor\'), {
        modules: {
            \'toolbar\': { container: document.querySelector(\'.featherlight-inner #toolbar\') },
            \'link-tooltip\': true
        },
            theme: \'snow\',
        });
        current = $.featherlight.current();
    }, closeOnClick: false
});
</script>
<!-- image editor -->
<div style="display: none;" class="editor-tools-box" id="lightbox"><h3>Image Source</h3><input id="imgid" type="hidden"><input style="width: 100%" id="img-input" type="text" value="Hello"><button onclick="imageSave();">Update</button></div>
<script type="text/javascript">
$(\'.featherlight-img\').featherlight(\'#lightbox\', {
	beforeOpen: function(event){
        document.getElementById(\'img-input\').value = document.getElementById(this.$currentTarget[0].id).src;
        document.getElementById(\'imgid\').value = this.$currentTarget[0].id;
	},
	afterContent: function(event){
		$(\'.featherlight-inner\').show();
        current = $.featherlight.current();
	}
});
function imageSave(){
	document.getElementById(document.querySelector(\'.featherlight-inner #imgid\').value).src = document.querySelector(\'.featherlight-inner #img-input\').value;
    current.close();
}
</script>';
$template = $twig->loadTemplate($_GET['file']);
echo $template->render(array('data' => $data, 'editable' => $edit, 'path' => $path, 'editor_scripts' => $editor_scripts, 'editor_head' => $editor_head, 'large_editor' => $large_editor, 'editable_image' => $editable_image, 'content_editable' => $content_editable));
}
else {
    $path = 'editor/';
    $edit = $large_editor = $editor_head = $editor_scripts = $editable_image = $content_editable = '';
$template = $twig->loadTemplate($_GET['file']);
$file = $template->render(array('data' => $data, 'editable' => $edit, 'path' => $path, 'editor_scripts' => $editor_scripts, 'editor_head' => $editor_head, 'large_editor' => $large_editor, 'editable_image' => $editable_image, 'content_editable' => $content_editable));
$myfile = fopen("../".$_GET['file'], "w") or die("Unable to open file!");
fwrite($myfile, $file);
fclose($myfile);
echo 'Succesfully Published @ '.$_GET['file'];
}
} else {
//LOGGED IN!, probably should change this to an if
if (isset($_GET['msg'])) {
  echo $_GET['msg'].'<br />';
}
echo 'You are logged in as: '.$_SESSION['user'].'<br />';
?>
<input id="file" type="text" placeholder="File Name" onkeydown="if (event.keyCode == 13) { document.getElementById('edits').click(); }"> <button id="edits" onclick="window.location.href = 'index.php?file=' + document.getElementById('file').value + '&editable';">Edit file</button><br /><a href="logout.php">Log Out</a> <a href="reg.php">Add a User</a>
<?php
}
?>