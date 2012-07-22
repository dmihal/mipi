<?php
class Template
{
	
	private $page;
	public $showTicker = true;
	const trans = "data:image/gif;base64,R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==";
	
	private $navLeft = array(
		"Home"		=> "/",
		"Members"	=> "/members",
		"Events"	=> "/events",
		"Rush"		=> "/rush"
		);
	private $navRight = array();
	private $secondNav;
	function __construct(Page $page){
		$this->page= $page;

        $this->navRight['<div id="msgFlag">'.Message::getNumUnread().'</div>&#9993'] = 'messages';
		$this->navRight[getUser()->getName()] = "/profile";
		
		$this->secondNav  = array(
		"home"		=> array(
			new NavElement("Dashboard","/","dash")
			),
		"members"	=> array(
			new NavElement("Brothers","/members","brothers"),
			new NavElement("Associate Members","/members/ams","ams"),
			new NavElement("Alumni","/members/alum","alum"),
			new NavElement("Family Tree","/family","family"),
			new NavElement("Phonebook","/members/phonebook","phonebook")
			),
		"events"	=> array(
			new NavElement("Calendar","/events","calendar"),
			new NavElement("Guest Lists","/events/list","glist"),
			new NavElement("Blacklist","/events/blacklist","blist")
			),
		"rush"		=> array(
			new NavElement("Recruits","/rush","recruits"),
			new NavElement("Events","/rush/events","rushevents")
			),
		"message"	=> array(
			new NavElement("Compose Message","messages/compose","compose"),
			new NavElement("Inbox","messages/inbox","inbox")
			),
		"profile"	=> array(
			new NavElement("My Profile","profile","profile"),
			new NavElement("Edit My Profile","profile/edit","editprofile"),
			new NavElement("Settings","profile/settings","settings")
			)
		);

		foreach (Officer::getOfficerLists(true) as $name => $title) {
			$this->secondNav['home'][] = new NavElement($title,"/officer/$name",$name);
		}
		//$this->secondNav['home'][] = new NavElement("","","spacer");
		foreach (Officer::getOfficerLists(false) as $name => $title) {
			$this->secondNav['home'][] = new NavElement($title,"/officer/$name",$name);
		}
	
	}
	
	private function getSecondNav(){
		return $this->secondNav[$this->page->section];
	}
	
	/**
	 * undocumented function
	 *
	 * @return string HTML for the page
	 */
	function buildPage() {
	if ($this->page->raw)
	{
		return $this->page->rawData;
	}
	
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php $this->page->title ?> - MiPi</title>
		<meta name="description" content="" />
		<meta name="author" content="David Mihal" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<link rel="stylesheet" href="styles.css"/>
		<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" />
		<link rel="stylesheet" href="js/jquery.jOrgChart.css" />
		<link rel="stylesheet" href= "http://www.smoothdivscroll.com/css/smoothDivScroll.css" />
		<link rel="stylesheet" href= "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/black-tie/jquery-ui.css" />
		<link rel="stylesheet" href= "/mipi/js/token-input-facebook.css" />
		<script src="/mipi/js/jquery-1.7.1.js" type="application/javascript"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="/mipi/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<script src="/mipi/js/jquery.jOrgChart.js"></script>
		<script src="/mipi/js/jquery.tokeninput.js"></script>
		<script src="http://www.smoothdivscroll.com/js/jquery.mousewheel.min.js"></script>
		<script src="http://www.smoothdivscroll.com/js/jquery.smoothdivscroll-1.2-min.js" type="application/javascript"></script>
		<script type="application/javascript">
$(function() {

    var fbLoaded = function(){
        $("#fancybox-content").find("a.userlink,a.messageLink").fancybox({onComplete:fbLoaded});
    }
	$("a.userlink,a.messageLink").fancybox({onComplete:fbLoaded});

	$("#stream").smoothDivScroll({
				autoScrollingMode: "always",
				autoScrollingDirection: "endlessloopright",
				autoScrollingStep: 1,
				autoScrollingInterval: 30 
			});
	$("#shouter input").keypress(function(event){
	 
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			var shout = this.value;
			this.value = "";
			$("#stream .scrollableArea").append('<span class="shouted"><span class="shoutMsg">"'+shout+'"</span> - <a href="user/<?php echo getUser()->id ?>" class="userlink"><?php echo getUser()->getName() ?></a></span>')
			$("#stream a.userlink").fancybox();
			$("#stream").smoothDivScroll("recalculateScrollableArea");
		}
		event.stopPropagation();
	});
	
	$("#tree").jOrgChart({
			chartElement : '#chart'
		});
});

