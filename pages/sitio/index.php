<?php
    include_once("../../conexionli.php");
    $estado ='off';

    if(isset($_POST['DesactivarSitio'])){
        $estado = 'off';
        $link=Conectarse();
        $bd=$link->query("SELECT * FROM ctrlmantencion");
        if($row=mysqli_fetch_array($bd)){
            $actSQL="UPDATE ctrlmantencion SET ";
            $actSQL.="estado  = '".$estado.   "'";
            $bdAct=$link->query($actSQL);
        }
        $link->close();
    }
    if(isset($_POST['ActivarSitio'])){
        $estado = 'on';
        $link=Conectarse();
        $bd=$link->query("SELECT * FROM ctrlmantencion");
        if($row=mysqli_fetch_array($bd)){
            $actSQL="UPDATE ctrlmantencion SET ";
            $actSQL.="estado  = '".$estado.   "'";
            $bdAct=$link->query($actSQL);
        }
        $link->close();
    }

    $link=Conectarse();
    $bd=$link->query("SELECT * FROM ctrlmantencion");
    if($row=mysqli_fetch_array($bd)){
        $estado = $row['estado'];
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

    <link rel="stylesheet" type="text/css" href="stylecheckboxx.css">

</head>

<body>

    <div id="wrapper">

        <?php include('menuPpal.php'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Control del Sitio</h1> 
                </div>

                <div class="col-lg-4">
                    <form name="formSub" method="post" action="index.php">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 15px;">
                            Estado Sitio 
                            <?php
                                if($estado == 'off'){
                                    echo '(<b>En Mantención</b>)';
                                }else{
                                    echo '(<b>Activo</b>)';
                                }
                            ?>
                        </div>
                        <div class="panel-body">
                            <?php
                                if($estado == 'on'){?>
                                    <button type="submit" name="DesactivarSitio" class="btn btn-primary">Desactivar Sitio</button>
                                    <?php 
                                }else{?>
                                    <button type="submit" name="ActivarSitio" class="btn btn-danger">Activar Sitio</button>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- /.col-lg-12 -->
            
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">

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
                                                            <a type="submit" href="categorias/?idCat=<?php echo $row['idCat']; ?>" class="btn btn-success">
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
