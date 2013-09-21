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
			new NavElement("Dashboard","/","dash"),
			new NavElement("Lights","/lights","lights")
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
			new NavElement("Recieved Bids","/rush/bids","bids"),
			new NavElement("Events","/rush/events","rushevents"),
			new NavElement("Voting List","/rush/votes","rushvote"),
			new NavElement("Stats","/rush/stats","rushstats"),
			new NavElement("Add Rushee","/rush/add","newrushee")
			),
		"message"	=> array(
			new NavElement("Compose Message","/messages/compose","compose"),
			new NavElement("Inbox","/messages/inbox","inbox")
			),
		"profile"	=> array(
			new NavElement("My Profile","/profile","profile"),
			new NavElement("Edit My Profile","/profile/edit","editprofile"),
			new NavElement("Settings","/profile/settings","settings"),
			new NavElement("Change Password",'/profile/changepw','password'),
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
		
        $addRushees = false;
		foreach (Officer::getOfficersByUser(getUser()) as $officer) {
		    /* @var $officer Officer */
			if (isset($officer->adminPages)) {
				foreach ($officer->adminPages as $name => $path) {
					$this->secondNav['profile'][] = new NavElement($name,$path,$officer->name);
				}
			}
		}
        
        if (getUser()->type == Member::ALUMNI){
            $this->showTicker = false;
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
<html>
  <head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo $this->page->title ?> - MiPi</title>
		<meta name="description" content="" />
		<meta name="author" content="David Mihal" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <!-- Le styles -->
        <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
          body {
            padding-top: 60px;
            padding-bottom: 40px;
          }
          .sidebar-nav {
            padding: 9px 0;
          }
    
          @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
              float: none;
              padding-left: 5px;
              padding-right: 5px;
            }
          }
        </style>
        <link href="/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->
    
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
          <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                       <link rel="shortcut icon" href="../assets/ico/favicon.png">
    

		<link rel="stylesheet" href="/styles.css"/>
		<link rel="stylesheet" href="/js/fancybox/jquery.fancybox-1.3.4.css" />
		<!-- <link rel="stylesheet" href="/js/jquery.jOrgChart.css" /> -->
		<link rel="stylesheet" href="/js/smoothDivScroll.css" />
		<!-- <link rel="stylesheet" href= "//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/black-tie/jquery-ui.css" /> -->
		<link rel="stylesheet" href="/js/token-input-facebook.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="application/javascript"></script>
		<script src= "//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="/bootstrap/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
		<script src="/js/jquery.jOrgChart.js"></script>
		<script src="/js/jquery.tokeninput.js"></script>
		<script src="/js/jquery.mousewheel.min.js"></script>
		<script src="/js/jquery.cookie.js"></script>
		<script src="/js/jquery.smoothdivscroll-1.2-min.js" type="application/javascript"></script>
		<script src="http://d3js.org/d3.v2.js" type="application/javascript"></script>
		<script type="application/javascript">
$(function() {

    window.fbLoaded = function(){
        $("#fancybox-content").find("a.userlink,a.messageLink,a.announceLink").fancybox({onComplete:fbLoaded});
        $("#fancybox-content").find(".tabs").tabs();
        $('#fancybox-content').find(".nav-tabs a").click(function (e) {
          e.preventDefault();
          $(this).tab('show');
        });
        $('#fancybox-content').find(".nav-tabs a:first").tab('show');
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
        type    : 'POST',
        complete: function(){
            var d = new Date();
            var curr_month = d.getMonth() +1;
            var date = ""+curr_month +"/"+ d.getDate() +"/"+ d.getFullYear()+" "+d.getHours()+':'+d.getMinutes();
            var comment = $(form).find('textarea').val();
            $(".comments").append('<li><div class="lcol"><?php echo getUser()->getLink() ?><br \>'+date+"</div><div>"+comment+"</div><br style=\"clear:both\"></li>");
            $(form).find('textarea').val('');
        }
    }); 
}
function vote(id,dir,link){
    $.ajax({
        url     : '/ajax/vote',
        data    : {'id':id, 'dir':dir},
        type    : 'POST'
    });
    link.className = 'voted';
    return false;
}
		</script>
<?php
echo $this->page->getJS();
?>
    </head>
    <body>
    <div class='navbar navbar-inverse navbar-fixed-top'>
      <div class='navbar-inner'>
        <div class='container-fluid'>
          <button class='btn btn-navbar' data-target='.nav-collapse' data-toggle='collapse' type='button'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
          <a class='brand' href='#'>My Pi Zeta</a>
          <div class='nav-collapse collapse'>
            <div class='pull-right'>
              <ul class='nav'>
<?php 
foreach ($this->navRight as $name => $uri) {
    echo "<li class='active'><a href=\"$uri\">$name</a></li>";
}
?>
              </ul>
            </div>
            <ul class='nav'>
<?php 
foreach ($this->navLeft as $name => $uri) {
    echo "<li class='active'><a href=\"$uri\">$name</a></li>";
}
?>
            </ul>
          </div>
        </div>
      </div>
    </div>
<?php if($this->showTicker) { ?>
    <div class='navbar navbar-fixed-bottom'>
      <div class='navbar-inner'>
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
      </div>
    </div>
<?php } ?>
<div class='container-fluid'>
      <div class='row-fluid'>
        <div class='span3'>
          <div class='well sidebar-nav'>
            <ul class='nav nav-list'>
<?php 
$navs = $this->getSecondNav();
foreach ($navs as $value) {
    /* @var $value HTMLElement */
   echo $value->getHTML();
}
?>
            </ul>
          </div>
        </div>
        <div class='span9'>
          <div class='row-fluid'>
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

if (!empty($this->page->boxes['left']))
{
    echo "<div class='span4'>";
    foreach ($this->page->boxes['left'] as $box) {
        echo $box->getHTML();
    }
    echo "</div>";
}
if (!empty($this->page->boxes['center']))
{
    echo "<div class='span4'>";
    foreach ($this->page->boxes['center'] as $box) {
        echo $box->getHTML();
    }
    echo "</div>";
}
if (!empty($this->page->boxes['double']))
{
    echo "<div class='span8'>";
    foreach ($this->page->boxes['double'] as $box) {
        echo $box->getHTML();
    }
    echo "</div>";
}
if (!empty($this->page->boxes['right']))
{
    echo "<div class='span4'>";
    foreach ($this->page->boxes['right'] as $box) {
        echo $box->getHTML();
    }
    echo "</div>";
}
if (!empty($this->page->boxes['tripple']))
{
    echo "<div class='span12'>";
    foreach ($this->page->boxes['tripple'] as $box) {
        echo $box->getHTML();
    }
    echo "</div>";
}
?>
<?php
if ($this->page->form){
    echo "</form>";
}
?>  
          </div>
        </div>
      </div>
      <hr>
      <footer>
        <p>Copyright</p>
      </footer>
    </div>
    <div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modal header</h3>
      </div>
      <div class="modal-body">
        <p>One fine body…</p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </body>
</html>
<?php
	return ob_get_clean();
	}
}
?>