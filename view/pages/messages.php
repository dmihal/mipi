<?php
switch (@$_GET[1]) {
	case 'compose':
		$page = Page::getPage('messages/compose');
		break;
    case 'popup';
        $page = Page::getPage('messages/popup');
        break;
    case 'send':
        $to = explode(',', $_POST['to']);
        Message::sendMessage($to, $_POST['message'],$_POST['subject']);
        header("Location: /mipi/messages/inbox/msg:success");
        break;
	default:
		$page = new Page("Messages");
        
        $inbox = new Box("inbox","Inbox");
        
        $msgList = new BCList();
        $messages = Message::getUserMessages();
        foreach ($messages as $key => $message) {
        	/* @var $message Message */
        	$msgList->addElement($message->getLink(), $message->getSender()->getLink(), $message->getPreview(),$message->date->format('m/d/Y'));
        }
        $inbox->setContent($msgList);
        $page->addBox($inbox,'tripple');
        
        ob_start();
        ?>
        function reply(id){
            window.location.href = "/mipi/messages/compose/r:"+id;
        }
        <?php
        $page->js = ob_get_clean();
        
		break;
}

$page->section = "message";
return $page;
?>
