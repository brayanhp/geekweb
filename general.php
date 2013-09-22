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

		$query_base = $db->query( "SELECT * FROM  museos WHERE LATITUD < - 12.064384AND LONGITUD < - 77.036986ORDER BY  `LATITUD` ,  `LONGITUD` ASC" );

		$rows = $query_base->fetchAll( PDO::FETCH_ASSOC );

		if( count( $rows ) ) $data_museo = $rows ;	
	}
	
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

<div class="container first-map preload" id="mapcanvas">
	<i class="icon-spinner icon-spin icon-large"></i>Cargando
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

						
					echo '<blockquote>';
			          echo '<div class="row">' ;
			            echo '<div class="col-md-12">' ;
			              echo '<div class="col-md-12"><strong>'.utf8_encode( $vData[ 'NOMBRE_DEL_MUSEO' ] ).'</strong></div>';
			              echo '<div class="col-md-3">Direccion: </div><div class="col-md-9">'.utf8_encode( $vData[ 'DIRECCION' ] ).'</div>';
			              echo '<div class="col-md-3">Atención: </div><div class="col-md-9">'.utf8_encode( $vData[ 'HORARIO_ATENCION' ] ).'</div>';
			              echo '<div class="col-md-3">Telefono: </div><div class="col-md-9">'.utf8_encode( $vData[ 'TELEFONO' ] ).'</div>';
			              echo '<div class="col-md-3">Costo: </div><div class="col-md-9">'.utf8_encode( $vData['COSTO'] ).'</div>';
			            echo '</div>';

			            echo '</div>' ;
			              echo '<div class="row btn-list"><div class="col-md-12">';
			              echo  '<div class="col-md-3 pull-right"><a href="mapa_only.php?id_ruta='.$vData[ 'ID' ].'" class="btn btn-success" >Ver Mapa</a></div> ';
			            echo '</div>';

			        echo '</blockquote>';

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