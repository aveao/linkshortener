<?php
$useget = !empty($_GET);
$usepost = !empty($_POST);
$password = "test";

if ($useget == FALSE && $usepost == FALSE)
{
    echo "You didn't use get nor post. I bet you'd use get, tip: pass, link and alias (alias is optional)";
    exit();
}
else if ($useget == TRUE && $usepost == TRUE)
{
    echo "Both GET and POST received, fail.";
    exit();
}
else if ($useget)
{
    $touse = $_GET;
}
else if ($usepost)
{
    $touse = $_POST;
}

if ($password == "test")
{
    echo "You can't use admin panel until you change the password. Open the admin.php to do it.";
    exit();
}

if (htmlspecialchars($touse["pass"]) == $password)
{
    if (!array_key_exists("alias", $touse) || ($touse["alias"]) == "" || ($touse["alias"]) == " " || ($touse["alias"]) == "-")
    {
        $alias = generateRandomString(3);
    }
    else
    {
        $alias = htmlspecialchars($touse["alias"]);
    }
    
    $alias = str_replace(array(".", ",", "/", "\\", "?", ":", "*", "\"", "<", ">", "|"), "", $alias); //escapes stuff thay shouldn't be used. dot is to cover our app from being abused if our admin pass gets stolen, comma is just in case, rest are actually banned to be used in file names
    
    if (!file_exists($alias)) {
    mkdir($alias, 0777, true);
    }
    
    $myfile = fopen("./" . $alias . "/index.php", "w") or die("error");
    if ($myfile == "error")
    {
        echo "Something is broken when trying to create a file.";
    }
    else
    {
        fwrite($myfile, "<?php header(\"Location: " . htmlspecialchars($touse["link"]) . "\"); ?>");
        fclose($myfile);
        echo "Created, alias is " . "<a href=\"" . $alias . "/index.php\">" . $alias . "</a>";
    }
}
else
{
    echo "<img src=\"http://oi62.tinypic.com/8yhxtu.jpg\" alt=\"nice hack bro.\" style=\"width:507px;height:264px;\">";
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz'; //ABCDEFGHIJKLMNOPQRSTUVWXYZ
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
