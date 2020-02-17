    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.configuracionInicial = false; 
        $rootScope.guardadatos = false;
        $rootScope.formProducto = false;

    });

    app.controller('myControlCarta', function($scope, $http) {

        $scope.loadTablaCarta = function(){
            $http.post('controlCartaRestorant.php', {accion: "cargarTablaCarta"})
            .then(function(response){  
                $scope.dataCarta = response.data.records;
                $scope.loadContadores();
            }, function(error) {
                $scope.errors = error.message;
            });

        }
        $scope.loadContadores = function(){
            $http.post('controlCartaRestorant.php', {accion: "contadores"})
            .then(function(response){  
                $scope.nItemCarta  = response.data.nItemCarta;
            }, function(error) {
                $scope.errors = error.message;
            });

        }
        $scope.loadTablaCarta();

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

