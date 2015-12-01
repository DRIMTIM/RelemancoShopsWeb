<?php

namespace backend\widgets\duallistbox;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Un widget propio
 */
class DualListBoxWidget extends InputWidget
{

    public $titulo;
    public $opcionesLenguaje;
    public $atributos;
    public $data;
    public $data_id;
    public $data_text;
    public $data_value;
    public $json;

    public function init() {
        parent::init();
        $this->data_id = isset($this->data_id) ? $this->data_id : 'id';
        $this->data_value = isset($this->data_value) ? $this->data_value : 'name';
        $this->data_text = isset($this->data_text) ? $this->data_text : 'texto';
        $this->titulo = isset($this->titulo) ? $this->titulo : '';
        $this->registerAssets();
        echo Html::activeTextInput($this->model, $this->attribute, ['class' => 'hidden', 'value' => $this->value]);
    }

    public function run() {
        $view = $this->getView();
        $model = $this->model;
        $inputId = $this->attribute;
        $selected = \yii\helpers\Json::decode($this->model->$inputId, JSON_UNESCAPED_UNICODE);
        $selected = ($selected == null) ? [] : $selected;
        $json_sel = Json::encode($selected);

        $idModel = strtolower($model->formName());

        $this->atributos = $this->model->attributes();

        if(!is_array($this->data)){
            $data = ($this->data) ? $this->data->asArray()->all() : [];
        }else{
            $data = $this->data;
        }

        echo '<div id="'.$inputId.'" >';

        $ret_sel = '';
        $ret = '<select style="display: none;" multiple = "multiple">';
        $cnt = 0;
        foreach ($data as $key => $value) {

            if (!in_array($value[$this->data_id], $selected)) {
                $ret .= '<option value="' . $value[$this->data_value] . '">' . $value[$this->data_text] . '</option>' . "\n";
            } else {
                $cnt++;
                $ret_sel .= '$("#dlb-'.$this->attribute.' .selected").
                append("<option value=' . $value[$this->data_value] . '>' . $value[$this->data_text] . '</option>");';
            }

        }
        $ret .= '</select>';

        $opcionesLenguaje = new Json();
        $opcionesLenguaje->advertencia_text = \Yii::t('app', 'Esta seguro que quiere seleccionar tantos elementos? Haciendo esto puede causar que su navegador no responda.');
        $opcionesLenguaje->buscar_placeholder = \Yii::t('app', 'Filtro');
        $opcionesLenguaje->mostrando_text = \Yii::t('app', ' - ');
        $opcionesLenguaje->disponible_text = \Yii::t('app', 'Disponible');
        $opcionesLenguaje->seleccionado_text = \Yii::t('app', 'Seleccionado');

        foreach($opcionesLenguaje as $key=>$value) {
            $opcionesLenguaje->$key = isset($this->opcionesLenguaje[$key]) ? $this->opcionesLenguaje[$key] : $value;
        }

        $lng_opt = new Json();
        $lng_opt->warning_info = $opcionesLenguaje->advertencia_text;
        $lng_opt->search_placeholder = $opcionesLenguaje->buscar_placeholder;
        $lng_opt->showing = $opcionesLenguaje->mostrando_text;
        $lng_opt->available = $opcionesLenguaje->disponible_text;
        $lng_opt->selected = $opcionesLenguaje->seleccionado_text;

        $options = 'lngOptions: '. json_encode($lng_opt);

        $json = isset($this->json) ? $this->json : 'false';

        $js = <<<SCRIPT

            $('#$inputId').DualListBox({
                json: $json,
                name: '$idModel',
                id: $inputId,
                title: '$this->titulo',
                $options
            });

            $ret_sel

            $("#$idModel-$inputId").val('$json_sel');

            $('#dlb-$inputId .selected-count').text('$cnt');

SCRIPT;

        $view->registerJs($js);

        return $ret.'</div>';
    }

    /**
     * Registro el asset
     */
    public function registerAssets()
    {
        $view = $this->getView();
        Asset::register($view);
    }
}
