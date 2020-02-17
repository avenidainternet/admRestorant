    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.configuracionInicial = false; 
        $rootScope.guardadatos = false;
        $rootScope.formProducto = false;
        $rootScope.tipoEstado = [
            {
                codEstado:"P",
                descripcion:"En Proceso"
            },{
                codEstado:"T",
                descripcion:"Terminar Proceso"
            },{
                codEstado:"E",
                descripcion:"Volver a CAM"
            },{
                codEstado:"N",
                descripcion:"Anular Proceso"
            }
            ];
        $rootScope.tpEnsayo = "1";
        $rootScope.tipoEnsayo = [
            {
                codEnsayo:"1",
                descripcion:"Caracterización"
            },{
                codEnsayo:"2",
                descripcion:"Análisis de Falla"
            }
            ];
        $rootScope.OFE = "off";
        $rootScope.tipoOferta = [
            {
                codOferta:"on",
                descripcion:"Oferta Económica"
            },{
                codOferta:"off",
                descripcion:"Sin Oferta Económica"
            }
            ];
        $rootScope.Moneda = "U";
        $rootScope.tipoMoneda = [
            {
                codMoneda:"U",
                descripcion:"UF"
            },{
                codMoneda:"P",
                descripcion:"Pesos"
            },{
                codMoneda:"D",
                descripcion:"Dolar"
            }
            ];
        $rootScope.correoInicioPAM  = "off";
        $rootScope.envios = [
            {
                codEnvio:"on",
                descripcionEnvio:"Si"
            },{
                codEnvio:"off",
                descripcionEnvio:"No"
            }
            ];
        $rootScope.RAM              = '';
        $rootScope.btnCreaCot = false;
        $rootScope.errCreaCot = true;

    });

    app.controller('myControlInventario', function($scope, $http) {

        $scope.loadTablaProductos = function(){
            $http.post('controlInventario.php', {accion: "cargarTablaProductos"})
            .then(function(response){  
                $scope.dataProductos = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });

        }
        $scope.loadTablaProductos();

        $scope.loadProducto = function(nControl){
            //alert('Entra...'+nControl);

            $http.post('controlInventario.php', {
                                                    nControl: nControl, 
                                                    accion: "lectura"
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.nControl         = response.data.nControl;
                $scope.Producto         = response.data.Producto;
                $scope.idCat            = response.data.idCat;
                $scope.idSub            = response.data.idSub;
                $scope.cBarra           = response.data.cBarra;
                $scope.Costo            = response.data.Costo;
                $scope.Stock            = response.data.Stock;
                $scope.StockCritico     = response.data.StockCritico;
                $scope.Margen           = response.data.Margen;
                $scope.precioVenta      = response.data.precioVenta;
                $scope.uMedida          = response.data.uMedida;
                $scope.Porciones        = response.data.Porciones;
                $scope.leerCategorias();
                $scope.leerSubCategorias($scope.idCat);
                $scope.formProducto = true;
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });

        }



        $scope.leerCategorias = function() {
            $http.post('controlInventario.php', {accion: "loadCategorias"})
            .then(function(response){  
                $scope.dataCat = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerSubCategorias = function(idCat) {
            $http.post('controlInventario.php', {idCat: idCat, accion: "loadSubCategorias"})
            .then(function(response){  
                $scope.dataSub = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        
        $scope.guardarProducto = function(){
            accion = "guardarProducto";
            if($scope.nControl == 0){
                accion="newProducto";
            }
            //alert($scope.Producto+' '+$scope.idCat+' '+$scope.idSub+' '+accion);
            
            $http.post('controlInventario.php', {
                                                    nControl:       $scope.nControl, 
                                                    Producto:       $scope.Producto,
                                                    idCat:          $scope.idCat,
                                                    idSub:          $scope.idSub,
                                                    cBarra:         $scope.cBarra,
                                                    Costo:          $scope.Costo,
                                                    Stock:          $scope.Stock,
                                                    StockCritico:   $scope.StockCritico,
                                                    Margen:         $scope.Margen,
                                                    uMedida:        $scope.uMedida,
                                                    Porciones:      $scope.Porciones,
                                                    precioVenta:    $scope.precioVenta,
                                                    accion:         accion
                        })
            .then(function (response) {
                $scope.resGuarda = 'Exito...';
                $scope.loadTablaProductos();
                $scope.guardadatos = true;
            }, function(error) {
                $scope.errors = error.message;
            });
            
            
        }

        $scope.newProducto = function(){
            $scope.formProducto = true;
            $scope.nControl     = '0';
            $scope.Producto     = '';
            $scope.cBarra       = '';
            $scope.Costo        = '';
            $scope.Stock        = '';
            $scope.StockCritico = '';
            $scope.Margen       = '';
            $scope.precioVenta  = '';
            $scope.leerCategorias();
        }


        // FIN CREAR COTIZACIÓN
    });

