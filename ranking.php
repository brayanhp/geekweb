<?php

// Get conection

ini_set('display_errors', 1);

$data_ranking = array(); 
$data_ranking_arq = array(); 

if(  is_readable(  $db_cnn = 'db-cnn.php' ) )
{
	require_once $db_cnn ;

	$query_ranking = $db->query( "SELECT * FROM  vote WHERE ORIGEN = 'M' ORDER BY TOTAL DESC" );
	$data_ranking = $query_ranking->fetchAll( PDO::FETCH_ASSOC );

	$query_ranking_arq = $db->query( "SELECT * FROM  vote WHERE ORIGEN = 'SA' ORDER BY TOTAL DESC" );
	$result_ranking_arq = $query_ranking_arq->fetchAll( PDO::FETCH_ASSOC );

}

?>

<!DOCTYPE html>
<html lang="es-PE">
<head>
	<meta charset="utf-8">
	<title>GeekWeb</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/geekweb.css">
	<link rel="stylesheet" type="text/css" href="css/map.css">
</head>
<body onload="">

<?php

if(  is_readable(  $menu = 'menu.php' ) )
{
	require_once $menu ;

}

?>

<div class="container sub-menu-geekweb list-rutas">


	<ul class="nav nav-tabs" id="myTab">
	  <li class="active"><a href="#museos_id">Museos</a></li>
	  <li><a href="#arqueologos">Sitios Arqueologicos</a></li>
	</ul>

	<div class="tab-content">
	  <div class="tab-pane active" id="museos_id">
	  		<!-- MUSEOS START-->
	  		<?php

			if( count( $data_ranking ) )
			{	
				foreach ( $data_ranking as $kDRanking => $vDRanking ) {
				
					echo '<blockquote>';
			          echo '<div class="row">' ;
			            echo '<div class="col-md-12">' ;


				           	$code_explode = explode('-', $vDRanking[ 'CODE_VOTE' ] ); 

				           	$origen1 = $code_explode[ 0 ] ;
				           	$origen2 = $code_explode[ 1 ] ;	
				           	$origen3 = $code_explode[ 2 ] ;

				           	$query_org1 = $db->query( "SELECT * FROM  museos WHERE ID = $origen1 LIMIT 0,1" );
							$result_org1 = $query_org1->fetch( PDO::FETCH_ASSOC );

							$query_org2 = $db->query( "SELECT * FROM  museos WHERE ID = $origen2 LIMIT 0,1" );
							$result_org2 = $query_org2->fetch( PDO::FETCH_ASSOC );
							
							$query_org3 = $db->query( "SELECT * FROM  museos WHERE ID = $origen3 LIMIT 0,1" );
							$result_org3 = $query_org3->fetch( PDO::FETCH_ASSOC );	

							echo '<div class="col-md-3">Desde: </div><div class="col-md-9">'.utf8_encode( $result_org1[ 'NOMBRE_DEL_MUSEO' ] ).'</div>';
							echo '<div class="col-md-3">Luego: </div><div class="col-md-9">'.utf8_encode( $result_org2[ 'NOMBRE_DEL_MUSEO' ] ).'</div>';
							echo '<div class="col-md-3">Finaliza en : </div><div class="col-md-9">'.utf8_encode( $result_org3[ 'NOMBRE_DEL_MUSEO' ] ).'</div>';
			               
			              echo '<div class="col-md-3">Puntos: </div><div class="col-md-9"><span class="label label-success">'. $vDRanking['TOTAL'] .'</span></div>';
			            echo '</div>';

			            echo '</div>' ;
			              echo '<div class="row btn-list"><div class="col-md-12">';
			              echo  '<div class="col-md-3 pull-right"><a href="verdetalle.php?id_ruta='.$vDRanking[ 'CODE_VOTE' ].'" class="btn btn-primary" >Ver Detalle</a></div> ';
			              echo  '<div class="col-md-3 pull-right"><a href="mapa.php?id_ruta='.$vDRanking[ 'CODE_VOTE' ].'" class="btn btn-success" >Ver Mapa</a></div> ';

			            echo '</div>';

			        echo '</blockquote>';

				}
			}
			else
			{
				?>
				<blockquote>
				  <p>No se pudo determinar ninguna ubicacion de museos.</p>
				  <small>GeekWeb<cite title="Source Title">=).</cite></small>
				</blockquote>	
				<?php
			}

			?>
	  		<!-- / MUSEOS END-->
	  </div>
	  <div class="tab-pane" id="arqueologos">
	  	<?php

	  	if( count( $data_ranking_arq ) )
		{
			foreach ( $data_ranking_arq as $kDRankingArq => $vDRankingArq ) {
				
					echo '<blockquote>';
			          echo '<div class="row">' ;
			            echo '<div class="col-md-12">' ;


				           	$code_explode = explode('-', $vDRankingArq[ 'CODE_VOTE' ] ); 

				           	$origen1 = $code_explode[ 0 ] ;
				           	$origen2 = $code_explode[ 1 ] ;	
				           	$origen3 = $code_explode[ 2 ] ;

				           	$query_org1 = $db->query( "SELECT * FROM  arqueologos WHERE ID = $origen1 LIMIT 0,1" );
							$result_org1 = $query_org1->fetch( PDO::FETCH_ASSOC );

							$query_org2 = $db->query( "SELECT * FROM  arqueologos WHERE ID = $origen2 LIMIT 0,1" );
							$result_org2 = $query_org2->fetch( PDO::FETCH_ASSOC );
							
							$query_org3 = $db->query( "SELECT * FROM  arqueologos WHERE ID = $origen3 LIMIT 0,1" );
							$result_org3 = $query_org3->fetch( PDO::FETCH_ASSOC );	

							echo '<div class="col-md-3">Desde: </div><div class="col-md-9">'.utf8_encode( $result_org1[ 'NOMBRE_DEL_MUSEO' ] ).'</div>';
							echo '<div class="col-md-3">Luego: </div><div class="col-md-9">'.utf8_encode( $result_org2[ 'NOMBRE_DEL_MUSEO' ] ).'</div>';
							echo '<div class="col-md-3">Finaliza en : </div><div class="col-md-9">'.utf8_encode( $result_org3[ 'NOMBRE_DEL_MUSEO' ] ).'</div>';
			               
			              echo '<div class="col-md-3">Puntos: </div><div class="col-md-9"><span class="label label-success">'. $vDRankingArq['TOTAL'] .'</span></div>';
			            echo '</div>';

			            echo '</div>' ;
			              echo '<div class="row btn-list"><div class="col-md-12">';
			              echo  '<div class="col-md-3 pull-right"><a href="verdetalle.php?id_ruta='.$vDRankingArq[ 'CODE_VOTE' ].'" class="btn btn-primary" >Ver Detalle</a></div> ';
			              echo  '<div class="col-md-3 pull-right"><a href="mapa.php?id_ruta='.$vDRankingArq[ 'CODE_VOTE' ].'" class="btn btn-success" >Ver Mapa</a></div> ';

			            echo '</div>';

			        echo '</blockquote>';

				}	
		}
		else
		{
			?>
			<blockquote>
				<p>No se pudo determinar ninguna ubicacion de sitios arqueologicos.</p>
				<small>GeekWeb<cite title="Source Title">=).</cite></small>
			</blockquote>	
			<?php
		}
	  	
	  	?>
	  </div>
	</div>

</div>

<!-- SCRIPT -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<script type="text/javascript" src="js/geekweb.js"></script>

</body>
</html>