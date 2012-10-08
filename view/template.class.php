<?php
class Template
{
	
	private $page;
	public $showTicker = true;
	
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
        $unreadMsg = Message::getNumUnread();
        
        $this->navRight['<div id="msgFlag">'.($unreadMsg ? $unreadMsg : '').'</div>&#9993'] = '/messages';
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
			new NavElement("Add Rushee","/rush/add","newrushee"),
			new NavElement("Events","/rush/events","rushevents")
			),
		"message"	=> array(
			new NavElement("Compose Message","/messages/compose","compose"),
			new NavElement("Inbox","/messages/inbox","inbox")
			),
		"profile"	=> array(
			new NavElement("My Profile","/profile","profile"),
			new NavElement("Edit My Profile","/profile/edit","editprofile"),
			new NavElement("Settings","/profile/settings","settings"),
			new Spacer()
			)
		);

		foreach (Officer::getOfficerLists(true) as $name => $title) {
			$this->secondNav['home'][] = new NavElement($title,"/officer/$name",$name);
		}
		$this->secondNav['home'][] = new Spacer();
		foreach (Officer::getOfficerLists(false) as $name => $title) {
			$this->secondNav['home'][] = new NavElement($title,"/officer/$name",$name);
		}
		
		foreach (Officer::getOfficersByUser(getUser()) as $officer) {
		    /* @var $officer Officer */
			if (isset($officer->adminPages)) {
				foreach ($officer->adminPages as $name => $path) {
					$this->secondNav['profile'][] = new NavElement($name,$path,$officer->name);
				}
			}
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
		<link rel="stylesheet" href="/styles.css"/>
		<link rel="stylesheet" href="/js/fancybox/jquery.fancybox-1.3.4.css" />
		<link rel="stylesheet" href="/js/jquery.jOrgChart.css" />
		<link rel="stylesheet" href="/js/smoothDivScroll.css" />
		<link rel="stylesheet" href= "//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/black-tie/jquery-ui.css" />
		<link rel="stylesheet" href="/js/token-input-facebook.css" />
		<script src="/js/jquery-1.7.1.js" type="application/javascript"></script>
		<script src= "//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<script src="/js/jquery.jOrgChart.js"></script>
		<script src="/js/jquery.tokeninput.js"></script>
		<script src="/js/jquery.mousewheel.min.js"></script>
		<script src="/js/jquery.smoothdivscroll-1.2-min.js" type="application/javascript"></script>
		<script type="application/javascript">
$(function() {

    window.fbLoaded = function(){
        $("#fancybox-content").find("a.userlink,a.messageLink,a.announceLink").fancybox({onComplete:fbLoaded});
        $("#fancybox-content").find(".tabs").tabs();
    }
	$("a.userlink,a.messageLink,a.announceLink").fancybox({onComplete:fbLoaded});

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
			$.ajax({
			    url:'/ajax/shout',
			    data: {message:shout},
			    type: 'POST'
			    });
		}
		event.stopPropagation();
	});
	
	$("#tree").jOrgChart({
			chartElement : '#chart'
		});
});
function reply(id){
    window.location.href = "/messages/compose/r:"+id;
}
function unread(id,e){
    $.ajax({url:'/messages/setunread/'+id,
            success: function(){
                e.innerHTML = "Mark Read";
            }});
}
function addComment(form) {
    $.ajax({
        url     : '/rush/comment/',
        data    : $(form).serialize(),
        type    : 'POST'
    }); 
}
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
						<input placeholder="Write a quick message..." />
					</div>
					<div id="ticker">
						<div id="stream">
<?php 
$shouts = Shout::getLastTen();
foreach ($shouts as $shout) {
	/* @var $shout Shout */
	echo '<span class="shouted"><span class="shoutMsg">"' . $shout->message . 
		'"</span> - '.$shout->getUser()->getLink().' </span>';
	
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
    /* @var $value HTMLElement */
   echo $value->getHTML();
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
if ($this->page->form){
    echo $this->page->form;
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
if ($this->page->form){
    echo "</form>";
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