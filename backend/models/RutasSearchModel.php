<?php

namespace backend\models;

use backend\controllers\RutasController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Ruta;
use yii\helpers\Json;


class RutasSearchModel {

    private $localizacionProvider;
    private $comercioProvider;
    private $relevadorProvider;
    private $rutaProvider;
    private $rutaRelevadorComercioProvider;
    public static $radioPredefinido = 1500; //En metros
    public static $maximaDistanciaRecorrer = 1000; //En metros

    function __construct(){
        $this->localizacionProvider = new BuscarLocalizacion();
        $this->comercioProvider = new BuscarComercio();
        $this->relevadorProvider = new BuscarRelevador();
        $this->rutaProvider = new BuscarRuta();
        $this->rutaRelevadorComercioProvider = new RutasRelevadorComercio();
    }

    public function getLocalizacionProvider(){ return $this->localizacionProvider; }
    public function getComercioProvider() { return $this->comercioProvider; }
    public function getRelevadorProvider() { return $this->relevadorProvider; }
    public function getRutaProvider() { return $this->rutaProvider; }

    /**
     * Formula para sacar distancia entre dos puntos dada la latitud y longitud de dos puntos.
     * Esta distancia tiene que estar dada en notación DECIMAL y no en SEXADECIMAL (Grados, minutos... etc)
     * @param type $latitud 1
     * @param type $longitud 1
     * @param type $latitud 2
     * @param type $longitud 2
     * @return type, Distancia en Kms, con 1 decimal de precisión
     */
    private static function harvestine($lat1, $long1, $lat2, $long2){
        //Distancia en kilometros en 1 grado distancia.
        //Distancia en millas nauticas en 1 grado distancia: $mn = 60.098;
        //Distancia en millas en 1 grado distancia: 69.174;
        //Solo aplicable a la tierra, es decir es una constante que cambiaria en la luna, marte... etc.
        $km = 111.302;

        //1 Grado = 0.01745329 Radianes
        $degtorad = 0.01745329;

        //1 Radian = 57.29577951 Grados
        $radtodeg = 57.29577951;
        //La formula que calcula la distancia en grados en una esfera, llamada formula de Harvestine. Para mas informacion hay que mirar en Wikipedia
        //http://es.wikipedia.org/wiki/F%C3%B3rmula_del_Haversine
        $dlong = ($long1 - $long2);
        $dvalue = (sin($lat1 * $degtorad) * sin($lat2 * $degtorad)) + (cos($lat1 * $degtorad) * cos($lat2 * $degtorad) * cos($dlong * $degtorad));
        $dd = acos($dvalue) * $radtodeg;
        return (round(($dd * $km), 2)) * 1000;
    }

    public static function isValidPoint($latitud, $longitud, $latOrig, $longOrig){
        if(RutasSearchModel::harvestine($latitud, $longitud, $latOrig, $longOrig) > RutasSearchModel::$radioPredefinido){
            return false;
        }
        return true;
    }

    public function buscarRelevadores($params){
        return $this->relevadorProvider->searchWithUsers($params);
    }

    public function buscarRutas($params){
        return $this->rutaProvider->search($params);
    }

    public function buscarComerciosSeleccionados($idArray){
        $query = $this->buscarComerciosSeleccionadosQuery($idArray)->with('localizacion')->with('prioridad');
        return $query->asArray()->all();
    }

    public function buscarRelevadoresDisponibles($idArray){
        $query = $this->buscarRelevadoresDisponiblesQuery($idArray)->with('user')->with('idLocalizacion');
        return $query->asArray()->all();
    }

    public function buscarComerciosSeleccionadosDataProvider($idArray){
        $query = $this->buscarComerciosSeleccionadosQuery($idArray);
        $comercioSearchModel = new BuscarComercio();
        $dataProvider = $comercioSearchModel->searchQuery($query);
        return $dataProvider;
    }

    private function buscarComerciosSeleccionadosQuery($idArray){
        $sql = 'SELECT * FROM ' . Comercio::tableName() . ' WHERE ';

        for($i = 0; $i < count($idArray); $i = $i + 1){
            $id = intval($idArray[$i]);
            if($i + 1 >= count($idArray)){
                $sql = $sql . 'id=' . $id;
            }else{
                $sql = $sql . 'id=' . $id . ' OR ';
            }
        }

        $comercioSearchModel = new BuscarComercio();

        $query = $comercioSearchModel->findBySql($sql);

        return $query;
    }

    private function buscarRelevadoresDisponiblesQuery($idArray){
        $sql = 'SELECT * FROM ' . Relevador::tableName() . ' WHERE ';

        for($i = 0; $i < count($idArray); $i = $i + 1){
            $id = intval($idArray[$i]);
            if($i + 1 >= count($idArray)){
                $sql = $sql . 'id=' . $id;
            }else{
                $sql = $sql . 'id=' . $id . ' OR ';
            }
        }

        $relevadorSearchModel = new BuscarRelevador();

        $query = $relevadorSearchModel->findBySql($sql);

        return $query;
    }

