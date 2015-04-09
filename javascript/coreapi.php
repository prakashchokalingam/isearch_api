<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($_POST['type']=="authenticate")
{
    $auth_id=$_POST['auth_id'];
    $secret_id=$_POST['secret_id'];
    
function authentication($auth_id,$secret_id)
{
    include 'connection.php';
    $sql=mysqli_query($con,"SELECT secretid FROM apiusers WHERE appid='$auth_id'");
    while($row=  mysqli_fetch_array($sql))
    {
        $checkid=$row['secretid'];
    }
    if($checkid==$secret_id)
    {
        $auth_token=uniqid();
        $sql=mysqli_query($con,"UPDATE apiusers SET auth_token='$auth_token' WHERE appid='$auth_id'");
        echo '{"auth_token":"'.$auth_token.'"}';
        
    }
    else
    {
        echo '{"error":"Check your input parameters !"}';
    }
    
    
}
authentication($auth_id, $secret_id);
}
if($_POST['type']=="keywordsearch")
{
    function keywordsearch($auth_token,$keyword,$limit)
    {
         include 'connection.php';
         $results=array();
         $count=0;
         $checksql=  mysqli_query($con,"SELECT appid FROM apiuser WHERE auth_token='$auth_token'");
         if(mysqli_affected_rows($con)==0)
         {
             
         }
         else
         {
             $sql=mysqli_query($con,"SELECT imagepath FROM feedcontainer  WHERE category LIKE '%$keyword' OR tags LIKE'%$keyword' LIMIT $limit");

    while($row=  mysqli_fetch_array($sql))
    {
        $results[$count]=$row['imagepath'];
        $count++;
    }
    echo json_encode($results);
         }
    
    }
}
if($_POST['type']=="pathsearch")
{
    echo "File not found";
}
if($_POST['type']=="upload")
{
    echo "Cant Upload write name";
    
}
if($_POST['type']=="delete")
{
    echo 'Deleted Successfully';
}
