<?php include 'database.php'; ?>
<?php
    if(isset($_POST['submit'])){
        
        // Get post variable
        $question_number = $_POST['question_number'];
        
        $question_text = $_POST['question_text'];
        
        $correct_choice = $_POST['correct_choice'];
        //Create array
        $choices = array();
        $choices[1] = $_POST['choice1'];
        $choices[2] = $_POST['choice2'];
        $choices[3] = $_POST['choice3'];
        $choices[4] = $_POST['choice4'];
        $choices[5] = $_POST['choice5'];
        
        //Question query
        $query = "INSERT INTO `question`(question_number, text)
            VALUES ('$question_number','$question_text')";
        
        //Run query
        
        $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
        
        //Validate insert
        if($insert_row){
            
            foreach($choices as $choice => $value){
                if($value != ''){
                    if($correct_choice == $choice){
                        $is_correct = 1;
                    }else{
                        $is_correct =0;
                    }
                    //Choice query
                    
                    $query = "INSERT INTO `choices` (question_number, is_correct, text)
                        VALUES ('$question_number','$is_correct','$value')";
                    //Run query
                    $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
                    
                    //Validate insert
                    if($insert_row){
                        continue;
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
                }
            }
            $msg = 'Question has been added';
        }
    }
    /*
     Get Total Questions
    */
    $query = "SELECT * FROM question" ;

    //Get The results
    $questions = $mysqli->query($query) or die($mysqli->error.__LINE__);
    $total = $questions->num_rows;
    $next = $total+1;


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>PHP Quizzer</title>
        <link rel="stylesheet" href="css/style.css" type="text/css">
    
    </head>
    <body>
        <header>
            <div class="container">
                <h1>PHP Quizzer</h1>
            </div>
        
        </header>
        <main>
            <div class="container">
               <h2>Add A Question</h2>
                
                <?php 
                    if(isset($msg)){
                        echo '<p>'.$msg.'</p>';
                    }
                
                ?>
                <form method="POST" action="add.php">
                <P>
                    <label>Question Number</label>
                    <input type="number" value="<?php echo $next ?>" name="question_number"/>
                </P>
                <P>
                    <label>Question Text</label>
                    
                    <input type="text" name="question_text"/>
                </P>
                <P>
                    <label>Choice #1:</label>
                    <input type="text" name="choice1"/>
                </P>
                <P>
                    <label>Choice #2:</label>
                    <input type="text" name="choice2"/>
                </P>
                <P>
                    <label>Choice #3:</label>
                    <input type="text" name="choice3"/>
                </P>
                <P>
                    <label>Choice #4:</label>
                    <input type="text" name="choice4"/>
                </P>
                <P>
                    <label>Choice #5:</label>
                    <input type="text" name="choice5"/>
                </P>
                <P>
                    <label>Correct Choice Number:</label>
                    <input type="number" name="correct_choice"/>
                </P>
                <P>
                   
                    <input type="submit" name="submit" value="submit"/>
                </P>
                
                </form>
           

            </div>
        </main>
        <footer>
        <div class="container">
                Copyright &copy; 2014,  PHP Quizzer
            </div>
            
        </footer>
    </body>
</html>