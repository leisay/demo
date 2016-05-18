<HTML>
    <HEAD>
        <TITLE> TALK </TITLE>
          <META HTTP-EQUIV = "Content-Type" CONTENT = "text/html; charset = utf-8">
          <SCRIPT language="JAVASCRIPT"> 
          
          function check_data()
          {
          if(document.myForm.author.value.length === 0)
          {
              alert("No Empty");
              return false;
              
          }
          
          if(document.myForm.content.value.length === 0)
          {
              alert("Content No Empty");
              return false;
          }
            myForm.submit();
          }
          </script>
    </HEAD>
    <BODY>
        <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
        $id =@ $_GET["id"];
        $link = mysqli_connect("localhost", "user", "pass", "user");
        if(!$link)
        {
            die("Connect Fail");
        }
        $sql = "SELECT * FROM message WHERE id ='$id'";
        mysqli_query("SET NAMES 'utf8'");
            $result = mysqli_query($link, $sql);
            if(!$result)
            {
                die("SQL fail");
            }
            
            echo 'TALK';
            
            while($row = mysqli_fetch_assoc($result));
            {
                echo "author:" .$row["author"]."";
                echo "Time:".$row["date"]."";
                echo $row["content"];
            }
            
            mysqli_free_result($result);
            $sql = "SELECT *FROM reply_message Where reply_id = $id";
            
            if(!$result)
            {
                die("SQL Fail");
                
            }
            
            if(mysqli_num_rows($result)<>0)
                {
                echo 'reply content';
                
                
                while($row = mysqli_fetch_assoc($result))
                {
                   echo "author:" .$row["author"]."";
                echo "Time:".$row["date"]."";
                echo $row["content"];  
                    
                }
                
                }
                
                mysqli_free_result($result);
                mysqli_close($link);
        ?>
        
        <FORM name="myForm" method="POST" action="post_reply.php">
            
            <INPUT type="hidden" name="reply_id" value="<? = $id ?>">
            
            ENTER
            
            </BR>
            author 
            <INPUT name="author" type="text" size="50">
            </BR>
            Content
            <TEXTAREA name="content" cols="50" rows="10" ></TEXTAREA>
            </BR>
            
            <input type="button" value="PO" onclick="check_data()">
           <input type="reset" value="reset">
            
        </FORM>
    </BODY>
</HTML>



