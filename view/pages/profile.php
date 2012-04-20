<?php
$user = getUser();
switch(@$_GET[1])
{
	case 'edit':
		$page = Page::getPage('profile/edit');
		break;
	case 'save':
		$user->email	= $_POST['email'];
		$user->cell		= $_POST['cell'];
		
		try
		{
			if ($user->save())
			{
				header("location: /mipi/profile/msg:saved");
			}else{
				header("location: /mipi/profile/msg:nosaved");
			}
			$user->start();
		} catch (Exception $e) {
			echo "SQL Error";
		}
		
		exit;
	default:
		$page = new Page("Profile");
		
		$left = new Box('left',$user->getName());
		$leftBox = new BCStatic();
		ob_start();
?>
<img src="<?php echo $user->getPhotoPath() ?>" style="width: 200px" />
<?php
		$leftBox->content = ob_get_clean();
		$left->setContent($leftBox);
		$page->addBox($left,'left');
		
		switch (@$_GET['msg']) {
			case 'saved':
				$page->setMessage("Your profile has been saved");
				break;
			case 'nosaved':
				$page->setMessage("No information updated");
				break;
		}
		break;
}

$page->section = "profile";
return $page;
?>
