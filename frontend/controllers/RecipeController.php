<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Ingredient;
use common\models\Recipe;
use common\models\RecipeIngredient;
use common\models\RecipeSearch;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * RecipeController implements the CRUD actions for Recipe model.
 */
class RecipeController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors() :array
    {
        return array_merge( parent::behaviors(), [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ] );
    }

    /**
     * Lists all Recipe models.
     *
     * @return string
     */
    public function actionIndex() :string
    {
        $searchModel  = new RecipeSearch();
        $dataProvider = $searchModel->search( $this->request->queryParams );

        return $this->render( 'index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ] );
    }

    /**
     * Displays a single Recipe model.
     *
     * @param int $id ID
     *
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionView(int $id) :string
    {
        $model = $this->findModel( $id );

        // get ingredients as array
        $query = Ingredient::find();
        $query->userId( Yii::$app->user->id );
        $ingredients = $query->all();

        // save quantity of ingredients
        if( $this->request->isPost )
        {
            $ingredientInputs = Yii::$app->request->post( 'ingredients', [] );

            RecipeIngredient::deleteAll( ['recipe_id' => $model->id] );

            // save all ingredients with values over 0
            foreach( $ingredientInputs as $ingredientId => $value )
            {
                if( (float) $value > 0 )
                {
                    $recipeIngredient                = new RecipeIngredient();
                    $recipeIngredient->user_id       = Yii::$app->user->id;
                    $recipeIngredient->recipe_id     = $model->id;
                    $recipeIngredient->ingredient_id = $ingredientId;
                    $recipeIngredient->quantity      = (float) $value;
                    $recipeIngredient->save();
                }
            }

            Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The ingredients have been saved.' ) );
        }

        // load saved ingredients
        $recipeIngredients = RecipeIngredient::findAll( ['recipe_id' => $model->id] );

        // load all categories as array
        $query = Category::find();
        $query->select( [
                            'name',
                            'id',
                        ] );
        $query->userId( Yii::$app->user->id );
        $query->orderBy( ['name' => SORT_ASC] );
        $categories = $query->column();

        return $this->render( 'view', [
            'model'             => $model,
            'categories'        => $categories,
            'ingredients'       => $ingredients,
            'recipeIngredients' => $recipeIngredients,
        ] );
    }

    /**
     * Creates a new Recipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate() :Response|string
    {
        $model = new Recipe();

        if( $model->load( $this->request->post() ) )
        {
            $model->user_id = Yii::$app->user->id;

            if( $model->save() )
            {
                Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The recipe has been saved.' ) );
                return $this->redirect( [
                                            'view',
                                            'id' => $model->id,
                                        ] );
            }
        }

        return $this->render( 'create', [
            'model' => $model,
        ] );
    }

    /**
     * Updates an existing Recipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id ID
     *
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionUpdate(int $id) :Response|string
    {
        $model = $this->findModel( $id );

        if( $this->request->isPost )
        {
            if( $model->load( $this->request->post() ) && $model->save() )
            {
                Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The recipe has been saved.' ) );
                return $this->redirect( [
                                            'view',
                                            'id' => $model->id,
                                        ] );
            }

            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'An error occurred while saving the recipe.' ) );
        }

        return $this->render( 'update', [
            'model' => $model,
        ] );
    }

    /**
     * Deletes an existing Recipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id ID
     *
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id) :Response
    {
        try
        {
            $this->findModel( $id )->delete();
        }
        catch( Throwable $e )
        {

        }

        return $this->redirect( ['index'] );
    }

    /**
     * Finds the Recipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if( ($model = Recipe::findOne( ['id' => $id] )) !== null )
        {
            return $model;
        }

        throw new NotFoundHttpException( Yii::t( 'common', 'The requested page does not exist.' ) );
    }
}
