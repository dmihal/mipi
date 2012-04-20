<?php
class Box
{
	public $name, $title, $content;
	function __construct($name,$title)
	{
		$this->name = $name;
		$this->title = $title;
	}
	function setContent(BoxContent $content)
	{
		$this->content = $content;
	}
	public function getHTML()
	{
?><div class="wbox" id="box<?php echo $this->name ?>">
	<h2><?php echo $this->title ?></h2>
<?php
if ($this->content) {
	echo $this->content->getHTML();
}
?>
</div><?php
	}
	public function getJS()
	{
		return ($this->content) ? $this->content->getJS() : NULL ;
	}
}
?>