    public function buscarComerciosEnRadioRelevador($idRelevador){
        $radioPredefinido = RutasSearchModel::$radioPredefinido;
        $relevador = $this->relevadorProvider->findOne($idRelevador);
        $idLocalizacion = $relevador->id_localizacion;
        $localizacionOrigen = $this->localizacionProvider->findOne($idLocalizacion);
        $latitudOrigen = $localizacionOrigen->latitud;
        $longitudOrigen = $localizacionOrigen->longitud;
        $condition = 'latitud >= ' . strval($latitudOrigen - $radioPredefinido) . ' AND latitud <=' . strval($latitudOrigen + $radioPredefinido) . ' AND ';
        $condition = $condition . 'longitud >= ' . strval($longitudOrigen - $radioPredefinido) . ' AND longitud <=' . strval($longitudOrigen + $radioPredefinido);
        $localizaciones = $this->localizacionProvider->findBySql('SELECT * FROM ' . Localizacion::tableName() . ' WHERE ' . $condition)->all();
        $localizacionesComercios = array();
        foreach($localizaciones as $localizacion){
            if($this->isValidPoint($localizacion->latitud, $localizacion->longitud, $latitudOrigen, $longitudOrigen)){
                array_push($localizacionesComercios, $localizacion);
            }
        }
        $comerciosDisponibles = array();
        foreach($localizacionesComercios as $localizacion){
            $condition = ['id_localizacion' => $localizacion->id];
            $comercio = $this->comercioProvider->findOne($condition);
            if(!empty($comercio)){
                array_push($comerciosDisponibles, $comercio);
            }
        }
        return $comerciosDisponibles;
    }

    public function buscarRutaDelDia($idRelevador, $isUpdated = false){
        if(!empty($idRelevador)){
            $ruta = null;
            $this->rutaRelevadorComercioProvider = new RutasRelevadorComercio();
            $queryRutaDelDia = $this->rutaRelevadorComercioProvider->find()->where(['id_relevador' => $idRelevador])->with('rutaDia.estado')->with('comercio.localizacion')->
            asArray()->all();
            $comercios = [];
            if(!empty($queryRutaDelDia)){
                foreach($queryRutaDelDia as $query){
                    if(!empty($query['rutaDia']) && $query['rutaDia']['estado']['nombre'] === Estado::$DISPONIBLE){
                        $comercio = $query['comercio'];
                        array_push($comercios, $comercio);
                        $ruta = $query['rutaDia'];
                    }
                }
            }
            if(!$isUpdated && empty($comercios)) {
                $buscarUpdateRuta = $this->updateRutasDelDia($idRelevador);
                if ($buscarUpdateRuta) {
                    $comercios = $this->buscarRutaDelDia($idRelevador, true);
                }
            }
            $response = new Json();
            $response->comercios = $comercios;
            unset($ruta['id_estado']);
            $response->ruta = $ruta;
            return $response;
        }
        return null;
    }

