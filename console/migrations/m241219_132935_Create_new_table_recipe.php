<?php

use yii\db\Migration;

/**
 * Class m241219_132935_Create_new_table_recipe
 */
class m241219_132935_Create_new_table_recipe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() :void
    {
        // delete fk-ingredient-user_id-user-id
        $this->dropForeignKey( 'fk-ingredient-user_id-user-id', '{{%ingredient}}' );

        // add auto_increment on user.id column
        $this->alterColumn( '{{%user}}', 'id', $this->integer( 11 )->unsigned()->notNull()->append( 'AUTO_INCREMENT' ) );

        // add fk-ingredient-user_id-user-id
        $this->addForeignKey( 'fk-ingredient-user_id-user-id', '{{%ingredient}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );

        // create new table recipe
        $this->createTable( '{{%recipe}}', [
            'id'          => $this->primaryKey( 11 )->unsigned(),
            'user_id'     => $this->integer( 11 )->unsigned()->notNull(),
            'name'        => $this->string( 255 )->notNull(),
            'description' => $this->text()->null(),
            'note'        => $this->text()->null(),
            'created_at'  => $this->dateTime()->notNull()->defaultExpression( 'CURRENT_TIMESTAMP' ),
            'updated_at'  => $this->dateTime()->null()->defaultExpression( 'NULL ON UPDATE CURRENT_TIMESTAMP' ),
        ],                  'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci' );

        $this->addForeignKey( 'fk-recipe-user_id-user-id', '{{%recipe}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
        $this->createIndex( 'idx-recipe-user_id', '{{%recipe}}', [
            'user_id',
            'name',
        ] );

        // create new table recipe_ingredient
        $this->createTable( '{{%recipe_ingredient}}', [
            'id'            => $this->primaryKey( 11 )->unsigned(),
            'user_id'       => $this->integer( 11 )->unsigned()->notNull(),
            'recipe_id'     => $this->integer( 11 )->unsigned()->notNull(),
            'ingredient_id' => $this->integer( 11 )->unsigned()->notNull(),
            'quantity'      => $this->decimal( 10, 2 )->notNull(),
            'created_at'    => $this->dateTime()->notNull()->defaultExpression( 'CURRENT_TIMESTAMP' ),
            'updated_at'    => $this->dateTime()->null()->defaultExpression( 'NULL ON UPDATE CURRENT_TIMESTAMP' ),
        ],                  'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci' );

        $this->addForeignKey( 'fk-recipe_ingredient-user_id-user-id', '{{%recipe_ingredient}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey( 'fk-recipe_ingredient-recipe_id-recipe-id', '{{%recipe_ingredient}}', 'recipe_id', '{{%recipe}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey( 'fk-recipe_ingredient-ingredient_id-ingredient-id', '{{%recipe_ingredient}}', 'ingredient_id', '{{%ingredient}}', 'id', 'CASCADE', 'CASCADE' );

        $this->createIndex( 'idx-recipe_ingredient-user_id', '{{%recipe_ingredient}}', [
            'user_id',
            'recipe_id',
            'ingredient_id',
        ] );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() :void
    {
        $this->dropIndex( 'idx-recipe_ingredient-user_id', '{{%recipe_ingredient}}' );
        $this->dropForeignKey( 'fk-recipe_ingredient-user_id-user-id', '{{%recipe_ingredient}}' );
        $this->dropForeignKey( 'fk-recipe_ingredient-recipe_id-recipe-id', '{{%recipe_ingredient}}' );
        $this->dropForeignKey( 'fk-recipe_ingredient-ingredient_id-ingredient-id', '{{%recipe_ingredient}}' );
        $this->dropTable( '{{%recipe_ingredient}}' );

        $this->dropIndex( 'idx-recipe-user_id', '{{%recipe}}' );
        $this->dropForeignKey( 'fk-recipe-user_id-user-id', '{{%recipe}}' );
        $this->dropTable( '{{%recipe}}' );

        // remove auto_increment on user.id column
        $this->alterColumn( '{{%user}}', 'id', $this->integer( 11 )->unsigned() );
    }
}