		</script>
<?php
echo $this->page->getJS();
?>
	</head>
	<body>
		<div id="container">
			<header>
				<h1><img src="img/pizetalogo.gif" alt="My Pi Zeta" /></h1>
				<nav>
					<ul id="navLeft" class="topNav">
<?php 
foreach ($this->navLeft as $name => $uri) {
	echo "<li><a href=\"$uri\">$name</a></li>";
}
?>
					</ul>
					<ul id="navRight" class="topNav">
<?php 
foreach ($this->navRight as $name => $uri) {
	echo "<li><a href=\"$uri\">$name</a></li>";
}
?>
					</ul>
				</nav>
				<div id="shout">
<?php if($this->showTicker) { ?>
					<div id="shouter">
						<input />
					</div>
					<div id="ticker">
						<div id="stream">
<?php 
$shouts = Shout::getLastTen();
foreach ($shouts as $shout) {
	/* @var $shout Shout */
	echo '<span class="shouted"><span class="shoutMsg">"' . $shout->message . 
		'"</span> - <a href="user/'. $shout->getUser()->id .'" class="userlink">'.$shout->getUser()->getName().'</a></span>';
	
}
unset($shouts);
?>
						</div>
					</div>
<?php } ?>
				</div>
			</header>
			<nav id="sidebar">
				<ul>
<?php 
$navs = $this->getSecondNav();
foreach ($navs as $value) {
?>
<li>
	<a href="<?php echo $value->link ?>">
		<div class="navIcon">
			<img src="<?php echo self::trans ?>" alt="<?php echo $value->title ?>" id="icon<?php echo ucfirst($value->class) ?>" />
		</div>
		<?php echo $value->title ?>
	</a>
</li>
<?php
}
?>
				</ul>
			</nav>
			<div id="content">
<?php
if ($this->page->message)
{
?>
<div class="message"><?php echo $this->page->message ?></div>
<?php
}
?>
				<div class="column">
<?php
foreach ($this->page->boxes['left'] as $box) {
	echo $box->getHTML();
}
echo '</div>';

if (!empty($this->page->boxes['center']))
{
	echo '<div class="column">';
	foreach ($this->page->boxes['center'] as $box) {
		echo $box->getHTML();
	}
	echo "</div>";
}

if (!empty($this->page->boxes['right']))
{
	echo '<div class="column">';
	foreach ($this->page->boxes['right'] as $box) {
		echo $box->getHTML();
	}
	echo "</div>";
}
if (!empty($this->page->boxes['double']))
{
	echo '<div class="column double">';
	foreach ($this->page->boxes['double'] as $box) {
		echo $box->getHTML();
	}
	echo "</div>";
}
if (!empty($this->page->boxes['tripple']))
{
	echo '<div class="column tripple">';
	foreach ($this->page->boxes['tripple'] as $box) {
		echo $box->getHTML();
	}
	echo "</div>";
}
?>					<div style="clear: both">&nbsp;</div>
				</div>
			</div>
			<footer>
				<p>
					&copy; Copyright  by David Mihal
				</p>
			</footer>
		</div>
	</body>
</html>
<?php
	return ob_get_clean();
	}
}
?>