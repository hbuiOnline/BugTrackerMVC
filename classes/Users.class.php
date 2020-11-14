<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use PhpRbac\Rbac;

require 'PHPMailer/vendor/autoload.php';


class Users extends Dbh {

  protected function validateUserCreate($usersFirst, $usersLast, $usersEmail, $username, $usersPwd){
    $sql = "SELECT username FROM users WHERE username=?"; // ? is a placeholder

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../signup.php?error=sqlerrorR");
      exit();
    }

    else {
      $stmt->execute([$username]);
      $resultCheck = $stmt->fetchColumn();

      if ($resultCheck == true) {
        header("Location: ../signup.php?error=usernameTaken&mail=".$email);
        exit();
      }

      else {
        $sql = "INSERT INTO users (usersFirst, usersLast, username, usersEmail, usersPwd) VALUES (?, ? ,?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../signup.php?error=sqlerrorR");
          exit();
        }
        else {
          $hashedPwd = password_hash($usersPwd, PASSWORD_DEFAULT);
          $stmt->execute([$usersFirst, $usersLast, $username, $usersEmail , $hashedPwd]);
          header("Location: ../signup.php?signup=success");
          exit();
        }
        $this->connect()->null;
      }
    }
  }//End of validateUserCreate

  protected function userLogin($mailUser, $userPwd){

    require '../vendor/autoload.php';
    $rbac = new Rbac();

    $sql = "SELECT * FROM users WHERE username = ? OR usersEmail = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$mailUser, $mailUser]);

      if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pwdCheck = password_verify($userPwd, $row['usersPwd']);

        if ($pwdCheck == false) {
          header('Location: ../index.php?error=wrongpwd');
          exit();
        }
        elseif ($pwdCheck == true) {
          session_start();
          $_SESSION['userID'] = $row['idUsers'];
          $_SESSION['usernUid'] = $row['username'];
          $_SESSION['userFirst'] = $row['usersFirst'];
          $_SESSION['userLast'] = $row['usersLast'];
          $_SESSION['userEmail'] = $row['usersEmail'];
          $_SESSION['userRole'] = $row['usersRole'];

          if ($rbac->Users->hasRole('admin', $_SESSION['userID'])) {
            header("Location: ../dashboard.php?login=success");
            exit();
          }
          elseif ($rbac->Users->hasRole('project-manager', $_SESSION['userID'])) {
            header("Location: ../projects.php?login=success");
            exit();
          }
          else {
            header("Location: ../tickets.php?login=success");
            exit();
          }

        }
        else{
            header("Location: ../index.php?error=wrongpwd");
            exit();
        }
      }
      else {
          header("Location: ../index.php?error=nouser");
          exit();
      }
    }
  }//End of userLogin

  protected function demoUserLogin($demoUsername){

    require '../vendor/autoload.php';
    $rbac = new Rbac();

    $sql = "SELECT * FROM users WHERE username = ?;";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../index.php?error=sqlError");
      exit();
    } else {
      $stmt->execute([$demoUsername]);
      if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        session_start();
        $_SESSION['userID'] = $row['idUsers'];
        $_SESSION['usernUid'] = $row['username'];
        $_SESSION['userFirst'] = $row['usersFirst'];
        $_SESSION['userLast'] = $row['usersLast'];
        $_SESSION['userEmail'] = $row['usersEmail'];
        $_SESSION['userRole'] = $row['usersRole'];

        if ($rbac->Users->hasRole('admin', $_SESSION['userID'])) {
          header("Location: ../dashboard.php?login=success");
          exit();
        }
        elseif ($rbac->Users->hasRole('project-manager', $_SESSION['userID'])) {
          header("Location: ../projects.php?login=success");
          exit();
        }
        else {
          header("Location: ../tickets.php?login=success");
          exit();
        }

      } else {
        header("Location: ../index.php?error=nouser");
        exit();
      }
    }
  }//End of demoUserLogin

  protected function userResetPwdEmail($userEmail)
  {
    //Create selector and token for validation
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32); //longer to be secure

    //A token is not allow to be available infinitely
    //This will give the user a limited time to use for securing purpose.
    $expires = date("U") + 1800; //This is one hour from the time submit the request.

    $url = "https://bugtrackermvc.herokuapp.com/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      echo 'There was an error in SQL';
      exit();
    } else {
      $stmt->execute([$userEmail]);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      echo 'There was an error in SQL';
      exit();
    } else {
      $hashedToken = password_hash($token, PASSWORD_DEFAULT);
      $stmt->execute([$userEmail, $selector, $hashedToken, $expires]);
    }

    $this->connect()->null;

    //This part using PHPMailer and Google Account server to send email to user for resetpwd link
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'bugtracker2020@gmail.com';                     // SMTP username
      $mail->Password   = 'Hviponlin3';                               // SMTP password
      $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    // 587 ,.... TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom('bugtracker2020@gmail.com', 'Bug Tracker');
      $mail->addAddress($userEmail);     // Add a recipient

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Reset your password for Bug Tracker';
      $mail->Body    .= '<p>We received a password request. The link to reset your password is below. If you did not make this request, please ignore this email </p>';
      $mail->Body    .= '<p>Here is your password reset link:</br>';
      $mail->Body    .= '<a href="' . $url . '">' . $url . '</a></p>';

      if ($mail->send()) {
        echo 'Message has been sent';
      } else {
        echo 'ERROR sending email';
      }
      $mail->smtpClose();

      header("Location: ../reset-password.php?reset=success");
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  } //End of userResetPwdEmail

  protected function usersDetail($userId){
    $userDetails = array();
    $sql = "SELECT * FROM users WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../profile.php?error=sqlerror");
    }
    else {
      $stmt->execute([$userId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userDetails = array(
          "username" => $row['username'],
          "userid" => $row['idUsers'],
          "userfirst" => $row['usersFirst'],
          "userlast" => $row['usersLast'],
          "userrole" => $row['usersRole'],
          "useremail" => $row['usersEmail']
        );
      }
    }

    return $userDetails;
  }

  protected function usersData(){

    $sql = "SELECT U.idUsers, U.usersEmail, U.usersFirst, U.usersLast, R.Title
            FROM users U
            LEFT JOIN phprbac_roles R ON U.usersRole = R.ID
            LEFT JOIN phprbac_userroles UR ON U.idUsers = UR.UserID;";

    // $sql = "SELECT * FROM users;";
    $stmt = $this->connect()->query($sql);
    $usersData = "";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $usersData .=
      "<tr>
        <td>".$row['idUsers']."</td>"
        ."<td>".$row['usersFirst']." ".$row['usersLast']."</td>"
        ."<td>".$row['usersEmail']."</td>"
        ."<td>".$row['Title']."</td>
      </tr>";

    }
    return $usersData;
  }//End of usersData

  protected function usersName(){
    $sql = "SELECT * FROM users";
    $stmt = $this->connect()->query($sql);
    $usersName = "";

    //Notes: need to change it to userId number instead of actual names
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $usersName .= "<option value=".$row['idUsers'].">".$row['usersFirst']." ".$row['usersLast']."</option>";
    }

    return $usersName;
  }//End of usersName


  protected function usersRoleAssign($userSelect, $userRole){

    $sql = "UPDATE users SET usersRole = ? WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../users.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userRole, $userSelect]);
      header("Location: ../users.php?roleassign=success");
      exit();
    }
    $this->connect()->null;

  }//End of usersRoleAssign

  protected function usersProfileUpdate($userId, $userFirst, $userLast, $userEmail){
    $sql = "UPDATE users SET usersFirst = ?, usersLast = ?, usersEmail = ? WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);

    if (!$stmt) {
      header("Location: ../profile.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userFirst, $userLast, $userEmail, $userId]);
      header("Location: ../profile.php?profileupdate=success");
      exit();
    }
    $this->connect()->null;

  }//End of usersProfileUpdate

  protected function usersPwdUpdate($userId ,$currentPwd, $newPwd){

    $sql = "SELECT * FROM users WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../profile.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userId]);

      if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pwdCheck = password_verify($currentPwd, $row['usersPwd']);

        if ($pwdCheck == false) {
          header("Location: ../profile.php?error=notcurrentpwd");
          exit();
        }

        elseif ($pwdCheck == true) {
          $hashedNewPwd = password_hash($newPwd, PASSWORD_DEFAULT);

          $sql = "UPDATE users SET usersPwd = ?;";
          $stmt= $this->connect()->prepare($sql);
          if (!$stmt) {
            header("Location: ../profile.php?error=sqlerror");
            exit();
          }
          else {
            $stmt->execute([$hashedNewPwd]);
            header("Location: ../profile.php?newpwdset=success");
          }
        }
        else {
          header("Location: ../profile.php?error=nouser");
        }
      }
    }
  }//End of usersPwdUpdate

} //End of class
