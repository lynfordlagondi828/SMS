<?php
    require_once 'inc/DbFunctions.php';
    $database = new DbFunctions();
    $message = "";

    require  'vendor/autoload.php';
    use Twilio\Rest\Client;
                    

    if(isset($_POST["submit"])){
        
        extract($_POST);

        $sd=$database->get_time($so_date_start);
        $ed=$database->get_time($so_date_end);


        if($database->check_occasion($so_name)){
            $message = "" .$so_name . " exists.";
        } 
        else {

        $start_d=$sd[0];
        $start_t=$sd[1];
        $end_d=$ed[0];
        $end_t=$ed[1];
        
        $emps=$database->get_employee();
        
        for($i=0;$i<sizeof($emps);$i++){

            $emp_name=$emps[$i]['emp_fname'];
            $emp_cont_num=$emps[$i]['emp_contact_num'];
            $body = "Hi! ".$emp_name.", we have an event (" . $so_acr .") ". $so_name. " on " . $start_d." starting @ ".$start_t." to ".$end_d." @ ".$end_t;
            
                $error_result = $database->add_special_occasions($so_name,$so_acr,$so_date_start,$so_date_end);
                if($error_result != TRUE){
                    $message = "" . $so_name  . " added.";
                    
                // $_SESSION["success"] = TRUE;
                // $_SESSION["so_name"] = $so_name;
                // header('location:send-sms.php');
                // exit();
                    
                        // Your Account SID and Auth Token from twilio.com/console
                        $account_sid = 'AC7a87bebc089b99f28aef6cd8ad64ef24';
                        $auth_token = '152f033a4e029015cbd69dd3b2553441';
                        // In production, these should be environment variables. E.g.:
                        // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]
                        // A Twilio number you own with SMS capabilities
                        $twilio_number = "+12565008442
                        ";
                    
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create(
                            // Where to send a text message (your cell phone?)
                            '+63'.$emp_cont_num,
                            array(
                                'from' => $twilio_number,
                                'body' => $body
                            )
                        );
                      

                } else {
                    $message = "" . $so_name  . " not added.";
                }
            }
        }
   
        
    }
?>
<html>
    <head>
        <title> 
             Adding Special Occasions
        </title>
        <link href="style.css" rel="stylesheet"> 
    </head>
    <body>
        <div id="container">
            <?php //echo $body;?>
            <p align="center">
                <img src="img/logo.png" width="50" height="50">
            </p>
            <h4  align="center"style="font-family:'Times New Roman'">
                 Negros Oriental State University
                 <hr>
            </h4>
           
            <h3 style="font-family:'Times New Roman'">
                NORSU HRMO
            </h3>

            <h4 style="font-family:'Times New Roman'">
               ADD NEW SPECIAL HOLIDAY
            </h4>

            <h4>
            <?php echo $message; 
            $cur_date=$database->get_cur_time();
           // echo $so_date_start."<br>";
            //print_r($cur_date);
            //echo '<br>'.$cur_date[0];
            ?>
            </h4>
            <form method="post">
                <label>Special Occasions Name</label>
                <input type="text"  name="so_name" placeholder="Special Occasions Name" required>

                <label>Special Occasions Acronym </label>
                <input type="text"  name="so_acr" placeholder="Special Occasions Acronym " required>

                <label>Special Occasions Date Start </label>
                <input type="datetime-local" value='<?php echo $cur_date[0];?>' name="so_date_start" placeholder="Special Occasions Date Start" required>

                <label>Special Occasions Date End </label>
                <input type="datetime-local" value='<?php echo $cur_date[0];?>' name="so_date_end" placeholder="Special Occasions Date End" required>
                <br><button class="button button4" name="submit">Submit</button>
              
            </form>
        </div>
    </body>
</html>