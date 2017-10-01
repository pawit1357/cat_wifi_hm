<?php
class MailUtil {

	public static function sendMail($to_email, $subject, $content) {
		
		$mail = Yii::app ()->Smtpmail;
		$mail->IsSMTP ();
		$mail->SetFrom ( 'pawitvaap@gmail.com', 'MU-RADBASE' );
		$mail->Subject = $subject;
		$mail->MsgHTML ( $content );
		$mail->ClearAddresses ();
		$mail->AddAddress ( $to_email, "" );
		if ($mail->Send ()) {
			return true;
		} else {
			return false; 
		}
// 		echo "SEND MAIL>>>>".$to_email;
		return true;
	}


}
?>
