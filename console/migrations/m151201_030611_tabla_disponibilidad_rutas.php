<?php
use yii\base\Exception;
use yii\db\Schema;
use yii\db\Migration;

class m151201_030611_tabla_disponibilidad_rutas extends Migration {

    private $rutasTableName = 'rutas';
    private $disponibilidadTableName = 'disponibilidad';
    private $rutasDisponibilidadTableName = 'rutas_disponibilidad';
    private $rutasForeingKeyColumn = 'id_ruta';
    private $disponibilidadForeingKeyColumn = 'id_disponibilidad';

    private $disponibilidades = [
        'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'
    ];

    public function safeUp() {
        try{
            $this->down();
        }catch (Exception $e){}

        $this->createTable($this->disponibilidadTableName, [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()
        ]);

        foreach ($this->disponibilidades as $disponibilidad) {
            $this->insert($this->disponibilidadTableName, ['nombre' => $disponibilidad]);
        }

        $this->createTable($this->rutasDisponibilidadTableName, [
            $this->rutasForeingKeyColumn => $this->bigInteger(),
            $this->disponibilidadForeingKeyColumn => $this->integer(),
            'PRIMARY KEY(' . $this->rutasForeingKeyColumn . ',' . $this->disponibilidadForeingKeyColumn . ')'
        ]);

        $this->createIndex('rutas_disponibilidad_d_idx', $this->rutasDisponibilidadTableName, $this->disponibilidadForeingKeyColumn);
        $this->createIndex('rutas_disponibilidad_r_idx', $this->rutasDisponibilidadTableName, $this->rutasForeingKeyColumn);

        $this->addForeignKey('rutas_disponibilidad_d_fk',
            $this->rutasDisponibilidadTableName,
            $this->disponibilidadForeingKeyColumn,
            $this->disponibilidadTableName, 'id', 'CASCADE');
        $this->addForeignKey('rutas_disponibilidad_r_fk',
            $this->rutasDisponibilidadTableName,
            $this->rutasForeingKeyColumn,
            $this->rutasTableName, 'id', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('rutas_disponibilidad_d_fk', $this->rutasDisponibilidadTableName);
        $this->dropForeignKey('rutas_disponibilidad_r_fk', $this->rutasDisponibilidadTableName);
        $this->dropIndex('rutas_disponibilidad_d_idx', $this->rutasDisponibilidadTableName);
        $this->dropIndex('rutas_disponibilidad_r_idx', $this->rutasDisponibilidadTableName);
        $this->dropTable($this->rutasDisponibilidadTableName);
        $this->dropTable($this->disponibilidadTableName);
    }

}
