<?php
    include_once("../../conexionli.php");
    $accion = '';
    $firstnSector = 0;
    if(isset($_GET['accion']))   { $accion = $_GET['accion'];       }

    if(isset($_POST['guardarSector'])){
        if(isset($_POST['nSector']))  { $nSector    = $_POST['nSector'];    }
        if(isset($_POST['Sector']))   { $Producto = $_POST['Sector'];       }
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
        $bd=$link->query("SELECT * FROM sectores Where nSector = '".$_POST['nSector']."'");
        if($row=mysqli_fetch_array($bd)){
            if(!$imagen){
                if($row['imagen']){
                    $imagen = $row['imagen'];
                }
            }
            //echo $_POST['idSub'];
            $actSQL="UPDATE sectores SET ";
            $actSQL.="Sector            = '".$_POST['Sector'].              "',";
            $actSQL.="Descripcion       = '".$_POST['Descripcion'].         "'";
            $actSQL.="WHERE nSector     = '".$_POST['nSector']."'";
            $bdAct=$link->query($actSQL);
        }else{
            $nSector            = $_POST['nSector'];
            $Descripcion        = $_POST['Descripcion'];
            $Sector             = $_POST['Sector'];

            $link->query("insert into sectores  (   nSector             ,
                                                    Descripcion         
                                                ) 
                                        values (    '$nSector'          ,
                                                    '$Descripcion'      
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
                    <h1 class="page-header">Sectores</h1>
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
                                    DataTables Sectores
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#           </th>
                                                <th>Sectores        </th>
                                                <th>Acción      </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstnSector = 0;
                                                $link=Conectarse();
                                                $bd=$link->query("SELECT * FROM sectores Order By nSector");
                                                while($row=mysqli_fetch_array($bd)){
                                                    if($firstnSector == 0){
                                                        $firstnSector = $row['nSector'];
                                                    }

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['nSector']; ?>        </td>
                                                        <td>
                                                            <?php 
                                                                    echo $row['Sector'];
                                                            ?>        
                                                        </td>
                                                        <td class="center text-center">
                                                            <a type="submit" href="index.php?nSector=<?php echo $row['nSector']; ?>" class="btn btn-success">
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
                                        if(isset($_GET['nSector'])) { $firstnSector = $_GET['nSector'];   }

                                        if(isset($_POST['nSector'])) { $firstnSector = $_POST['nSector'];   }


                                        if(isset($_GET['accion']) == 'NewSector'){
                                            echo '<h4>Nuevo Sector</h4>';

                                            $SQL = "SELECT * FROM sectores Order By nSector Desc";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                $firstnSector = $row['nSector'] + 1;
                                                //echo $row['nSector'];
                                            }
                                            $link->close();
                                            //echo $firstnSector;

                                        }
                                        $SQL = "SELECT * FROM sectores Where nSector = '$firstnSector'";
                                        $link=Conectarse();
                                        $bd=$link->query($SQL);
                                        if($row=mysqli_fetch_array($bd)){
                                            echo '<h4>'.$row['Sector'].'</h4>';
                                            $firstnSector = $row['nSector'];
                                            //echo $firstnSector;
                                        }
                                        $link->close();
                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form name="formSectores" method="post" action="index.php" enctype="multipart/form-data">
                                    <div class="panel-body">
                                            <input type="hidden" class="form-control" name="nSector" value="<?php echo $firstnSector; ?>" autofocus required />
                                            <div class="form-group">
                                                <label for="Producto">Sector</label>
                                                <input type="text" class="form-control" name="Sector" value="<?php echo $row['Sector']; ?>" autofocus required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Descripcion">Descipción Sector</label>
                                                <textarea class="form-control" rows="2" id="Descripcion" name="Descripcion" maxlength="160" required><?php echo $row['Descripcion']; ?></textarea> 
                                            </div>

                                            

                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" name="guardarSector" class="btn btn-primary">Guardar</button>
                                         <a type="submit" href="index.php?accion=NewSector" class="btn btn-info" style="float:right;">
                                            Agregar Sector
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
