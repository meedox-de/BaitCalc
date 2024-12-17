<?php

namespace frontend\controllers;

use common\models\Ingredient;
use common\models\ingredientSearch;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * IngredientController implements the CRUD actions for Ingredient model.
 */
class IngredientController extends Controller
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
     * Lists all Ingredient models.
     *
     * @return string
     */
    public function actionIndex() :string
    {
        $searchModel  = new ingredientSearch();
        $dataProvider = $searchModel->search( $this->request->queryParams );

        return $this->render( 'index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ] );
    }

    /**
     * Creates a new Ingredient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate() :Response|string
    {
        $model = new Ingredient();

        if( $model->load( Yii::$app->request->post() ) )
        {
            $model->user_id = Yii::$app->user->id;

            if( $model->save() )
            {
                Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The ingredient has been saved.' ) );
                return $this->redirect( ['index'] );
            }

            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'An error occurred while saving the ingredient.' ) );
        }

        return $this->render( 'create', [
            'model' => $model,
        ] );
    }

    /**
     * Updates an existing Ingredient model.
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

        if( $this->request->isPost && $model->load( $this->request->post() ) && $model->save() )
        {
            Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The ingredient has been saved.' ) );
            return $this->redirect( ['index'] );
        }
        else
        {
            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'An error occurred while saving the ingredient.' ) );
        }

        return $this->render( 'update', [
            'model' => $model,
        ] );
    }

    /**
     * Deletes an existing Ingredient model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id ID
     *
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id) :Response
    {
        $this->findModel( $id )->delete();

        Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The ingredient has been deleted.' ) );
        return $this->redirect( ['index'] );
    }

    /**
     * Finds the Ingredient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return Ingredient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) :Ingredient
    {
        if( ($model = Ingredient::findOne( ['id' => $id] )) !== null )
        {
            return $model;
        }

        throw new NotFoundHttpException( Yii::t( 'common', 'The requested page does not exist.' ) );
    }
}
