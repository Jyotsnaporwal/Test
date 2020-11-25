
<?php
require_once 'init.php';
$query= "SELECT  * FROM fileuploads order by id desc";
$query_run= mysqli_query($conn, $query);
$output = '<table>
<tr>
<th width=10%>Id</th>
<th width=40%>Video</th>
<th width=40%>Location</th>
</tr>
</table>';


if($query_run){
  function ConsoleLog($msg)
  { echo "<script>
    console.log($msg)
    </script>";
  };

while($row = mysqli_fetch_array($query_run)){
  
  if (($row['type'] == "video/mp4") || 
  ($row['type']== "video/mov")||($row['type']== "video/gif")||($row['type'] == "video/avi")){
    $locate=$row['loc'];
    $output .= '<tr>
    <td> '.$row["id"].' </td>
    <td>
    <video width="320" height="240" controls>
   <source src="'.($row['loc']).'" type="'.($row['type']).'">
  </video>
    </td>
    <td><input type="button" onclick="ConsoleLog($locate)" value="Select" /></td>
    <td><a href="'.($row['loc']).'">'.($row['loc']).'</a><br></td>
    </tr>
    ';
}

}
$output .= '</table>';
echo $output;
ConsoleLog("'$locate'");
}
else
{
    echo "No record found";
}

?>
