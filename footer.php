						</div>
					</div>
					<div id="left-bar">
						<ul id="nav">
							<li><a href="index.php">Home</a></li>
							 <li><a><form action="search.php" method="get">
							  <input type="text" name="query"/> <input type="submit" name="submit" value="search" />
							  </form></a></li>
		<?if(isset($login['id'])){?>
							<li><a href="add_campaign.php">Add Campaign</a></li>
							<li><a href="mycampaigns.php">My Campaigns</a></li>
							<li><a href="my_orgs.php">My Organisations</a></li>
		<?}?>
							<li><a href="sfc.php">Campaigns</a></li>
							<li><a href="sfc.php">Categories</a></li>
							<li><a href="locations.php">Locations</a></li>
							<li><a href="sfc.php">People</a></li>
							<li><a href="orgs.php">Organisations</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
		
		
		
		</div>
	</body>
</html>
