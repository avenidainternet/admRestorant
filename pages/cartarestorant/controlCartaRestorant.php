<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../../conexionli.php");

if($dato->accion == 'cargarTablaCarta'){
	$outp = '';
	$firstProd = '';
	$link=Conectarse();
	$SQL = "Select * From productos Order By idCat Asc, idSub Asc";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		if($firstProd == ''){ $firstProd = $rs["nControl"]; }
		$SubCat = '';
		$SQLsc = "Select * From invsubclasificacion Where idCat = '".$rs['idCat']."' and idSub = '".$rs['idSub']."'";
		$bdsc=$link->query($SQLsc);
		if($rssc = mysqli_fetch_array($bdsc)){
			$SubCat = $rssc['SubClasificacion'];
		}

		$outp .= '{"nControl":"'  . 		$rs["nControl"]. 			'",';
		$outp .= '"firstProd":"'. 			$firstProd. 				'",';
		$outp .= '"SubCat":"'. 				$SubCat. 					'",';
		$outp .= '"idCat":"'. 				$rs["idCat"]. 				'",';
		$outp .= '"idSub":"'. 				$rs["idSub"]. 				'",';
		$outp .= '"Stock":"'. 				$rs["Stock"]. 				'",';
		$outp .= '"Producto":"'. 			$rs["Producto"]. 			'",';
		$outp .= '"uMedida":"'. 			$rs["uMedida"]. 			'",';
		$outp .= '"Porciones":"'. 			$rs["Porciones"]. 			'",';
		$outp .= '"precioVenta":"'. 		$rs["precioVenta"]. 		'"}';
	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	echo ($outp);
}


if($dato->accion == 'contadores'){
	$res = '';
	$link=Conectarse();
	$SQL = "SELECT * FROM itemCartaRestorant Order By Item Desc"; 
	$bd=$link->query($SQL);
	if($rs=mysqli_fetch_array($bd)){
		$res.= '{"nItemCarta":"'.		$rs["Item"].			'",';
	    $res.= '"nItemCarta":"'.		$rs["Item"]. 			'",';
	   	$res.= '"nombreItem":"'. 		$rs["nombreItem"]. 		'"}';
	}
	$link->close();
	echo $res;	
}

if($dato->accion == 'loadCategorias'){
	$outp = '';
	$link=Conectarse();
	$SQL = "Select * From invclasificacion";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"idCat":"'  . 			$rs["idCat"]. 				'",';
		$outp .= '"Cantidad":"'. 			$rs["Cantidad"]. 			'",';
		$outp .= '"Clasificacion":"'. 		$rs["Clasificacion"]. 		'"}';
	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	echo ($outp);
}
if($dato->accion == 'loadSubCategorias'){
	$outp = '';
	$link=Conectarse();
	$SQL = "Select * From invsubclasificacion Where idCat = '$dato->idCat'";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"idCat":"'  . 			$rs["idCat"]. 				'",';
		$outp .= '"idSub":"'. 				$rs["idSub"]. 				'",';
		$outp .= '"Cantidad":"'. 			$rs["Cantidad"]. 			'",';
		$outp .= '"SubClasificacion":"'. 	$rs["SubClasificacion"]. 		'"}';
	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	echo ($outp);
}
if($dato->accion == 'guardarProducto'){
	$link=Conectarse();
    $bd=$link->query("SELECT * FROM productos Where nControl = '$dato->nControl'");
    if($row=mysqli_fetch_array($bd)){
    	$actSQL="UPDATE productos SET ";
    	$actSQL.="Producto        	= '".$dato->Producto.         	"', ";
    	$actSQL.="cBarra        	= '".$dato->cBarra.         	"', ";
    	$actSQL.="Stock        		= '".$dato->Stock.         		"', ";
    	$actSQL.="StockCritico      = '".$dato->StockCritico.       "', ";
    	$actSQL.="idCat      		= '".$dato->idCat.       		"', ";
    	$actSQL.="idSub      		= '".$dato->idSub.       		"', ";
    	$actSQL.="Costo      		= '".$dato->Costo.       		"', ";
    	$actSQL.="Margen      		= '".$dato->Margen.       		"', ";
    	$actSQL.="uMedida      		= '".$dato->uMedida.       		"', ";
    	$actSQL.="Porciones      	= '".$dato->Porciones.       	"', ";
    	$actSQL.="precioVenta      	= '".$dato->precioVenta.       	"' ";
    	$actSQL.="WHERE nControl    = '".$dato->nControl. "'";
        $bdAct=$link->query($actSQL);

    }
	$link->close();
}
if($dato->accion == 'newProducto'){
	$nControl = 0;
	$link=Conectarse();
    $bd=$link->query("SELECT * FROM productos Order By nControl Desc");
    if($row=mysqli_fetch_array($bd)){
    	$nControl = $row['nControl'] + 1;
    }
    $link->query("insert into productos (   		nControl            		,
                                                    Producto            		,    
                                                    cBarra              		,    
                                                    Stock               		,    
                                                    StockCritico        		,    
                                                    idCat               		,    
                                                    idSub               		,        
                                                    Costo               		,        
                                                    Margen              		,        
                                                    precioVenta       
                                                ) 
                                        values (    '$nControl'         		,
                                                    '$dato->Producto'         	,
                                                    '$dato->cBarra'           	,
                                                    '$dato->Stock'            	,
                                                    '$dato->StockCritico'     	,
                                                    '$dato->idCat'            	,
                                                    '$dato->idSub'            	,
                                                    '$dato->Costo'            	,
                                                    '$dato->Margen'           	,
                                                    '$dato->precioVenta'
                                                )");

	$link->close();
}

?>