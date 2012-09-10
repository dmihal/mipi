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
        header("Location: /messages/inbox/msg:success");
        break;
    case 'setunread':
        echo 'test';
        $message = Message::getMessage($_GET[2]);
        $message->setRead(false);
        var_dump($message);
        exit;
	default:
		$page = new Page("Messages");
        
        $inbox = new Box("inbox","Inbox");
        
        $msgList = new BCList();
        $messages = Message::getUserMessages();
        foreach ($messages as $key => $message) {
        	/* @var $message Message */
        	$read = $message->read ? NULL : "unread";
        	$msgList->addElement($message->getLink(), $message->getSender()->getLink(), $message->getPreview(),$message->date->format('m/d/Y'),$read);
        }
        $inbox->setContent($msgList);
        $page->addBox($inbox,'tripple');
        
		break;
}

$page->section = "message";
return $page;
?>