    private function updateRutasDelDia($idRelevador){
        $this->rutaRelevadorComercioProvider = new RutasRelevadorComercio();
        $rutasPendientes = $this->rutaRelevadorComercioProvider->find()->where(['id_relevador' => $idRelevador])->asArray()->all();
        if(!empty($rutasPendientes)){
            $diaActual = jddayofweek(cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y")), 0);
            $queryDispRutas = new RutasDisponibilidad();
            foreach($rutasPendientes as $rutaPendiente){
                $disponibilidadRuta = $queryDispRutas->find()->where(['id_disponibilidad' => $diaActual, 'id_ruta' => $rutaPendiente['id_ruta']])->asArray()->all();
                if(!empty($disponibilidadRuta)){
                    $rutaUpdater = new Ruta();
                    $rutaUpdater = $rutaUpdater->findOne($rutaPendiente['id_ruta']);
                    $fechaActual = date(RutasController::$DATE_FORMAT);
                    $rutaUpdater->fecha_asignada = $fechaActual;
                    $rutaUpdater->update(true, ['fecha_asignada']);
                    return true;
                }
            }
        }
        return false;
    }

    public function buscarHistoricoRutas($idRelevador, $limite = 10, $ultimoIdRuta = -1){
        if(!empty($idRelevador)){
            $this->rutaRelevadorComercioProvider = new RutasRelevadorComercio();
            $queryRutaDelDia = $this->rutaRelevadorComercioProvider->find()->where(['id_relevador' => $idRelevador])->with('rutaHistorica')->with('comercio.localizacion')->asArray()->all();
            $comerciosDisponibles = [];
            $rutasReferencia = [];
            $rutasDevolver = [];
            $contadorRutas = 0;
            if(!empty($queryRutaDelDia)){
                foreach($queryRutaDelDia as $query){
                    if(!empty($query['rutaHistorica'])){
                        $ruta = $query['rutaHistorica'];
                        if(!array_key_exists($ruta['id'], $rutasReferencia)){
                            $rutasReferencia[$ruta['id']] = $ruta;
                        }
                        $comercio = $query['comercio'];
                        if(array_key_exists($ruta['id'], $comerciosDisponibles)){
                            array_push($comerciosDisponibles[$ruta['id']], $comercio);
                        }else{
                            $comerciosDisponibles[$ruta['id']] = [$comercio];
                        }
                    }
                }
                foreach($rutasReferencia as $idRuta => $rutaReferencia){
                    if($ultimoIdRuta < $idRuta){
                        $rutaReferencia['comercios'] = $comerciosDisponibles[$idRuta];
                        unset($rutaReferencia['id_estado']);
                        array_push($rutasDevolver, $rutaReferencia);
                    }
                    $contadorRutas++;
                    if($contadorRutas > $limite){
                        break;
                    }
                }
                return $rutasDevolver;
            }
        }
        return null;
    }

    public function buscarDisponibilidades(){
        $searchModel = new Disponibilidad();
        return $searchModel->find()->asArray()->all();
    }

    public function obtenerMejorRuta($localizacionRelevador, $comerciosParaRuta){
        $comercios = [];
        if(!empty($localizacionRelevador) && !empty($comerciosParaRuta)){
            //Ordeno de mayor a menor prioridad
            usort($comerciosParaRuta, function ($a, $b){
                $indexpA = array_search($a['prioridad']['nombre'], RutasController::$PRIORIDADES);
                $indexpB = array_search($b['prioridad']['nombre'], RutasController::$PRIORIDADES);
                if($indexpA < $indexpB){
                    return -1;
                }else if($indexpA === $indexpB){
                    return 0;
                }else{
                    return 1;
                }
            });
            //Descarto los comercios fuera del rango maximo de distancia a recorrer
            $comercios = $this->quitarComerciosFueraDeRango($localizacionRelevador, $comerciosParaRuta);
            //Descarto los comercios de menor prioridad cuando la suma de todas las distancias superan el rango hasta que no ocurra mas
            $comercios = $this->verificarSumaDeDistancias($localizacionRelevador, $comercios);
        }
        return $comercios;
    }

    /**
     *
     * Va sumando las distancias de los comercios en total (partiendo de la localizacion del relevador) y agrega los comercios resultantes
     * Si la suma de distancias supera el limite definido se corta la lista y se retorna la ruta hasta ese momento
     * Se espera una lista ordenada en prioridad de mayor a menor
     *
     * @param $localizacionRelevador
     * @param $comerciosParaRuta
     * @return array
     */
    private function verificarSumaDeDistancias($localizacionRelevador, $comerciosParaRuta){
        $comercios = [];
        if(!empty($comerciosParaRuta) && !empty($localizacionRelevador)){
            $distanciaARecorrer = 0;
            $localizacionAnterior = $localizacionRelevador;
            foreach($comerciosParaRuta as $comercio){
                $distanciaRecorrida = $this->harvestine($comercio['localizacion']['latitud'], $comercio['localizacion']['longitud'], $localizacionAnterior['latitud'], $localizacionAnterior['longitud']);
                if($distanciaARecorrer + $distanciaRecorrida > RutasSearchModel::$maximaDistanciaRecorrer){
                    break;
                }
                $distanciaARecorrer = $distanciaARecorrer + $distanciaRecorrida;
                array_push($comercios, $comercio);
            }
        }
        return $comercios;
    }

    /**
     *
     * Quita todos los comercios que calculando la distnacia desde la localizacion del relevador superen el maximo de distancia a recorrer.
     *
     * @param $localizacionRelevador
     * @param $comerciosParaRuta
     * @return array
     */
    private function quitarComerciosFueraDeRango($localizacionRelevador, $comerciosParaRuta){
        $comercios = [];
        if(!empty($comerciosParaRuta) && !empty($localizacionRelevador)){
            foreach($comerciosParaRuta as $comercio){
                $distanciaLocalizacionComercio = $this->harvestine($comercio['localizacion']['latitud'], $comercio['localizacion']['longitud'], $localizacionRelevador['latitud'], $localizacionRelevador['longitud']);
                if(!($distanciaLocalizacionComercio > RutasSearchModel::$maximaDistanciaRecorrer)){
                    array_push($comercios, $comercio);
                }
            }
        }
        return $comercios;
    }

}
