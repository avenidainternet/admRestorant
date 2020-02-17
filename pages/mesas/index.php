<?php
    include_once("../../conexionli.php");
    date_default_timezone_set("America/Santiago");
    $accion = '';
    $firstnControl = 0;
    if(isset($_GET['accion']))   { $accion = $_GET['accion'];       }

    if(isset($_POST['eliminarMesa'])){
        if(isset($_POST['nMesa']))          { $nMesa            = $_POST['nMesa'];          }
        $SQL = "DELETE FROM mesas where nMesa = '$nMesa'";
        $link=Conectarse();
        $bd=$link->query($SQL);
        $link->close();
    }
    if(isset($_POST['guardarMesa'])){
        if(isset($_POST['nMesa']))          { $nMesa            = $_POST['nMesa'];          }
        if(isset($_POST['Descripcion']))    { $Descripcion      = $_POST['Descripcion'];    }
        if(isset($_POST['nCapacidad']))     { $nCapacidad       = $_POST['nCapacidad'];     }
        if(isset($_POST['Estado']))         { $Estado           = $_POST['Estado'];         }
        if(isset($_POST['Reservada']))      { $Reservada        = $_POST['Reservada'];      }
        if(isset($_POST['horaReserva']))    { $horaReserva      = $_POST['horaReserva'];    }

        $imagen = '';

        if(isset($_FILES['img']['name'])){
            $nombre_archivo = $_FILES['img']['name'];
            $tipo_archivo   = $_FILES['img']['type'];
            $tamano_archivo = $_FILES['img']['size'];
            $desde          = $_FILES['img']['tmp_name'];
            
            
            $directorio="../../../images";
            //$directorio="imagenes/";
            if(($tipo_archivo == "image/jpeg" or $tipo_archivo == "image/png" or $tipo_archivo == "image/gif") ) { 
                
                if(move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
                    echo $nombre_archivo . ' ' . $tipo_archivo;
                    $imagen = $nombre_archivo;
                }
            }
        }
        $link=Conectarse();
        $bd=$link->query("SELECT * FROM mesas Where nMesa = '".$_POST['nMesa']."'");
        if($row=mysqli_fetch_array($bd)){
            if(!$imagen){
                if($row['imagen']){
                    $imagen = $row['imagen'];
                }
            }
            //echo $_POST['idSub'];
            $actSQL="UPDATE mesas SET ";
            $actSQL.="Descripcion       = '".$_POST['Descripcion'].         "',";
            $actSQL.="nSector           = '".$_POST['nSector'].             "',";
            $actSQL.="nCapacidad        = '".$_POST['nCapacidad'].          "',";
            $actSQL.="Estado            = '".$_POST['Estado'].              "',";
            $actSQL.="Reservada         = '".$_POST['Reservada'].           "',";
            $actSQL.="fechaReserva      = '".$_POST['fechaReserva'].        "',";
            $actSQL.="horaReserva       = '".$_POST['horaReserva'].         "'";
            $actSQL.="WHERE nMesa       = '".$_POST['nMesa']."'";
            $bdAct=$link->query($actSQL);
        }else{
            $Enuso          = 'off';
            $nMesa          = $_POST['nMesa'];
            $Descripcion    = $_POST['Descripcion'];
            $nCapacidad     = $_POST['nCapacidad'];
            $Estado         = $_POST['Estado'];
            $Enuso          = $_POST['Enuso'];

            $link->query("insert into mesas (   nMesa            ,
                                                Descripcion      ,    
                                                nCapacidad       ,
                                                Estado           ,
                                                Reservada        ,
                                                fechaReserva     ,
                                                horaReserva
                                                ) 
                                    values (    '$nMesa'         ,
                                                '$Descripcion'   ,
                                                '$nCapacidad'    ,   
                                                '$Estado'        ,    
                                                '$Reservada'     ,    
                                                '$fechaReserva'  ,
                                                '$horaReserva'  
                                                )");
        }
        $link->close();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Backend Restaurant El Caulle</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <?php include('menuPpal.php'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Mesas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-7">

                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding: 15px;">
                                    DataTables Mesas
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#           </th>
                                                <th>Descripción </th>
                                                <th>Cap.        </th>
                                                <th>Sector      </th>
                                                <th>Situación   </th>
                                                <th>Acción      </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstnMesa = 0;
                                                $link=Conectarse();
                                                $bd=$link->query("SELECT * FROM mesas Order By nMesa Asc");
                                                while($row=mysqli_fetch_array($bd)){
                                                    if($firstnMesa == 0){
                                                        $firstnMesa = $row['nMesa'];
                                                    }
                                                    $boton = 'btn btn-info';
                                                    if($row['Estado'] == 'on'){
                                                        $boton = 'btn btn-success';
                                                    }
                                                    if($row['Reservada'] == 'on'){
                                                        $boton = 'btn btn-warning';
                                                    }

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['nMesa']; ?>        </td>
                                                        <td><?php echo $row['Descripcion'];?>   </td>
                                                        <td><?php echo $row['nCapacidad'];?>   </td>
                                                        <td>
                                                            <?php 
                                                                $bdsec=$link->query("SELECT * FROM sectores where nSector = '".$row['nSector']."'");
                                                                if($rowsec=mysqli_fetch_array($bdsec)){
                                                                    echo $rowsec['Sector']; 
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($row['Enuso'] == 'on'){
                                                                    echo 'En uso';
                                                                }else{
                                                                    echo '<div>Disponible</div>';
                                                                }
                                                                if($row['Reservada'] == 'on'){
                                                                    $fechaHoy = date('Y-m-d');
                                                                    $horaHoy = date('H:m:s');
                                                                    //echo '<br>'.$horaHoy;
                                                                    if($row['fechaReserva'] == $fechaHoy){
                                                                        echo '<br><b>'.$row['fechaReserva'].'</b>';
                                                                        echo '<br><b>'.$row['horaReserva'].'</b>';
                                                                    }
                                                                }

                                                            ?>
                                                        </td>
                                                        <td class="center text-center">
                                                            <a type="submit" href="index.php?nMesa=<?php echo $row['nMesa']; ?>" class="<?php echo $boton; ?>">
                                                                Ver
                                                            </a>
                                                        </td>  
                                                    </tr>
                                                    <?php
                                                }
                                                $link->close();
                                            ?>
                                          
                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>


                        </div>
                        <div class="col-lg-5">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    
                                    <?php
                                        $Accion = '';
                                        if(isset($_GET['nMesa']))    { $firstnMesa = $_GET['nMesa'];       }
                                        if(isset($_POST['nMesa']))   { $firstnMesa = $_POST['nMesa'];      }


                                        if(isset($_GET['accion']) == 'NewMesa'){
                                            echo '<h4>Nueva Mesa</h4>';

                                            $SQL = "SELECT * FROM mesas Order By nMesa Desc";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                $firstnMesa = $row['nMesa'] + 1;
                                                //echo $row['nSector'];
                                            }
                                            $link->close();
                                            //echo $firstnControl;

                                        }
                                        $SQL = "SELECT * FROM mesas Where nMesa = '$firstnMesa'";
                                        $link=Conectarse();
                                        $bd=$link->query($SQL);
                                        if($row=mysqli_fetch_array($bd)){
                                            echo '<h4>'.$row['Descripcion'].'</h4>';
                                            $firstnMesa = $row['nMesa'];
                                            //echo $firstnSector;
                                        }
                                        $link->close();
                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form name="formSectores" method="post" action="index.php" enctype="multipart/form-data">
                                    <div class="panel-body">
                                            <input type="hidden" class="form-control" name="nMesa" value="<?php echo $firstnMesa; ?>" />
                                            <div class="form-group">
                                                <label for="Descripcion">Identificación Mesa</label>
                                                <input type="text" class="form-control" name="Descripcion" value="<?php echo $row['Descripcion']; ?>" autofocus required />
                                            </div>

                                            <div class="form-group">
                                                <label for="nCapacidad">Capacidad</label>
                                                <input type="text" class="form-control" name="nCapacidad" value="<?php echo $row['nCapacidad']; ?>" required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Reservada">Reservada</label>
                                                <select name="Reservada" class="form-control">
                                                <?php
                                                    if($row['Reservada'] == 'on'){?>
                                                        <option selected value="on">Reservada</option>
                                                        <option value="off">Disponible</option>
                                                            <?php
                                                    }else{?>
                                                            <option value="on">Reservada</option>
                                                            <option selected value="off">Disponible</option>
                                                            <?php
                                                    }
                                                    $link->close();
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="fechaReserva">Fecha Reserva</label>
                                                <input type="date" class="form-control" name="fechaReserva" value="<?php echo $row['fechaReserva']; ?>" required />
                                            </div>
                                            <div class="form-group">
                                                <label for="horaReserva">Hora Reserva</label>
                                                <input type="time" class="form-control" name="horaReserva" value="<?php echo $row['horaReserva']; ?>" required />
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="nSector">Sector</label>
                                                <select name="nSector" class="form-control">
                                                <?php
                                                    $link=Conectarse();
                                                    $bdsec=$link->query("SELECT * FROM sectores Order By nSector");
                                                    while($rowsec=mysqli_fetch_array($bdsec)){
                                                        if($rowsec['nSector'] == $row['nSector']){?>
                                                            <option selected value="<?php echo $rowsec['nSector']; ?>"><?php echo $rowsec['Sector']; ?></option>
                                                            <?php
                                                        }else{?>
                                                            <option value="<?php echo $rowsec['nSector']; ?>"><?php echo $rowsec['Sector']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    $link->close();
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nSector">Estado</label>
                                                <select name="Estado" class="form-control">
                                                <?php
                                                    if($row['Estado'] == 'on'){?>
                                                        <option selected value="on">Activa</option>
                                                        <option value="off">Cerrado</option>
                                                            <?php
                                                    }else{?>
                                                            <option value="on">Activa</option>
                                                            <option selected value="off">Cerrado</option>
                                                            <?php
                                                    }
                                                    $link->close();
                                                ?>
                                                </select>
                                            </div>


                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" name="guardarMesa" class="btn btn-primary">Guardar</button>
                                        <button type="submit" name="eliminarMesa" class="btn btn-danger">Eliminar</button>

                                         <a type="submit" href="index.php?accion=NewMesa" class="btn btn-info" style="float:right;">
                                            Agregar Mesa
                                        </a>
                                        
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
