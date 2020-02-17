<?php
    include_once("../../../conexionli.php");
    if(isset($_POST['grabarSub'])){
        echo $_POST['idSub'];
        $link=Conectarse();
        $bd=$link->query("SELECT * FROM subcat Where idCat = '".$_POST['idCat']."' and idSub = '".$_POST['idSub']."'");
        if($row=mysqli_fetch_array($bd)){
            $actSQL="UPDATE subcat SET ";
            $actSQL.="SubCategoria  = '".$_POST['SubCategoria'].   "'";
            $actSQL.="WHERE idCat   = '".$_POST['idCat']."' and idSub = '".$_POST['idSub']."'";
            $bdAct=$link->query($actSQL);
        }else{
            $idCat          = $_POST['idCat'];
            $idSub          = $_POST['idSub'];
            $SubCategoria   = $_POST['SubCategoria'];

            $link->query("insert into subcat    (   idCat           ,
                                                    idSub           ,
                                                    SubCategoria
                                                ) 
                                        values (    '$idCat'        ,
                                                    '$idSub'        ,
                                                    '$SubCategoria'
                                                )");
        }
        $link->close();
    }
    if(isset($_POST['guardarCat'])){
        $link=Conectarse();
        $bd=$link->query("SELECT * FROM categoria Where idCat = '".$_POST['idCat']."'");
        if($row=mysqli_fetch_array($bd)){
            $actSQL="UPDATE categoria SET ";
            $actSQL.="Categoria     = '".$_POST['Categoria'].   "'";
            $actSQL.="WHERE idCat   = '".$_POST['idCat'].       "'";
            $bdAct=$link->query($actSQL);
        }else{
            $idCat      = $_POST['idCat'];
            $Categoria  = $_POST['Categoria'];

            $link->query("insert into categoria (   idCat       ,
                                                    Categoria
                                                ) 
                                        values (    '$idCat'    ,
                                                    '$Categoria'
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
    <link href="../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                    <h1 class="page-header">Categorías</h1>
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
                                    DataTables Categorías
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Categorías</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstidCat = '';
                                                $link=Conectarse();
                                                $bd=$link->query("SELECT * FROM categoria Order By idCat");
                                                while($row=mysqli_fetch_array($bd)){
                                                    if(!$firstidCat){
                                                        $firstidCat = $row['idCat'];
                                                    }
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['idCat']; ?>        </td>
                                                        <td><?php echo $row['Categoria']; ?>    </td>
                                                        <td class="center text-center">
                                                            <a type="submit" href="index.php?idCat=<?php echo $row['idCat']; ?>" class="btn btn-success">
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
                                    Categoría 
                                    <?php
                                        $Accion = '';
                                        if(isset($_GET['idCat'])) { $firstidCat = $_GET['idCat'];   }
                                        if(isset($_GET['accion'])){ $accion     = $_GET['accion'];  }
                                        if($accion == 'NewCategoria'){
                                            echo '<b>Nueva Categoría</b>';
                                            
                                            $SQL = "SELECT * FROM categoria Order By idCat Desc";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                $firstidCat = $row['idCat'] + 1;
                                            }
                                            $link->close();

                                        }
                                            $SQL = "SELECT * FROM categoria Where idCat = '$firstidCat'";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                echo '<b>'.$row['Categoria'].'</b>';
                                            }
                                            $link->close();
                                        

                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form name="formCat" method="post" action="index.php">
                                    <div class="panel-body">
                                        
                                            <div class="form-group">
                                                <label for="idCat">Nº Categoría <?php echo $firstidCat; ?></label>
                                                <input type="text" class="form-control" name="idCat" value="<?php echo $firstidCat; ?>" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label for="Categoria">Categoría</label>
                                                <input type="text" class="form-control" name="Categoria" value="<?php echo $row['Categoria']; ?>" autofocus required />
                                            </div>
                                        
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" name="guardarCat" class="btn btn-primary">Guardar</button>
                                         <a type="submit" href="index.php?accion=NewCategoria" class="btn btn-info" style="float:right;">
                                            Agregar Categoría
                                        </a>
                                        
                                    </div>
                                </form>
                            </div>




                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding: 15px;">
                                    Sub Categorías
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sub Categorías</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstidSub = '';
                                                $link=Conectarse();
                                                $SQLs = "SELECT * FROM subcat Where idCat = '$firstidCat' Order By idSub";
                                                //echo $SQLs;
                                                $bds=$link->query($SQLs);
                                                while($rows=mysqli_fetch_array($bds)){
                                                    if(!$firstidSub){
                                                        $firstidSub = $rows['idSub'];
                                                    }
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $rows['idSub']; ?>        </td>
                                                        <td><?php echo $rows['SubCategoria']; ?>    </td>
                                                        <td class="center text-center">
                                                            <?php
                                                                $class = 'btn btn-success';
                                                                if($rows['mostrarTit'] == 'off'){
                                                                    $class = 'btn btn-danger';
                                                                }
                                                            ?>
                                                            <a type="submit" href="index.php?idCat=<?php echo $row['idCat']; ?>&idSub=<?php echo $rows['idSub']; ?>" class="<?php echo $class; ?>">
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


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Sub Categoría 
                                    <?php
                                        $Accion = '';
                                        if(isset($_GET['idSub'])) { $firstidSub = $_GET['idSub'];   }
                                        if(isset($_GET['accion'])){ $accion     = $_GET['accion'];  }
                                        if($accion == 'NewSubCategoria'){
                                            echo '<b>Nueva Sub Categoría</b>';
                                            $firstidSub = 1;
                                            $link=Conectarse();
                                            $SQLs = "SELECT * FROM subcat Where idCat = '$firstidCat' Order By idSub Desc";
                                            $link=Conectarse();
                                            $bds=$link->query($SQLs);
                                            if($rows=mysqli_fetch_array($bds)){
                                                $firstidSub = $rows['idSub'] + 1;
                                            }
                                            $link->close();

                                        }
                                        $SQLs = "SELECT * FROM subcat Where idCat = '$firstidCat' and idSub = '$firstidSub'";
                                        //echo $SQLs;
                                        $link=Conectarse();
                                        $bds=$link->query($SQLs);
                                        if($rows=mysqli_fetch_array($bds)){
                                            echo '<b>'.$rows['SubCategoria'].'</b>';
                                        }
                                        $link->close();
                                        

                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form name="formSub" method="post" action="index.php">
                                    <div class="panel-body">
                                        
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="idCat" value="<?php echo $firstidCat; ?>" />
                                                <label for="idSub">Nº Sub Categoría <?php echo $firstidSub; ?></label>
                                                <input type="text" class="form-control" name="idSub" value="<?php echo $firstidSub; ?>" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label for="SubCategoria">Sub Categoría</label>
                                                <input type="text" class="form-control" name="SubCategoria" value="<?php echo $rows['SubCategoria']; ?>" autofocus required />
                                            </div>
                                        
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" name="grabarSub" class="btn btn-primary">Guardar</button>
                                         <a type="submit" href="index.php?idCat=<?php echo $firstidCat; ?>&accion=NewSubCategoria" class="btn btn-info" style="float:right;">
                                            Agregar Sub Categoría
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
    <script src="../../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../../dist/js/sb-admin-2.js"></script>

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
