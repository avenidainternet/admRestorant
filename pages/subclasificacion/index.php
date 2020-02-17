<?php
    include_once("../../conexionli.php");
    $accion = '';
    $firstidCat = 0;
    if(isset($_GET['accion']))   { $accion = $_GET['accion'];       }

    if(isset($_POST['eliminarClasificacion'])){
        $link=Conectarse();
        $bd=$link->query("DELETE FROM invsubclasificacion Where idCat = '".$_POST['idCat']."' and idSub = '".$_POST['idSub']."'");
        $link->close();

    }
    if(isset($_POST['guardarClasificacion'])){
        if(isset($_POST['idCat']))              { $idCat            = $_POST['idCat'];              }
        if(isset($_POST['idSub']))              { $idSub            = $_POST['idSub'];              }
        if(isset($_POST['SubClasificacion']))   { $SubClasificacion = $_POST['SubClasificacion'];   }

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
        $bd=$link->query("SELECT * FROM invsubclasificacion Where idCat = '".$_POST['idCat']."' and idSub = '".$_POST['idSub']."'");
        if($row=mysqli_fetch_array($bd)){
            if(!$imagen){
                if($row['imagen']){
                    $imagen = $row['imagen'];
                }
            }
            //echo $_POST['idSub'];
            $actSQL="UPDATE invsubclasificacion SET ";
            $actSQL.="SubClasificacion  = '".$_POST['SubClasificacion'].  "'";
            $actSQL.="WHERE idCat       = '".$_POST['idCat']."' and idSub = '".$_POST['idSub']."'";
            $bdAct=$link->query($actSQL);
        }else{
            $idCat              = $_POST['idCat'];
            $idSub              = $_POST['idSub'];
            $SubClasificacion   = $_POST['SubClasificacion'];

            $link->query("insert into invsubclasificacion   (   idCat               ,
                                                                idSub               ,
                                                                SubClasificacion    
                                                            ) 
                                                    values  (   '$idCat'            ,
                                                                '$idSub'            ,      
                                                                '$SubClasificacion'      
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
                    <h1 class="page-header">Sub Clasificación</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">26</div>
                                    <div>Clasificación!</div>
                                </div>
                            </div>
                        </div>
                        <a href="../clasificacion/">
                            <div class="panel-footer">
                                <span class="pull-left">Ir a Clasificación</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>Sub Clasificación!</div>
                                </div>
                            </div>
                        </div>
                        <a href="../subclasificacion/">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
                                    <div>Inventario!</div>
                                </div>
                            </div>
                        </div>
                        <a href="../inventario/">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Stock!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->




            
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-7">

                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding: 15px;">
                                    DataTables Sub Clasificación
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#               </th>
                                                <th>Clasificación   </th>
                                                <th>Sub Clasificación   </th>
                                                <th>Acción          </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstidSub = 0;
                                                $firstidCat = 0;
                                                $link=Conectarse();
                                                $bd=$link->query("SELECT * FROM invsubclasificacion Order By idCat");
                                                while($row=mysqli_fetch_array($bd)){
                                                    if($firstidSub == 0){
                                                        $firstidCat = $row['idCat'];
                                                        $firstidSub = $row['idSub'];
                                                    }
                                                    $boton = 'btn btn-success';

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['idCat'].'.'.$row['idSub']; ?>        </td>
                                                        <td>
                                                            <?php 
                                                                $bdcla=$link->query("SELECT * FROM invclasificacion where idCat = '".$row['idCat']."'");
                                                                if($rowcla=mysqli_fetch_array($bdcla)){
                                                                    echo $rowcla['Clasificacion'];
                                                                }
                                                            ?>        
                                                        </td>

                                                        <td>
                                                            <?php 
                                                                    echo $row['SubClasificacion'];
                                                            ?>        
                                                        </td>
                                                        <td class="center text-center">
                                                            <a type="submit" href="index.php?idCat=<?php echo $row['idCat']; ?>&idSub=<?php echo $row['idSub']; ?>" class="<?php echo $boton; ?>">
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
                                        if(isset($_GET['idCat']))    { $firstidCat = $_GET['idCat'];       }
                                        if(isset($_GET['idSub']))    { $firstidSub = $_GET['idSub'];       }
                                        if(isset($_POST['idCat']))   { $firstidCat = $_POST['idCat'];      }
                                        if(isset($_POST['idSub']))   { $firstidSub = $_POST['idSub'];      }


                                        if(isset($_GET['accion']) == 'NewSubClasificacion'){
                                            echo '<h4>Nueva Sub Clasificación</h4>';

                                            $SQL = "SELECT * FROM invsubclasificacion Where idCat = '$firstidCat' Order By idSub Desc";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                $firstidSub = $row['idSub'] + 1;
                                                //echo $row['nSector'];
                                            }
                                            $link->close();
                                            //echo $firstidCat;

                                        }
                                        $SQL = "SELECT * FROM invsubclasificacion Where idCat = '$firstidCat' and idSub = '$firstidSub'";
                                        $link=Conectarse();
                                        $bd=$link->query($SQL);
                                        if($row=mysqli_fetch_array($bd)){
                                            echo '<h4>'.$row['SubClasificacion'].'</h4>';
                                            $firstidSub = $row['idSub'];
                                            //echo $firstnSector;
                                        }
                                        $link->close();
                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form name="formSectores" method="post" action="index.php" enctype="multipart/form-data">
                                    <div class="panel-body">
                                            <input type="hidden" class="form-control" name="idCat" value="<?php echo $firstidCat; ?>" />
                                            <input type="hidden" class="form-control" name="idSub" value="<?php echo $firstidSub; ?>" />
                                            <div class="form-group">
                                                <label for="idCat">Clasificación</label>
                                                <select name="idCat" class="form-control">
                                                <?php
                                                    $link=Conectarse();
                                                    $bdcat=$link->query("SELECT * FROM invclasificacion Order By idCat");
                                                    while($rowcat=mysqli_fetch_array($bdcat)){
                                                        if($rowcat['idCat'] == $row['idCat']){?>
                                                            <option selected value="<?php echo $rowcat['idCat']; ?>"><?php echo $rowcat['Clasificacion']; ?></option>
                                                            <?php
                                                        }else{?>
                                                            <option value="<?php echo $rowcat['idCat']; ?>"><?php echo $rowcat['Clasificacion']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    $link->close();
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="SubClasificacion">Sub Clasificación</label>
                                                <input type="text" class="form-control" name="SubClasificacion" value="<?php echo $row['SubClasificacion']; ?>" autofocus required />
                                            </div>

                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" name="guardarClasificacion" class="btn btn-primary">Guardar</button>
                                        <button type="submit" name="eliminarClasificacion" class="btn btn-danger">Eliminar</button>

                                         <a type="submit" href="index.php?accion=NewClasificacion&idCat=<?php echo $rowcla['idCat']; ?>" class="btn btn-info" style="float:right;">
                                            Agregar Sub Clasificación
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
