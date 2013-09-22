<?php

// Get conection

ini_set('display_errors', 1);

$data_museo = array();
$data_sitiosArq = array();

if(  is_readable(  $db_cnn = 'db-cnn.php' ) )
{
	require_once $db_cnn ;

	if( !$error )
	{

		$query_base = $db->query( "SELECT * FROM  museos WHERE (LATITUD < - 12.064384 AND LONGITUD < - 77.036986) OR (LATITUD > - 12.064384 AND LONGITUD > - 77.036986) ORDER BY  `LATITUD` ,  `LONGITUD` ASC" );

		$rows = $query_base->fetchAll( PDO::FETCH_ASSOC );

		if( count( $rows ) ) $data_museo = $rows ;	

		$query_base2 = $db->query( "SELECT * FROM  arqueologos WHERE (LATITUD < - 12.064384 AND LONGITUD < - 77.036986)  OR (LATITUD > - 12.064384 AND LONGITUD > - 77.036986) ORDER BY  `LATITUD` ,  `LONGITUD` ASC LIMIT 27" );

		$rowsito = $query_base2->fetchAll( PDO::FETCH_ASSOC );

		if( count( $rowsito ) ) $data_sitiosArq = $rowsito ;	
	}
	
}

?>

<!DOCTYPE html>
<html lang="es">
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

<div class="container first-map preload" id="mapcanvas">
	<i class="icon-spinner icon-spin icon-large"></i>Cargando
	<p><span id="status" >found you!</span></p>
</div>

<div class="container sub-menu-geekweb list-rutas">


	<ul class="nav nav-tabs" id="myTab">
	  <li class="active"><a href="#museos_id">Museos</a></li>
	  <li><a href="#arqueologos">Sitios Arqueologicos</a></li>
	</ul>

	<div class="tab-content">
	  <div class="tab-pane active" id="museos_id">
	  		<!-- MUSEOS START-->
	  		<?php

			if( count( $data_museo ) )
			{	
				$indices_usados = array();

				$next_row = 0 ;

				$count = 0 ;
					
				$list_id = '' ;
					
				foreach ( $data_museo as $kData => $vData ) {					

					if( !in_array( $kData  , $indices_usados ) )
					{	

						if( $count == 0 )
						{
							echo '<blockquote>' ;
						}

						if( array_key_exists( ( $next_row == 0 ? $next_row : $next_row++  ) , $data_museo ) )
						{
							array_push( $indices_usados  , $next_row );
						}

						echo '<div class="row">' ;

						if( $count == 0 )
						{
							echo  '<div class="col-md-3">Inicia en : </div> ';	
						}else if( $count == 2 )
						{
							echo  '<div class="col-md-3">Finaliza en : </div>';	
						}
						else
						{
							echo '<div class="col-md-3">Luego a :</div>' ;
						}

							echo '<div class="col-md-9">'.utf8_encode( $vData[ 'NOMBRE_DEL_MUSEO' ] ) . '</div>' ;	

							$list_id .= $vData[ 'ID' ] . ( $count == 2 ? '' : '-' ) ;

						echo '</div>';
		 
						if( $count == 2 )
						{
							echo '<div class="row btn-list"><div class="col-md-12">';
							echo  '<div class="col-md-3 pull-right"><a href="verdetalle.php?id_ruta='.$list_id.'" class="btn btn-primary">Ver Detalle</a></div> ';
							echo  '<div class="col-md-3 pull-right"><a href="mapa.php?id_ruta='.$list_id.'" class="btn btn-success" >Ver Mapa</a></div> ';
							echo '</div>';


							echo '</blockquote>' ;

							$list_id = '' ;
							$next_row = 0 ;
							$count = -1 ;

						}

						$count++ ;

					}

					?> 
					<?php
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
	  	
		if( count( $data_sitiosArq ) )
			{	
				$indices_usados = array();

				$next_row = 0 ;

				$count = 0 ;
					
				$list_id = '' ;
					
				foreach ( $data_sitiosArq as $kData => $vData ) {					

					if( !in_array( $kData  , $indices_usados ) )
					{	

						if( $count == 0 )
						{
							echo '<blockquote>' ;
						}

						if( array_key_exists( ( $next_row == 0 ? $next_row : $next_row++  ) , $data_sitiosArq ) )
						{
							array_push( $indices_usados  , $next_row );
						}

						echo '<div class="row">' ;

						if( $count == 0 )
						{
							echo  '<div class="col-md-3">Inicia en : </div> ';	
						}else if( $count == 2 )
						{
							echo  '<div class="col-md-3">Finaliza en : </div>';	
						}
						else
						{
							echo '<div class="col-md-3">Luego a :</div>' ;
						}

							echo '<div class="col-md-9">'.utf8_encode( $vData[ 'NOMBRE' ] ) . '</div>' ;	

							$list_id .= $vData[ 'ID' ] . ( $count == 2 ? '' : '-' ) ;

						echo '</div>';
		 
						if( $count == 2 )
						{
							echo '<div class="row btn-list"><div class="col-md-12">';
							echo  '<div class="col-md-3 pull-right"><a href="verdetalle_arq.php?id_ruta='.$list_id.'" class="btn btn-primary">Ver Detalle</a></div> ';
							echo  '<div class="col-md-3 pull-right"><a href="mapa_arq.php?id_ruta='.$list_id.'" class="btn btn-success" >Ver Mapa</a></div> ';
							echo '</div>';


							echo '</blockquote>' ;

							$list_id = '' ;
							$next_row = 0 ;
							$count = -1 ;

						}

						$count++ ;

					}

					?> 
					<?php
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

<!-- FOOTER -->
<div id="footer">
	<small>Proximamente en: </small>
	<img src="http://www.amadamadonna.com/business/images/Android_and_Apple-2-2.jpg" alt="footer">
</div>

<!-- SCRIPT -->

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> 
<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<script type="text/javascript" src="js/geekweb.js"></script>-

</body>
</html>