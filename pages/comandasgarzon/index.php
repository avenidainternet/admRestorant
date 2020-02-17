<?php
    include_once("../../conexionli.php");
    date_default_timezone_set("America/Santiago");
    $fechaHoy = date('Y-m-d');
    $accion = '';
    $firstnControl = 0;
    if(isset($_GET['accion']))   { $accion = $_GET['accion'];       }

    if(isset($_POST['guardarProducto'])){
        if(isset($_POST['nControl']))       { $nControl     = $_POST['nControl'];       }
        if(isset($_POST['Producto']))       { $Producto     = $_POST['Producto'];       }
        if(isset($_POST['cBarra']))         { $cBarra       = $_POST['cBarra'];         }
        if(isset($_POST['Stock']))          { $Stock        = $_POST['Stock'];          }
        if(isset($_POST['StockCritico']))   { $StockCritico = $_POST['StockCritico'];   }
        if(isset($_POST['idCat']))          { $idCat        = $_POST['idCat'];          }
        if(isset($_POST['idSub']))          { $idSub        = $_POST['idSub'];          }
        if(isset($_POST['Costo']))          { $Costo        = $_POST['Costo'];          }
        if(isset($_POST['Margen']))         { $Margen       = $_POST['Margen'];         }
        if(isset($_POST['precioVenta']))    { $precioVenta  = $_POST['precioVenta'];    }

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
        $bd=$link->query("SELECT * FROM productos Where nControl = '".$_POST['nControl']."'");
        if($row=mysqli_fetch_array($bd)){
            if(!$imagen){
                if($row['imagen']){
                    $imagen = $row['imagen'];
                }
            }
            //echo $_POST['idSub'];
            $precioVenta = 0;
            if($_POST['Costo'] > 0 and $_POST['Margen'] > 0){
                $precioVenta = ($_POST['Costo'] * (1+($_POST['Margen']/100)));
            }else{
                if($_POST['precioVenta'] > 0){
                    $precioVenta = $_POST['precioVenta'];
                }
            }
            $actSQL="UPDATE productos SET ";
            $actSQL.="Producto          = '".$_POST['Producto'].            "',";
            $actSQL.="cBarra            = '".$_POST['cBarra'].              "',";
            $actSQL.="Stock             = '".$_POST['Stock'].               "',";
            $actSQL.="StockCritico      = '".$_POST['StockCritico'].        "',";
            $actSQL.="idCat             = '".$_POST['idCat'].               "',";
            $actSQL.="idSub             = '".$_POST['idSub'].               "',";
            $actSQL.="Costo             = '".$_POST['Costo'].               "',";
            $actSQL.="Margen            = '".$_POST['Margen'].              "',";
            $actSQL.="precioVenta       = '".$precioVenta.                  "'";
            $actSQL.="WHERE nControl    = '".$_POST['nControl']."'";
            $bdAct=$link->query($actSQL);
        }else{
            $nControl           = $_POST['nControl'];
            $Producto           = $_POST['Producto'];
            $cBarra             = $_POST['cBarra'];
            $Stock              = $_POST['Stock'];
            $StockCritico       = $_POST['StockCritico'];
            $Costo              = $_POST['Costo'];
            $Margen             = $_POST['Margen'];
            $precioVenta        = $_POST['precioVenta'];
            if($_POST['Costo'] > 0 and $_POST['Margen'] > 0){
                $precioVenta = ($_POST['Costo'] * (1+($_POST['Margen']/100)));
            }else{
                if($_POST['precioVenta'] > 0){
                    $precioVenta = $_POST['precioVenta'];
                }
            }
            $link->query("insert into productos (   nControl            ,
                                                    Producto            ,    
                                                    cBarra              ,    
                                                    Stock               ,    
                                                    StockCritico        ,    
                                                    idCat               ,    
                                                    idSub               ,        
                                                    Costo               ,        
                                                    Margen              ,        
                                                    precioVenta       
                                                ) 
                                        values (    '$nControl'         ,
                                                    '$Producto'         ,
                                                    '$cBarra'           ,
                                                    '$Stock'            ,
                                                    '$StockCritico'     ,
                                                    '$idCat'            ,
                                                    '$idSub'            ,
                                                    '$Costo'            ,
                                                    '$Margen'           ,
                                                    '$precioVenta'
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
                    <h1 class="page-header">Comandas <?php echo $fechaHoy; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding: 15px;">
                                    DataTables Comandas
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#           </th>
                                                <th>Mesa        </th>
                                                <th>Cuenta       </th>
                                                <th>Acción      </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstnComanda  = 0;
                                                $fechaComanda   = $fechaHoy;
                                                $link=Conectarse();
                                                $bd=$link->query("SELECT * FROM comandas where fechaComanda = '$fechaHoy'Order By nComanda Asc");
                                                while($row=mysqli_fetch_array($bd)){
                                                    if($firstnComanda == 0){
                                                        $firstnComanda = $row['nComanda'];
                                                    }
                                                    $boton = 'btn btn-success';
                                                    if($row['Stock'] < $row['StockCritico']){
                                                        $boton = 'btn btn-danger';
                                                    }
                                                    if($row['Stock'] == $row['StockCritico']){
                                                        $boton = 'btn btn-warning';
                                                    }

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['nComanda']; ?>        </td>
                                                        <td>
                                                            <?php 
                                                                    echo $row['nMesa'];
                                                            ?>        
                                                        </td>
                                                        <td><?php echo $row['MontoCuenta']; ?></td>
                                                        <td class="center text-center">
                                                            <a type="submit" href="index.php?nComanda=<?php echo $row['nComanda']; ?>" class="<?php echo $boton; ?>">
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
                        <div class="col-lg-6">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Comanda
                                    <?php
                                        $Accion = '';
                                        if(isset($_GET['nComanda']))    { $firstnComanda = $_GET['nComanda'];       }
                                        if(isset($_POST['nComanda']))   { $firstnComanda = $_POST['nComanda'];      }


                                        if(isset($_GET['accion']) == 'NewComanda'){
                                            
                                            $firstnComanda = 1;

                                            $SQL = "SELECT * FROM comandas where fechaComanda = '$fechaHoy' Order By nComanda Desc";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                $firstnComanda = $row['nComanda'] + 1;
                                            }
                                            $link->close();
                                            echo '<h4>Nueva Comanda Nº '.$firstnComanda.'</h4>';

                                        }
                                        $SQL = "SELECT * FROM comandas Where fechaComanda = '$fechaComanda' and nComanda = '$firstnComanda'";
                                        $link=Conectarse();
                                        $bd=$link->query($SQL);
                                        if($row=mysqli_fetch_array($bd)){
                                            echo '<h4>'.$row['nComanda'].'</h4>';
                                            $firstnComanda = $row['nComanda'];
                                            //echo $firstnSector;
                                        }
                                        $link->close();
                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <input type="hidden" class="form-control" name="nControl" value="<?php echo $firstnComanda; ?>" />   
                                    <input type="hidden" class="form-control" name="fechaComanda" value="<?php echo $fechaHoy; ?>" />

                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#           </th>
                                                <th>Artículos   </th>
                                                <th>Cantidad    </th>
                                                <th>Total       </th>
                                                <th>Acción      </th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                        </tbody>
                                    </table>                                    


                                </div>
                                <div class="panel-footer">
                                        <button type="submit" name="guardarComanda" class="btn btn-primary">Guardar Comanda</button>
                                         <a type="submit" href="index.php?accion=NewComanda" class="btn btn-info" style="float:right;">
                                            Agregar Comanda
                                        </a>
                                        
                                </div>

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
