<?php 
       include "../../includes/dbconnect.php";
      include "../../includes/functions.php";
     
      session_start();



      if(isset($_POST['save_bug'])){
        $bug_title = $_POST['bug_title'] ?? '';
        $bug_text = $_POST['bug_text'] ?? '';
        
        $bug_priority = (isset($_POST['bug_priority']) && $_POST['bug_priority'] != 0) ? $_POST['bug_priority'] : 'low';
        $bug_status = (isset($_POST['bug_status']) && $_POST['bug_status'] != 0) ? $_POST['bug_status'] : 'new';
        
        $is_fixed = 0;
    
        // Použitie pripraveného SQL dotazu na bezpečné vloženie
        $save_bug = "INSERT INTO bugs (bug_title, bug_text, priority, status, is_fixed, added_date) 
                     VALUES (?, ?, ?, ?, ?, now())";
        
        $stmt = mysqli_prepare($link, $save_bug);
        mysqli_stmt_bind_param($stmt, "ssssi", $bug_title, $bug_text, $bug_priority, $bug_status, $is_fixed);
        mysqli_stmt_execute($stmt);
        
        // Získanie posledného ID bezpečne
        $max_id = mysqli_insert_id($link);
    
        // Logovanie do app_log
        $diary_text = "Minecraft IS: Bol zaznamenaný nový bug s ID $max_id";
        $log_sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, now())";
        
        $log_stmt = mysqli_prepare($link, $log_sql);
        mysqli_stmt_bind_param($log_stmt, "s", $diary_text);
        mysqli_stmt_execute($log_stmt);
    }


      if(isset($_POST['see_bug_details'])){
        $bug_id = $_POST['bug_id'];
        $_SESSION['bug_id']=$bug_id;
        $_SESSION['is_fixed']=$is_fixed;
        header("location:bug.php");
      }

      if (isset($_POST['bug_remove'])) {
        $bug_id = intval($_POST['bug_id']); // Ošetrenie vstupu
    
        if ($bug_id > 0) {
            // Spustiť transakciu
            mysqli_begin_transaction($link);
    
            try {
                // Odstrániť bug
                $remove_bug = "DELETE FROM bugs WHERE bug_id=?";
                $stmt = mysqli_prepare($link, $remove_bug);
                mysqli_stmt_bind_param($stmt, "i", $bug_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
                // Odstrániť komentáre k bugom
                $delete_comments = "DELETE FROM bugs_comments WHERE bug_id=?";
                $stmt = mysqli_prepare($link, $delete_comments);
                mysqli_stmt_bind_param($stmt, "i", $bug_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
                // Logovanie do denníka
                $diary_text = "Minecraft IS: Bol vymazaný bug s ID $bug_id";
                $sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, NOW())";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "s", $diary_text);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
                // Commit transakcie
                mysqli_commit($link);
    
            } catch (Exception $e) {
                mysqli_rollback($link); // Ak niečo zlyhá, vráti zmeny späť
                die("MySQLi ERROR: " . mysqli_error($link));
            }
        }
    }
    

?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link rel="stylesheet" href="../../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/bugs.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <script type="text/javascript" defer src="../../js/bugs.js?<?php echo time(); ?>"></script>
      <link rel="icon" type="image/png" sizes="32x32" href="../../favicon-32x32.png">

  </head>
  <body>
       <?php include("../../includes/header.php") ?>   
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("../../includes/menu.php"); ?>
        </div>    
        <div class="main_wrap">
         <div class="content">
              <div class="list">
              
              <div class="new_bug">
                <form action="" method="post">
                      <input type="text" name="bug_title" placeholder="bug title here" id="bug_title" autocomplete="off">
                      <textarea name="bug_text" placeholder="Put a bug / error text here" id="markdown-input"></textarea>
                      <select name="bug_priority">
                        <option value="0">--- choose priority --- </option>
                        <option value = "low">low</option>
                        <option value = "medium">medium</option>
                        <option value = "high">high</option>
                        <option value = "critical">critical</option>
                      </select>

                      <select name="bug_status">
                          <option value="0">--- choose status --- </option>
                          <option value = "new">new</option>
                          <option value = "in progress">in progress</option>
                          <option value = "pending">pending</option>
                          <option value = "fixed">fixed</option>
                          <option value = "reopened">reopened</option>
                      </select>

                      <div class="new_bug_action">
                        <button type="submit" name="save_bug" class="button small_button">Save</button>
                      </div>
               </form>
              </div><!-- new bug-->
              
              <div class="bug_list">
                

                    <?php if ($errorMessage): ?>
                    <p class="error-message"><?= htmlspecialchars($errorMessage) ?></p>
                <?php elseif ($data): ?>
                    <?php foreach ($data as $bug):
                        $bug_id         = $bug['bug_id'];
                        $bug_title      = $bug['bug_title'];
                        $bug_text       = $bug['bug_text'];
                        $bug_status     = $bug['bug_status'];
                        $bug_priority   = $bug['bug_priority'];
                        $is_fixed       = $bug['is_fixed'];
                        $nr_of_comments = $bug['comments'];
                        
                        $fixed_label = $is_fixed == 1 ? "<span class='fixed_label'>fixed</span>" : "";
                        
                        if ($is_fixed == 0) {
                            $action_buttons = "
                                <button type='submit' name='delete_bug' class='button small_button'><i class='fa fa-times'></i></button>
                                <button type='submit' name='mark_fixed' class='button small_button'><i class='fa fa-check'></i></button>
                            ";
                        } else {
                            $action_buttons = "<div class='span_modpack'>fixed</div>";
                        }
                    ?>

                    <div class="bug" bug-id="<?= $bug_id ?>">
                        <div class="bug_title"><?= htmlspecialchars($bug_title) ?> <?= $fixed_label ?></div>
                        <div class="bug_text"><?= htmlspecialchars($bug_text) ?></div>
                        <div class="bug_footer">
                            <div class="bug_status <?= $bug_status ?>"><?= htmlspecialchars($bug_status) ?></div>
                            <div class="bug_priority <?= $bug_priority ?>"><?= htmlspecialchars($bug_priority) ?></div>
                            <div class="nr_of_comments"><?= $nr_of_comments ?> comments</div>
                            <div class="bug_action">
                                <?= $action_buttons ?>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Žiadne bugy.</p>
                <?php endif; ?>
                                          
                  ?>
              </div>                
            </div><!-- list-->

        </div><!--content-->
      </div><!--main_wrap-->
      
     <dialog class="modal_show_status">
        <ul>
          <li>new</li>
          <li>in progress</li>
          <li>pending</li>
          <li>fixed</li>
          <li>reopened</li>
        </ul>
    </dialog>

    <dialog class="modal_show_priority">
      <ul>
        <li>low</li>
        <li>medium</li>
        <li>high</li>
        <li>critical</li>
      </ul> 
    </dialog>

    <dialog class="modal_add_comment">
      <textarea name="comment_text" placeholder="Add a comment here"></textarea>
      <button type="submit" name="add_comment" class="button small_button">Add</button>
    </dialog>                  
    
              

  </body>
  </html> 
