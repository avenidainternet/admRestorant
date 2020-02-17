<?php
    include_once("../../conexionli.php");
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

    <script src="../../vendor/angular/angular.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body ng-app="myApp" ng-controller="myControlInventario">
    <div id="wrapper">

        <?php include('menuPpal.php'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Inventario</h1>
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

            <div class="row" style="margin: 5px;">
                <div class="col-md-12">
                    <a  ng-click="newProducto()" 
                        href="" 
                        class="btn btn-warning" 
                        style="float:left;">
                        + Producto
                    </a>
                </div>
            </div>





            <!-- /.row -->
           
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-7">

                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding: 15px;">
                                    DataTables Inventario
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    
                                    <div class="row" style="padding: 5px;">
                                        <div class="col-md-3">
                                            Filtrar: 
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" ng-model="filtro">
                                        </div>
                                    </div>

                                    

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#           </th>
                                                <th>Cat.        </th>
                                                <th>Productos   </th>
                                                <th>Stock       </th>
                                                <th>Porciones   </th>
                                                <th>Acción      </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="p in dataProductos | filter: filtro">
                                                <td> {{p.nControl}}     </td>
                                                <td> {{p.SubCat}}       </td>
                                                <td> {{p.Producto}}     </td>
                                                <td> {{p.Stock}}        </td>
                                                <td> {{p.Porciones}}    </td>
                                                <td>  
                                                    <a  href="#"
                                                        type="button"
                                                        class="btn btn-success" 
                                                        ng-click="loadProducto(p.nControl)">
                                                        Ver
                                                    </a>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>




                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>


                        </div>
                        <div class="col-lg-5">

                            <div class="panel panel-default" ng-show="formProducto">

                                <div class="panel-heading" ng-init="loadProducto(p.firstProd)">
                                    <h4>{{Producto}}</h4>
                                </div>
                                <!-- /.panel-heading 
                                <form name="formSectores" method="post" action="index.php" enctype="multipart/form-data">
                                -->
                                    <div class="panel-body">
                                            <input  type="hidden" 
                                                    class="form-control" 
                                                    name="nControl" 
                                                    ng-model="nControl" />

                                            <div class="form-group">
                                                <label for="idCat">Clasificación</label>
                                                
                                                <select class     = "form-control"
                                                        ng-model  = "idCat" 
                                                        ng-change= "leerSubCategorias(idCat)"
                                                        ng-options  = "x.idCat as x.Clasificacion for x in dataCat" >
                                                    <option value="x.idCat">{{x.Clasificacion}}</option>
                                                </select>
                                                {{idCat}}
                                            </div>

                                            <div class="form-group">

                                                <label for="idSub">Sub Clasificación</label>
                                                <select class     = "form-control"
                                                      ng-model  = "idSub" 
                                                      ng-options  = "x.idSub as x.SubClasificacion for x in dataSub" >
                                                    <option value="x.idSub">{{x.SubClasificacion}}</option>
                                                </select>
                                                {{idSub}}

                                            </div>






                                            <div class="form-group">
                                                <label for="Producto">Producto</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="Producto" 
                                                        ng-model="Producto"
                                                        autofocus required />
                                            </div>

                                            <div class="form-group">
                                                <label for="cBarra">Cod.Barra</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="cBarra" 
                                                        ng-model="cBarra"
                                                        required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Costo">Costo</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="Costo" 
                                                        ng-model="Costo"
                                                        required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Margen">Margen</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="Margen" 
                                                        ng-model="Margen"
                                                        required />
                                            </div>

                                            <div class="form-group">
                                                <label for="precioVenta">Precio de Venta</label>
                                                <b>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="precioVenta" 
                                                        ng-model="precioVenta" 
                                                        required />
                                                </b>
                                            </div>

                                            <div class="form-group">
                                                <label for="Stock">Stock</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="Stock" 
                                                        ng-model="Stock" 
                                                        required />
                                            </div>
                                            <div class="form-group">
                                                <label for="uMedida">Unidad Medida</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="uMedida" 
                                                        ng-model="uMedida"
                                                        required />
                                            </div>
                                            <div class="form-group">
                                                <label for="Porciones">Porciones</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="Porciones" 
                                                        ng-model="Porciones"
                                                        required />
                                            </div>

                                            <div class="form-group">
                                                <label for="StockCritico">Stock Crítico</label>
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="StockCritico" 
                                                        ng-model="StockCritico" 
                                                        required />
                                            </div>
                                            
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a  href="#"
                                                    type="button"
                                                    class="btn btn-success" 
                                                    ng-click="guardarProducto()">
                                                    Guardar
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                            </div>
                                            <div class="col-md-2">
                                                 <a type="submit" href="index.php?accion=NewProducto" class="btn btn-info" style="float:right;">
                                                    Agregar Producto
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 5px;">
                                            <div class="col-md-12">
                                                <div class="alert alert-info alert-dismissible" 
                                                     ng-show="guardadatos">
                                                    
                                                     {{resGuarda}}

                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                <!-- </form> -->
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
    <script src="inventario.js"></script>

</body>

</html>
