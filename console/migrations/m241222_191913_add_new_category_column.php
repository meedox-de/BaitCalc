<?php

use yii\db\Migration;

/**
 * Class m241222_191913_add_new_category_column
 */
class m241222_191913_add_new_category_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() :void
    {
        // create new category table
        $this->createTable( '{{%category}}', [
            'id'         => $this->primaryKey( 11 )->unsigned(),
            'user_id'    => $this->integer( 11 )->unsigned()->notNull(),
            'name'       => $this->string( 255 )->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression( 'CURRENT_TIMESTAMP' ),
            'updated_at' => $this->dateTime()->null()->defaultExpression( 'NULL ON UPDATE CURRENT_TIMESTAMP' ),
        ],                  'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci' );

        $this->addForeignKey( 'fk-category-user_id-user-id', '{{%category}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
        $this->createIndex( 'idx-category-user_id', '{{%category}}', [
            'user_id',
            'name',
        ] );

        // add category_id column to ingredient table
        $this->addColumn( '{{%ingredient}}', 'category_id', $this->integer( 11 )->unsigned()->after( 'user_id' ) );
        $this->addForeignKey( 'fk-ingredient-category_id-category-id', '{{%ingredient}}', 'category_id', '{{%category}}', 'id', 'SET NULL', 'CASCADE' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() :void
    {
        // drop category_id column from ingredient table
        $this->dropColumn( '{{%ingredient}}', 'category_id' );

        // drop foreign key
        $this->dropForeignKey( 'fk-category-user_id-user-id', '{{%category}}' );

        // drop index
        $this->dropIndex( 'idx-category-user_id', '{{%category}}' );

        // drop category table
        $this->dropTable( '{{%category}}' );
    }
}
