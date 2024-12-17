<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ingredient}}`.
 */
class m241216_184401_Create_ingredient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() :void
    {
        // make user.id unsigned
        $this->alterColumn( '{{%user}}', 'id', $this->integer( 11 )->unsigned() );

        // create table ingredient and add foreign key to user
        $this->createTable( '{{%ingredient}}', [
            'id'           => $this->primaryKey( 11 )->unsigned(),
            'user_id'      => $this->integer( 11 )->unsigned()->notNull(),
            'name'         => $this->string( 255 )->notNull(),
            'protein'      => $this->decimal( 10, 2 )->notNull(),
            'fat'          => $this->decimal( 10, 2 )->notNull(),
            'carbohydrate' => $this->decimal( 10, 2 )->notNull(),
            'note'         => $this->text()->null(),
            'created_at'   => $this->dateTime()->notNull()->defaultExpression( 'CURRENT_TIMESTAMP' ),
            'updated_at'   => $this->dateTime()->null()->defaultExpression( 'NULL ON UPDATE CURRENT_TIMESTAMP' ),
        ],                  'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci' );

        $this->addForeignKey( 'fk-ingredient-user_id-user-id', '{{%ingredient}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
        $this->createIndex( 'idx-ingredient-user_id', '{{%ingredient}}', [
            'user_id',
            'name',
        ] );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() :void
    {
        $this->dropIndex( 'idx-ingredient-user_id', '{{%ingredient}}' );
        $this->dropForeignKey( 'fk-ingredient-user_id-user-id', '{{%ingredient}}' );
        $this->dropTable( '{{%ingredient}}' );

        // make user.id signed
        $this->alterColumn( '{{%user}}', 'id', $this->integer( 11 ) );
    }
}
