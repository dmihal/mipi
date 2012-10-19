<?php
/**
 * Page object for a popup window with a left column
 *
 * @package default
 * @author  
 */
class PopupSplit extends Page {
	
	private $left,$right;
	
	function __construct(){
		$this->raw = true;
	}
	public function setLeft($left)
	{
		$this->left = $left;
		$this->updateRaw();
	}
	public function setRight($right)
	{
		$this->right = $right;
		$this->updateRaw();
	}
	private function updateRaw()
	{
	    ob_start();
?>
<div style="min-width:500px;">
    <div style="float: left;width: 200px;background: #EEE">
        <?php echo $this->left ?>
    </div>
    <div style="float:left;width:400px;"><?php //style="margin-left: 200px;min-width: 300px;margin-top: 40px;"> ?>
        <?php echo $this->right ?>
    </div>
</div>
<?php
		$this->rawData = ob_get_clean();
	}
} // END
?>