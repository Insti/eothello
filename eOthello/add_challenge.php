<?php 
if(isLoggedIn())
{
	$id = $_SESSION['id_player'];
	if (isset($_REQUEST['challenged']) && isset($_REQUEST['color']) && isset($_REQUEST['rated']))
	{
		$challenged = (int)$_REQUEST['challenged'];
		//controlamos que no se rete a s� mismo
		if ($challenged == $id)
			echo '<p>You can\'t challenge yourself.</p>';
		}
		{
			try 
				$query = "SELECT challenger FROM challenges WHERE challenger = '$id' AND challenged = '$challenged' AND status = 'unanswered'";
				$stmt = $dbh->query($query);
				//controlamos que no rete a alguien con quien ya tiene un reto pendiente
				if ($stmt->rowCount() != 0)
					echo '<p>You can\'t challenge the same person twice.<br />';
				}
				{
					//valor de rated
					$rated = true;
					if ($_REQUEST['rated'] == "no")
					{
					//valor de random
					$random = false;
					if ($_REQUEST['random'] == "yes")
					//valor de color
					$color = "random";
					if ($_REQUEST['color'] == "White")
						$color = "White";
					}
					{
					$query = "INSERT INTO challenges (challenger, challenged, status, rated, color, random) VALUE ('$id', '$challenged', 'unanswered', '$rated', '$color', '$random')";
					if ($dbh->exec($query))
					{
						$query = "SELECT username FROM players WHERE id_player = '$challenged'";
						$stmt = $dbh->query($query);
						$row = $stmt->fetch();
							
						echo "<p>You successfully challenged <a href='stats.php?player=$challenged'>".$row['username']."</a>, you will be notified when <a href='stats.php?player=$challenged'>".$row['username']."</a> replies to your challenge.<br /></p>";
					}
					else
						echo '<p>Error when trying to add the challenge. Please contact the site administrators.</p>';
					}
			catch(PDOException $e) 
				// tratamiento del error
				echo "error: ".$e->GetMessage();
			}
		}
	}
}
else
	needLoggedIn();
include_once('inc/footer.php');  