						</div>
					</div>
					<div id="left-bar">
					<div id="searchbox">
					  <form action="search.php" method="get">
					  <input type="text" name="query"/> <input type="submit" name="submit" value="search" />
					   </form>
					</div>
						<ul id="nav">
							<li><a href="index.php">Home</a></li>
		<?if(isset($login['id'])){?>
							<li><a href="mycampaigns.php">My Campaigns</a></li>
							<li><a href="my_orgs.php">My Organisations</a></li>
		<?}?>
							<li><a href="sfc.php">Campaigns</a></li>
							<li><a href="sfc.php">Categories</a></li>
							<li><a href="locations.php">Locations</a></li>
							<li><a href="people.php">People</a></li>
							<li><a href="org.php">Organisations</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
		
		
		
		</div>
	</body>
</html>
