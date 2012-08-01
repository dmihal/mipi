<?php
/**
 * 
 */
class NavElement extends Hyperlink {
    
    const trans = "data:image/gif;base64,R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==";
    
	public function getHTML()
	{
		ob_start();
        ?>
<li>
    <a href="<?php echo $this->url ?>">
        <div class="navIcon">
            <img src="<?php echo self::trans ?>" alt="<?php echo $this->title ?>" id="icon<?php echo ucfirst($this->class) ?>" />
        </div>
        <?php echo $this->title ?>
    </a>
</li>
<?php
        return ob_get_clean();
	}
}

?>