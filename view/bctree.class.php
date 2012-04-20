<?php
class BCTree implements BoxContent
{
	public function getHTML()
	{
		ob_start();
?>
<div style="overflow: scroll" id="chart">
</div>
<ul id="tree" style="display: none">
	<li>
		Pi Colony
		<ul>
			<li>
				Jared Broberg
				<ul>
					<li>
						Jon Rapp
						<ul>
							<li>
								Victor Puksta
								<ul>
									<li>
										James Klyng
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						Zach Bornemann
						<ul>
							<li>Joey Collins</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				Tim Flynn
				<ul>
					<li>
						Mike Boucher
						<ul>
							<li>
								Mark Shooter
								<ul>
									<li>
										Ryan Bagge
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						Joe Monasky
						<ul>
							<li>
								David Mihal
							</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				Dustin Vinci
				<ul>
					<li>
						Jonas Bellini
						<ul>
							<li>
								J.P. Correia
								<ul>
									<li>
										Eric Eoff
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						Steven Cortesa
					</li>
				</ul>
			</li>
		</ul>
	</li>
</ul>
<?php
		return ob_get_clean();
	}
	public function getJS(){
		return NULL;
	}
}
?>