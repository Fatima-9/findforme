 <?php  
 //upload.php  
 $output = '';
 $imgss = '';
 if(is_array($_FILES))  
 {  
      foreach($_FILES['images']['name'] as $name => $value)  
      {  
           $file_name = explode(".", $_FILES['images']['name'][$name]);  
           $allowed_extension = array("jpg", "jpeg", "png", "gif");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = rand() . '.'. $file_name[1];  
                $sourcePath = $_FILES["images"]["tmp_name"][$name];  
                $targetPath = "upload/".$new_name;  
                $imgss .= $new_name . ", ";
                move_uploaded_file($sourcePath, $targetPath);  

                $output .= '<div class="p-3"><img src="' . $targetPath .'" width="182px" height="182px" /></div>';
           }  
      }

      $imgss = rtrim($imgss, ", ");
      echo "<input type='hidden' name='imgs' value='" . $imgss . "'></input>"  . $output;  
 }  
 ?>  