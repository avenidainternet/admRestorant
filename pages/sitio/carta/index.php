<?php
    include_once("../../../conexionli.php");
    if(isset($_POST['guardarArt'])){
        if(isset($_POST['nProd']))      { $nProd    = $_POST['nProd'];      }
        if(isset($_POST['Producto']))   { $Producto = $_POST['Producto'];   }

        $nombre_archivo = $_FILES['img']['name'];
        $tipo_archivo   = $_FILES['img']['type'];
        $tamano_archivo = $_FILES['img']['size'];
        $desde          = $_FILES['img']['tmp_name'];
        
        $imagen = '';
        if(isset($_FILES['img']['name'])){
            
            $directorio="../../../../images";
            //$directorio="imagenes/";
            if(($tipo_archivo == "image/jpeg" or $tipo_archivo == "image/png" or $tipo_archivo == "image/gif") ) { 
                
                if(move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
                    echo $nombre_archivo . ' ' . $tipo_archivo;
                    $imagen = $nombre_archivo;
                }
            }
        }
        $link=Conectarse();
        $bd=$link->query("SELECT * FROM carta Where nProd = '".$_POST['nProd']."'");
        if($row=mysqli_fetch_array($bd)){
            if(!$imagen){
                if($row['imagen']){
                    $imagen = $row['imagen'];
                }
            }
            //echo $_POST['idSub'];
            $actSQL="UPDATE carta SET ";
            $actSQL.="idCat             = '".$_POST['idCat'].               "',";
            $actSQL.="idSub             = '".$_POST['idSub'].               "',";
            $actSQL.="Producto          = '".$_POST['Producto'].            "',";
            $actSQL.="imagen            = '".$imagen.                       "',";
            $actSQL.="Descripcion       = '".$_POST['Descripcion'].         "',";
            $actSQL.="DescripcionLarga  = '".$_POST['DescripcionLarga'].    "'";
            $actSQL.="WHERE nProd       = '".$_POST['nProd']."'";
            $bdAct=$link->query($actSQL);
        }else{
            $nProd              = $_POST['nProd'];
            $idCat              = $_POST['idCat'];
            $idSub              = $_POST['idSub'];
            $Producto           = $_POST['Producto'];
            $imagen             = $_POST['imagen'];
            $Descripcion        = $_POST['Descripcion'];
            $DescripcionLarga   = $_POST['DescripcionLarga'];

            $link->query("insert into carta     (   nProd               ,
                                                    idCat               ,
                                                    idSub               ,
                                                    Producto            ,
                                                    imagen              ,
                                                    Descripcion         ,
                                                    DescripcionLarga
                                                ) 
                                        values (    '$nProd'            ,
                                                    '$idCat'            ,
                                                    '$idSub'            ,
                                                    '$Producto'         ,
                                                    '$imagen'           ,
                                                    '$Descripcion'      ,
                                                    '$DescripcionLarga'
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
                    <h1 class="page-header">Carta</h1>
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
                                    DataTables Carta
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#           </th>
                                                <th>Cat.        </th>
                                                <th>Sub.Cat     </th>
                                                <th>Artículos   </th>
                                                <th>Acción      </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                       
                                            <?php
                                                $firstidCat = 0;
                                                $firstidSub = 0;
                                                $firstnProd = 0;
                                                $link=Conectarse();
                                                $bd=$link->query("SELECT * FROM carta Order By idCat, idSub");
                                                while($row=mysqli_fetch_array($bd)){
                                                    if($firstnProd == 0){
                                                        $firstidCat = $row['idCat'];
                                                        $firstidSub = $row['idSub'];
                                                        $firstnProd = $row['nProd'];
                                                    }

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['nProd']; ?>        </td>
                                                        <td>
                                                            <?php 
                                                                $SQLc = "SELECT * FROM categoria Where idCat = '".$row['idCat']."'";
                                                                $link=Conectarse();
                                                                $bdc=$link->query($SQLc);
                                                                if($rowc=mysqli_fetch_array($bdc)){
                                                                    echo $rowc['Categoria'];
                                                                }else{
                                                                    echo 'S/C';
                                                                } 
                                                            ?>        
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            
                                                                $SQLc = "SELECT * FROM subcat Where idCat = '".$row['idCat']."' and idSub = '".$row['idSub']."'";
                                                                $link=Conectarse();
                                                                $bdc=$link->query($SQLc);
                                                                if($rowc=mysqli_fetch_array($bdc)){
                                                                    echo $rowc['SubCategoria'];
                                                                }else{
                                                                    echo 'S/C';
                                                                } 
                                                                  
                                                            ?>        
                                                        </td>
                                                        <td><?php echo $row['Producto']; ?>     </td>
                                                        <td class="center text-center">
                                                            <?php
                                                                $class = "btn btn-success";
                                                                if($rowc['mostrarTit'] == 'off'){
                                                                    $class = "btn btn-danger";
                                                                }
                                                            ?>
                                                            <a type="submit" href="index.php?idCat=<?php echo $row['idCat']; ?>&idSub=<?php echo $row['idSub']; ?>&nProd=<?php echo $row['nProd']; ?>" class="<?php echo $class; ?>">
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
                                        if(isset($_GET['idCat'])) { $firstidCat = $_GET['idCat'];   }
                                        if(isset($_GET['idSub'])) { $firstidSub = $_GET['idSub'];   }
                                        if(isset($_GET['nProd'])) { $firstnProd = $_GET['nProd'];   }
                                        if(isset($_GET['accion'])){ $accion     = $_GET['accion'];  }

                                        if(isset($_POST['idCat'])) { $firstidCat = $_POST['idCat'];   }
                                        if(isset($_POST['idSub'])) { $firstidSub = $_POST['idSub'];   }
                                        if(isset($_POST['nProd'])) { $firstnProd = $_POST['nProd'];   }
                                        if(isset($_POST['accion'])){ $accion     = $_POST['accion'];  }


                                        if($accion == 'NewArticulo'){
                                            echo '<h4>Nuevo Artículo</h4>';
                                            $firstidCat = 0;
                                            $firstidSub = 0;

                                            $SQL = "SELECT * FROM carta Order By nProd Desc";
                                            $link=Conectarse();
                                            $bd=$link->query($SQL);
                                            if($row=mysqli_fetch_array($bd)){
                                                $firstnProd = $row['nProd'] + 1;
                                            }
                                            $link->close();
                                            //echo $nProd;

                                        }
                                        $SQL = "SELECT * FROM carta Where nProd = '$firstnProd'";
                                        //echo $SQL;
                                        //echo $firstidCat.' '.$firstidSub.' '.$firstnProd;
                                        $link=Conectarse();
                                        $bd=$link->query($SQL);
                                        if($row=mysqli_fetch_array($bd)){
                                            echo '<h4>'.$row['Producto'].'</h4>';
                                            $firstidSub = $row['idSub'];
                                            echo $firstidSub;
                                        }
                                        $link->close();
                                    ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form name="formCat" method="post" action="index.php" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        
                                            <div class="form-group">
                                                <input name="nProd" type="hidden" value="<?php echo $firstnProd; ?>">
                                                <label for="idCat">Categoría </label>
                                                <select class="form-control" name="idCat">
                                                    <option></option>
                                                    <?php
                                                        $SQLc = "SELECT * FROM categoria Order By idCat Asc";
                                                        $link=Conectarse();
                                                        $bdc=$link->query($SQLc);
                                                        while($rowc=mysqli_fetch_array($bdc)){
                                                            if($rowc['idCat'] == $firstidCat){?>
                                                                <option value="<?php echo $rowc['idCat']; ?>" selected>
                                                                     <?php echo $rowc['Categoria']; ?>
                                                                </option>
                                                            <?php
                                                            }else{?>
                                                                <option value="<?php echo $rowc['idCat']; ?>">
                                                                     <?php echo $rowc['Categoria']; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        $link->close();
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="idSub">SubCategoría </label>
                                                <select class="form-control" name="idSub">
                                                    <option></option>
                                                    <?php
                                                        $SQLs = "SELECT * FROM subcat where mostrarTit = 'on' Order By SubCategoria Asc";
                                                        $link=Conectarse();
                                                        $bds=$link->query($SQLs);
                                                        while($rows=mysqli_fetch_array($bds)){
                                                            if($rows['idCat'] == $firstidCat and $rows['idSub'] == $firstidSub){?>
                                                                <option value="<?php echo $rows['idSub']; ?>" selected>
                                                                     <?php echo $rows['SubCategoria']; ?>
                                                                </option>
                                                            <?php
                                                            }else{?>
                                                                <option value="<?php echo $rows['idSub']; ?>">
                                                                     <?php echo $rows['SubCategoria']; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        $link->close();
                                                    ?>
                                                </select>
                                                
                                            </div>


                                            <div class="form-group">
                                                <label for="Producto">Artículo</label>
                                                <input type="text" class="form-control" name="Producto" value="<?php echo $row['Producto']; ?>" autofocus required />
                                            </div>

                                            <div class="form-group">
                                                <label for="Descripcion">Descipción Corta</label>
                                                <textarea class="form-control" rows="2" id="Descripcion" name="Descripcion" maxlength="160" required><?php echo $row['Descripcion']; ?></textarea> 
                                            </div>

                                            <div class="form-group">
                                                <label for="DescripcionLarga">Descipción Larga</label>
                                                <textarea class="form-control" rows="8" id="DescripcionLarga" name="DescripcionLarga" maxlength="400" required><?php echo $row['DescripcionLarga']; ?></textarea> 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="img">Imágen</label>
                                                <input name="img" type="file" id="img" class="btn btn-info">
                                            </div>
                                            <?php
                                                if($row['imagen']){
                                                    $img = "../../../../images/".$row['imagen'];
                                                    ?>
                                                    <img src="<?php echo $img; ?>" width="240px"  height="215">
                                                    <?php
                                                }
                                            ?>
                                            

                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" name="guardarArt" class="btn btn-primary">Guardar</button>
                                         <a type="submit" href="index.php?accion=NewArticulo" class="btn btn-info" style="float:right;">
                                            Agregar Artículo
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
