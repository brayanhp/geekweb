<?php
$id_rutas = $_GET['id_ruta'];
$rutas = explode("-", $id_rutas);
$ruta1= $rutas[0];
$ruta2= $rutas[1];
$ruta3= $rutas[2];
// Get conection

ini_set('display_errors', 1);

$data = array();

if(  is_readable(  $db_cnn = 'db-cnn.php' ) )
{
  require_once $db_cnn ;

  if( !$error )
  {

    $query_base = $db->query( "SELECT * FROM  arqueologos WHERE ID=$ruta1 OR ID=$ruta2 OR ID=$ruta3" );

    $rows = $query_base->fetchAll( PDO::FETCH_ASSOC );

    if( count( $rows ) ) $data = $rows ;  
  }
 
}
$location1 = $data[0]['LATITUD'].','.$data[0]['LONGITUD'];
$location2 = $data[1]['LATITUD'].','.$data[1]['LONGITUD'];
$location3 = $data[2]['LATITUD'].','.$data[2]['LONGITUD'];


// GENERA NUEVO VOTO

# Capturamos la IP Actual
$ip = $_SERVER[ 'REMOTE_ADDR' ];

$vote = false ;
$vote_error = false ;
$ip_have_voted = false ;

# Verificamos los datos enviados
if(  isset( $_POST['ruta_to_vote'] )  && preg_match('/^[0-9\-]+$/', $_POST['ruta_to_vote'] ) )
{
  $code = $_POST['ruta_to_vote'] ;

  # Indica que se ha enviado un voto
  $vote = true ;

  # Verificamos el archivo de configuracion
  if(  is_readable(  $db_cnn = 'db-cnn.php' ) )
  {
    # Llamamos al archivo de configuracion
    require_once $db_cnn ;

    //echo "SELECT * FROM  vote WHERE IP = $ip " ;
    
    # Primera consulta para verificar que la ip ya haya sido registrada
    $query_check_ip   = $db->query( "SELECT * FROM  vote WHERE IP = '$ip' " );
    $result_check_ip  = $query_check_ip->fetchAll( PDO::FETCH_ASSOC );

    // Si la IP ya ha sido registrada
    if( count( $result_check_ip ) )
    {
      $vote_error = true ;
      $ip_have_voted = true ;
    }
    else
    {
        # Obtenemos el total

        $query_vote   = $db->query( "SELECT * FROM  vote WHERE CODE_VOTE = '$code' ;" );
        $result_vote  = $query_vote->fetch( PDO::FETCH_ASSOC );

        if( $result_vote  )
        {
          $sentencia = $db->prepare( 'UPDATE vote SET TOTAL = ? WHERE ID = ? ' );
          $sentencia->execute( array( ( $result_vote['TOTAL'] + 1 ) , $result_vote['ID'] ) );
        }
        else
        {
          $sentencia = $db->prepare( 'INSERT INTO vote ( IP , CODE_VOTE , TOTAL ) values ( ? , ? , ? , ? ); ' );
          $sentencia->execute( array( $ip , $code , 1 , 'SA') );
        }

    }

  }
}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/geekweb.css">
  </head>
  <body onload="calcRoute();">
    
    <?php

    if(  is_readable(  $menu = 'menu.php' ) )
    {
      require_once $menu ;

    }

    ?>

    <div class="container list-rutas">

      <?php

      if( $vote && !$vote_error  )
      {
        ?>
        <div class="alert alert-success">
          <a href="#" class="alert-link">Se ha registrado con exito su voto. Gracias.=)</a>
        </div>
        <?php
      }
      else if( $vote && $vote_error )
      {
        ?>
        <div class="alert alert-danger">
          <a href="#" class="alert-link">
            Ocurrio un problema al registrar su voto

            <?php

            echo ( $ip_have_voted ? ' , ya se ha registrado un voto desde su direccion.' : '' );

            ?>
          </a>
        </div>
        <?php
      }

      ?>

     <?php
      foreach ( $data as $kData => $vData ) {

        echo '<blockquote>';
          echo '<div class="row">' ;
            echo '<div class="col-md-12">' ;
              echo '<div class="col-md-12"><strong>'.utf8_encode( $vData[ 'NOMBRE' ] ).'</strong></div>';
            echo '</div>';

            echo '</div>' ;
              echo '<div class="row btn-list"><div class="col-md-12">';
              echo  '<div class="col-md-3 pull-right"><a href="mapa_only.php?id_ruta='.$vData[ 'ID' ].'" class="btn btn-success" >Ver Mapa</a></div> ';
            echo '</div>';

        echo '</blockquote>';

      }

      echo '<form action="" method="POST">';
      echo '<p class="text-center">' ;
        echo '<a  href="mapa_arq.php?id_ruta='.$_GET[ 'id_ruta' ].'" class="btn btn-primary">Ver Ruta Completa</a><small>&nbsp;</small>' ;
        
        
        echo '<input type="hidden" name="send_vote" value="1">';
        echo '<input type="hidden" name="ruta_to_vote" value="'.$_GET['id_ruta'].'">';
        echo '<input type="submit" class="btn btn-success" value="Dar Punto" >';
      echo '<p>' ;
      echo '</form>';
     ?>
    </div>
  </body>
</html>