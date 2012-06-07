<?php
switch (@$_GET[1]) {
	case 'compose':
		$page = Page::getPage('messages/compose');
		break;
	default:
		$page = new Page("Messages");
        
        $inbox = new Box("inbox","Inbox");
        
        $msgList = new BCList();
        $messages = Message::getUserMessages();
        foreach ($messages as $key => $message) {
        	/* @var $message Message */
        	$msgList->addElement($message->subject, $message->getSender()->getName(), $message->getPreview(),'#','/user/'.$message->getSender()->id,$message->date->format('m/d/Y'));
        }
        $inbox->setContent($msgList);
        $page->addBox($inbox,'tripple');
        
        $page->section = "message";
		break;
}

return $page;
?>
