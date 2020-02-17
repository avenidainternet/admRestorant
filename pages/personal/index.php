<?php
    include_once("../../conexionli.php");
    $accion = '';
    $firstnControl = 0;
    $Estado = 'on';
    if(isset($_GET['accion']))   { $accion = $_GET['accion'];       }

    if(isset($_POST['eliminarPersonal'])){
        if(isset($_POST['nControl']))          { $nControl            = $_POST['nControl'];          }
        $SQL = "DELETE FROM personal where nControl = '$nControl'";
        $link=Conectarse();
        $bd=$link->query($SQL);
        $link->close();
    }
    if(isset($_POST['guardarPersonal'])){
        if(isset($_POST['nControl']))       { $nControl         = $_POST['nControl'];       }
        if(isset($_POST['Rut']))            { $Rut              = $_POST['Rut'];            }
        if(isset($_POST['Nombre']))         { $Nombre           = $_POST['Nombre'];         }
        if(isset($_POST['Paterno']))        { $Paterno          = $_POST['Paterno'];        }
        if(isset($_POST['Materno']))        { $Materno          = $_POST['Materno'];        }
        if(isset($_POST['nPerfil']))        { $nPerfil          = $_POST['nPerfil'];        }

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
        $bd=$link->query("SELECT * FROM personal Where nControl = '".$_POST['nControl']."'");
        if($row=mysqli_fetch_array($bd)){
            if(!$imagen){
                if($row['imagen']){
                    $imagen = $row['imagen'];
                }
            }
            //echo $_POST['nPerfil'];
            $actSQL="UPDATE personal SET ";
            $actSQL.="Rut               = '".$_POST['Rut'].                 "',";
            $actSQL.="Nombre            = '".$_POST['Nombre'].              "',";
            $actSQL.="Paterno           = '".$_POST['Paterno'].             "',";
            $actSQL.="Materno           = '".$_POST['Materno'].             "',";
            $actSQL.="nPerfil           = '".$_POST['nPerfil'].             "',";
            $actSQL.="Estado            = '".$_POST['Estado'].              "'";
            $actSQL.="WHERE nControl    = '".$_POST['nControl']."'";
            $bdAct=$link->query($actSQL);
        }else{
            $nControl           = $_POST['nControl'];
            $Rut                = $_POST['Rut'];
            $Nombre             = $_POST['Nombre'];
            $Paterno            = $_POST['Paterno'];
            $Materno            = $_POST['Materno'];
            $Estado             = $_POST['Estado'];

            $link->query("insert into personal (    nControl            ,
                                                    Rut                 ,    
                                                    Nombre              ,    
                                                    Paterno             ,    
                                                    Materno             ,    
                                                    nPerfil             ,    
                                                    Estado   
                                                ) 
                                        values (    '$nControl'         ,
                                                    '$Rut'              ,
                                                    '$Nombre'           ,     
                                                    '$Paterno'          ,     
                                                    '$Materno'          ,     
                                                    '$nPerfil'          ,     
                                                    '$Estado'    
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
                    <h1 class="page-header">Personal</h1>
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
                                    DataTables Personal
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#           </th>
                                                <th>Rut         </th>
                                                <th>Nombres     </th>
                                                <th>Perfil      </th>
                                                <th>Acción      </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstnControl = 0;
                                                $link=Conectarse();
                                                $bd=$link->query("SELECT * FROM personal Order By nControl Asc");
                                                while($row=mysqli_fetch_array($bd)){
                                                    if($firstnControl == 0){
                                                        $firstnControl = $row['nControl'];
                                                    }
                                                    $boton = 'btn btn-info';
                                                    if($row['Logeado'] == 'on'){
                                                        $boton = 'btn btn-success';
                                                    }

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['nControl']; ?>        </td>
                                                        <td><?php echo $row['Rut']; ?>        </td>
                                                        <td><?php echo $row['Nombre'].' '.$row['Paterno'];?>   </td>
                                                        <td>
                                                            <?php 
                                                                $bdsec=$link->query("SELECT * FROM perfiles where nPerfil = '".$row['nPerfil']."'");
                                                                if($rowsec=mysqli_fetch_array($bdsec)){
                                                                    echo $rowsec['Perfil']; 
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="center text-center">
                                                            <a type="submit" href="index.php?nControl=<?php echo $row['nControl']; ?>" class="<?php echo $boton; ?>">
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
                                        if(isset($_GET['nControl']))    { $firstnControl = $_GET['nControl'];       }
                                        if(isset($_POST['nControl']))   { $firstnControl = $_POST['nControl'];      }


                                        if(isset($_GET['accion']) == 'NewMesa'){
                                            echo '<h4>Nuevo Personal</h4>';

                                            $SQL = "SELECT * FROM personal Order By nControl Desc";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                $firstnControl = $row['nControl'] + 1;
                                                //echo $row['nSector'];
                                            }
                                            $link->close();
                                            //echo $firstnControl;

                                        }
                                        $SQL = "SELECT * FROM personal Where nControl = '$firstnControl'";
                                        $link=Conectarse();
                                        $bd=$link->query($SQL);
                                        if($row=mysqli_fetch_array($bd)){
                                            echo '<h4>'.$row['Nombre'].' '.$row['Paterno'].'</h4>';
                                            $firstnMesa = $row['nControl'];
                                            //echo $firstnSector;
                                        }
                                        $link->close();
                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form name="formSectores" method="post" action="index.php" enctype="multipart/form-data">
                                    <div class="panel-body">
                                            <input type="hidden" class="form-control" name="nControl" value="<?php echo $firstnControl; ?>" />

                                            <input type="hidden" class="form-control" name="Estado" value="on" />



                                            <div class="form-group">
                                                <label for="Rut">RUT</label>
                                                <input type="text" class="form-control" name="Rut" value="<?php echo $row['Rut']; ?>" autofocus required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Nombre">Nombre</label>
                                                <input type="text" class="form-control" name="Nombre" value="<?php echo $row['Nombre']; ?>" required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Paterno">Paterno</label>
                                                <input type="text" class="form-control" name="Paterno" value="<?php echo $row['Paterno']; ?>" required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Materno">Materno</label>
                                                <input type="text" class="form-control" name="Materno" value="<?php echo $row['Materno']; ?>" required />
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="nPerfil">Perfil</label>
                                                <select name="nPerfil" class="form-control">
                                                <?php
                                                    $link=Conectarse();
                                                    $bdsec=$link->query("SELECT * FROM perfiles Order By nPerfil");
                                                    while($rowsec=mysqli_fetch_array($bdsec)){
                                                        if($rowsec['nPerfil'] == $row['nPerfil']){?>
                                                            <option selected value="<?php echo $rowsec['nPerfil']; ?>"><?php echo $rowsec['Perfil']; ?></option>
                                                            <?php
                                                        }else{?>
                                                            <option value="<?php echo $rowsec['nPerfil']; ?>"><?php echo $rowsec['Perfil']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    $link->close();
                                                ?>
                                                </select>
                                            </div>


                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" name="guardarPersonal" class="btn btn-primary">Guardar</button>
                                        <button type="submit" name="eliminarPersonal" class="btn btn-danger">Eliminar</button>

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
