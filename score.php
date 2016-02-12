<?php
	include_once 'includes/db_connect.php';
	include_once 'core/stock_functions.php';

	$stmt4="	SELECT u.id as userid,u.tek_name as name,u.tek_email as email ,u.credit,p.stock_id,p.id, SUM((p.bought-p.sold)*p.value) AS stocktotal, SUM((p.bought-p.sold)*p.value)+u.credit AS total
            FROM vsm_user u 
            LEFT JOIN vsm_portfolio p ON u.id=p.user_id
            WHERE u.trashed = 0
            GROUP BY u.id
            ORDER BY total DESC";

            ?>

            <table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Total Score</th>
							</tr>
						</thead>
						<tbody>
            <?php
 	$query4=$con->query($stmt4);
 	$i=0;
 	while ($row=$query4->fetch_array(MYSQLI_ASSOC)) {
 		echo '
							<tr>
								<td>'.$i.'</td>
								<td>'.$row["name"].'</td>
								<td>'.$row["email"].'</td>
								<td>'.$row["total"].'</td>
							</tr>
						';
		$i++;
 	}


?>
</tbody>
					</table>
